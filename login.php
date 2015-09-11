<?php
include "./functions/conexao.php";
include "./functions/sessao.php";

// variaveis
$page = "login.php";
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
	// buscando a senha no banco
	$realPass = db_select("SELECT senha from ".$sqlTabUsuario." WHERE login = ".db_quote($_POST[$inputUser]));
	
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
				session_login($_POST[$inputUser]);
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

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head -->
	<title>Lista de Chamados</title>

	<!-- CSS Styles -->
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap-datepicker.css">
	<link rel="stylesheet" type="text/css" href="css/custom.css">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

</head>
<body>
	<!-- jQuery -->
	<!-- <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->
	<script type="text/javascript" src="js/jquery1-11-3.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="js/custom.js"></script>

	<!-- Barra de Navegação -->
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
				</button>
				<a class="navbar-brand" href="login.php">SIGOI</a>
			</div>
		</div>
	</nav>

	<!-- Conteúdo -->
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-3 col-md-offset-4">
				<!-- Mensagem de erro: Usuario nao existe -->
				<?php if($loginError === true){ ?>
				<div class="col-md-12">
					<div class="alert alert-danger alert-dismissible login-error" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong>Atenção!</strong> Usuário ou senha não cadastrados.
					</div>
				</div>
				<?php } ?>

				<?php if($newPassword === false){ ?>
				<!-- Painel de Login -->
				<div class="panel panel-default" id="idlogin">
					<div class="panel-heading"> <strong class="brand">SIGOI: Login</strong></div>
					<div class="panel-body">
						<form class="form-horizontal" role="form" name="login" <?php echo(" action=\"".$page."\""); ?> method="post">
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
					</div> <!-- /panel -->
				</div> <!-- /panel-default -->
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
						<form class="form-horizontal" role="form" name="login" <?php echo(" action=\"".$page."?reset=1\""); ?> method="post">
							<div class="form-group">
								<label <?php echo(" for=\"".$inputSenha1."\""); ?> class="col-sm-2 control-label">Senha:</label>
								<div class="col-sm-10">
									<input type="hidden" class="form-control" <?php echo(" name=\"".$inputUser."\""); ?> <?php echo(" value=\"".$_POST[$inputUser]."\""); ?>>
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
					</div> <!-- /panel -->
				</div> <!-- /panel-default -->
				<?php } ?>

			</div> <!-- /col-md-4 -->
		</div> <!-- /Row -->
	</div> <!-- /Container-Fluid -->

</body>
</html>