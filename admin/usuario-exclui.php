<?php
require_once '../vendor/autoload.php';

use Microblog\Usuario;

$usuario = new Usuario;
$usuario->setId($_GET['id']);

$produto->excluirUsuario();
header("location:usuarios.php");