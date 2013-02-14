<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Descripcion de cursogrado
 *
 * @author LP
 */

class CursoGrado extends EntityBase {

    var $cod_curso = '';
    var $cod_grado = '';
    
    var $obj_curso;
    var $obj_grado;

    public function __construct($options = array()) {
        parent::__construct($options);
        $this->obj_curso = new Curso($options);
        $this->obj_grado = new Grado($options);
    }

    public function storeFormValues(&$options) {
        $pattern = "/[^\.\,\-\_'\"\@\?\!\:\$ a-zA-Z0-9()áéíóúÁÉÍÓÚüÜ]/";
        if (isset($options["cod_curso"])) {
            if ($options["cod_curso"] == "" || $options["cod_curso"]=="0") {
                $options["cod_curso"] = null;
            }
        }
        if (isset($options["cod_grado"])) {
            if ($options["cod_grado"] == "" || $options["cod_grado"]=="0") {
                $options["cod_grado"] = null;
            }
        }
        $this->__construct($options);
    }

    public function insert() {
        if (is_null($this->cod_grado) || is_null($this->cod_curso)) {
            trigger_error("CursoGrado::insert(): Intento de insertar un objeto CURSOGRADO que no tiene asignada su llave primaria compuesta(valores: $this->cod_grado , $this->cod_curso).", E_USER_ERROR);
        }
        $q = "INSERT INTO cursogrado (cod_curso, cod_grado) VALUES('%d', '%d')";
        $q = sprintf($q, $this->cod_curso, $this->cod_grado);
        DB::query($q);
        return DB::getMySQLiObject();
    }

    public static function getById($cod_curso, $cod_grado) {
        $q = "SELECT * FROM cursogrado cg 
            INNER JOIN curso c on cg.cod_curso=c.cod_curso
            INNER JOIN grado g on cg.cod_grado=g.cod_grado
            WHERE cg.cod_curso='$cod_curso' and cg.cod_grado='$cod_grado' LIMIT 1";
        
        $result = DB::query($q);
        $c = $result->fetch_assoc();
        if ($c) {
            return new CursoGrado($c);
        }
        return null;
    }
    
    public static function getByFields($opts, $numRows=10, $order="cg.cod_curso"){
        $arr_opts = array();
        foreach($opts as $opt){
            $arr_opts[] = sprintf("%s %s '%s'", $opt["field"], $opt["operator"], $opt["value"]);
        }
        
        $q = "SELECT SQL_CALC_FOUND_ROWS * FROM cursogrado cg 
            INNER JOIN curso c on cg.cod_curso=c.cod_curso
            INNER JOIN grado g on cg.cod_grado=g.cod_grado
            WHERE %s ORDER BY %s LIMIT %d";
        $q = sprintf($q, join(" AND ", $arr_opts), mysql_escape_string($order), $numRows);
        
        $result = DB::query($q);
        $cursos = array();
        while ($cg = $result->fetch_assoc()) {
            $cursogrado = new CursoGrado($cg);
            $cursos[] = $cursogrado;
        }
        
        $q = "SELECT FOUND_ROWS() as totalRows";
        $result = DB::query($q);
        $fila = $result->fetch_assoc();
        return array("cursos" => $cursos, "totalRows" => $fila["totalRows"]);
    }
    

    public static function getList($numRows = 10, $order = "cg.cod_grado") {
        $q = 'SELECT SQL_CALC_FOUND_ROWS * FROM cursogrado cg
            INNER JOIN curso c on cg.cod_curso=c.cod_curso
            INNER JOIN grado g on cg.cod_grado=g.cod_grado            
            ORDER BY %s 
            LIMIT %d';
        $q = sprintf($q, mysql_escape_string($order), $numRows);
        
        $result = DB::query($q);
        $cursogrados = array();
        while ($c = $result->fetch_assoc()) {
            $cursogrado = new CursoGrado($c);
            $cursogrados[] = $cursogrado;
        }
        $q = "SELECT FOUND_ROWS() as totalRows";
        $result = DB::query($q);
        $fila = $result->fetch_assoc();
        return array("cursogrados" => $cursogrados, "totalRows" => $fila["totalRows"]);
    }

    public function delete() {
        if (is_null($this->cod_grado || is_null($this->cod_curso))) {
            trigger_error("CursoGrado::delete(): Intento de eliminar un objecto CURSOGRADO cuya llave primaria no se ha determinado.", E_USER_ERROR);
        }
        $sql = "DELETE FROM cursogrado WHERE cod_grado='%d' and cod_curso='%d' LIMIT 1";
        $sql = sprintf($sql, $this->cod_grado, $this->cod_curso);
        DB::query($sql);
        return DB::getMySQLiObject();
    }

}

?>
