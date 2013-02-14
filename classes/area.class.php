<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of area
 *
 * @author LP
 */
class Area extends EntityBase {

    var $cod_area = '';
    var $areas = '';

    public function __construct($options = array()) {
        parent::__construct($options);
    }

    public function storeFormValues(&$options) {
        $pattern = "/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()áéíóúÁÉÍÓÚüÜ]/";
        if (isset($options["cod_area"])) {
            if ($options["cod_area"] == "") {
                $options["cod_area"] = null;
            }
        }
        if (isset($options["areas"])) {
            $options["areas"] = preg_replace($pattern, "", $options["areas"]);
        }
        $this->__construct($options);
    }

    public function insert() {
        if (!is_null($this->cod_area)) {
            trigger_error("Area::insert(): Intento de insertar un objeto AREA que ya tiene asignada su propiedad ID (valor: $this->cod_area).", E_USER_ERROR);
        }

        $q = "INSERT INTO areas ( areas) VALUES( '%s')";
        $q = sprintf($q, $this->areas);
        DB::query($q);
        return DB::getMySQLiObject();
    }

    public static function getById($idarea) {
        $q = "SELECT * from AREAS a WHERE a.cod_area='$idarea' LIMIT 1";
        $result = DB::query($q);
        $a = $result->fetch_assoc();
        IF ($a) {
            return new Area($a);
        }
        return null;
    }
    
    public static function getByFields($opts, $numRows=10, $order="cod_grado"){
        $arr_opts = array();
        foreach($opts as $opt){
            $arr_opts[] = sprintf("%s %s '%s'", $opt["field"], $opt["operator"], $opt["value"]);
        }
        $q = "SELECT SQL_CALC_FOUND_ROWS a.* FROM areas a
            INNER JOIN gradoarea ga ON ga.`cod_area`=a.`cod_area`
            WHERE %s ORDER BY %s LIMIT %d";                
        $q = sprintf($q, join(" AND ", $arr_opts), mysql_escape_string($order), $numRows);
        
        $result = DB::query($q);
        $areas = array();
        while ($a = $result->fetch_assoc()) {
            $area = new Area($a);
            $areas[] = $area;
        }
        
        $q = "SELECT FOUND_ROWS() as totalRows";
        $result = DB::query($q);
        $fila = $result->fetch_assoc();
        return array("areas" => $areas, "totalRows" => $fila["totalRows"]);
    }
    
    public static function getAreasByGrado($cod_grado) {
        $q = "SELECT a.* FROM cursogrado cg 
            INNER JOIN grado g on cg.cod_grado=g.cod_grado
            INNER JOIN curso c on cg.cod_curso=c.cod_curso
            INNER JOIN areas a on c.cod_area=a.cod_area
            WHERE cg.cod_grado='$cod_grado'
            GROUP BY a.cod_area";
        $result = DB::query($q);
        $areas = array();
        while ($a = $result->fetch_assoc()) {
            $area = new Area($a);
            $areas[] = $area;
        }
        return array("areas" => $areas, "totalRows" => count($areas));
    }
    

    public static function getList($numRows = 10, $order = "cod_area") {
        $q = 'SELECT SQL_CALC_FOUND_ROWS * FROM areas ORDER BY %s LIMIT %d';
        $q = sprintf($q, mysql_escape_string($order), $numRows);
        $result = DB::query($q);

        $areas = array();
        while ($a = $result->fetch_assoc()) {
            $area = new Area($a);
            $areas[] = $area;
        }

        $q = "SELECT FOUND_ROWS() as totalRows";
        $result = DB::query($q);
        $fila = $result->fetch_assoc();

        return array("areas" => $areas, "totalRows" => $fila["totalRows"]);
    }

    public function update() {
        if (is_null($this->cod_area)) {
            trigger_error("Area::update(): Intento de actualizar un objeto Area que no tiene ajustado su propiedad ID.", E_USER_ERROR);
        }

        $sql = "UPDATE areas SET areas='%s' WHERE cod_area='%d'";
        $sql = sprintf($sql, $this->areas, $this->cod_area);
        DB::query($sql);
        return DB::getMySQLiObject();
    }

    public function delete() {
        if (is_null($this->cod_area)) {
            trigger_error("Area::delete(): Intento de eliminar un objecto AREA cuya propiedad ID no se ha determinado.", E_USER_ERROR);
        }

        $sql = "DELETE FROM areas WHERE cod_area='%d' LIMIT 1";
        $sql = sprintf($sql, $this->cod_area);
        DB::query($sql);
        return DB::getMySQLiObject();
    }

}

?>
