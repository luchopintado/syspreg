<?php

/**
 * Description of capacidad
 *
 * @author LP
 */
class Capacidad extends EntityBase {

    var $cod_capacidad = '';
    var $cod_area = '';
    var $capacidad = '';
    var $obj_area;

    function __construct($options = array()) {
        parent::__construct($options);
        $this->obj_area = new Area($options);
    }
    
    public function storeFormValues(&$options) {
        $pattern = "/[^\.\,\-\_'\"\@\?\!\:\$ a-zA-Z0-9()áéíóúÁÉÍÓÚüÜ]/";
        if (isset($options["cod_capacidad"])) {
            if ($options["cod_capacidad"] == "") {
                $options["cod_capacidad"] = null;
            }
        }
        //Add validation for other fields, specially STRINGS!
        $this->__construct($options);
    }

    public function insert() {
        if (!is_null($this->cod_capacidad)) {
            trigger_error("Capacidad::insert(): Intento de insertar un objeto CAPACIDAD que ya tiene asignada su propiedad ID (valor: $this->cod_capacidad).", E_USER_ERROR);
        }
        $q = "INSERT INTO capacidad (cod_area, capacidad) VALUES('%s', '%s')";
        $q = sprintf($q, $this->cod_area, $this->capacidad);
        DB::query($q);
        return DB::getMySQLiObject();
    }

    public static function getById($cod_capacidad) {
        $q = "SELECT * FROM capacidad c WHERE c.cod_capacidad='$cod_capacidad' LIMIT 1";
        $result = DB::query($q);
        $c = $result->fetch_assoc();
        if ($c) {
            return new Capacidad($c);
        }
        return null;
    }

    public static function getList($numRows = 10, $order = "cod_capacidad") {
        //$q = 'SELECT SQL_CALC_FOUND_ROWS * FROM capacidad ORDER BY %s LIMIT %d';
        $q = 'SELECT SQL_CALC_FOUND_ROWS * FROM capacidad c
            INNER JOIN areas a ON c.`cod_area`=a.`cod_area`
            ORDER BY %s LIMIT %d';
        $q = sprintf($q, mysql_escape_string($order), $numRows);
        $result = DB::query($q);
        $capacidads = array();
        while ($c = $result->fetch_assoc()) {
            $capacidad = new Capacidad($c);
            $capacidads[] = $capacidad;
        }
        $q = "SELECT FOUND_ROWS() as totalRows";
        $result = DB::query($q);
        $fila = $result->fetch_assoc();
        return array("capacidades" => $capacidads, "totalRows" => $fila["totalRows"]);
    }
    
    public static function getByArea($idarea) {
        $q = "SELECT c.* FROM capacidad c            
            INNER JOIN areas a on c.cod_area=a.cod_area
            WHERE a.cod_area='$idarea'
            ORDER BY c.cod_capacidad";
        
        $result = DB::query($q);
        $capacidades = array();
        while ($c = $result->fetch_assoc()) {
            $capacidad = new Capacidad($c);
            $capacidades[] = $capacidad;
        }

        return array("capacidades" => $capacidades, "totalRows" => count($capacidades));
    }

    public function delete() {
        if (is_null($this->cod_capacidad)) {
            trigger_error("Capacidad::delete(): Intento de eliminar un objecto CAPACIDAD cuya propiedad ID no se ha determinado.", E_USER_ERROR);
        }
        $sql = "DELETE FROM capacidad WHERE cod_capacidad='%d' LIMIT 1";
        $sql = sprintf($sql, $this->cod_capacidad);
        DB::query($sql);
        return DB::getMySQLiObject();
    }
    
    public function update() {
        if (is_null($this->cod_capacidad)) {
            trigger_error("Capacidad::update(): Intento de actualizar un objeto CAPACIDAD que no tiene ajustado su propiedad ID.", E_USER_ERROR);
        }
        $sql = "UPDATE capacidad SET cod_area='%s', capacidad='%s' WHERE cod_capacidad='%d'";
        $sql = sprintf($sql, $this->cod_area, $this->capacidad, $this->cod_capacidad);
        DB::query($sql);
        return DB::getMySQLiObject();
    }

}

?>
