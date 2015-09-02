<?php
include "conexao.php"; 

// variaveis
$page = "cadastro_usuario.php";
//$btnUpdate = "btnUpdate";
//$btnInsert = "btnInsert";
//$btnDelete = "btnDelete";
//$modalInsert = "insert-usuario";
//$modalUpdate = "update-funcao";
//$inputFuncao = "inputFuncao";
//$dataId = "idFuncao";
//$duplicate = false;
$sqlTabUsuario = "usuario";
//$sqlOrder = "ORDER BY LOWER(nome)";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastro de Usuário</title>
 
    <!-- CSS Styles -->
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap-datepicker.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap-select.min.css" />
	<link rel="stylesheet" type="text/css" href="css/custom.css">
 
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <!-- jQuery & JavaScript -->
	<!-- <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->
	<script type="text/javascript" src="js/jquery1-11-3.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="js/bootstrap-select.min.js"></script>
	<script type="text/javascript" src="js/custom.js"></script>	

	<!-- Barra de Navegação -->
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="index.php">SIGOI</a>
			</div>
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<!--  Barra de Navegação: Esquerda -->
				<ul class="nav navbar-nav">
					<li class="nav nav-btn"><a href="index.php">Sair</a></li>
				</ul>
				<!-- Barra de Navegação: Direita -->
				<ul class="nav navbar-nav navbar-right">
				</ul>
			</div>
		</div>
	</nav>

	<!-- Conteúdo -->
	<div class="container-fluid">
		<div class="row">



		<div class="col-md-3">
			<div class="panel panel-default">
  				<div class="panel-body">

					<div class="form-group">
						<form role="form" method="post" action="parametros.php">
							<div class="form-group">
								<label for="nome-solicitante">Nome</label>
								<input type="text" name='prioridade-1' class="form-control" value="" id="prioridade-1">
							</div>
							<div class="form-group">
								<label for="nome-solicitante">Setor</label>
								<input type="text" name='prioridade-2' class="form-control" value="" id="prioridade-2">
							</div>
							<div class="form-group">
								<label for="nome-solicitante">Função</label>
								<input type="text" name='prioridade-3' class="form-control" value="" id="prioridade-3">
							</div>
							<div class="form-group">
								<label for="nome-solicitante">Login</label>
								<input type="text" name='prioridade-1' class="form-control" value="" id="prioridade-1">
							</div>
							Último Acesso: 02/09/2015

								<div class="checkbox">
									<label><input type="checkbox" value="">Usuário Ativo</label>
								</div>

								<div class="checkbox">
									<label><input type="checkbox" value="">Usuário Administrador</label>
								</div>


								<div class="checkbox">
									<label><input type="checkbox" value="">Resetar a Senha</label>
								</div>
							<div class="form-group">
                    			<input name="submit-prioridade" type="submit" class="btn btn-primary" value="Salvar"/>
            				</div>
						</form>
					</div>
  				</div> <!-- panel-body -->
			</div> <!-- panel -->
		</div> <!-- col-md-2 -->

		<div class="col-md-3">
			<div class="panel panel-default">
  				<div class="panel-body">

					<div class="form-group">
						<form role="form" method="post" action="parametros.php">

							<label style="margin-bottom:-5px;">Permissões:</label>
							<div class="checkbox"><label><input type="checkbox" value="">Abrir Chamados</label></div>
							<div class="checkbox"><label><input type="checkbox" value="">Responder Chamados</label></div>
							<div class="checkbox"><label><input type="checkbox" value="">Alterar Chamados</label></div>
							<div class="checkbox"><label><input type="checkbox" value="">Fechar Chamados</label></div>
							<div class="checkbox"><label><input type="checkbox" value="">Excluir Chamados</label></div>
							
							<label style="margin-top: 10px; margin-bottom:-5px;">Visualizações:</label>
							<div class="checkbox"><label><input type="checkbox" value="">Visualizar os seus Chamados</label></div>
							<div class="checkbox"><label><input type="checkbox" value="">Visualizar todos os Chamados</label></div>
							
							<label style="margin-top: 10px; margin-bottom:-5px;">Funções de Administrador:</label>
							<div class="checkbox"><label><input type="checkbox" value="">Cadastro de Usuários</label></div>
							<div class="checkbox"><label><input type="checkbox" value="">Cadastro de Setores</label></div>
							<div class="checkbox"><label><input type="checkbox" value="">Cadastro de Locais</label></div>
							<div class="checkbox"><label><input type="checkbox" value="">Cadastro de Funções</label></div>
							<div class="checkbox"><label><input type="checkbox" value="">Parâmetros SIGOI</label></div>
							
							
							<div class="form-group">
                    			<input name="submit-prioridade" type="submit" class="btn btn-primary" value="Salvar"/>
            				</div>
						</form>
					</div>
  				</div> <!-- panel-body -->
			</div> <!-- panel -->
		</div> <!-- col-md-2 -->


			
		</div> <!-- /Row -->
	</div> <!-- /Container-Fluid -->

</body>
</html>