<?php

use Microblog\ControleDeAcesso;
use Microblog\Noticia;

require_once "../vendor/autoload.php";

$sessao = new ControleDeAcesso;
$sessao->verificaAcesso();

$noticia = new Noticia; // Não esqueça do autoload e do namespace

// Obtemos o id da URL e tipo e os passamos para o setter
$noticia->setId($_GET['id']);
$noticia->usuario->setId($_SESSION['id']);
$noticia->usuario->setTipo($_SESSION['tipo']);

// Só então executamos o método de exclusão
$noticia->excluirNoticia();

// Após excluir, redirecionamos para a página de lista de usuários
header("location:noticias.php");