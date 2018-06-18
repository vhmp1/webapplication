<?php
require_once("../bd/Database.php");
require_once("../util/Response.php");

class SessaoDAO{

    public function __construct(){}

    static public function efetuarLogin($login, $senha) {
        $senha = md5($senha);

        $query = <<<SQL
                SELECT *
                FROM User
                WHERE username = :username AND
                password = :password
SQL;

        $database = new Database();
        $database = $database->getConn();
        $statement = $database->prepare($query);
        $statement->bindValue(':username', $login, PDO::PARAM_INT);
        $statement->bindValue(':password', $senha, PDO::PARAM_STR);
        $statement->execute();
        $database = null;

        return ($statement->rowCount() > 0);
    }

     static public function efetuarCadastro($login, $senha) {
        $senha = md5($senha);

        $query = <<<SQL
                INSERT INTO User ('username', 'password')
                VALUES (:username, :password)
SQL;

        $database = new Database();
        $database = $database->getConn();
        $statement = $database->prepare($query);
        $statement->bindValue(':username', $login, PDO::PARAM_INT);
        $statement->bindValue(':password', $senha, PDO::PARAM_STR);
        $statement->execute();
        $database = null;

        return ($statement->rowCount() > 0);
    }

}