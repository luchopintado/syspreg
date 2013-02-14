<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Descripcion de grado
 *
 * @author LP
 */
class Grado extends EntityBase {

    var $cod_grado = '';
    var $cod_nivel = '';
    var $grado = '';
    
    var $obj_nivel;

    public function __construct($options = array()) {
        parent::__construct($options);
        $this->obj_nivel = new Nivel($options);
    }

    public function storeFormValues(&$options) {
        $pattern = "/[^\.\,\-\_'\"\@\?\!\:\$ a-zA-Z0-9()áéíóúÁÉÍÓÚüÜ]/";
        if (isset($options["cod_grado"])) {
            if ($options["cod_grado"] == "") {
                $options["cod_grado"] = null;
            }
        }
        //Add validation for other fields, specially STRINGS!
        $this->__construct($options);
    }

    public function insert() {
        if (!is_null($this->cod_grado)) {
            trigger_error("Grado::insert(): Intento de insertar un objeto GRADO que ya tiene asignada su propiedad ID (valor: $this->cod_grado).", E_USER_ERROR);
        }
        $q = "INSERT INTO grado (cod_nivel, grado) VALUES('%s', '%s')";
        $q = sprintf($q, $this->cod_nivel, $this->grado);
        DB::query($q);
        return DB::getMySQLiObject();
    }

    public static function getById($cod_grado) {
        $q = "SELECT * FROM grado g 
            INNER JOIN nivel n on g.cod_nivel=n.cod_nivel
            WHERE g.cod_grado='$cod_grado' LIMIT 1";
        $result = DB::query($q);
        $g = $result->fetch_assoc();
        if ($g) {
            return new Grado($g);
        }
        return null;
    }
    
    public static function getByFields($opts, $numRows=10, $order="cod_grado"){
        $arr_opts = array();
        foreach($opts as $opt){
            $arr_opts[] = sprintf("%s %s '%s'", $opt["field"], $opt["operator"], $opt["value"]);
        }
        
        $q = "SELECT SQL_CALC_FOUND_ROWS * FROM grado g WHERE %s ORDER BY %s LIMIT %d";        
        $q = sprintf($q, join(" AND ", $arr_opts), mysql_escape_string($order), $numRows);
        
        $result = DB::query($q);
        $grados = array();
        while ($g = $result->fetch_assoc()) {
            $grado = new Grado($g);
            $grados[] = $grado;
        }
        
        $q = "SELECT FOUND_ROWS() as totalRows";
        $result = DB::query($q);
        $fila = $result->fetch_assoc();
        return array("grados" => $grados, "totalRows" => $fila["totalRows"]);
    }

    public static function getList($numRows = 10, $order = "cod_grado") {
        $q = 'SELECT SQL_CALC_FOUND_ROWS *             
            FROM grado 
            INNER JOIN nivel n on g.cod_nivel=n.cod_nivel
            ORDER BY %s LIMIT %d';
        $q = sprintf($q, mysql_escape_string($order), $numRows);
        $result = DB::query($q);
        $grados = array();
        while ($g = $result->fetch_assoc()) {
            $grado = new Grado($g);
            $grados[] = $grado;
        }
        $q = "SELECT FOUND_ROWS() as totalRows";
        $result = DB::query($q);
        $fila = $result->fetch_assoc();
        return array("grados" => $grados, "totalRows" => $fila["totalRows"]);
    }

    public function update() {
        if (is_null($this->cod_grado)) {
            trigger_error("Grado::update(): Intento de actualizar un objeto GRADO que no tiene ajustado su propiedad ID.", E_USER_ERROR);
        }
        $sql = "UPDATE grado SET cod_nivel='%s', grado='%s' WHERE $this->cod_grado='%d'";
        $sql = sprintf($sql, $this->cod_nivel, $this->grado);
        DB::query($sql);
        return DB::getMySQLiObject();
    }

    public function delete() {
        if (is_null($this->cod_grado)) {
            trigger_error("Grado::delete(): Intento de eliminar un objecto GRADO cuya propiedad ID no se ha determinado.", E_USER_ERROR);
        }
        $sql = "DELETE FROM grado WHERE cod_grado='%d' LIMIT 1";
        $sql = sprintf($sql, $this->cod_area);
        DB::query($sql);
        return DB::getMySQLiObject();
    }

}

?>
