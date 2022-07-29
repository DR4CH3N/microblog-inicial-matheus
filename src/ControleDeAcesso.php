<?php

namespace Microblog;

final class ControleDeAcesso 
{
    public function __construct()
    {
        // Se NÃO EXISTIR uma sessão em funcionamento

        if ( !isset($_SESSION) ) {

            // então iniciamos a sessão
            session_start();
        }
    }

    public function verificaAcesso():void {
        // se NÃO EXISTIR uma variavel de acesso relacionada ao ID do usuario logado...
        
        if ( !isset($_SESSION['id']) ) {
            
            /* então significa que o usuario não esta logado, portanto apague qualquer
            requicio de sessão e force o usuario a ir para o login.php */
            session_destroy();
            header("location:../login.php?acesso_proibido");
            die(); // exit
        }
    }

    public function login(int $id, string $nome, string $tipo) {
        /* No momento em que ocorrer o login
        adicionamos a sessao variaveis de sessão contendo os dados necessarios para o sistema*/

        $_SESSION['id'] = $id;
        $_SESSION['nome'] = $nome;
        $_SESSION['tipo'] = $tipo;
    }

    public function logout():void {
        session_start();
        session_destroy();
        header("location:../login.php?logout");
        die(); // exit;
    }

    public function verificaAcessoAdmin():void {

        if ($_SESSION['tipo'] !== 'admin')  {

            /* então significa que o usuario não esta logado, portanto apague qualquer
            requicio de sessão e force o usuario a ir para o login.php */
            header("location:nao-autorizado.php");
            die();
        } 
    }
}