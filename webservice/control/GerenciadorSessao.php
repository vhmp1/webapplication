<?php

require_once("../model/SessaoDAO.php");
class GerenciadorSessao {

    public function __construct() {
    }
    public function efetuarLogin($usuario,$senha){
        return SessaoDAO::efetuarLogin($usuario,$senha);
    }
}