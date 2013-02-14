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

    public function save() {
        $q = "INSERT INTO alternativa (cod_pregunta, valor, correcta) VALUES('%s', '%s', '%d')";
        $q = sprintf($q, $this->cod_pregunta, $this->valor, $this->correcta);
        DB::query($q);
        return DB::getMySQLiObject();
    }
    
    public static function findByPregunta($idpregunta){
        $q = "SELECT * FROM alternativa WHERE cod_pregunta='$idpregunta'";
        $result = DB::query($q);
        $alternativas = array();
        
        while($a = $result->fetch_assoc()){
            $alternativa = new Alternativa($a);
            $alternativas[] = $alternativa;
        }
        
        return $alternativas;
    }

    public static function delete($idalternativa) {
        $q = "DELETE FROM alternativa WHERE idalternativa='$idalternativa' LIMIT 1";
        DB::query($q);
        return DB::getMySQLiObject();
    }

}

?>
