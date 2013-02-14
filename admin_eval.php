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
    
    case 'ingresarPregunta':
        formIngresarPregunta();
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
    
    case 'getCursoByGrado':
        getCursoByGrado();
        break;
    
    case 'getTemaByCurso':
        getTemaByCurso();        
        break;
    
    case 'getSubtemaByTema':
        getSubtemaByTema();
        break;
    
    case 'getRandomQuestions':
        getRandomQuestions();
        break;
    
    case 'saveQuestion':
        saveQuestion();
        break;
    
    case 'saveEvaluation':
        saveEvaluation();
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

function formIngresarPregunta() {
    $results = array();
    
    $data = Area::getList();
    //$results["areas"] = $data["areas"];
    $results["totalRows"] = $data["totalRows"];
    $results["pageTitle"] = "Ingresar pregunta al banco";
    $results["indice"] = "ingresar";
    $results["formAction"] = "saveQuestion";
    
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
        require TEMPLATE_PATH . "/admin_eval/ingresarPregunta.php";        
    }else{
        require TEMPLATE_PATH . "/admin_eval/ingresarPregunta.php";
        
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
    $_SESSION["preguntas"] = serialize($ids_preguntas);
    
    echo json_encode(array("preguntas"=>$preguntas_total, "totalCount"=>count($preguntas_total)));
}

function saveQuestion() {
    $question = new Pregunta;
    $question->storeFormValues($_POST);
    //print_r($_POST);return;
    $mysqli = $question->insert();
    $insert_id = $mysqli->insert_id;
    if($mysqli->affected_rows == 1){
        $alts = $_POST["alt"];
        $resps = $_POST["resp"];
        for($i=0; $i<5; $i++){
            $alternativa = new Alternativa;
            $options = array("cod_alternativa"=>"", "cod_pregunta"=>$insert_id, "valor"=>$alts[$i], "correcta"=>($resps[$i]==="true"?1:0));
            $alternativa->storeFormValues($options);
            $alternativa->insert();
        }
        return array("success"=>true);
    }else{
        return array("success"=>false);
    }
}

function saveEvaluation(){
    
    $evaluacion = new Evaluacion;
    $evaluacion->storeFormValues($_POST);
    $mysqli = $evaluacion->insert();
    $insert_id = $mysqli->insert_id;
    return;
    if($mysqli->affected_rows == 1){
        $preguntas = unserialize($_SESSION["preguntas"]);
        $evaluacion->savePreguntas($preguntas);
        return array("success"=>true);
    }else{
        return array("success"=>false);
    }
}
?>
