<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Descripcion de alternativa
 *
 * @author LP
 */
class Alternativa extends EntityBase {

    var $cod_alternativa = '';
    var $cod_pregunta = '';
    var $valor = '';
    var $correcta = '';

    public function __construct($options = array()) {
        parent::__construct($options);
    }

    public function storeFormValues(&$options) {
        $pattern = "/[^\.\,\-\_'\"\@\?\!\:\$ a-zA-Z0-9()áéíóúÁÉÍÓÚüÜ]/";
        if (isset($options["cod_alternativa"])) {
            if ($options["cod_alternativa"] == "") {
                $options["cod_alternativa"] = null;
            }
        }
        //Add validation for other fields, specially STRINGS!
        $this->__construct($options);
    }

    public function insert() {
        if (!is_null($this->cod_alternativa)) {
            trigger_error("Alternativa::insert(): Intento de insertar un objeto ALTERNATIVA que ya tiene asignada su propiedad ID (valor: $this->cod_alternativa).", E_USER_ERROR);
        }
        $q = "INSERT INTO alternativa (cod_pregunta, valor, correcta) VALUES('%d', '%s', '%d')";
        $q = sprintf($q, $this->cod_pregunta, $this->valor, $this->correcta);
        DB::query($q);
        return DB::getMySQLiObject();
    }

    public static function getById($cod_alternativa) {
        $q = "SELECT * FROM alternativa a WHERE a.cod_alternativa='$cod_alternativa' LIMIT 1";
        $result = DB::query($q);
        $a = $result->fetch_assoc();
        if ($a) {
            return new Alternativa($a);
        }
        return null;
    }
    
    public static function getByFields($opts, $numRows=10, $order="a.cod_alternativa"){
        $arr_opts = array();
        foreach($opts as $opt){
            $arr_opts[] = sprintf("%s %s '%s'", $opt["field"], $opt["operator"], $opt["value"]);
        }
        
        $q = "SELECT * FROM alternativa a WHERE %s ORDER BY %s LIMIT %d";
        $q = sprintf($q, join(" AND ", $arr_opts), mysql_escape_string($order), $numRows);
        //echo $q;return;
        
        $result = DB::query($q);
        $alternativas = array();
        while ($a = $result->fetch_assoc()) {
            $alternativa = new Alternativa($a);
            $alternativas[] = $alternativa;
        }
        
        return array("alternativas" => $alternativas, "totalRows" => count($alternativas));
    }

    public static function getList($numRows = 10, $order = "cod_alternativa") {
        $q = 'SELECT SQL_CALC_FOUND_ROWS * FROM alternativa ORDER BY %s LIMIT %d';
        $q = sprintf($q, mysql_escape_string($order), $numRows);
        $result = DB::query($q);
        $alternativas = array();
        while ($a = $result->fetch_assoc()) {
            $alternativa = new Alternativa($a);
            $alternativas[] = $alternativa;
        }
        $q = "SELECT FOUND_ROWS() as totalRows";
        $result = DB::query($q);
        $fila = $result->fetch_assoc();
        return array("alternativas" => $alternativas, "totalRows" => $fila["totalRows"]);
    }

    public function update() {
        if (is_null($this->cod_alternativa)) {
            trigger_error("Alternativa::update(): Intento de actualizar un objeto ALTERNATIVA que no tiene ajustado su propiedad ID.", E_USER_ERROR);
        }
        $sql = "UPDATE alternativa SET cod_pregunta='%s', valor='%s', correcta='%s' WHERE cod_alternativa='%d' LIMIT 1";
        $sql = sprintf($sql, $this->cod_pregunta, $this->valor, $this->correcta, $this->cod_alternativa);
        DB::query($sql);
        return DB::getMySQLiObject();
    }

    public function delete() {
        if (is_null($this->cod_alternativa)) {
            trigger_error("Alternativa::delete(): Intento de eliminar un objecto ALTERNATIVA cuya propiedad ID no se ha determinado.", E_USER_ERROR);
        }
        $sql = "DELETE FROM alternativa WHERE cod_alternativa='%d' LIMIT 1";
        $sql = sprintf($sql, $this->cod_alternativa);
        DB::query($sql);
        return DB::getMySQLiObject();
    }

}

?>
