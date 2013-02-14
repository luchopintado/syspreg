<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of usuario
 *
 * @author LP
 */
class Usuario extends EntityBase {

    var $cod_usuario = '';
    var $usuario = '';
    var $clave = '';
    var $estado = '';
    var $fecha_registro = '';
    var $conectado = '';
    
    
    public static function checkLogin($user, $pass){
        $q = "SELECT COUNT(cod_usuario) as cuenta FROM usuario WHERE usuario='%s' AND clave='%s' LIMIT 1";
        $q = sprintf($q, $user, $pass);
        $r = DB::query($q);
        $fila = $r->fetch_assoc();
        if($fila["cuenta"] == 1){
            return true;
        }else{
            return false;
        }
    }

    public function save() {
        $q = "INSERT INTO usuario (usuario, clave, fecha_registro) VALUES('%s', '%s', '%s')";
        $q = sprintf($q,  $this->usuario, $this->clave, $this->fecha_registro);
        DB::query($q);
        return DB::getMySQLiObject();
    }

    public static function findById($idusuario) {
        $q = "select * from usuario u where u.idusuario='$idusuario' limit 1";
        $result = DB::query($q);
        $u = $result->fetch_assoc();
        return new Usuario($u);
    }

    public static function show() {
        $q = "SELECT SQL_CALC_FOUND_ROWS * FROM usuario ";
        $result = DB::query($q);

        $usuarios = array();
        while ($u = $result->fetch_assoc()) {
            $usuario = new Usuario($u);
            $usuarios[] = $usuario;
        }
        return $usuarios;
    }

    public static function delete($idusuario) {
        $q = "delete from usuario where idusuario='$idusuario' limit 1";
        DB::query($q);
        return DB::getMySQLiObject();
    }

}

?>
