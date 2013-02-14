<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Descripcion de curso
 *
 * @author LP
 */


class Curso extends EntityBase {

    var $cod_curso = '';
    var $cod_area = '';
    var $curso = '';
    var $obj_area;
    
    
    public function __construct($options = array()) {
        parent::__construct($options);
        $this->obj_area = new Area($options);
    }

    public function storeFormValues(&$options) {
        $pattern = "/[^\.\,\-\_'\"\@\?\!\:\$ a-zA-Z0-9()áéíóúÁÉÍÓÚüÜ]/";
        if (isset($options["cod_curso"])) {
            if ($options["cod_curso"] == "") {
                $options["cod_curso"] = null;
            }
        }
        //Add validation for other fields, specially STRINGS!
        $this->__construct($options);
    }
    
    
    public function insert() {
        if (!is_null($this->cod_curso)) {
            trigger_error("Curso::insert(): Intento de insertar un objeto CURSO que ya tiene asignada su propiedad ID (valor: $this->cod_curso).", E_USER_ERROR);
        }
        $q = "INSERT INTO curso (cod_area, curso) VALUES('%d', '%s')";
        $q = sprintf($q, $this->cod_area, $this->curso);
        DB::query($q);
        return DB::getMySQLiObject();
    }


    
    public static function getById($cod_curso) {
        $q = "SELECT * FROM curso c WHERE c.cod_curso='$cod_curso' LIMIT 1";
        $result = DB::query($q);
        $c = $result->fetch_assoc();
        if ($c) {
            return new Curso($c);
        }
        return null;
    }
    
    
    public static function getByFields($opts, $numRows=10, $order="cod_curso"){
        $arr_opts = array();
        foreach($opts as $opt){
            $arr_opts[] = sprintf("%s %s '%s'", $opt["field"], $opt["operator"], $opt["value"]);
        }
        
        $q = "SELECT SQL_CALC_FOUND_ROWS * FROM curso c WHERE %s ORDER BY %s LIMIT %d";
        $q = sprintf($q, join(" AND ", $arr_opts), mysql_escape_string($order), $numRows);
        
        $result = DB::query($q);
        $cursos = array();
        while ($c = $result->fetch_assoc()) {
            $curso = new Curso($c);
            $cursos[] = $curso;
        }
        
        $q = "SELECT FOUND_ROWS() as totalRows";
        $result = DB::query($q);
        $fila = $result->fetch_assoc();
        return array("cursos" => $cursos, "totalRows" => $fila["totalRows"]);
    }
   
 
    public static function getList($numRows = 10, $order = "cod_curso") {
        $q = 'SELECT SQL_CALC_FOUND_ROWS * FROM curso c
            LEFT JOIN areas a ON c.cod_area=a.cod_area
            ORDER BY %s LIMIT %d';
        $q = sprintf($q, mysql_escape_string($order), $numRows);
        $result = DB::query($q);
        $cursos = array();
        while ($c = $result->fetch_assoc()) {
            $curso = new Curso($c);
            $cursos[] = $curso;
        }
        $q = "SELECT FOUND_ROWS() as totalRows";
        $result = DB::query($q);
        $fila = $result->fetch_assoc();
        return array("cursos" => $cursos, "totalRows" => $fila["totalRows"]);
    }
    
    public static function getByAreaGrado($idarea, $idgrado) {
        $q = "SELECT c.*, a.* FROM cursogrado cg
            INNER JOIN grado g on cg.cod_grado=g.cod_grado            
            INNER JOIN curso c on cg.cod_curso=c.cod_curso
            INNER JOIN areas a on c.cod_area=a.cod_area
            WHERE cg.cod_grado='$idgrado' and a.cod_area='$idarea'
            ORDER BY c.curso";
        
        $result = DB::query($q);
        $cursos = array();
        while ($c = $result->fetch_assoc()) {
            $curso = new Curso($c);
            $cursos[] = $curso;
        }

        return array("cursos" => $cursos, "totalRows" => count($cursos));
    }
    
    public function update() {
        if (is_null($this->cod_curso)) {
            trigger_error("Curso::update(): Intento de actualizar un objeto CURSO que no tiene ajustado su propiedad ID.", E_USER_ERROR);
        }
        $sql = "UPDATE curso SET cod_area='%s', curso='%s' WHERE cod_curso='%d' limit 1";
        $sql = sprintf($sql, $this->cod_area, $this->curso, $this->cod_curso);
        DB::query($sql);
        return DB::getMySQLiObject();
    }

    public function delete() {
        if (is_null($this->cod_curso)) {
            trigger_error("Curso::delete(): Intento de eliminar un objecto CURSO cuya propiedad ID no se ha determinado.", E_USER_ERROR);
        }
        $sql = "DELETE FROM curso WHERE cod_curso='%d' LIMIT 1";
        $sql = sprintf($sql, $this->cod_curso);
        DB::query($sql);
        return DB::getMySQLiObject();
    }

}

?>
