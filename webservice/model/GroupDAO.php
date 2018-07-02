<?php

 ini_set('display_errors',1);
 ini_set('display_startup_erros',1);
//error_reporting(E_ALL);

require_once("../bd/Database.php");
require_once("../util/Response.php");

class GroupDAO{
    public function __construct(){}
    
    static public function getGroups($user) {
        $query = <<<SQL
                SELECT idGroup, groupname, pic
				FROM User_has_Group
				JOIN Groups
				ON Group_idGroup = idGroup
				WHERE User_idUser = :user
SQL;
    	
        $database = new Database();
        $database = $database->getConn();
        $statement = $database->prepare($query);
        $statement->bindValue(':user', $user, PDO::PARAM_STR);
        $statement->execute();
        $database = null;

        $array = array();
        while(($data = $statement->fetchObject()) !== false){
            $atual = array();
            $atual["idGroup"] = $data->idGroup;
            $atual["groupname"] = $data->groupname;
            $atual["pic"] = $data->pic;
            $array[] = $atual;
        }

        return $array;
    }

    static public function createGroup($user, $groupname, $desc){
 		$query = <<<SQL
                INSERT INTO Groups(groupname, description)
				VALUES (:groupname, :desc)
SQL;
    	
        $database = new Database();
        $database = $database->getConn();
        $statement = $database->prepare($query);
        $statement->bindValue(':groupname', $groupname, PDO::PARAM_STR);
        $statement->bindValue(':desc', $desc, PDO::PARAM_STR);
        $statement->execute();
        $lastId = $database->lastInsertId();
        $database = null;

        if($statement->rowCount() == 0)
        	return false;

        return GroupDAO::addMemberById($lastId, $user);
    }

    static public function getGroupInfo($group){
    	$query = <<<SQL
                SELECT idGroup, groupname, pic, description
				FROM Groups
				WHERE idGroup = :group
SQL;
    	
        $database = new Database();
        $database = $database->getConn();
        $statement = $database->prepare($query);
        $statement->bindValue(':group', $group, PDO::PARAM_STR);
        $statement->execute();
        $database = null;

        return $statement->fetchObject();
    }

    static public function getMembers($group){
    	$query = <<<SQL
                SELECT idUser, name, username, pic
				FROM User_has_Group
				JOIN User
                ON idUser = User_idUser
				WHERE Group_idGroup = :group
SQL;
    	
        $database = new Database();
        $database = $database->getConn();
        $statement = $database->prepare($query);
        $statement->bindValue(':group', $group, PDO::PARAM_STR);
        $statement->execute();
        $database = null;

        $array = array();
        while(($data = $statement->fetchObject()) !== false){
            $atual = array();
            $atual["idUser"] = $data->idUser;
            $atual["name"] = $data->name;
            $atual["username"] = $data->username;
            $atual["pic"] = $data->pic;
            $array[] = $atual;
        }

        return $array;
    }

    static public function addMemberById($group, $user){
    	$query = <<<SQL
                INSERT INTO User_has_Group (Group_idGroup, User_idUser) 
                VALUES (:group, :user)
SQL;
    	
        $database = new Database();
        $database = $database->getConn();
        $statement = $database->prepare($query);
        $statement->bindValue(':user', $user, PDO::PARAM_INT);
        $statement->bindValue(':group', $group, PDO::PARAM_STR);
        $statement->execute();
        $database = null;

        return $statement->rowCount() > 0;
    }

    static public function addMember($group, $user){
    	$query = <<<SQL
                SELECT idUser
                FROM User
                WHERE username = :user
SQL;
        $database = new Database();
        $database = $database->getConn();
        $statement = $database->prepare($query);
        $statement->bindValue(':user', $user, PDO::PARAM_STR);
        $statement->execute();
        $database = null;

        if(($data = $statement->fetchObject()) == false)
        	return false;

        return GroupDAO::addMemberById($group, $data->idUser);
    }

    static public function deleteMember($group, $user){
    	$query = <<<SQL
                DELETE FROM User_has_Group
                WHERE User_idUser = :user
                AND Group_idGroup = :group
SQL;
    	
        $database = new Database();
        $database = $database->getConn();
        $statement = $database->prepare($query);
        $statement->bindValue(':user', $user, PDO::PARAM_STR);
        $statement->bindValue(':group', $group, PDO::PARAM_STR);
        $statement->execute();
        $database = null;

        return $statement->rowCount() > 0;
    }
}

?>