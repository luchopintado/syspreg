<?php

require 'config.php';
session_start();

$_SESSION["menu"] = "academico";

$action = isset($_GET["action"]) ? $_GET["action"] :  "";
$username = isset($_SESSION["username"]) ? $_SESSION["username"] : "";
if($action!= "login" && $action!="logout" && !$username){
    login();
    exit;
}


switch ($action) {
    
    /*****************      LOGIN     **********************/
    
    case 'login':
        login();
        break;
    
    case 'logout':
        logout();
        break;
    
    
    /*****************      AREAS      **********************/
    
    case 'listAreas':
        listAreas();
        break;
    
    case 'newArea':
        newArea();
        break;
    
    case 'editArea':
        editArea();
        break;
    
    case 'deleteArea':
        deleteArea();
        break;
    
    
    /*****************      CAPACIDADES      **********************/
    
    
    case 'listCapacidades':
        listCapacidades();
        break;
    
    case 'newCapacidad';
        newCapacidad();
        break;
    
    case 'editCapacidad';
        editCapacidad();
        break;
    
    case 'deleteCapacidad';
        deleteCapacidad();
        break;
    
    
    /*****************      CURSOS      **********************/
    
    case 'newCurso':
        newCurso();
        break;
    
    case 'editCurso':
        editCurso();
        break;
    
    case 'listCursos':
        listCursos();
        break;
    
    case 'deleteCurso':
        deleteCurso();
        break;
    
    
    /*****************      CURSO-GRADO      **********************/
    
    case 'newCursoGrado':
        newCursoGrado();
        break;
    
    case 'listCursosgrados':
        listCursoGrados();
        break;
    
    case 'deleteCursoGrado':
        deleteCursoGrado();
        break;
    
    
    /*****************      TEMAS      **********************/
    
    case 'listTemas':
        listTemas();
        break;
    
    case 'newTema':
        newTema();
        break;

    case 'editTema':
        editTema();
        break;
    
    case 'deleteTema':
        deleteTema();
        break;

    
    /*****************      SUBTEMAS      **********************/
    
    case 'listSubtemas':
        listSubTemas();
        break;
    
    case 'newSubtema':
        newSubTema();
        break;

    case 'editSubtema':
        editSubTema();
        break;
    
    case 'deleteSubtema':
        deleteSubTema();
        break;
        
    
    
    
    default:
        listAreas();
        break;
}


function login() {
    $results = array();
    $results["pageTitle"] = "Inicio de Sesi&oacute;n | ". PAGE_TITLE;
    
    if(isset($_POST["login"])){
        $user = $_POST["username"];
        $pass = $_POST["password"];
        
        if(Usuario::checkLogin($user, $pass)){
            
        }
        
        if($_POST["username"]==ADMIN_USERNAME && $_POST["password"]==ADMIN_PASSWORD){
            $_SESSION["username"] = ADMIN_USERNAME;
            header("Location: admin.php");
        }else{
            $results["errorMessage"] = "Incorrect username or password. Please try again";
            require TEMPLATE_PATH . '/admin/loginForm.php';
        }
    }  else {
        require TEMPLATE_PATH . '/admin/loginForm.php';
    }
}

function logout() {
    unset($_SESSION["username"]);
    header("Location: admin.php");
}





########################################################################################################################
######################################     AREAS     ###################################################################
########################################################################################################################

function listAreas() {    
    $results = array();
    
    $data = Area::getList();
    $results["areas"] = $data["areas"];
    $results["totalRows"] = $data["totalRows"];
    $results["pageTitle"] = "&Aacute;reas";
    $results["indice"] = "areas";
    
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
        $results["formAction"] = "newArea";
        require TEMPLATE_PATH . "/admin/editArea.php";        
    }else{
        require TEMPLATE_PATH . "/admin/listAreas.php";
        
    }
}

function newArea() {
    $results = array();
    
    $results["pageTitle"] = "Nueva &Aacute;rea";
    $results["formAction"] = "newArea";
    $results["indice"] = "areas";
    
    if(isset($_POST["saveChanges"])){
        $article = new Area;
        $article->storeFormValues($_POST);
        $article->insert();
        header("Location: admin.php?action=listAreas&status=changesSaved");
    }elseif(isset($_POST["cancel"])){
        header("Location: admin.php?action=listAreas");
    }else{
        $results["area"] = new Area;
        require TEMPLATE_PATH . "/admin/editArea.php";
    }
}


