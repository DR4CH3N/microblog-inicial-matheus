<?php

use Microblog\ControleDeAcesso;
use Microblog\Usuario;
use Microblog\Utilitarios;

require_once "inc/cabecalho.php";

/* 
mensagens de feedback relacionados ao acesso
*/

if (isset($_GET['acesso_proibido']) ) {
	$feedback = "Você deve logar primeiro... 🗿";
}
	elseif ((isset($_GET['campos_obrigatorios'])) ) {
	$feedback = 'voce deve preencher os dois campos! 🙄';
	}
	elseif (isset($_GET['nao_encontrado']) ) {
		$feedback = 'Usuario não encontrado!';
	}
	elseif (isset($_GET['senha_incorreta']) ) {
		$feedback = 'senha incorreta';
	} elseif (isset($_GET['logout']) ) {
		$feedback = 'Você saiu do sistema';
	}
?>


<div class="row">
    <div class="bg-white rounded shadow col-12 my-1 py-4">
        <h2 class="text-center fw-light">Acesso à área administrativa</h2>

        <form action="" method="post" id="form-login" name="form-login" class="mx-auto w-50">

                <?php if(isset($feedback)){?>
				<p class="my-2 alert alert-warning text-center">
					<?=$feedback?>
				</p>
                <?php } ?>

				<div class="mb-3">
					<label for="email" class="form-label">E-mail:</label>
					<input class="form-control" type="email" id="email" name="email">
				</div>
				<div class="mb-3">
					<label for="senha" class="form-label">Senha:</label>
					<input class="form-control" type="password" id="senha" name="senha">
				</div>

				<button class="btn btn-primary btn-lg" name="entrar" type="submit">Entrar</button>

			</form>
			<?php
			if (isset($_POST['entrar']) ) {
				
				// verificação de campos
				if (empty($_POST['email']) || empty($_POST['senha'])) {
					header("location:login.php?campos_obrigatorios");
				} else {
					// capturamos o email informado
					$usuario = new Usuario;
					$usuario->setEmail($_POST['email']);

					// buscando um usuario no banco a partir do e-mail
					$dados = $usuario->buscar();



						// Utilitarios::dump($dados);
						// die();

					if (!$dados) {
						// então, fica no login e da um feedback
						header("location:login.php?nao_encontrado");
					} else {
						/* verificação da senha e login */
						if ( password_verify($_POST['senha'], $dados['senha'] )) {
							// estando certa, sera feito o login
							// die('OK!');
							$sessao = new ControleDeAcesso;
							$sessao->login($dados['id'], $dados['nome'], $dados['tipo'] );
							header("location:admin/index.php");
						} else {
							// caso contrario, mantenha na pagina login e apresente uma mensagem
							header("location:login.php?senha_incorreta");
						}
						
					}
					
					// Utilitarios::dump($dados);
				}
				
			}
			
			?>
        </div>
    
    
</div>        
        
<?= include_once "inc/todas.php"; ?>



<?php 
require_once "inc/rodape.php";
?>

