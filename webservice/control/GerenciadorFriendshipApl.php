<?php

session_start();
header("Access-Control-Allow-Origin: *");
require_once("../control/GerenciadorFriendship.php");

if( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
	$json = file_get_contents('php://input');
    $jsonObject = json_decode($json);
    $response = new Response();

    if( strcasecmp($jsonObject->method, "askFriendship") == 0 ) {
    	$user = $jsonObject->user;
        $newUser = $jsonObject->newUser;

        $response->status = GerenciadorFriendship::askFriendship($user, $newUser);

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode( $response );
    } elseif ( strcasecmp($jsonObject->method, "confirmFriendship") == 0 ) {
        $user = $jsonObject->user;
        $newUser = $jsonObject->newUser;

        $response->status = GerenciadorFriendship::confirmFriendship($user, $newUser);
        
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode( $response );
    } elseif ( strcasecmp($jsonObject->method, "cancelFriendship") == 0 ) {
        $user = $jsonObject->user;
        $newUser = $jsonObject->newUser;

        $response->status = GerenciadorFriendship::cancelFriendship($user, $newUser);
        
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode( $response );
    } elseif ( strcasecmp($jsonObject->method, "getFriends") == 0 ) {
        $user = $jsonObject->user;

        $response->message = GerenciadorFriendship::getFriends($user);
        $response->status = !empty($response->message);
        
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode( $response );
    }
}