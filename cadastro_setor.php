<!DOCTYPE html>
<html lang="en">
<head>
	<!-- PHP Includes -->
	<?php 
		include "conexao.php"; 
		//buscando a lista de setores no banco
		$tabSetor = "setor";
		$tabLocal = "local";
		$setores = db_select("SELECT SETOR.id AS id, SETOR.nome AS setor, LOCAL.nome AS local FROM ".$tabSetor." INNER JOIN local on (setor.idlocal = local.id)");
		$locais = db_select("SELECT * FROM ".$tabLocal." ORDER BY LOWER(nome)");

		// alterando setor no banco
		if(isset($_POST['submit-setor'])){
			// buscando o ID do local selecionado
			$localSelected = $_POST['select-local'];
			$localSelected = db_select("SELECT id from ".$tabLocal." WHERE nome =".db_quote($localSelected));
			$localSelected = $localSelected[0]['id'];
			// executando a query
			$result = db_query("UPDATE ".$tabSetor." SET nome = ".db_quote($_POST['inputSetor']).", idLocal =".$localSelected." WHERE id = ".db_quote($_POST['idSetor']));
			if($result === false){
				$error = pg_result_error($result);
			}
			header("Refresh:0");
		}

		// excluindo setor do banco
		if(isset($_POST['delete-setor'])){
			// testa se não existe dependências
			$blocked = false;
			//$locaisBlocked = db_select("SELECT DISTINCT idLocal FROM ".$tabSetor);
			//for ($i = 0; $i < count($locaisBlocked); $i++){
				//if(strcasecmp($_POST['idLocal'], $locaisBlocked[$i]['idlocal']) == 0){
					//$blocked = true;
					//$blockedError = "Yes";
				//}
			//}

			// se não existe deleta o local
			if($blocked == false){
				$result = db_query("DELETE from ".$tabSetor." WHERE id = ".db_quote($_POST['idSetor']));
				if($result === false) {
					$error = pg_result_error($result);
				}
				header("Refresh:0");	
			}
		}

		// inserindo setor no banco
		if(isset($_POST['insert-setor'])){
			// testando se já não existe uma entrada com esses valores
			$duplicate = false;
			for ($i = 0; $i < count($setores); $i++) {
				if((strcasecmp($setores[$i]['setor'], $_POST['inputSetor']) == 0) && (strcasecmp($setores[$i]['local'], $_POST['select-local']) == 0)){
					$duplicate = true;
					$duplicateError = "Yes";
				}
			}

			// se não existe insere no banco
			if($duplicate == false){
				// buscando o ID do local selecionado
				$localSelected = $_POST['select-local'];
				$localSelected = db_select("SELECT id from ".$tabLocal." WHERE nome =".db_quote($localSelected));
				$localSelected = $localSelected[0]['id'];
				$result = db_query("INSERT INTO ".$tabSetor." (nome, idLocal) VALUES (".db_quote($_POST['inputSetor']).", ".$localSelected.")");
				if($result === false) {
					$error = pg_result_error($result);
				}
				// atualiza o array com a lista de setores
				$setores = db_select("SELECT SETOR.id AS id, SETOR.nome AS setor, LOCAL.nome AS local FROM ".$tabSetor." INNER JOIN local on (setor.idlocal = local.id)");
				header("Refresh:0");	
			}
			
		}
	?>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head -->
	<title>Cadastro de Setores</title>

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
	<!-- jQuery -->
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
					<li class="nav nav-btn" data-toggle="modal" data-target="#insertSetor"><a href="#">Incluir Setor</a></li>
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
	<?php if(!empty($duplicateError)){ ?>
	<div class="col-md-10 col-md-offset-1">
		<div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<strong>Atenção!</strong> Esse setor já existe no cadastro.
		</div>
	</div>
	<?php } ?>
		
		<table class="table table-condensed table-hover">
			<thead>
				<tr>
					<th width="3%"></th>
					<th class="col-sm-3">Setor</th>
					<th class="col-sm-3">Local</th>
					<th class="col-sm-5"></th>
				</tr>
			</thead>
			<tbody>
				<?php 
				for ($i = 0; $i < count($setores); $i++) {
					echo "<tr data-toggle=\"modal\" data-id=\"".$setores[$i]['id']."\" data-target=\"#editSetor\" data-nome=\"".$setores[$i]['setor']."\" data-local=\"".$setores[$i]['local']."\">";
					echo "<td></td>";
					echo "<td>".$setores[$i]['setor']."</td>";
					echo "<td>".$setores[$i]['local']."</td>";
					echo "<td></td>";
					echo "</tr>";
				} ?>
			</tbody>
		</table>

	</div> <!-- Entire Row -->
	</div> <!-- Container-Fluid -->

	<!-- Modal Edit Local -->
	<div class="modal fade" id="editSetor" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Editar Setor</h4>
				</div>
				<div class="modal-body">
					<form role="form" method="post" action="cadastro_setor.php">
						<div class="form-group">
							<label for="setor-heading">Setor</label>
							<input type="hidden" name="idSetor" id="idSetor" value=""/>
							<input type="text" name="inputSetor" class="form-control" value="" id="inputSetor">
						</div>
						<div class="btn-group" role="group">
							<div class="form-group">
								<select id="select-local" name="select-local" class="selectpicker" data-width="100%">
									<?php
									for($i = 0; $i <count($locais); $i++){
										echo "<option>".$locais[$i]['nome']."</option>";
									}
									?>
								</select> 
							</div>
						</div>
						<div class="form-group">
							<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                			<input name="submit-setor" type="submit" class="btn btn-primary" value="Salvar"/>
                			<input name="delete-setor" type="submit" class="btn btn-danger" value="Delete" onclick="return confirm('Você tem certeza?');"/>
        				</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal Insert local -->
	<div class="modal fade" id="insertSetor" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Incluir Setor</h4>
				</div>
				<div class="modal-body">
					<form role="form" method="post" action="cadastro_setor.php">
						<div class="form-group">
							<label for="setor-heading">Setor</label>
							<input type="text" name="inputSetor" class="form-control" value="" id="inputSetor">
						</div>
						<div class="btn-group" role="group">
							<div class="form-group">
								<select id="select-local" name="select-local" class="selectpicker" data-width="100%">
								<option>Selecione o local:</option>
									<?php
									for($i = 0; $i <count($locais); $i++){
										echo "<option>".$locais[$i]['nome']."</option>";
									}
									?>
								</select> 
							</div>
						</div>
						<div class="form-group">
							<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                			<input name="insert-setor" type="submit" class="btn btn-primary" value="Salvar"/>
        				</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<script>
    $('tr').on('click', function (e) {
	    e.preventDefault();
	    // pegando os valores dos parametros
	    var id = $(this).closest('tr').data('id');
	    var nome = $(this).closest('tr').data('nome');
	    var local = $(this).closest('tr').data('local');
	    // e setando eles dentro do modal
	    $("#editSetor #idSetor").val(id);
	    $("#editSetor #inputSetor").val(nome);
	    $("#editSetor #select-local").selectpicker('val', local);
	});

    // seta o foco pro text field inputSetor
	$("#insertSetor").on('shown.bs.modal', function(){
        $(this).find('#inputSetor').focus();
    });
    $("#editSetor").on('shown.bs.modal', function(){
        $(this).find('#inputSetor').focus();
    });

    // altera o estilo doselectpicker
	$('.selectpicker').selectpicker();
	</script>

</body>
</html>