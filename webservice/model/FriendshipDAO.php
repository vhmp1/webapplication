<?php

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
//error_reporting(E_ALL);

require_once("../bd/Database.php");
require_once("../util/Response.php");

class FriendshipDAO{

    public function __construct(){}

    static public function askFriendship($user, $newUser) {
        $query = <<<SQL
                INSERT INTO User_has_Friend(User_idUser, User_idUser1)
                VALUES (:user, :newUser)

SQL;
    
        $database = new Database();
        $database = $database->getConn();
        $statement = $database->prepare($query);
        $statement->bindValue(':user', $user, PDO::PARAM_STR);
        $statement->bindValue(':newUser', $newUser, PDO::PARAM_STR);
        $statement->execute();
        $database = null;

        return $statement->rowCount() > 0;
    }

    static public function confirmFriendship($user, $newUser) {
        $query = <<<SQL
                UPDATE User_has_Friend
                SET status = 2
                WHERE User_idUser = :user 
                AND User_idUser1 = :newUser

SQL;
    
        $database = new Database();
        $database = $database->getConn();
        $statement = $database->prepare($query);
        $statement->bindValue(':user', $user, PDO::PARAM_STR);
        $statement->bindValue(':newUser', $newUser, PDO::PARAM_STR);
        $statement->execute();
        $database = null;

        return $statement->rowCount() > 0;
    }

    static public function cancelFriendship($user, $newUser) {
        $query = <<<SQL
                UPDATE User_has_Friend
                SET status = 3
                WHERE User_idUser = :user 
                AND User_idUser1 = :newUser

SQL;
    
        $database = new Database();
        $database = $database->getConn();
        $statement = $database->prepare($query);
        $statement->bindValue(':user', $user, PDO::PARAM_STR);
        $statement->bindValue(':newUser', $newUser, PDO::PARAM_STR);
        $statement->execute();
        $database = null;

        return $statement->rowCount() > 0;
    }

    static public function getFriends($user) {
        $query = <<<SQL
                (SELECT idUser, username, name, pic
                FROM User
                JOIN User_has_Friend ON 
                User_idUser = idUser
                WHERE User_idUser = :user
                AND status = 2)
                UNION
                (SELECT idUser, username, name, pic
                FROM User
                JOIN User_has_Friend ON 
                User_idUser1 = idUser
                WHERE User_idUser1 = :user
                AND status = 2)

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
            $atual["idUser"] = $data->idUser;
            $atual["username"] = $data->username;
            $atual["name"] = $data->name;
            $atual["pic"] = $data->pic;
            $array[] = $atual;
        }

        return $array;
    }

}