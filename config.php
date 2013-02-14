<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

ini_set("display_errors", true);

date_default_timezone_set("America/Peru");

//define("DB_DSN", "mysql:host=localhost;dbname=sys_preg");
define("PAGE_TITLE", "SysPreg");
define("DB_HOST", "localhost");
define("DB_NAME", "sys_preg");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "");
define("CLASS_PATH", "classes");
define("TEMPLATE_PATH", "tpl");
define("HOMEPAGE_NUM_ARTICLES", 5);
define("ADMIN_USERNAME", "admin");
define("ADMIN_PASSWORD", "123456");

//Messages
define("MESSAGE_CHANGES_SAVED", "Sus cambios han sido guardados.");
define("MESSAGE_ARTICLE_NOT_FOUND", "Registro no encontrado.");
define("MESSAGE_ARTICLE_DELETED", "Registro eliminado..");


require CLASS_PATH.'/db.class.php';
require CLASS_PATH.'/entitybase.class.php';
require CLASS_PATH.'/menu.class.php';
require CLASS_PATH.'/usuario.class.php';
require CLASS_PATH.'/nivel.class.php';
require CLASS_PATH.'/area.class.php';
require CLASS_PATH.'/grado.class.php';
require CLASS_PATH.'/capacidad.class.php';
require CLASS_PATH.'/curso.class.php';
require CLASS_PATH.'/cursogrado.class.php';
require CLASS_PATH.'/trimestre.class.php';
require CLASS_PATH.'/tema.class.php';
require CLASS_PATH.'/subtema.class.php';
require CLASS_PATH.'/tipoevaluacion.class.php';
require CLASS_PATH.'/niveldificultad.class.php';
require CLASS_PATH.'/pregunta.class.php';
require CLASS_PATH.'/alternativa.class.php';
require CLASS_PATH.'/evaluacion.class.php';

DB::init(
    array(
        "db_host"=>DB_HOST,
        "db_user"=>DB_USERNAME,
        "db_pass"=>DB_PASSWORD,
        "db_name"=>DB_NAME
));

function handle_exception($exception){
    echo "Ha ocurrido un problema, por favor int&eacute;ntelo m&aacute;s tarde";
    error_log($exception->getMessage());
}

set_exception_handler('handle_exception');
?>
