<?php

session_start();
header("Access-Control-Allow-Origin: *");
require_once("../control/GerenciadorMessage.php");

if( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
	$json = file_get_contents('php://input');
    $jsonObject = json_decode($json);
    $response = new Response();

    if( strcasecmp($jsonObject->method, "getMessageLog") == 0 ) {
    	$user = $jsonObject->user;

        $response->message = GerenciadorMessage::getMessageLog($user);
        $response->status = !empty($response->message);
        
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode( $response );
    } elseif ( strcasecmp($jsonObject->method, "getMessageHistory") == 0) {
    	$user = $jsonObject->user;
    	$user2 = $jsonObject->user2;

        $response->message = GerenciadorMessage::getMessageHistory($user, $user2);
        $response->status = !empty($response->message);
        
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode( $response );
    } elseif ( strcasecmp($jsonObject->method, "sendMessage") == 0) {
    	$type = $jsonObject->type;
    	$user = $jsonObject->user;
    	$user2 = $jsonObject->user2;
    	$message = $jsonObject->message;

        $response->status = GerenciadorMessage::sendMessage($type, $user, $user2, $message);
       
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode( $response );
    }

}
