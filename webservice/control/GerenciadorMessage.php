<?php

require_once("../model/MessageDAO.php");
class GerenciadorMessage {

    public function __construct() {
    }
    public function getMessageLog($user){
        return MessageDAO::getMessageLog($user);
    }
    public function getMessageHistory($user, $user2){
        return MessageDAO::getMessageHistory($user, $user2);
    }
    public function sendMessage($type, $user, $user2, $message){
        return MessageDAO::sendMessage($type, $user, $user2, $message);
    }
}

?>