function editArea() {
    $results = array();
    
    $results["pageTitle"] = "Editar &Aacute;rea";
    $results["formAction"] = "editArea";
    $results["indice"] = "areas";
    
    if(isset($_POST["saveChanges"])){        
        if(!$area = Area::getById((int)$_POST["cod_area"])){
            header("Location: admin.php?error=articleNotFound");
            return;
        }
        $area->storeFormValues($_POST);
        $area->update();
        //print_r($_POST);
        header("Location: admin.php?action=listAreas&status=changesSaved");
    } elseif(isset ($_POST["cancel"])){
        header("Location: admin.php?action=listAreas");
    } else{
        if(!$area = Area::getById( (int)$_GET["cod_area"])){
            header("Location: admin.php?action=listAreas&error=articleNotFound");
            return;
        }else{
            $results["area"] = $area;
            require TEMPLATE_PATH . "/admin/editArea.php";            
        }
    }
}

function deleteArea() {
    if (!$area = Area::getById( (int)$_GET["cod_area"])) {
        header("Location: admin.php?error=articleNotFound");
        return;
    }
    $area->delete();
    header("Location: admin.php?status=articleDeleted");
}


########################################################################################################################
#####################################       CAPACIDADES ################################################################
########################################################################################################################


function listCapacidades() {    
    $results = array();
    
    $data = Capacidad::getList();
    $results["capacidades"] = $data["capacidades"];
    $results["totalRows"] = $data["totalRows"];
    $results["pageTitle"] = "Capacidades";
    $results["indice"] = "capacidades";
    
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
        $results["formAction"] = "newCapacidad";
        require TEMPLATE_PATH . "/admin/editCapacidad.php";        
    }else{
        require TEMPLATE_PATH . "/admin/listCapacidades.php";        
    }
}

function newCapacidad() {
    $results = array();
    $results["pageTitle"] = "Nueva Capacidad";
    $results["formAction"] = "newCapacidad";
    $results["indice"] = "capacidades";
    
    if (isset($_POST["saveChanges"])) {
        $capacidad = new Capacidad;
        $capacidad->storeFormValues($_POST);
        $capacidad->insert();
        header("Location: admin.php?action=listCapacidades&status=changesSaved");
    } elseif (isset($_POST["cancel"])) {
        header("Location: admin.php?action=listCapacidades");
    } else {
        $results["capacidad"] = new Capacidad;
        require TEMPLATE_PATH . "/admin/editCapacidad.php";
    }
}

function editCapacidad() {
    $results = array();
    $results["pageTitle"] = "Editar Capacidad";    
    $results["formAction"] = "editCapacidad";
    $results["indice"] = "capacidades";
    
    if (isset($_POST["saveChanges"])) {
        if (!$capacidad = Capacidad::getById((int) $_POST["cod_capacidad"])) {
            header("Location: admin.php?action=listCapacidades&error=articleNotFound");
            return;
        }
        $capacidad->storeFormValues($_POST);
        $capacidad->update();
        header("Location: admin.php?action=listCapacidades&status=changesSaved");
    } elseif (isset($_POST["cancel"])) {
        header("Location: admin.php?action=listCapacidades");
    } else {
        if (!$capacidad = Capacidad::getById((int) $_GET["cod_capacidad"])) {
            header("Location: admin.php?action=listCapacidades&error=articleNotFound");
            return;
        } else {
            $results["capacidad"] = $capacidad;
            require TEMPLATE_PATH . "/admin/editCapacidad.php";
        }
    }
}

function deleteCapacidad() {    
    if (!$capacidad = Capacidad::getById((int) $_GET["cod_capacidad"])) {
        header("Location: admin.php?action=listCapacidades&error=articleNotFound");
        return;
    }
    $capacidad->delete();
    header("Location: admin.php?action=listCapacidades&status=articleDeleted");
}

########################################################################################################################
#####################################       CURSO       ################################################################
########################################################################################################################



function newCurso() {
    $results = array();
    $results["pageTitle"] = "Nuevo Curso";
    $results["formAction"] = "newCurso";
    $results["indice"] = "cursos";
    
    if(isset($_POST["saveChanges"])){
        $curso = new Curso;
        $curso->storeFormValues($_POST);
        $curso->insert();
        header("Location: admin.php?action=listCursos&status=changesSaved");
    }elseif(isset($_POST["cancel"])){
        header("Location: admin.php?action=listCursos");
    }else{
        $results["curso"] = new Curso;
        require TEMPLATE_PATH . "/admin/editCurso.php";
    }
}

