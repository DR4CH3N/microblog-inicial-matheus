<?php 
require_once "../inc/cabecalho-admin.php";

use Microblog\Usuario;
use Microblog\Utilitarios;



$usuario = new Usuario;

$usuario->setId($_SESSION['id']);
$dados = $usuario->listarUm();




// Utilitarios::dump($dados);

if (isset($_POST['atualizar'])) {
	$usuario->setNome($_POST['nome']);
	$usuario->setEmail($_POST['email']);
	$usuario->setTipo($_SESSION['tipo']);

	// LOGICA DA SENHA:

	/* algoritmo da senha
	se o campo senha do furmulario no formulario estiver vazio, 
	signfica que o usuario NÃO MUDOU A SENHA.
	*/
	if (empty($_POST['senha']) ) {
		$usuario->setSenha( $dados['senha'] );
		echo $usuario->getSenha();
	}
	else {
		/* Caso contrario, se o usuario digitou alguma coisa no campo senha, precisaremos verificar o que foi digitado 
		*/

		$usuario->setSenha(  
			$usuario->verificaSenha($_POST['senha'], $dados['senha'])
		);

		// echo $usuario->verificaSenha($_POST['senha'], $dados['senha']);
	}

	$usuario->atualizar();
	header("location:index.php?perfil_atualizado");
}
?>


<div class="row">
	<article class="col-12 bg-white rounded shadow my-1 py-4">
		
		<h2 class="text-center">
		Atualizar meus dados
		</h2>
				
		<form class="mx-auto w-75" action="" method="post" id="form-atualizar">


			<div class="mb-3">
				<label class="form-label" for="nome">Nome:</label>
				<input value="<?=$dados['nome']?>" class="form-control" type="text" id="nome" name="nome" required>
			</div>

			<div class="mb-3">
				<label class="form-label" for="email">E-mail:</label>
				<input value="<?=$dados['email']?>" class="form-control" type="email" id="email" name="email" required>
			</div>

			<div class="mb-3">
				<label class="form-label" for="senha">Senha:</label>
				<input  class="form-control" type="password" id="senha" name="senha" placeholder="Preencha apenas se for alterar">
			</div>

			<button class="btn btn-primary" name="atualizar"><i class="bi bi-arrow-clockwise"></i> Atualizar</button>
		</form>
		
	</article>
</div>


<?php 
require_once "../inc/rodape-admin.php";
?>

