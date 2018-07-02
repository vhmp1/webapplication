<?php

require_once("../model/FriendshipDAO.php");
class GerenciadorFriendship {

    public function __construct() {
    }
    public function askFriendship($user, $newUser){
        return FriendshipDAO::askFriendship($user, $newUser);
    }
    public function confirmFriendship($user, $newUser){
        return FriendshipDAO::confirmFriendship($user, $newUser);
    }
    public function cancelFriendship($user, $newUser){
    	return FriendshipDAO::cancelFriendship($user, $newUser);
    }
    public function getFriends($user){
        return FriendshipDAO::getFriends($user);
    }
     public function getFriendshipRequest($user){
        return FriendshipDAO::getFriendshipRequest($user);
    }
}

?>