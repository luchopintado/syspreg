<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Descripcion de NivelDificultad
 *
 * @author LP
 */
class NivelDificultad extends EntityBase {

    var $cod_niveldificultad = '';
    var $nivel = '';

    public function __construct($options = array()) {
        parent::__construct($options);
    }

    public function storeFormValues(&$options) {
        $pattern = "/[^\.\,\-\_'\"\@\?\!\:\$ a-zA-Z0-9()áéíóúÁÉÍÓÚüÜ]/";
        if (isset($options["cod_niveldificultad"])) {
            if ($options["cod_niveldificultad"] == "") {
                $options["cod_niveldificultad"] = null;
            }
        }
        //Add validation for other fields, specially STRINGS!
        $this->__construct($options);
    }

    public function insert() {
        if (!is_null($this->cod_niveldificultad)) {
            trigger_error("NivelDificultad::insert(): Intento de insertar un objeto NIVELDIFICULTAD que ya tiene asignada su propiedad ID (valor: $this->cod_niveldificultad).", E_USER_ERROR);
        }
        $q = "INSERT INTO niveldificultad (nivel) VALUES('%s')";
        $q = sprintf($q, $this->nivel);
        DB::query($q);
        return DB::getMySQLiObject();
    }

    public static function getById($cod_niveldificultad) {
        $q = "SELECT * FROM niveldificultad n WHERE n.cod_niveldificultad='$cod_niveldificultad' LIMIT 1";
        $result = DB::query($q);
        $n = $result->fetch_assoc();
        if ($n) {
            return new NivelDificultad($n);
        }
        return null;
    }

    public static function getList($numRows = 10, $order = "cod_niveldificultad") {
        $q = 'SELECT SQL_CALC_FOUND_ROWS * FROM niveldificultad ORDER BY %s LIMIT %d';
        $q = sprintf($q, mysql_escape_string($order), $numRows);
        $result = DB::query($q);
        $niveldificultads = array();
        while ($n = $result->fetch_assoc()) {
            $niveldificultad = new NivelDificultad($n);
            $niveldificultads[] = $niveldificultad;
        }
        $q = "SELECT FOUND_ROWS() as totalRows";
        $result = DB::query($q);
        $fila = $result->fetch_assoc();
        return array("nivelesdificultad" => $niveldificultads, "totalRows" => $fila["totalRows"]);
    }

    public function update() {
        if (is_null($this->cod_niveldificultad)) {
            trigger_error("NivelDificultad::update(): Intento de actualizar un objeto NIVELDIFICULTAD que no tiene ajustado su propiedad ID.", E_USER_ERROR);
        }
        $sql = "UPDATE niveldificultad SET nivel='%s' WHERE $this->cod_niveldificultad='%d'";
        $sql = sprintf($sql, $this->nivel);
        DB::query($sql);
        return DB::getMySQLiObject();
    }

    public function delete() {
        if (is_null($this->cod_niveldificultad)) {
            trigger_error("NivelDificultad::delete(): Intento de eliminar un objecto NIVELDIFICULTAD cuya propiedad ID no se ha determinado.", E_USER_ERROR);
        }
        $sql = "DELETE FROM niveldificultad WHERE cod_niveldificultad='%d' LIMIT 1";
        $sql = sprintf($sql, $this->cod_area);
        DB::query($sql);
        return DB::getMySQLiObject();
    }

}

?>
