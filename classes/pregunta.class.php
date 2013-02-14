<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Descripcion de pregunta
 *
 * @author LP
 */
class Pregunta extends EntityBase {
    
    var $cod_pregunta = '';
    var $cod_curso = '';
    var $cod_grado = '';
    var $cod_niveldificultad = '';
    var $enunciado = '';
    var $id_tema = '';
    var $id_subtema = '';
    var $fecha_registro = '';
    
    var $obj_niveldificultad;
    var $obj_grado;
    var $obj_curso;
    
    var $alternativas;
    
    
    public function __construct($options = array()) {
        parent::__construct($options);
        $this->obj_niveldificultad = new NivelDificultad($options);
        $this->obj_grado = new Grado($options);
        $this->obj_curso = new Curso($options);
    }
    
    public function storeFormValues(&$options) {        
        $pattern = "/[^\.\,\-\_'\"\@\?\!\:\$ a-zA-Z0-9()áéíóúÁÉÍÓÚüÜ]/";
        if (isset($options["cod_pregunta"])) {
            if ($options["cod_pregunta"] == "") {
                $options["cod_pregunta"] = null;
                $this->cod_pregunta = null;
            }
        }
        $this->__construct($options);
    }

    
    public function insert() {        
        if (!is_null($this->cod_pregunta)) {
            trigger_error("Pregunta::insert(): Intento de insertar un objeto PREGUNTA que ya tiene asignada su propiedad ID (valor: $this->cod_pregunta).", E_USER_ERROR);
        }
        $q = "INSERT INTO pregunta (cod_curso, cod_grado, cod_niveldificultad, enunciado, id_tema, id_subtema, fecha_registro) VALUES('%d', '%d', '%d', '%s', '%d', '%d', '%s')";
        $q = sprintf($q, $this->cod_curso, $this->cod_grado, $this->cod_niveldificultad, $this->enunciado, $this->id_tema, $this->id_subtema, date("Y-m-d H:i:s"));
        DB::query($q);
        return DB::getMySQLiObject();
    }


    public static function getById($cod_pregunta) {
        $q = "SELECT * FROM pregunta p WHERE p.cod_pregunta='$cod_pregunta' LIMIT 1";
        $result = DB::query($q);
        $p = $result->fetch_assoc();
        if ($p) {
            return new Pregunta($p);
        }
        return null;
    }
    public static function getList($numRows=10, $order = "cod_pregunta") {
        $q = 'SELECT SQL_CALC_FOUND_ROWS * FROM pregunta ORDER BY %s LIMIT %d';
        $q = sprintf($q, mysql_escape_string($order), $numRows);
        $result = DB::query($q);
        $preguntas = array();
        while ($p = $result->fetch_assoc()) {
           $pregunta = new Pregunta($p);
           $preguntas[] = $pregunta;
        }
        $q = "SELECT FOUND_ROWS() as totalRows";
        $result = DB::query($q);
        $fila = $result->fetch_assoc();
        return array("preguntas"=>$preguntas, "totalRows"=>$fila["totalRows"]);
    }
    public function update() {
        if (is_null($this->cod_pregunta)) {
            trigger_error("Pregunta::update(): Intento de actualizar un objeto PREGUNTA que no tiene ajustado su propiedad ID.", E_USER_ERROR);
        }
        $sql = "UPDATE pregunta SET cod_curso='%s', cod_grado='%s', cod_niveldificultad='%s', enunciado='%s', id_tema='%s', id_subtema='%s', fecha_registro='%s' WHERE cod_pregunta='%d' LIMIT 1";
        $sql = sprintf($sql, $this->cod_curso, $this->cod_grado, $this->cod_niveldificultad, $this->enunciado, $this->id_tema, $this->id_subtema, $this->fecha_registro, $this->cod_pregunta);
        DB::query($sql);
        return DB::getMySQLiObject();
    }
    public function delete() {
        if (is_null($this->cod_pregunta)) {
            trigger_error("Pregunta::delete(): Intento de eliminar un objecto PREGUNTA cuya propiedad ID no se ha determinado.", E_USER_ERROR);
        }
        $sql = "DELETE FROM pregunta WHERE cod_pregunta='%d' LIMIT 1";
        $sql = sprintf($sql, $this->cod_pregunta);
        DB::query($sql);
        return DB::getMySQLiObject();
    }
    
    public static function getByDifLevel($idlevel, $numquestions) {
        $q = "SELECT * FROM pregunta p             
            WHERE p.cod_niveldificultad='$idlevel' 
            ORDER BY RAND() LIMIT 0, $numquestions";
        
        $result = DB::query($q);        
        while($p = $result->fetch_assoc()){
            $pregunta = new Pregunta($p);            
            $options = array(array("field"=>"a.cod_pregunta", "operator"=>"=", "value"=>$pregunta->cod_pregunta));
            $pregunta->alternativas = Alternativa::getByFields($options);
            $preguntas[] = $pregunta;
        }
        return $preguntas;
    }
}

?>
