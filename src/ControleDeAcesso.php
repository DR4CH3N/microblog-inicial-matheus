<?php

namespace Microblog;

final class ControleDeAcesso 
{
    public function __destruct()
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
}
