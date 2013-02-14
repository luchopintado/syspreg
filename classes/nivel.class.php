<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Descripcion de nivel
 *
 * @author LP
 */
class Nivel extends EntityBase {

    var $cod_nivel = '';
    var $nivel = '';

    public function __construct($options = array()) {
        parent::__construct($options);
    }

    public function storeFormValues(&$options) {
        $pattern = "/[^\.\,\-\_'\"\@\?\!\:\$ a-zA-Z0-9()áéíóúÁÉÍÓÚüÜ]/";
        if (isset($options["cod_nivel"])) {
            if ($options["cod_nivel"] == "") {
                $options["cod_nivel"] = null;
            }
        }
        //Add validation for other fields, specially STRINGS!
        $this->__construct($options);
    }

    public function insert() {
        if (!is_null($this->cod_nivel)) {
            trigger_error("Nivel::insert(): Intento de insertar un objeto NIVEL que ya tiene asignada su propiedad ID (valor: $this->cod_nivel).", E_USER_ERROR);
        }
        $q = "INSERT INTO nivel (nivel) VALUES('%s')";
        $q = sprintf($q, $this->nivel);
        DB::query($q);
        return DB::getMySQLiObject();
    }

    public static function getById($cod_nivel) {
        $q = "SELECT * FROM nivel n WHERE n.cod_nivel='$cod_nivel' LIMIT 1";
        $result = DB::query($q);
        $n = $result->fetch_assoc();
        if ($n) {
            return new Nivel($n);
        }
        return null;
    }

    public static function getList($numRows = 10, $order = "cod_nivel") {
        $q = 'SELECT SQL_CALC_FOUND_ROWS * FROM nivel ORDER BY %s LIMIT %d';
        $q = sprintf($q, mysql_escape_string($order), $numRows);
        $result = DB::query($q);
        $nivels = array();
        while ($n = $result->fetch_assoc()) {
            $nivel = new Nivel($n);
            $nivels[] = $nivel;
        }
        $q = "SELECT FOUND_ROWS() as totalRows";
        $result = DB::query($q);
        $fila = $result->fetch_assoc();
        return array("niveles" => $nivels, "totalRows" => $fila["totalRows"]);
    }

    public function update() {
        if (is_null($this->cod_nivel)) {
            trigger_error("Nivel::update(): Intento de actualizar un objeto NIVEL que no tiene ajustado su propiedad ID.", E_USER_ERROR);
        }
        $sql = "UPDATE nivel SET nivel='%s' WHERE $this->cod_nivel='%d'";
        $sql = sprintf($sql, $this->nivel);
        DB::query($sql);
        return DB::getMySQLiObject();
    }

    public function delete() {
        if (is_null($this->cod_nivel)) {
            trigger_error("Nivel::delete(): Intento de eliminar un objecto NIVEL cuya propiedad ID no se ha determinado.", E_USER_ERROR);
        }
        $sql = "DELETE FROM nivel WHERE cod_nivel='%d' LIMIT 1";
        $sql = sprintf($sql, $this->cod_area);
        DB::query($sql);
        return DB::getMySQLiObject();
    }

}

?>
