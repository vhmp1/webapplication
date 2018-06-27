<?php
define('__PATH_FULL_URL__', 'localhost/webapplication/webservice/');

class Database {
    private $pdo;

    public function __construct(){}
    public function __destruct(){
        $this->pdo = null;
    }

    /**
     * @return PDO
     */
    public function getConn(){
        if( is_object($this->pdo) ){
            return($this->pdo);
        }
        try{
            /// Notebook
            $this->pdo = new PDO("mysql:host=127.0.0.1;dbname=webapplication", "root", "Cadlya19");
            /// Sala
            //$this->pdo = new PDO("mysql:host=127.0.0.1;dbname=webapplication", "root", "aluno");
        } catch(PDOException $e){
            echo $e;
            exit(false);
        }

        return($this->pdo);
    }

    public function setConn($pdo){
        $this->pdo = $pdo;
    }
}

?>