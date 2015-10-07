<?php
include("./functions/conexao.php");
include("./functions/sessao.php");
include("./functions/defaults.php");
session_start();

// variaveis
$pageTitle = "Login - SIGOI";
$pageUrl = "login.php";
$btnLogin = "btnLogin";
$btnResetPassword = "btnResetPassword";
$inputUser = "inputUser";
$inputSenha = "inputSenha";
$inputSenha1 = "inputSenha1";
$inputSenha2 = "inputSenha2";
$sqlTabUsuario = "usuario";
$loginError = false;
$resetError = false;
$newPassword = false;

if(isset($_GET['reset'])) {
	$newPassword = true;
}

if(isset($_POST[$btnLogin])){
	//testa se o campo de login esta em branco

	// buscando a senha no banco
	$realPass = db_select("SELECT id,senha from ".$sqlTabUsuario." WHERE login = ".db_quote($_POST[$inputUser])." AND ativo = true");
	
	// se o usuario não existe
	if($realPass == null){
		$loginError = true;
	} else {
		// compara as senhas
		if(password_verify($_POST[$inputSenha], $realPass[0]['senha']) === true){
			// testa se esta marcado para resetar a senha
			$resetarSenha = db_select("SELECT resetarsenha from ".$sqlTabUsuario." WHERE login = ".db_quote($_POST[$inputUser]));
			if($resetarSenha[0]['resetarsenha'] === 't'){
				$newPassword = true;
			}else{
				// autentica o usuario
				session_start();
				session_login($_POST[$inputUser], $realPass[0]['id']);
				// redireciona pra página inicial
				header('Location: index.php');
    			die();
			}
		}else{
			$loginError = true;
		}
	}
}

if(isset($_POST[$btnResetPassword])){
	// testando se as senhas digitadas são iguais
	if(strcasecmp($_POST[$inputSenha1], $_POST[$inputSenha2]) == 0){
		// altera a senha no banco
		$hashedPassword = password_hash($_POST[$inputSenha1], PASSWORD_DEFAULT);
		$result = db_query("UPDATE ".$sqlTabUsuario." SET senha =".db_quote($hashedPassword).", resetarsenha=false WHERE login = ".db_quote($_POST[$inputUser]));

		// autentica o usuario no sistema
		session_start();
		session_login($_POST[$inputUser]);

		// redireciona pra página inicial
		header('Location: index.php');
    	die();
	}else{
		$resetError = true;
	}
}

// Header
require_once('./includes/header.php');
require_once('./includes/navbar_login.php');
?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-3 col-md-offset-4">

				<?php
				// Mensagem de erro apos usuario e/ou senha invalido
				if($loginError === true){
					$errorMessage="<strong>Atenção!</strong> Usuário ou senha não cadastrados.";
					require('./includes/alert_error.php');
				} ?>

				<?php if($newPassword === false){ ?>
				<!-- Painel de Login -->
				<div class="panel panel-default" id="idlogin">
					<div class="panel-heading"> <strong class="brand">SIGOI: Login</strong></div>
					<div class="panel-body">
						<form class="form-horizontal" role="form" name="login" <?php echo(" action=\"".$pageUrl."\""); ?> method="post">
							<div class="form-group">
								<label <?php echo(" for=\"".$inputUser."\""); ?> class="col-sm-2 control-label">Usuário:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" <?php echo(" name=\"".$inputUser."\""); ?> placeholder="Usuário" required="">
								</div>
							</div>
							<div class="form-group">
								<label <?php echo(" for=\"".$inputSenha."\""); ?> class="col-sm-2 control-label">Senha:</label>
								<div class="col-sm-10">
									<input type="password" class="form-control" <?php echo(" name=\"".$inputSenha."\""); ?> placeholder="Senha" required="">
								</div>
							</div>
							<!-- <div class="form-group">
								<div class="col-sm-offset-3 col-sm-9">
									<div class="checkbox">
										<label class="">
											<input type="checkbox" class="">Remember me</label>
										</div>
									</div>
								</div> -->
							<div class="form-group last">
								<div class="col-sm-offset-2 col-sm-9">
									<button <?php echo(" name=\"".$btnLogin."\""); ?> type="submit" class="btn btn-success btn-sm">Login</button>
								</div>
							</div>
						</form> 
					</div>
				</div>
				<?php } else { ?>
				<?php if($resetError === true){ ?>
				<div class="col-md-12">
					<div class="alert alert-danger alert-dismissible login-error" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong>Atenção!</strong> As senhas digitadas não conferem.
					</div>
				</div>
				<?php } ?>
				<!-- Painel de Troca de Senha -->
				<div class="panel panel-default" id="idlogin">
					<div class="panel-heading"> <strong class="brand">SIGOI: Alteração de Senha</strong></div>
					<div class="panel-body">
						<form class="form-horizontal" role="form" name="login" <?php echo(" action=\"".$pageUrl."?reset=1\""); ?> method="post">
							<div class="form-group">
								<label <?php echo(" for=\"".$inputSenha1."\""); ?> class="col-sm-2 control-label">Senha:</label>
								<div class="col-sm-10">
									<input type="hidden" class="form-control" <?php echo(" name=\"".$inputUser."\" value=\"".$_POST[$inputUser]."\""); ?>>
									<input type="password" class="form-control" <?php echo(" name=\"".$inputSenha1."\""); ?> placeholder="Senha" required="">
								</div>
							</div>
							<div class="form-group">
								<label <?php echo(" for=\"".$inputSenha2."\""); ?> class="col-sm-2 control-label">Confirmar:</label>
								<div class="col-sm-10">
									<input type="password" class="form-control" <?php echo(" name=\"".$inputSenha2."\""); ?> placeholder="Senha" required="">
								</div>
							</div>
							<div class="form-group last">
								<div class="col-sm-offset-2 col-sm-9">
									<button <?php echo(" name=\"".$btnResetPassword."\""); ?> type="submit" class="btn btn-success btn-sm">Confirmar</button>
								</div>
							</div>
						</form> 
					</div>
				</div>
				<?php } ?>

			</div> <!-- /col-md-4 -->
		</div> <!-- /Row -->
	</div> <!-- /Container-Fluid -->

</body>
</html>