<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Descripcion de evaluacion
 *
 * @author LP
 */
class Evaluacion extends EntityBase {
    
    
    var $cod_evaluacion = '';
    var $cod_curso = '';
    var $cod_grado = '';
    var $cod_tipoevaluacion = '';
    var $e_nombre = '';
    var $fecha_evaluacion = '';
    var $fecha_registro = '';
    var $nro_preguntas = '';
    var $id_tema = '';
    var $id_subtema = '';
    
    
    public function __construct($options = array()) {
        parent::__construct($options);
    }


    public function storeFormValues(&$options) {
        $pattern = "/[^\.\,\-\_'\"\@\?\!\:\$ a-zA-Z0-9()áéíóúÁÉÍÓÚüÜ]/";
        if (isset($options["cod_evaluacion"])) {
            if ($options["cod_evaluacion"] == "") {
                $options["cod_evaluacion"] = null;
            }
        }
        //Add validation for other fields, specially STRINGS!
        $this->__construct($options);
    }
    
    public function insert() {
        if (!is_null($this->cod_evaluacion)) {
            trigger_error("Evaluacion::insert(): Intento de insertar un objeto EVALUACION que ya tiene asignada su propiedad ID (valor: $this->cod_evaluacion).", E_USER_ERROR);
        }
        $q = "INSERT INTO evaluacion (cod_curso, cod_grado, cod_tipoevaluacion, e_nombre, fecha_evaluacion, fecha_registro, nro_preguntas, id_tema, id_subtema) VALUES('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')";
        $q = sprintf($q, $this->cod_curso, $this->cod_grado, $this->cod_tipoevaluacion, $this->e_nombre, $this->fecha_evaluacion, $this->fecha_registro, $this->nro_preguntas, $this->id_tema, $this->id_subtema);
        echo $q;return;
        DB::query($q);
        return DB::getMySQLiObject();
    }


    public static function getById($cod_evaluacion) {
        $q = "SELECT * FROM evaluacion e WHERE e.cod_evaluacion='$cod_evaluacion' LIMIT 1";
        $result = DB::query($q);
        $e = $result->fetch_assoc();
        if ($e) {
            return new Evaluacion($e);
        }
        return null;
    }
    
    public static function getList($numRows=10, $order = "cod_evaluacion") {
        $q = 'SELECT SQL_CALC_FOUND_ROWS * FROM evaluacion ORDER BY %s LIMIT %d';
        $q = sprintf($q, mysql_escape_string($order), $numRows);
        $result = DB::query($q);
        $evaluacions = array();
        while ($e = $result->fetch_assoc()) {
           $evaluacion = new Evaluacion($e);
           $evaluacions[] = $evaluacion;
        }
        $q = "SELECT FOUND_ROWS() as totalRows";
        $result = DB::query($q);
        $fila = $result->fetch_assoc();
        return array("evaluacions"=>$evaluacions, "totalRows"=>$fila["totalRows"]);
    }
    
    public function update() {
        if (is_null($this->cod_evaluacion)) {
            trigger_error("Evaluacion::update(): Intento de actualizar un objeto EVALUACION que no tiene ajustado su propiedad ID.", E_USER_ERROR);
        }
        $sql = "UPDATE evaluacion SET cod_curso='%s', cod_grado='%s', cod_tipoevaluacion='%s', e_nombre='%s', fecha_evaluacion='%s', fecha_registro='%s', nro_preguntas='%s', id_tema='%s', id_subtema='%s' WHERE cod_evaluacion='%d' LIMIT 1";
        $sql = sprintf($sql, $this->cod_curso, $this->cod_grado, $this->cod_tipoevaluacion, $this->e_nombre, $this->fecha_evaluacion, $this->fecha_registro, $this->nro_preguntas, $this->id_tema, $this->id_subtema, $this->cod_evaluacion);
        DB::query($sql);
        return DB::getMySQLiObject();
    }
    
    public function delete() {
        if (is_null($this->cod_evaluacion)) {
            trigger_error("Evaluacion::delete(): Intento de eliminar un objecto EVALUACION cuya propiedad ID no se ha determinado.", E_USER_ERROR);
        }
        $sql = "DELETE FROM evaluacion WHERE cod_evaluacion='%d' LIMIT 1";
        $sql = sprintf($sql, $this->cod_evaluacion);
        DB::query($sql);
        return DB::getMySQLiObject();
    }
    
    public function getPreguntas(){
        $idevaluacion = $this->cod_evaluacion;
        $q = "SELECT * FROM pregunta p
            INNER JOIN evaluacion_pregunta ep ON p.cod_pregunta=ep.cod_pregunta 
            INNER JOIN niveldificultad nf on p.cod_niveldificultad=nf.cod_niveldificultad
            INNER JOIN tipopregunta tp ON p.cod_tipopregunta=tp.cod_tipopregunta            
            WHERE ep.cod_evaluacion='$idevaluacion'";
        
        $result = DB::query($q);
        $preguntas = array();
        while($p = $result->fetch_assoc()){
            $pregunta = new Pregunta($p);
            $preguntas[] = $pregunta;
        }
        return $preguntas;        
    }

}

?>
