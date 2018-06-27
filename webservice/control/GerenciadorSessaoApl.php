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
    if( strcasecmp($jsonObject->method, "login") == 0 ) {
    	$login = $jsonObject->login;
        $senha = $jsonObject->pass;

        $response->status = GerenciadorSessao::efetuarLogin($login, $senha);
        
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode( $response );
    } elseif ( strcasecmp($jsonObject->method, "singup") == 0 ) {
        $name = $jsonObject->name;
        $login = $jsonObject->login;
        $pass = $jsonObject->pass;
        $email = $jsonObject->email;

        $response->status = GerenciadorSessao::efetuarCadastro($name, $login, $pass, $email);
        
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode( $response );
    } elseif ( strcasecmp($jsonObject->method, "confirmUser") == 0 ) {
        $key = $jsonObject->key;

        $response->status = GerenciadorSessao::confirmarCadastro($key);
        
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode( $response );
    }
}