<?php 
use Microblog\Noticia;
use Microblog\Utilitarios;

require_once "inc/cabecalho.php";


$noticia->setCategoriaId($_GET['id']);
$dados = $noticia->listarPorCategoria();
?>


<div class="row my-1 mx-md-n1">
    <?php if (count($dados) > 0) { ?>
    <article class="col-12">
        <h2>Notícias sobre <span class="badge bg-primary"><?=$dados[0]['categoria']?> </span> </h2>
        <?php } else { ?>
            <h2 class="alert alert-warning text-center">Não tem noticias desta categoria!</h2>
        <?php } ?>
        
        <div class="row my-1">
            <div class="col-12 px-md-1">
                <div class="list-group">
                    <?php foreach ($dados as $noticia) { ?>  
                    <a href="noticia.php?id=<?=$noticia['id']?>" class="list-group-item list-group-item-action">
                        <h3 class="fs-6"><?=$noticia['titulo']?></h3>
                        <p><time><?=Utilitarios::formataData($noticia['data'])?>
                        
                        </time> - <?=$dados['autor'] ?? "<i>Equipe microblog</i>"?></p>
                        <p><?=$noticia['resumo']?></p>
                    </a>
                    <?php } ?>
                </div>
            </div>
        </div>


    </article>
    

</div>        
        
<?= include_once "inc/todas.php"; ?>      

<?php 
require_once "inc/rodape.php";
?>

