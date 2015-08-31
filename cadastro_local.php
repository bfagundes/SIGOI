<!DOCTYPE html>
<html lang="en">
<head>
	<!-- PHP Includes -->
	<?php 
		include "conexao.php"; 
		//buscando a lista de locais no banco
		$tabLocal = "local";
		$locais = db_select("SELECT * FROM ".$tabLocal." ORDER BY LOWER(nome)");

		// salvando alteracao de local no banco
		if(isset($_POST['submit-local'])){
			$result = db_query("UPDATE ".$tabLocal." SET nome = ".db_quote($_POST['inputLocal'])." WHERE id = ".db_quote($_POST['idLocal']));
			if($result === false) {
				$error = pg_result_error($result);
			}
			header("Refresh:0");
		}

		// salvando exclusao de local no banco
		if(isset($_POST['delete-local'])){
			$result = db_query("DELETE from ".$tabLocal." WHERE id = ".db_quote($_POST['idLocal']));
			if($result === false) {
				$error = pg_result_error($result);
			}
			header("Refresh:0");
		}

		// salvando insercao de local no banco
		if(isset($_POST['insert-local'])){

			// testa se já não existe uma entrada duplicada (case insensitive)
			$duplicate = false;
			for ($i = 0; $i < count($locais); $i++) {
				if(strcasecmp($locais[$i]['nome'], $_POST['inputLocal']) == 0){
					$duplicate = true;
					$duplicateError = "Yes";
				}
			}

			// se não existe insere no banco
			if($duplicate == false){
				$result = db_query("INSERT INTO ".$tabLocal." (nome) VALUES (".db_quote($_POST['inputLocal']).")");
				if($result === false) {
					$error = pg_result_error($result);
				}
				// atualiza o array com a lista de locais
				$locais = db_select("SELECT * FROM ".$tabLocal." ORDER BY LOWER(nome)");
				header("Refresh:0");	
			}
			
		}
	?>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head -->
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
					<li class="nav nav-btn" data-toggle="modal" data-target="#insertLocal"><a href="#">Incluir Local</a></li>
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
			<strong>Atenção!</strong> Esse local já existe no cadastro.
		</div>
	</div>
	<?php } ?>
		
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
					echo "<tr data-toggle=\"modal\" data-id=\"".$locais[$i]['id']."\" data-target=\"#editLocal\" data-raw=\"".$locais[$i]['nome']."\">";
					echo "<td></td>";
					echo "<td>".$locais[$i]['nome']."</td>";
					echo "</tr>";
				} ?>
			</tbody>
		</table>

	</div> <!-- Entire Row -->
	</div> <!-- Container-Fluid -->

	<!-- Modal Edit Local -->
	<div class="modal fade" id="editLocal" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Editar Local</h4>
				</div>
				<div class="modal-body">
					<form role="form" method="post" action="cadastro_local.php">
						<div class="form-group">
							<label for="local-heading">Função</label>
							<input type="hidden" name="idLocal" id="idLocal" value=""/>
							<input type="text" name="inputLocal" class="form-control" value="" id="inputLocal">
						</div>
						<div class="form-group">
							<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                			<input name="submit-local" type="submit" class="btn btn-primary" value="Salvar"/>
                			<input name="delete-local" type="submit" class="btn btn-danger" value="Delete" onclick="return confirm('Você tem certeza?');"/>
        				</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal Insert local -->
	<div class="modal fade" id="insertLocal" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Incluir Local</h4>
				</div>
				<div class="modal-body">
					<form role="form" method="post" action="cadastro_local.php">
						<div class="form-group">
							<label for="local-heading">Local</label>
							<input type="text" name="inputLocal" class="form-control" value="" id="inputLocal">
						</div>
						<div class="form-group">
							<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                			<input name="insert-local" type="submit" class="btn btn-primary" value="Salvar"/>
        				</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<script>
    $('tr').on('click', function (e) {
	    e.preventDefault();
	    // pegando o id e o nome da local na linha clicada
	    var id = $(this).closest('tr').data('id');
	    var nome = $(this).closest('tr').data('raw');
	    // mandando isso pra dentro do modal
	    $("#editLocal #idLocal").val(id);
	    $("#editLocal #inputLocal").val(nome);
	});

    // seta o foco pro text field inputLocal
	$("#insertLocal").on('shown.bs.modal', function(){
        $(this).find('#inputLocal').focus();
    });
    $("#editLocal").on('shown.bs.modal', function(){
        $(this).find('#inputLocal').focus();
    });
	</script>

</body>
</html>