<?php
include "conexao.php"; 

// variaveis
$page = "cadastro_funcao.php";
$btnUpdate = "btnUpdate";
$btnInsert = "btnInsert";
$btnDelete = "btnDelete";
$modalInsert = "insert-funcao";
$modalUpdate = "update-funcao";
$inputFuncao = "inputFuncao";
$dataId = "idFuncao";
$duplicate = false;
$blocked = false;
$sqlTabFuncao = "funcao";
$sqlOrder = "ORDER BY LOWER(nome)";
$sqlTabUsuario = "usuario";

// busca a lista de funcoes no banco
$funcoes = db_select("SELECT * FROM ".$sqlTabFuncao." ".$sqlOrder);

// altera funcoes no banco
if(isset($_POST[$btnUpdate])){
	$result = db_query("UPDATE ".$sqlTabFuncao." SET nome = ".db_quote($_POST[$inputFuncao])." WHERE id = ".db_quote($_POST[$dataId]));
	if($result === false) {
		$error = pg_result_error($result);
	}
	header("Refresh:0");
}

// exclui funcoes do banco
if(isset($_POST[$btnDelete])){
	// testa se não existe dependências
	$blocked = false;
	$funcoesBlocked = db_select("SELECT DISTINCT idfuncao FROM ".$sqlTabUsuario);
	for ($i = 0; $i < count($funcoesBlocked); $i++){
		if(strcasecmp($_POST[$dataId], $funcoesBlocked[$i]['idfuncao']) == 0){
			$blocked = true;
		}
	}

	if($blocked === false){
		$result = db_query("DELETE from ".$sqlTabFuncao." WHERE id = ".db_quote($_POST[$dataId]));
		if($result === false) {
			$error = pg_result_error($result);
		}
		header("Refresh:0");
	}
}

// insere funcoes no banco
if(isset($_POST[$btnInsert])){
	// testa se já não existe uma entrada duplicada (case insensitive)
	$duplicate = false;
	for ($i = 0; $i < count($funcoes); $i++) {
		if(strcasecmp($funcoes[$i]['nome'], $_POST[$inputFuncao]) == 0){
			$duplicate = true;
		}
	}

	// se não existe insere no banco
	if($duplicate === false){
		$result = db_query("INSERT INTO ".$sqlTabFuncao." (nome) VALUES (".db_quote($_POST[$inputFuncao]).")");
		if($result === false) {
			$error = pg_result_error($result);
		}
		// atualiza o array com a lista de funcoes
		$funcoes = db_select("SELECT * FROM ".$sqlTabFuncao." ".$sqlOrder);
		header("Refresh:0");	
	}
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastro de Funções</title>
 
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
					<li class="nav nav-btn" data-toggle="modal" <?php echo(" data-target=\"#".$modalInsert."\""); ?>><a href="#">Incluir Funcao</a></li>
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
			<!-- Mensagem de Erro ao cadastrar funcao duplicada -->
			<?php if($duplicate === true){ ?>
			<div class="col-md-10 col-md-offset-1">
				<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong>Atenção!</strong> Essa função já existe no cadastro.
				</div>
			</div>
			<?php } ?>

			<!-- Mensagem de Erro ao tentar deletar uma funcao com dependências -->
			<?php if($blocked === true){ ?>
			<div class="col-md-10 col-md-offset-1">
				<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong>Atenção!</strong> Essa função está vinculada a um ou mais usuários. Não é possível efetuar a exclusão.
				</div>
			</div>
			<?php } ?>
				
			<!-- Tabela com a lista de funções -->
			<table class="table table-condensed table-hover">
				<thead>
					<tr>
						<th width="1%"></th>
						<th class="col-sm-3">Função</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					for ($i = 0; $i < count($funcoes); $i++) {
						echo "<tr data-toggle=\"modal\" data-id=\"".$funcoes[$i]['id']."\" data-target=\"#".$modalUpdate."\" data-raw=\"".$funcoes[$i]['nome']."\">";
						echo "<td></td>";
						echo "<td>".$funcoes[$i]['nome']."</td>";
						echo "</tr>";
					} ?>
				</tbody>
			</table>
		</div> <!-- /Row -->
	</div> <!-- /Container-Fluid -->

	<!-- Modal update-funcao -->
	<div class="modal fade" <?php echo(" id=\"".$modalUpdate."\""); ?> tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Editar Função</h4>
				</div>
				<div class="modal-body">
					<form role="form" method="post" <?php echo(" action=\"".$page."\""); ?>>
						<div class="form-group">
							<label for="funcao-heading">Função</label>
							<input type="hidden" <?php echo(" name=\"".$dataId."\""); ?> <?php echo(" id=\"".$dataId."\""); ?> value=""/>
							<input type="text" name=<?php echo("\"".$inputFuncao."\""); ?> class="form-control" value="" <?php echo(" id=\"".$inputFuncao."\""); ?>>
						</div>
						<div class="form-group">
							<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                			<input <?php echo(" name=\"".$btnUpdate."\""); ?> type="submit" class="btn btn-primary" value="Salvar"/>
                			<input <?php echo(" name=\"".$btnDelete."\""); ?> type="submit" class="btn btn-danger" value="Delete" onclick="return confirm('Você tem certeza?');"/>
        				</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal insert-funcao -->
	<div class="modal fade" <?php echo(" id=\"".$modalInsert."\""); ?> tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Incluir Função</h4>
				</div>
				<div class="modal-body">
					<form role="form" method="post" <?php echo(" action=\"".$page."\""); ?>>
						<div class="form-group">
							<label for="funcao-heading">Função</label>
							<input type="text" <?php echo(" name=\"".$inputFuncao."\""); ?> class="form-control" value="" <?php echo(" id=\"".$inputFuncao."\""); ?>>
						</div>
						<div class="form-group">
							<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                			<input <?php echo(" name=\"".$btnInsert."\""); ?> type="submit" class="btn btn-primary" value="Salvar"/>
        				</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- Scripts -->
	<script type="text/javascript">
	    $('tr').on('click', function (e) {
		    e.preventDefault();
		    // pegando o id e o nome da funcao na linha clicada
		    var id = $(this).closest('tr').data('id');
		    var nome = $(this).closest('tr').data('raw');
		    // mandando isso pra dentro do modal
		    $("#update-funcao #idFuncao").val(id);
		    $("#update-funcao #inputFuncao").val(nome);
		});

	    // seta o foco pro text field inputFuncao
		$("#insert-funcao").on('shown.bs.modal', function(){
	        $(this).find('#inputFuncao').focus();
	    });
	    $("#update-funcao").on('shown.bs.modal', function(){
	        $(this).find('#inputFuncao').focus();
	    });
	</script>

</body>
</html>