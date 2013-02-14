<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Descripcion de tipoevaluacion
 *
 * @author LP
 */
class TipoEvaluacion extends EntityBase {

    var $cod_tipoevaluacion = '';
    var $tipoevaluacion = '';

    public function __construct($options = array()) {
        parent::__construct($options);
    }

    public function storeFormValues(&$options) {
        $pattern = "/[^\.\,\-\_'\"\@\?\!\:\$ a-zA-Z0-9()áéíóúÁÉÍÓÚüÜ]/";
        if (isset($options["cod_tipoevaluacion"])) {
            if ($options["cod_tipoevaluacion"] == "") {
                $options["cod_tipoevaluacion"] = null;
            }
        }
        //Add validation for other fields, specially STRINGS!
        $this->__construct($options);
    }

    public function insert() {
        if (!is_null($this->cod_tipoevaluacion)) {
            trigger_error("TipoEvaluacion::insert(): Intento de insertar un objeto TIPOEVALUACION que ya tiene asignada su propiedad ID (valor: $this->cod_tipoevaluacion).", E_USER_ERROR);
        }
        $q = "INSERT INTO tipoevaluacion (tipoevaluacion) VALUES('%s')";
        $q = sprintf($q, $this->tipoevaluacion);
        DB::query($q);
        return DB::getMySQLiObject();
    }

    public static function getById($cod_tipoevaluacion) {
        $q = "SELECT * FROM tipoevaluacion t WHERE t.cod_tipoevaluacion='$cod_tipoevaluacion' LIMIT 1";
        $result = DB::query($q);
        $t = $result->fetch_assoc();
        if ($t) {
            return new TipoEvaluacion($t);
        }
        return null;
    }
/**
 * Static Method that list TipoEvaluacion objects in an array...
 * 
 * @param type $numRows Number of rows that return from query
 * @param type $order Order field
 * @return Array An array of objects
 */
    public static function getList($numRows = 10, $order = "cod_tipoevaluacion") {
        $q = 'SELECT SQL_CALC_FOUND_ROWS * FROM tipoevaluacion ORDER BY %s LIMIT %d';
        $q = sprintf($q, mysql_escape_string($order), $numRows);
        $result = DB::query($q);
        $tipoevaluacions = array();
        while ($t = $result->fetch_assoc()) {
            $tipoevaluacion = new TipoEvaluacion($t);
            $tipoevaluacions[] = $tipoevaluacion;
        }
        $q = "SELECT FOUND_ROWS() as totalRows";
        $result = DB::query($q);
        $fila = $result->fetch_assoc();
        return array("tipoevaluaciones" => $tipoevaluacions, "totalRows" => $fila["totalRows"]);
    }

    public function update() {
        if (is_null($this->cod_tipoevaluacion)) {
            trigger_error("TipoEvaluacion::update(): Intento de actualizar un objeto TIPOEVALUACION que no tiene ajustado su propiedad ID.", E_USER_ERROR);
        }
        $sql = "UPDATE tipoevaluacion SET tipoevaluacion='%s' WHERE $this->cod_tipoevaluacion='%d'";
        $sql = sprintf($sql, $this->tipoevaluacion);
        DB::query($sql);
        return DB::getMySQLiObject();
    }

    public function delete() {
        if (is_null($this->cod_tipoevaluacion)) {
            trigger_error("TipoEvaluacion::delete(): Intento de eliminar un objecto TIPOEVALUACION cuya propiedad ID no se ha determinado.", E_USER_ERROR);
        }
        $sql = "DELETE FROM tipoevaluacion WHERE cod_tipoevaluacion='%d' LIMIT 1";
        $sql = sprintf($sql, $this->cod_area);
        DB::query($sql);
        return DB::getMySQLiObject();
    }

}

?>
