<?php
include "conexao.php"; 

// variaveis
$page = "lista_usuario.php";
$btnUpdate = "btnUpdate";
$btnInsert = "btnInsert";
$btnDelete = "btnDelete";
$inputNome = "inputNome";
$inputSetor = "inputSetor";
$inputFuncao = "inputFuncao";
$inputLogin = "inputLogin";
$dataId = "idUsuario";
//$duplicate = false;
$sqlTabUsuario = "usuario";
$sqlJoin = "INNER JOIN setor on (usuario.idsetor = setor.id)";
$sqlOrder = "ORDER BY LOWER(USUARIO.nome)";
$sqlTabSetor = "setor";
$sqlTabFuncao = "funcao";

// altera setores no banco
if(isset($_POST[$btnUpdate])){
	// buscando o ID do setor selecionado
	$setorSelected = $_POST[$inputSetor];
	$setorSelected = db_select("SELECT id from ".$sqlTabSetor." WHERE nome =".db_quote($setorSelected));
	$setorSelected = $setorSelected[0]['id'];
	// buscando o ID da funcao selecionada
	$funcaoSelected = $_POST[$inputFuncao];
	$funcaoSelected = db_select("SELECT id from ".$sqlTabFuncao." WHERE nome =".db_quote($funcaoSelected));
	$funcaoSelected = $funcaoSelected[0]['id'];
	// executando a query
	$result = db_query("UPDATE ".$sqlTabUsuario." SET nome='Teste', idSetor=2, idFuncao=4, login='teste', senha=null, ativo=true, admin=false, resetarSenha=false, ultimoLogin=null WHERE id = ".$_POST['idUsuario']);
	if($result === false){
		$error = pg_result_error($result);
	}
	//header("Refresh:0");
}

// busca a lista de funcoes no banco
$usuarios = db_select("SELECT USUARIO.id AS id, USUARIO.nome AS nome, USUARIO.login AS login, SETOR.nome as setor FROM ".$sqlTabUsuario." ".$sqlJoin." ".$sqlOrder);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastro de Usuários</title>
 
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
					<li class="nav nav-btn"><a href="cadastro_usuario.php?id=0">Incluir Usuario</a></li>
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

			<!-- Tabela com a lista de usuarios -->
			<table class="table table-condensed table-hover">
				<thead>
					<tr>
						<th width="3%"></th>
						<th class="col-sm-2">Usuario</th>
						<th class="col-sm-3">Nome</th>
						<th class="col-sm-3">Setor</th>
						<th class="col-sm-3"></th>
					</tr>
				</thead>
				<tbody>
					<?php 
					for ($i = 0; $i < count($usuarios); $i++) {
						echo "<tr data-id=\"".$usuarios[$i]['id']."\">";
						echo "<td></td>";
						echo "<td>".$usuarios[$i]['login']."</td>";
						echo "<td>".$usuarios[$i]['nome']."</td>";
						echo "<td>".$usuarios[$i]['setor']."</td>";
						echo "<td></td>";
						echo "</tr>";
					} ?>
				</tbody>
			</table>
		</div> <!-- /Row -->
	</div> <!-- /Container-Fluid -->

</body>
</html>

<script type="text/javascript">
	jQuery( function($) {
		$('tr').addClass('clickable').click(function() {
			var id = $(this).closest('tr').data('id');
			window.location = "cadastro_usuario.php?id=" + id;
		});
	});
</script>