<?php
/*
require 'config.php';
$action = isset($_GET["action"]) ? $_GET["action"] : "";

switch ($action) {
    case 'viewArticle':
        viewArticle();
        break;

    default:
        homepage();
        break;    
}

function viewArticle() {
    if( !isset($_GET["articleId"]) || !$_GET["articleId"] ){
        homepage();
        return;
    }
    $results = array();
    $results["article"] = Article::getById( (int) $_GET["articleId"]);
    $results["pagetTitle"] = $results["article"]->title . " | ".PAGE_TITLE;
    
    //throw new Exception;
    require TEMPLATE_PATH .'/viewArticle.php';
}

function homepage(){
    $results = array();
    $data = Article::getList(HOMEPAGE_NUM_ARTICLES);
    $results["articles"] = $data["articles"];
    $results["totalRows"] = $data["totalRows"];
    $results["pageTitle"] = PAGE_TITLE;
    
    
    require TEMPLATE_PATH . '/homepage.php';
}*/

header("Location: admin.php");
?>
