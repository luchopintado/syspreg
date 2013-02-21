<?php

require 'config.php';
session_start();

$_SESSION["menu"] = "evaluaciones";

$action = isset($_GET["action"]) ? $_GET["action"] :  "";
$username = isset($_SESSION["username"]) ? $_SESSION["username"] : "";
if($action!= "login" && $action!="logout" && !$username){
    header("Location: admin.php");
    exit;
}

switch ($action) {
    case 'listExamenes':
        listExamenes();
        break;
    
    case 'generarEvaluacion':
        formGenerarEvaluacion();
        break;
    
   
    
    case 'getGradoByNivel':
        getGradoByNivel();
        break;
    
    case 'getAreasByGrado':
        getAreasByGrado();
        break;
    
    case 'getCursoByArea':
        getCursoByArea();
        break;
    
    case 'getCursoByAreaSimple':
        getCursoByAreaSimple();
        break;
    
    case 'getCapacidadByArea':
        getCapacidadByArea();
        break;
    
    case 'getCursoByGrado':
        getCursoByGrado();
        break;
    
    case 'getTemaByCurso':
        getTemaByCurso();        
        break;
    
    case 'getTemaByCursoCapacidad':
        getTemaByCursoCapacidad();        
        break;
    
    case 'getSubtemaByTema':
        getSubtemaByTema();
        break;
    
    case 'getRandomQuestions':
        getRandomQuestions();
        break;
    
    case 'getQuestions':
        getQuestions();
        break;
    
    case 'getSelectedQuestions':
        getSelectedQuestions();
        break;
    
    case 'exportMSWord':
        exportMSWord();
        break;
    
    default :
        formGenerarEvaluacion();
}



function formGenerarEvaluacion() {
    $results = array();
    
    $data = Area::getList();
    $results["areas"] = $data["areas"];
    $results["totalRows"] = $data["totalRows"];
    $results["pageTitle"] = "Generar evaluaci&oacute;n";
    $results["indice"] = "generar";
    $results["formAction"] = "getRandomQuestions";
    
    
    if(isset($_GET["error"])){
        if($_GET["error"] == "articleNotFound"){
            $results["errorMessage"] = MESSAGE_ARTICLE_NOT_FOUND;
        }
    }
    
    if(isset($_GET["status"])){
        if($_GET["status"] == "changesSaved"){
            $results["statusMessage"] = MESSAGE_CHANGES_SAVED;
        }
        if($_GET["status"] == "articleDeleted"){
            $results["statusMessage"] = MESSAGE_ARTICLE_DELETED;
        }
    }
    //print_r($results);
    //return;
    if($data["totalRows"] == 0){
        require TEMPLATE_PATH . "/admin_eval/generarEvaluacion.php";        
    }else{
        require TEMPLATE_PATH . "/admin_eval/generarEvaluacion.php";
        
    }
}


function listExamenes() {
    $results = array();
    
    $data = Area::getList();
    $results["areas"] = $data["areas"];
    $results["totalRows"] = $data["totalRows"];
    $results["pageTitle"] = "Listar Examenes Anteriores | " . PAGE_TITLE;
    $results["indice"] = "listar";
    
    if(isset($_GET["error"])){
        if($_GET["error"] == "articleNotFound"){
            $results["errorMessage"] = MESSAGE_ARTICLE_NOT_FOUND;
        }
    }
    
    if(isset($_GET["status"])){
        if($_GET["status"] == "changesSaved"){
            $results["statusMessage"] = MESSAGE_CHANGES_SAVED;
        }
        if($_GET["status"] == "articleDeleted"){
            $results["statusMessage"] = MESSAGE_ARTICLE_DELETED;
        }
    }
    //print_r($results);
    //return;
    if($data["totalRows"] == 0){
        require TEMPLATE_PATH . "/admin_eval/listExamenes.php";        
    }else{
        require TEMPLATE_PATH . "/admin_eval/listExamenes.php";
        
    }
}

function getGradoByNivel() {
    $idnivel = intval($_POST["idnivel"]);
    $grados = Grado::getByFields(array(array("field"=>"g.cod_nivel", "operator"=>"=", "value"=>$idnivel)));
    echo json_encode($grados);
}

function getAreasByGrado() {
    $idgrado = intval($_POST["idgrado"]);
    $areas = Area::getAreasByGrado($idgrado);
    echo json_encode($areas);
}

function getCursoByArea() {
    $idarea = intval($_POST["idarea"]);
    $idgrado = intval($_POST["idgrado"]);
    $cursos = Curso::getByAreaGrado($idarea, $idgrado);
    echo json_encode($cursos);
}

function getCapacidadByArea() {
    $idarea = intval($_POST["idarea"]);    
    $capacidades = Capacidad::getByArea($idarea);
    echo json_encode($capacidades);
}

