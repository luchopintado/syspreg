<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Descripcion de subtema
 *
 * @author LP
 */
class SubTema extends EntityBase {

    var $cod_subtema = '';
    var $cod_tema = '';
    var $subtema = '';
    var $obj_tema;

    public function __construct($options = array()) {
        parent::__construct($options);
        $this->obj_tema = new Tema($options);
    }

    public function storeFormValues(&$options) {
        $pattern = "/[^\.\,\-\_'\"\@\?\!\:\$ a-zA-Z0-9()áéíóúÁÉÍÓÚüÜ]/";
        if (isset($options["cod_subtema"])) {
            if ($options["cod_subtema"] == "") {
                $options["cod_subtema"] = null;
            }
        }
        if (isset($options["subtema"])) {
            $options["subtema"] = preg_replace($pattern, "", $options["subtema"]);
        }        
        
        $this->__construct($options);
    }

    public function insert() {
        if (!is_null($this->cod_subtema)) {
            trigger_error("SubTema::insert(): Intento de insertar un objeto SUBTEMA que ya tiene asignada su propiedad ID (valor: $this->cod_subtema).", E_USER_ERROR);
        }
        $q = "INSERT INTO subtema (cod_tema, subtema) VALUES('%d', '%s')";
        $q = sprintf($q, $this->cod_tema, $this->subtema);
        DB::query($q);
        return DB::getMySQLiObject();
    }

    public static function getById($cod_subtema) {
         $q = "SELECT * FROM subtema st
            INNER JOIN tema t ON t.cod_tema=st.cod_tema
            INNER JOIN trimestre tr ON t.cod_trimestre=tr.cod_trimestre
            INNER JOIN curso c ON t.cod_curso=c.cod_curso 
            INNER JOIN areas a ON c.cod_area=a.cod_area 
            INNER JOIN grado g ON t.cod_grado=g.cod_grado
            INNER JOIN nivel n ON g.cod_nivel=n.cod_nivel
            WHERE st.cod_subtema='$cod_subtema'
            LIMIT 1";        
            
        $result = DB::query($q);
        $s = $result->fetch_assoc();
        if ($s) {
            return new SubTema($s);
        }
        return null;
    }
    
    public static function getByFields($opts, $numRows=10, $order="cod_subtema"){
        $arr_opts = array();
        foreach($opts as $opt){
            $arr_opts[] = sprintf("%s %s '%s'", $opt["field"], $opt["operator"], $opt["value"]);
        }
        
        $q = "SELECT SQL_CALC_FOUND_ROWS * FROM subtema st WHERE %s ORDER BY %s LIMIT %d";
        $q = sprintf($q, join(" AND ", $arr_opts), mysql_escape_string($order), $numRows);
        
        $result = DB::query($q);
        $subtemas = array();
        while ($st = $result->fetch_assoc()) {
            $subtema = new SubTema($st);
            $subtemas[] = $subtema;
        }
        
        $q = "SELECT FOUND_ROWS() as totalRows";
        $result = DB::query($q);
        $fila = $result->fetch_assoc();
        return array("subtemas" => $subtemas, "totalRows" => $fila["totalRows"]);
    }

    public static function getList($numRows = 10, $order = "st.cod_subtema") {
        $q = "SELECT SQL_CALC_FOUND_ROWS * FROM subtema st
            INNER JOIN tema t ON t.cod_tema=st.cod_tema
            INNER JOIN trimestre tr ON t.cod_trimestre=tr.cod_trimestre
            INNER JOIN curso c ON t.cod_curso=c.cod_curso 
            INNER JOIN areas a ON c.cod_area=a.cod_area 
            INNER JOIN grado g ON t.cod_grado=g.cod_grado
            INNER JOIN nivel n ON g.cod_nivel=n.cod_nivel            
            ORDER BY %s LIMIT %d";        
        $q = sprintf($q, mysql_escape_string($order), $numRows);
        
        $result = DB::query($q);
        $subtemas = array();
        while ($s = $result->fetch_assoc()) {
            $subtema = new SubTema($s);
            $subtemas[] = $subtema;
        }
        $q = "SELECT FOUND_ROWS() as totalRows";
        $result = DB::query($q);
        $fila = $result->fetch_assoc();
        return array("subtemas" => $subtemas, "totalRows" => $fila["totalRows"]);
    }

    public function update() {
        if (is_null($this->cod_subtema)) {
            trigger_error("SubTema::update(): Intento de actualizar un objeto SUBTEMA que no tiene ajustado su propiedad ID.", E_USER_ERROR);
        }
        $sql = "UPDATE subtema SET cod_tema='%s', subtema='%s' WHERE cod_subtema='%d'";
        $sql = sprintf($sql, $this->cod_tema, $this->subtema, $this->cod_subtema);
        DB::query($sql);
        return DB::getMySQLiObject();
    }

    public function delete() {
        if (is_null($this->cod_subtema)) {
            trigger_error("SubTema::delete(): Intento de eliminar un objecto SUBTEMA cuya propiedad ID no se ha determinado.", E_USER_ERROR);
        }
        $sql = "DELETE FROM subtema WHERE cod_subtema='%d' LIMIT 1";
        $sql = sprintf($sql, $this->cod_subtema);
        DB::query($sql);
        return DB::getMySQLiObject();
    }
    
}

?>
