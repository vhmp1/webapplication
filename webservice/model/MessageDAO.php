<?php

//ini_set('display_errors',1);
//ini_set('display_startup_erros',1);
//error_reporting(E_ALL);

require_once("../bd/Database.php");
require_once("../util/Response.php");

class MessageDAO{
    public function __construct(){}

    static public function getMessageLog($user) {
        $query = <<<SQL
                SELECT idUser, username, pic, message
				FROM Message AS m1
				JOIN (SELECT source, destiny, MAX(date) as date
				   	  FROM Message
				      WHERE destiny = :user
				   	  GROUP BY source, destiny) as m2
				ON m1.source = m2.source
				AND m1.destiny = m2.destiny
				AND m1.date = m2.date
				JOIN User
				ON m1.source = User.idUser
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
            $atual["pic"] = $data->pic;
            $atual["message"] = $data->message;
            $array[] = $atual;
        }

        return $array;
    }
 	
 	static public function getMessageHistory($user, $user2){
 		 $query = <<<SQL
                SELECT idUser, name, username, pic, message, date
				FROM Message
                JOIN User
				ON source = idUser
				WHERE source = :user
                AND destiny = :user2
                UNION
                SELECT idUser, name, username, pic, message, date
				FROM Message
                JOIN User
				ON source = idUser
                WHERE source = :user2
                AND destiny = :user
                ORDER BY date
SQL;
    	
        $database = new Database();
        $database = $database->getConn();
        $statement = $database->prepare($query);
        $statement->bindValue(':user', $user, PDO::PARAM_STR);
        $statement->bindValue(':user2', $user2, PDO::PARAM_STR);
        $statement->execute();
        $database = null;

        $array = array();
        while(($data = $statement->fetchObject()) !== false){
            $atual = array();
            $atual["idUser"] = $data->idUser;
            $atual["username"] = $data->username;
            $atual["name"] = $data->name;
            $atual["pic"] = $data->pic;
            $atual["message"] = $data->message;
            $array[] = $atual;
        }

        return $array;
 	}

 	static public function sendMessage($type, $user, $user2, $message){
 		$query = <<<SQL
                INSERT INTO Message (MessageType_idMessageType, MessageOrigin_idMessageOrigin, source, destiny, message)
                VALUES (:type, 1, :user, :user2, :message);
SQL;
    	
        $database = new Database();
        $database = $database->getConn();
        $statement = $database->prepare($query);
        $statement->bindValue(':type', $type, PDO::PARAM_STR);
        $statement->bindValue(':user', $user, PDO::PARAM_STR);
        $statement->bindValue(':user2', $user2, PDO::PARAM_STR);
        $statement->bindValue(':message', $message, PDO::PARAM_STR);
        $statement->execute();
        $database = null;

        return $statement->rowCount() > 0;
 	}

}

?>