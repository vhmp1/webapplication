<?php

session_start();
header("Access-Control-Allow-Origin: *");
require_once("../control/GerenciadorGroup.php");

if( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
	$json = file_get_contents('php://input');
    $jsonObject = json_decode($json);
    $response = new Response();

    if( strcasecmp($jsonObject->method, "getGroups") == 0 ) {
    	$user = $jsonObject->user;

        $response->message = GerenciadorGroup::getGroups($user);
        $response->status = !empty($response->message);

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode( $response );
    } elseif( strcasecmp($jsonObject->method, "createGroup") == 0 ) {
        $user = $jsonObject->user;
        $groupname = $jsonObject->groupname;
        $desc = $jsonObject->desc;
        
        $response->status = GerenciadorGroup::createGroup($user, $groupname, $desc);

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode( $response );
    } elseif( strcasecmp($jsonObject->method, "getMembers") == 0 ) {
        $group = $jsonObject->group;

        $response->message = GerenciadorGroup::getMembers($group);
        $response->status = !empty($response->message);

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode( $response );
    } elseif( strcasecmp($jsonObject->method, "getGroupInfo") == 0 ) {
        $group = $jsonObject->group;

        $response->message = GerenciadorGroup::getGroupInfo($group);
        $response->status = !empty($response->message);

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode( $response );
    } elseif( strcasecmp($jsonObject->method, "addMember") == 0 ) {
        $group = $jsonObject->group;
        $user = $jsonObject->user;

        $response->status = GerenciadorGroup::addMember($group, $user);

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode( $response );
    } elseif( strcasecmp($jsonObject->method, "deleteMember") == 0 ) {
        $group = $jsonObject->group;
        $user = $jsonObject->user;

        $response->status = GerenciadorGroup::deleteMember($group, $user);

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode( $response );
    }
}