function editCurso() {
    $results = array();
    $results["pageTitle"] = "Editar Curso";
    $results["formAction"] = "editCurso";
    $results["indice"] = "cursos";
    
    if(isset($_POST["saveChanges"])){
        if(!$curso = Curso::getById((int)$_POST["cod_curso"])){
            header("Location: admin.php?action=listCursos&error=articleNotFound");
            return;
        }
        $curso->storeFormValues($_POST);
        $curso->update();
        header("Location: admin.php?action=listCursos&status=changesSaved");
    } elseif(isset ($_POST["cancel"])){
        header("Location: admin.php?action=listCursos");
    } else{
        if(!$curso = Curso::getById( (int)$_GET["cod_curso"])){
            header("Location: admin.php?action=listCursos&error=articleNotFound");
            return;
        }else{
            $results["curso"] = $curso;
            require TEMPLATE_PATH . "/admin/editCurso.php";
        }
    }
}

function listCursos() {
    $results = array();
    $data = Curso::getList(100);
    
    $results["cursos"] = $data["cursos"];
    $results["totalRows"] = $data["totalRows"];
    $results["pageTitle"] = "Cursos";
    $results["indice"] = "cursos";
    
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
    
    if($data["totalRows"] == 0){
        $results["formAction"] = "editCurso";
        require TEMPLATE_PATH . "/admin/editCurso.php";
    }else{
        require TEMPLATE_PATH . "/admin/listCursos.php";
    }
}

function deleteCurso() {    
    if (!$curso = Curso::getById((int) $_GET["cod_curso"])) {
        header("Location: admin.php?action=listCursos&error=articleNotFound");
        return;
    }
    $curso->delete();
    header("Location: admin.php?action=listCursos&status=articleDeleted");
}

########################################################################################################################
#######################################      TEMA       ################################################################
########################################################################################################################


function newTema() {
    $results = array();
    $results["pageTitle"] = "Nuevo Tema";
    $results["formAction"] = "newTema";
    $results["indice"] = "temas";
    if(isset($_POST["saveChanges"])){
        $tema = new Tema;
        $tema->storeFormValues($_POST);        
        $tema->insert();
        header("Location: admin.php?action=listTemas&status=changesSaved");
    }elseif(isset($_POST["cancel"])){
        header("Location: admin.php?action=listTemas");
    }else{
        $results["tema"] = new Tema;
        require TEMPLATE_PATH . "/admin/editTema.php";
    }
}

function editTema() {
    $results = array();
    $results["pageTitle"] = "Editar Tema";
    $results["formAction"] = "editTema";
    $results["indice"] = "temas";

    if(isset($_POST["saveChanges"])){
        if(!$tema = Tema::getById((int)$_POST["cod_tema"])){
            header("Location: admin.php?action=listTemas&error=articleNotFound");
            return;
        }
        $tema->storeFormValues($_POST);
        $tema->update();
        header("Location: admin.php?status=changesSaved");
    } elseif(isset ($_POST["cancel"])){
        header("Location: admin.php?action=listTemas");
    } else{
        if(!$tema = Tema::getById( (int)$_GET["cod_tema"])){
            header("Location: admin.php?action=listTemas&error=articleNotFound");
            return;
        }else{
            $results["tema"] = $tema;
            require TEMPLATE_PATH . "/admin/editTema.php";
        }
    }
}

function deleteTema() {
    if (!$tema = Tema::getById( (int)$_GET["cod_tema"])) {
        header("Location: admin.php?error=articleNotFound");
        return;
    }
    $tema->delete();
    header("Location: admin.php?action=listTemas&status=articleDeleted");
}


function listTemas() {
    $results = array();
    $data = Tema::getList();
    $results["temas"] = $data["temas"];
    $results["totalRows"] = $data["totalRows"];
    $results["pageTitle"] = "Temas";
    $results["indice"] = "temas";

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
    if($data["totalRows"] == 0){
        $results["formAction"] = "newTema";
        require TEMPLATE_PATH . "/admin/editTema.php";
    }else{
        require TEMPLATE_PATH . "/admin/listTemas.php";
    }
}


########################################################################################################################
######################################         SUBTEMA        ##########################################################
########################################################################################################################