function getCursoByAreaSimple() {
    $idarea = intval($_POST["idarea"]);
    $cursos = Curso::getByFields(array(array("field"=>"c.cod_area", "operator"=>"=", "value"=>$idarea)));
    echo json_encode($cursos);
}

function getCursoByGrado() {
    $idgrado = intval($_POST["idgrado"]);
    $cursos = CursoGrado::getByFields(array(array("field"=>"cg.cod_grado", "operator"=>"=", "value"=>$idgrado)));
    echo json_encode($cursos);
}

function getTemaByCurso() {
    $idcurso = intval($_POST["idcurso"]);
    $temas = Tema::getByFields(array(array("field"=>"t.cod_curso", "operator"=>"=", "value"=>$idcurso)));
    echo json_encode($temas);
}

function getTemaByCursoCapacidad() {
    $idcurso = intval($_POST["idcurso"]);
    $idcapacidad = intval($_POST["idcapacidad"]);
    $temas = Tema::getByFields(
        array(
            array("field"=>"t.cod_curso", "operator"=>"=", "value"=>$idcurso),
            array("field"=>"t.id_capacidad", "operator"=>"=", "value"=>$idcapacidad)
        )
    );
    echo json_encode($temas);
}

function getSubtemaByTema() {
    $idtema = intval($_POST["idtema"]);
    $subtemas = Subtema::getByFields(array(array("field"=>"st.cod_tema", "operator"=>"=", "value"=>$idtema)));
    echo json_encode($subtemas);
}

function getRandomQuestions() {
    $nro_preguntas_basico = $_POST["nropreguntas-1"];
    $nro_preguntas_intermedio = $_POST["nropreguntas-2"];
    $nro_preguntas_avanzado = $_POST["nropreguntas-3"];
    
    $preguntas_basico = Pregunta::getByDifLevel(1, $nro_preguntas_basico);
    $preguntas_intermedio = Pregunta::getByDifLevel(1, $nro_preguntas_intermedio);
    $preguntas_avanzado = Pregunta::getByDifLevel(1, $nro_preguntas_avanzado);
    
    $preguntas_total = array_merge($preguntas_basico, $preguntas_intermedio, $preguntas_avanzado);
    
    $ids_preguntas = array();
    foreach($preguntas_total as $preg){
        $ids_preguntas[] = $preg->cod_pregunta;
    }
    //print_r($ids_preguntas);
    unset($_SESSION["preguntas"]);
    $_SESSION["preguntas"] = serialize($ids_preguntas);
    
    echo json_encode(array("preguntas"=>$preguntas_total, "totalCount"=>count($preguntas_total)));
}

function getQuestions() {
    $cod_curso = $_POST["cod_curso"];
    $cod_grado = $_POST["cod_grado"];
    //$cod_niveldificultad = $_POST["cod_niveldificultad"]; - No hay porque el usuario va elegir
    
    $id_tema = $_POST["id_tema"];
    $id_subtema = $_POST["id_subtema"];
    $id_capacidad = $_POST["id_capacidad"];
    $id_tipopregunta = $_POST["rb_tipoevaluacion"];
    
    $resultado = Pregunta::getByFields(array(
        array("field"=>"p.cod_curso", "operator"=>"=", "value"=>$cod_curso),
        array("field"=>"p.cod_grado", "operator"=>"=", "value"=>$cod_grado),
        array("field"=>"p.id_tipopregunta", "operator"=>"=", "value"=>$id_tipopregunta)
    ));
    
    echo json_encode($resultado);
}

function getSelectedQuestions() {        
    $ids = $_POST["ids"];
    unset($_SESSION["preguntas"]);
    $_SESSION["preguntas"] = serialize($ids);
    $resultado = Pregunta::getByIds($ids);
    echo json_encode($resultado);
}

function exportMSWord() {
    $ids = unserialize($_SESSION["preguntas"]);
    $preguntas = Pregunta::getByIds($ids);
    //header("Content-type: application/vnd.ms-word");
    //header("Content-Disposition: attachment;Filename=evaluacion.doc");
    
    echo '<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        
        <style type="text/css">
            .COLUMNS{
            -moz-column-count: 2;
            -moz-column-gap: 1.5em;
            -moz-column-rule: none;
            -webkit-column-count: 2;
            -webkit-column-gap: 1.5em;
            -webkit-column-rule: none;
            column-count: 2;
            column-gap: 1.5em;
            column-rule: none;
            }
            </style>
    </head>
    <body>
    <p>las preguntas son las siguientes'.join('-', $ids).'
    </p>
        <div class="COLUMNS">            
            <ol style="list-style: decimal;">';
    
    foreach ($preguntas["preguntas"] as $preg) {        
        echo '<li>'. $preg->enunciado .'</li>';
        echo '<ol style="list-style: upper-alpha;">';
        foreach($preg->alternativas["alternativas"] as $alt){
            echo '<li>'. $alt->valor .'</li>';
        }
        echo '</ol>';
    }
            
    echo '</ol>
            </div>
        </body>
    </html>';
}
?>