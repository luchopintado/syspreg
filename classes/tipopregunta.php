<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Descripcion de tipopregunta
 *
 * @author LP
 */
class TipoPregunta extends EntityBase {

    var $cod_tipopregunta = '';
    var $tipo = '';

    public function save() {
        $q = "INSERT INTO tipopregunta (tipo) VALUES('%s')";
        $q = sprintf($q, $this->tipo);
        DB::query($q);
        return DB::getMySQLiObject();
    }

    public static function findById($idtipopregunta) {
        $q = "SELECT * FROM tipopregunta t WHERE t.idtipopregunta='$idtipopregunta' LIMIT 1";
        $result = DB::query($q);
        $t = $result->fetch_assoc();
        return new TipoPregunta($t);
    }

    public static function show() {
        $q = 'SELECT * FROM tipopregunta';
        $result = DB::query($q);

        $tipopreguntas = array();
        while ($t = $result->fetch_assoc()) {
            $tipopregunta = new TipoPregunta($t);
            $tipopreguntas[] = $tipopregunta;
        }
        return $tipopreguntas;
    }

    public static function delete($idtipopregunta) {
        $q = "DELETE FROM tipopregunta WHERE idtipopregunta='$idtipopregunta' LIMIT 1";
        DB::query($q);
        return DB::getMySQLiObject();
    }

}

?>
