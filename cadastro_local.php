<?php
include "./functions/conexao.php";

// variaveis
$page = "cadastro_local.php";
$btnUpdate = "btnUpdate";
$btnInsert = "btnInsert";
$btnDelete = "btnDelete";
$modalInsert = "insert-local";
$modalUpdate = "update-local";
$inputLocal = "inputLocal";
$dataId = "idLocal";
$duplicate = false;
$blocked = false;
$sqlTabLocal = "local";
$sqlTabSetor = "setor";
$sqlOrder = "ORDER BY LOWER(nome)";

// busca a lista de locais no banco
$locais = db_select("SELECT * FROM ".$sqlTabLocal." ".$sqlOrder);

// altera locais no banco
if(isset($_POST[$btnUpdate])){
	$result = db_query("UPDATE ".$sqlTabLocal." SET nome = ".db_quote($_POST[$inputLocal])." WHERE id = ".db_quote($_POST[$dataId]));
	if($result === false) {
		$error = pg_result_error($result);
	}
	header("Refresh:0");
}

// exclui locais do banco
if(isset($_POST[$btnDelete])){
	// testa se não existe dependências
	$blocked = false;
	$locaisBlocked = db_select("SELECT DISTINCT idLocal FROM ".$sqlTabSetor);
	for ($i = 0; $i < count($locaisBlocked); $i++){
		if(strcasecmp($_POST[$dataId], $locaisBlocked[$i]['idlocal']) == 0){
			$blocked = true;
		}
	}

	// se não existe deleta o local
	if($blocked === false){
		$result = db_query("DELETE from ".$sqlTabLocal." WHERE id = ".db_quote($_POST[$dataId]));
		if($result === false) {
			$error = pg_result_error($result);
		}
		header("Refresh:0");	
	}
}

// insere locais no banco
if(isset($_POST[$btnInsert])){
	// testa se já não existe uma entrada duplicada (case insensitive)
	$duplicate = false;
	for ($i = 0; $i < count($locais); $i++) {
		if(strcasecmp($locais[$i]['nome'], $_POST[$inputLocal]) == 0){
			$duplicate = true;
		}
	}

	// se não existe insere no banco
	if($duplicate == false){
		$result = db_query("INSERT INTO ".$sqlTabLocal." (nome) VALUES (".db_quote($_POST[$inputLocal]).")");
		if($result === false) {
			$error = pg_result_error($result);
		}
		// atualiza o array com a lista de locais
		$locais = db_select("SELECT * FROM ".$sqlTabLocal." ".$sqlOrder);
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
    <title>Cadastro de Locais</title>
 
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
					<li class="nav nav-btn" data-toggle="modal" <?php echo(" data-target=\"#".$modalInsert."\""); ?>><a href="#">Incluir Local</a></li>
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
			<!-- Mensagem de Erro ao cadastrar local duplicada -->
			<?php if($duplicate === true){ ?>
			<div class="col-md-10 col-md-offset-1">
				<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong>Atenção!</strong> Esse local já existe no cadastro.
				</div>
			</div>
			<?php } ?>

			<!-- Mensagem de Erro ao tentar deletar um local com dependências -->
			<?php if($blocked === true){ ?>
			<div class="col-md-10 col-md-offset-1">
				<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong>Atenção!</strong> Esse local está vinculado a um ou mais setores. Não é possível efetuar a exclusão.
				</div>
			</div>
			<?php } ?>
				
			<!-- Tabela com a lista de locais -->
			<table class="table table-condensed table-hover">
				<thead>
					<tr>
						<th width="1%"></th>
						<th class="col-sm-3">Local</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					for ($i = 0; $i < count($locais); $i++) {
						echo "<tr data-toggle=\"modal\" data-id=\"".$locais[$i]['id']."\" data-target=\"#".$modalUpdate."\" data-raw=\"".$locais[$i]['nome']."\">";
						echo "<td></td>";
						echo "<td>".$locais[$i]['nome']."</td>";
						echo "</tr>";
					} ?>
				</tbody>
			</table>
		</div> <!-- /Row -->
	</div> <!-- /Container-Fluid -->

	<!-- Modal update-local -->
	<div class="modal fade" <?php echo(" id=\"".$modalUpdate."\""); ?> tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Editar Local</h4>
				</div>
				<div class="modal-body">
					<form role="form" method="post" <?php echo(" action=\"".$page."\""); ?>>
						<div class="form-group">
							<label for="local-heading">Função</label>
							<input type="hidden" <?php echo(" name=\"".$dataId."\""); ?> <?php echo(" id=\"".$dataId."\""); ?> value=""/>
							<input type="text" name=<?php echo("\"".$inputLocal."\""); ?> class="form-control" value="" <?php echo(" id=\"".$inputLocal."\""); ?> required>
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

	<!-- Modal insert-local -->
	<div class="modal fade" <?php echo(" id=\"".$modalInsert."\""); ?> tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Incluir Local</h4>
				</div>
				<div class="modal-body">
					<form role="form" method="post" <?php echo(" action=\"".$page."\""); ?>>
						<div class="form-group">
							<label for="local-heading">Local</label>
							<input type="text" <?php echo(" name=\"".$inputLocal."\""); ?> class="form-control" value="" <?php echo(" id=\"".$inputLocal."\""); ?> required>
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
		    // pegando o id e o nome da local na linha clicada
		    var id = $(this).closest('tr').data('id');
		    var nome = $(this).closest('tr').data('raw');
		    // mandando isso pra dentro do modal
		    $("#update-local #idLocal").val(id);
		    $("#update-local #inputLocal").val(nome);
		});

	    // seta o foco pro text field inputLocal
		$("#insert-local").on('shown.bs.modal', function(){
	        $(this).find('#inputLocal').focus();
	    });
	    $("#update-local").on('shown.bs.modal', function(){
	        $(this).find('#inputLocal').focus();
	    });
	</script>

</body>
</html>