function newSubTema() {
    $results = array();
    $results["pageTitle"] = "Nuevo SubTema";
    $results["formAction"] = "newSubtema";
    $results["indice"] = "subtemas";

    if (isset($_POST["saveChanges"])) {
        $subtema = new SubTema;
        $subtema->storeFormValues($_POST);
        $subtema->insert();
        header("Location: admin.php?action=listSubtemas&status=changesSaved");
    } elseif (isset($_POST["cancel"])) {
        header("Location: admin.php?action=listSubtemas");
    } else {
        $results["subtema"] = new SubTema;
        require TEMPLATE_PATH . "/admin/editSubTema.php";
    }
}

function editSubTema() {
    $results = array();
    $results["pageTitle"] = "Editar SubTema";
    $results["formAction"] = "editSubtema";
    $results["indice"] = "subtemas";

    if (isset($_POST["saveChanges"])) {
        if (!$subtema = SubTema::getById((int) $_POST["cod_subtema"])) {
            header("Location: admin.php?action=listSubtemas&error=articleNotFound");
            return;
        }
        $subtema->storeFormValues($_POST);
        $subtema->update();
        header("Location: admin.php?action=listSubtemas&status=changesSaved");
    } elseif (isset($_POST["cancel"])) {
        header("Location: admin.php?action=listSubtemas");
    } else {
        if (!$subtema = SubTema::getById((int) $_GET["cod_subtema"])) {
            header("Location: admin.php?action=listSubtemas&error=articleNotFound");
            return;
        } else {
            $results["subtema"] = $subtema;
            require TEMPLATE_PATH . "/admin/editSubTema.php";
        }
    }
}

function listSubTemas() {
    $results = array();
    $data = SubTema::getList();
    $results["subtemas"] = $data["subtemas"];
    $results["totalRows"] = $data["totalRows"];
    $results["pageTitle"] = "SubTemas";
    $results["indice"] = "subtemas";

    if (isset($_GET["error"])) {
        if ($_GET["error"] == "articleNotFound") {
            $results["errorMessage"] = MESSAGE_ARTICLE_NOT_FOUND;
        }
    }
    if (isset($_GET["status"])) {
        if ($_GET["status"] == "changesSaved") {
            $results["statusMessage"] = MESSAGE_CHANGES_SAVED;
        }
        if ($_GET["status"] == "articleDeleted") {
            $results["statusMessage"] = MESSAGE_ARTICLE_DELETED;
        }
    }
    if ($data["totalRows"] == 0) {
        $results["formAction"] = "newSubtema";
        require TEMPLATE_PATH . "/admin/editSubTema.php";
    } else {
        require TEMPLATE_PATH . "/admin/listSubTemas.php";
    }
}

function deleteSubTema() {
    if (!$subtema = SubTema::getById((int) $_GET["cod_subtema"])) {
        header("Location: admin.php?action=listSubtemas&error=articleNotFound");
        return;
    }
    $subtema->delete();
    header("Location: admin.php?action=listSubtemas&status=articleDeleted");
}





########################################################################################################################
#####################################         CURSO - GRADO      #######################################################
########################################################################################################################


function newCursoGrado() {
    $results = array();
    $results["pageTitle"] = "Asignacion de Curso-Grado";
    $results["formAction"] = "newCursoGrado";
    $results["indice"] = "cursosgrados";
    
    if(isset($_POST["saveChanges"])){
        $cursogrado = new CursoGrado;
        $cursogrado->storeFormValues($_POST);
        $cursogrado->insert();        
        header("Location: admin.php?action=listCursosgrados&status=changesSaved");
    }elseif(isset($_POST["cancel"])){
        header("Location: admin.php?action=listCursoGrados");
    }else{
        $results["cursogrado"] = new CursoGrado;
        require TEMPLATE_PATH . "/admin/editCursoGrado.php";
    }
}

function listCursoGrados() {
    $results = array();
    $data = CursoGrado::getList();
    
    $results["cursogrados"] = $data["cursogrados"];
    $results["totalRows"] = $data["totalRows"];
    $results["pageTitle"] = "Cursos - Grados";
    $results["indice"] = "cursosgrados";
    
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
    if($data["totalRows"] == 0){
        $results["formAction"] = "newCursoGrado";
        require TEMPLATE_PATH . "/admin/editCursoGrado.php";
    }else{
        require TEMPLATE_PATH . "/admin/listCursoGrado.php";
    }
}
function deleteCursoGrado() {
    if (!$cursogrado = CursoGrado::getById( (int)$_GET["cod_curso"], (int)$_GET["cod_grado"])) {
        header("Location: admin.php?action=listCursosgrados&error=articleNotFound");
        return;
    }
    $cursogrado->delete();
    header("Location: admin.php?action=listCursosgrados&status=articleDeleted");
}

?>
