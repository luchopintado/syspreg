<?php

/**
 * Descripcion de sesion
 *
 * @author LP
 */


class Sesion extends EntityBase {

    var $cod_sesion = '';
    var $cod_usuario = '';
    var $fecha_login = '';
    var $ip = '';
    var $fecha_logout = '';

    public function save() {
        $q = "INSERT INTO sesion (cod_usuario, fecha_login, ip, fecha_logout) VALUES('%s', '%s', '%s', '%s', '%s')";
        $q = sprintf($q, $this->cod_usuario, $this->fecha_login, $this->ip, $this->fecha_logout);
        DB::query($q);
        return DB::getMySQLiObject();
    }

    public static function findById($idsesion) {
        $q = "select * from sesion s where s.idsesion='$idsesion' limit 1";
        $result = DB::query($q);
        $s = $result->fetch_assoc();
        return new Sesion($s);
    }
    
    public static function findByUser($idusuario) {
        $q = "SELECT * FROM sesion s INNER JOIN usuario u ON s.cod_usuario=u.cod_usuario AND u.cod_usuario='$idusuario'";
        $result = DB::query($q);
        
        $sesiones = array();
        while ($s = $result->fetch_assoc()) {
            $sesion = new Sesion($s);
            $sesiones[] = $sesion;
        }        
        return $sesiones;
    }

    public static function show($limit, $offset) {
        $q = "SELECT SQL_CALC_FOUND_ROWS * FROM sesion limit $limit, $offset";
        $result = DB::query($q);
        
        $q_total = "SELECT FOUND_ROWS() as totalCount";
        $result_total = DB::query($q_total);        
        $f = $result_total->fetch_assoc();
        
        $sesions = array();
        while ($s = $result->fetch_assoc()) {
            $sesion = new Sesion($s);
            $sesions[] = $sesion;
        }
        return array("sesions" => $sesions, "totalCount" => $f["totalCount"]);
    }

    public static function delete($idsesion) {
        $q = "delete from sesion where idsesion='$idsesion' limit 1";
        DB::query($q);
        return DB::getMySQLiObject();
    }

}

?>
