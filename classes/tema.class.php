<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Descripcion de tema
 *
 * @author LP
 */
class Tema extends EntityBase {

    var $cod_tema = '';
    var $cod_curso = '';
    var $cod_grado = '';
    var $cod_trimestre = '';
    var $tema = '';
    var $id_capacidad = '';
    
    var $obj_curso;
    var $obj_grado;
    var $obj_trimestre;
    
    public function __construct($options = array()) {
        parent::__construct($options);
        $this->obj_curso = new Curso($options);
        $this->obj_grado = new Grado($options);
        $this->obj_trimestre = new Trimestre($options);
    }


    public function storeFormValues(&$options) {
        $pattern = "/[^\.\,\-\_'\"\@\?\!\:\$ a-zA-Z0-9()áéíóúÁÉÍÓÚüÜ]/";
        if (isset($options["cod_tema"])) {
            if ($options["cod_tema"] == "") {
                $options["cod_tema"] = null;
            }
        }
        
        if (isset($options["id_capacidad"])) {
            if ($options["id_capacidad"] == "") {
                $options["id_capacidad"] = null;
            }
        }
        
        
        $this->__construct($options);
    }
    
    public function insert() {
        if (!is_null($this->cod_tema)) {
            trigger_error("Tema::insert(): Intento de insertar un objeto TEMA que ya tiene asignada su propiedad ID (valor: $this->cod_tema).", E_USER_ERROR);
        }
        $q = "INSERT INTO tema (cod_curso, cod_grado, cod_trimestre, tema, id_capacidad) VALUES('%d', '%d', '%d', '%s', %s)";
        $q = sprintf($q, $this->cod_curso, $this->cod_grado,  $this->cod_trimestre, $this->tema, $this->id_capacidad);
        DB::query($q);
        return DB::getMySQLiObject();
    }
   
    public static function getById($cod_tema) {
        $q = "SELECT * FROM tema t 
            INNER JOIN trimestre tr ON t.cod_trimestre=tr.cod_trimestre
            INNER JOIN curso c ON t.cod_curso=c.cod_curso 
            INNER JOIN areas a ON c.cod_area=a.cod_area 
            INNER JOIN grado g ON t.cod_grado=g.cod_grado
            INNER JOIN nivel n ON g.cod_nivel=n.cod_nivel
            WHERE t.cod_tema='$cod_tema'
            LIMIT 1";
        $result = DB::query($q);
        $t = $result->fetch_assoc();
        if ($t) {
            return new Tema($t);
        }
        return null;
    }
    
    public static function getByFields($opts, $numRows=10, $order="t.cod_tema"){
        $arr_opts = array();
        foreach($opts as $opt){
            $arr_opts[] = sprintf("%s %s '%s'", $opt["field"], $opt["operator"], $opt["value"]);
        }
        
        $q = "SELECT SQL_CALC_FOUND_ROWS * FROM tema t WHERE %s ORDER BY %s LIMIT %d";
        $q = sprintf($q, join(" AND ", $arr_opts), mysql_escape_string($order), $numRows);
        //echo $q;return;
        
        $result = DB::query($q);
        $temas = array();
        while ($t = $result->fetch_assoc()) {
            $tema = new Tema($t);
            $temas[] = $tema;
        }
        
        $q = "SELECT FOUND_ROWS() as totalRows";
        $result = DB::query($q);
        $fila = $result->fetch_assoc();
        return array("temas" => $temas, "totalRows" => $fila["totalRows"]);
    }
    
    
    public static function getList($numRows=10, $order = "t.tema") {
         $q = "SELECT SQL_CALC_FOUND_ROWS * FROM tema t 
            INNER JOIN trimestre tr ON t.cod_trimestre=tr.cod_trimestre
            INNER JOIN curso c ON t.cod_curso=c.cod_curso 
            INNER JOIN areas a ON c.cod_area=a.cod_area 
            INNER JOIN grado g ON t.cod_grado=g.cod_grado
            INNER JOIN nivel n ON g.cod_nivel=n.cod_nivel
            ORDER BY %s LIMIT %d";
        
        $q = sprintf($q, mysql_escape_string($order), $numRows);
        $result = DB::query($q);
        
        $temas = array();
        while ($t = $result->fetch_assoc()) {
            $tema = new Tema($t);
            $temas[] = $tema;
        }
        
        $q = "SELECT FOUND_ROWS() as totalRows";
        $result = DB::query($q);
        $fila = $result->fetch_assoc();
        return array("temas" => $temas, "totalRows" => $fila["totalRows"]);
    }
   
    public function update() {
        if (is_null($this->cod_tema)) {
            trigger_error("Tema::update(): Intento de actualizar un objeto TEMA que no tiene ajustado su propiedad ID.", E_USER_ERROR);
        }
        $sql = "UPDATE tema SET cod_curso='%s', cod_trimestre='%s',  tema='%s' WHERE cod_tema='%d'";
        $sql = sprintf($sql, $this->cod_curso, $this->cod_trimestre, $this->tema, $this->cod_tema);
        DB::query($sql);
        return DB::getMySQLiObject();
    }

    public function delete() {
        if (is_null($this->cod_tema)) {
            trigger_error("Tema::delete(): Intento de eliminar un objecto TEMA cuya propiedad ID no se ha determinado.", E_USER_ERROR);
        }
        $sql = "DELETE FROM tema WHERE cod_tema='%d' LIMIT 1";
        $sql = sprintf($sql, $this->cod_tema);
        DB::query($sql);
        return DB::getMySQLiObject();
    }

}

?>
