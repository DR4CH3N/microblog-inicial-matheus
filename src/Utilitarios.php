<?php
namespace Microblog;

abstract class Utilitarios {

    // $dados podem retornar em array ou em boolean (retorna false caso nao tiver nada)
    // public static function dump(array | bool) {}
    public static function dump($dados) {
        echo "<pre>";
        var_dump($dados);
        echo "</pre>";
    }

}

