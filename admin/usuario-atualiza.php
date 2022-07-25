<?php

use Microblog\Usuario;
use Microblog\Utilitarios;

require_once "../inc/cabecalho-admin.php";

$usuario = new Usuario;

$usuario->setId($_GET['id']);
$dados = $usuario->listarUm();

// Utilitarios::dump($dados);

if (isset($_POST['atualizar'])) {
	$usuario->setNome($_POST['nome']);
	$usuario->setEmail($_POST['email']);
	$usuario->setTipo($_POST['tipo']);

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
	header("location:usuarios.php");
}

?>


<div class="row">
	<article class="col-12 bg-white rounded shadow my-1 py-4">
		
		<h2 class="text-center">
		Atualizar dados do usuário
		</h2>
				
		<form class="mx-auto w-75" action="" method="post" id="form-atualizar" name="<?=$dados['id']?>">

			<div class="mb-3">
				<label class="form-label" for="nome">nome:</label>
				<input value="<?=$dados['nome']?>" class="form-control" type="text" id="nome" name="nome" required>
			</div>

			<div class="mb-3">
				<label class="form-label" for="email">email:</label>
				<input value="<?=$dados['email']?>" class="form-control" type="email" id="email" name="email" required>
			</div>

			<div class="mb-3">
				<label class="form-label" for="senha">Senha:</label>
				<input class="form-control" type="password" id="senha" name="senha" placeholder="Preencha apenas se for alterar">
			</div>

			<div class="mb-3">
				<label class="form-label" for="tipo"><?=$dados['tipo']?></label>
				<select class="form-select" name="tipo" id="tipo" required>
					<option value=""></option>
					<option <?php if ($dados['tipo'] == 'editor') echo ' selected ' ?>
					value="editor">Editor</option>


					<option <?php if ($dados['tipo'] == 'admin') echo ' selected ' ?> value="admin">Administrador</option>
				</select>
			</div>
			
			<button class="btn btn-primary" name="atualizar"><i class="bi bi-arrow-clockwise"></i> Atualizar</button>
		</form>
		
	</article>
</div>


<?php 
require_once "../inc/rodape-admin.php";
?>

