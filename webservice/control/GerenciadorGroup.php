<?php

require_once("../model/GroupDAO.php");
class GerenciadorGroup {

    public function __construct() {
    }
    public function getGroups($user){
        return GroupDAO::getGroups($user);
    }
    public function getMembers($group){
        return GroupDAO::getMembers($group);
    }
    public function getGroupInfo($group){
        return GroupDAO::getGroupInfo($group);
    }
    public function addMember($group, $user){
        return GroupDAO::addMember($group, $user);
    }
    public function deleteMember($group, $user){
        return GroupDAO::deleteMember($group, $user);
    }
    public function createGroup($user, $groupname, $desc){
        return GroupDAO::createGroup($user, $groupname, $desc);
    }
}

?>