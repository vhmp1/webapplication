<?php

require_once("../model/SessaoDAO.php");
class GerenciadorSessao {

    public function __construct() {
    }
    public function efetuarLogin($usuario,$senha){
        return SessaoDAO::efetuarLogin($usuario,$senha);
    }
    public function efetuarCadastro($name, $login, $pass, $email){
        return SessaoDAO::efetuarCadastro($name, $login, $pass, $email);
    }
    public function confirmarCadastro($key){
    	return SessaoDAO::confirmarCadastro($key);
    }
    public function getData($user){
        return SessaoDAO::getData($user);
    }
    public function updateData($user, $username, $pic){
        return SessaoDAO::updateData($user, $username, $pic);
    }
    public function search($pattern){
        return SessaoDAO::search($pattern);
    }
    public function uploadPic($user, $file){
        return SessaoDAO::uploadPic($user, $file);
    }
}

?>