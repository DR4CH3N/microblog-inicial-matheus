<?php

use Microblog\Usuario;

require_once "../vendor/autoload.php";

$usuario = new Usuario;

// obtemos o id da URL e o passamos para o setter
$usuario->setId($_GET['id']);

// só então executamos o modo de exclusão
$usuario->excluirUsuario();

// apos concluir, redirecionamos para a pagina lista de usuarios
header("location:usuarios.php");