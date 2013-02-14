<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Descripcion de trimestre
 *
 * @author LP
 */
class Trimestre extends EntityBase {

    var $cod_trimestre = '';
    var $trimestre = '';
    var $fechaini = '';
    var $fechafin = '';

    public function __construct($options = array()) {
        parent::__construct($options);
    }

    public function storeFormValues(&$options) {
        $pattern = "/[^\.\,\-\_'\"\@\?\!\:\$ a-zA-Z0-9()áéíóúÁÉÍÓÚüÜ]/";
        if (isset($options["cod_trimestre"])) {
            if ($options["cod_trimestre"] == "") {
                $options["cod_trimestre"] = null;
            }
        }
        //Add validation for other fields, specially STRINGS!
        $this->__construct($options);
    }

    public function insert() {
        if (!is_null($this->cod_trimestre)) {
            trigger_error("Trimestre::insert(): Intento de insertar un objeto TRIMESTRE que ya tiene asignada su propiedad ID (valor: $this->cod_trimestre).", E_USER_ERROR);
        }
        $q = "INSERT INTO trimestre (nombre, fechaini, fechafin) VALUES('%s', '%s', '%s')";
        $q = sprintf($q, $this->trimestre, $this->fechaini, $this->fechafin);
        DB::query($q);
        return DB::getMySQLiObject();
    }

    public static function getById($cod_trimestre) {
        $q = "SELECT * FROM trimestre t WHERE t.cod_trimestre='$cod_trimestre' LIMIT 1";
        $result = DB::query($q);
        $t = $result->fetch_assoc();
        if ($t) {
            return new Trimestre($t);
        }
        return null;
    }

    public static function getList($numRows = 10, $order = "cod_trimestre") {
        $q = 'SELECT SQL_CALC_FOUND_ROWS * FROM trimestre ORDER BY %s LIMIT %d';
        $q = sprintf($q, mysql_escape_string($order), $numRows);
        
        $result = DB::query($q);
        $trimestres = array();        
        while ($t = $result->fetch_assoc()) {
            $trimestre = new Trimestre($t);
            $trimestres[] = $trimestre;
        }
        $q = "SELECT FOUND_ROWS() as totalRows";
        $result = DB::query($q);
        $fila = $result->fetch_assoc();
        return array("trimestres" => $trimestres, "totalRows" => $fila["totalRows"]);
    }

    public function update() {
        if (is_null($this->cod_trimestre)) {
            trigger_error("Trimestre::update(): Intento de actualizar un objeto TRIMESTRE que no tiene ajustado su propiedad ID.", E_USER_ERROR);
        }
        $sql = "UPDATE trimestre SET trimestre='%s', fechaini='%s', fechafin='%s' WHERE cod_trimestre='%d' LIMIT 1";
        $sql = sprintf($sql, $this->trimestre, $this->fechaini, $this->fechafin, $this->cod_trimestre);
        DB::query($sql);
        return DB::getMySQLiObject();
    }

    public function delete() {
        if (is_null($this->cod_trimestre)) {
            trigger_error("Trimestre::delete(): Intento de eliminar un objecto TRIMESTRE cuya propiedad ID no se ha determinado.", E_USER_ERROR);
        }
        $sql = "DELETE FROM trimestre WHERE cod_trimestre='%d' LIMIT 1";
        $sql = sprintf($sql, $this->cod_trimestre);
        DB::query($sql);
        return DB::getMySQLiObject();
    }

}

?>
