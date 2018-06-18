<?php

session_start();
header("Access-Control-Allow-Origin: *");
//require_once('../util/autoload.php');
// require_once("../model/Sessao.php");
// require_once("../util/Response.php");
require_once("../control/GerenciadorSessao.php");
// require_once("../bd/Database.php");

if( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
	$json = file_get_contents('php://input');
    $jsonObject = json_decode($json);
    $response = new Response();
    if( strcasecmp($jsonObject->method, "efetuarLogin") == 0 ) {
    	$login = $jsonObject->login;
        $senha = $jsonObject->senha;

        $response->status = GerenciadorSessao::efetuarLogin($login, $senha);
        
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode( $response );
    }
}