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

        $response->message = GerenciadorSessao::efetuarLogin($login, $senha);
        $response->status = !empty($response->message);
        
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode( $response );
    } elseif ( strcasecmp($jsonObject->method, "signup") == 0 ) {
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
    } elseif ( strcasecmp($jsonObject->method, "getData") == 0 ) {
        $user = $jsonObject->user;

        $response->message = GerenciadorSessao::getData($user);
        $response->status = !empty($response->message);
        
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode( $response );
    } elseif ( strcasecmp($jsonObject->method, "updateData") == 0 ) {
        $user = $jsonObject->user;
        $username = $jsonObject->username;
        $pic = $jsonObject->pic;

        $response->status = GerenciadorSessao::updateData($user, $username, $pic);
        
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode( $response );
    } elseif ( strcasecmp($jsonObject->method, "search") == 0 ) {
        $pattern = $jsonObject->pattern;

        $response->message = GerenciadorSessao::search($pattern);
        $response->status = !empty($response->message);
        
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode( $response );
    } 

}