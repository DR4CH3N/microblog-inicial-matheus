<?php

use Microblog\ControleDeAcesso;
use Microblog\Noticia;

require_once "../vendor/autoload.php";

$sessao = new ControleDeAcesso;
$sessao->verificaAcesso();

$noticia = new Noticia; // Não esqueça do autoload e do namespace

// Obtemos o id da URL e o passamos para o setter
$noticia->setId($_GET['id']);

// Só então executamos o método de exclusão
$noticia->excluirNoticia();

// Após excluir, redirecionamos para a página de lista de usuários
header("location:noticias.php");