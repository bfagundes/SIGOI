<!DOCTYPE html>
<html lang="en">
<head>
	<!-- PHP Includes -->
	<?php 
		include "conexao.php"; 
		//buscando a lista de funcoes no banco
		$tabFuncao = "funcao";
		$funcoes = db_select("SELECT * FROM ".$tabFuncao." ORDER BY nome");

		// salvando alteracao de funcao no banco
		if(isset($_POST['submit-funcao'])){
			$result = db_query("UPDATE ".$tabFuncao." SET nome = ".db_quote($_POST['inputFuncao'])." WHERE id = ".db_quote($_POST['idFuncao']));
			if($result === false) {
				$error = pg_result_error($result);
			}
			header("Refresh:0");
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
					<li class="nav nav-btn"><a href="#">Incluir Funcao</a></li>
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
					echo "<tr data-toggle=\"modal\" data-id=\"".$funcoes[$i]['id']."\" data-target=\"#modalFuncao\" data-raw=\"".$funcoes[$i]['nome']."\">";
					echo "<td></td>";
					echo "<td>".$funcoes[$i]['nome']."</td>";
					echo "</tr>";
				} ?>
			</tbody>
		</table>

	</div> <!-- Entire Row -->
	</div> <!-- Container-Fluid -->

	<!-- Modal -->
	<div class="modal fade" id="modalFuncao" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="editFuncao">Editar Função</h4>
				</div>
				<div class="modal-body">
					<form role="form" method="post" action="cadastro_funcao.php">
						<div class="form-group">
							<label for="funcao-heading" id="lol">Função</label>
							<input type="hidden" name="idFuncao" id="idFuncao" value=""/>
							<input type="text" name="inputFuncao" class="form-control" value="" id="inputFuncao">
						</div>
						<div class="form-group">
							<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                			<input name="submit-funcao" type="submit" class="btn btn-primary" value="Salvar"/>
        				</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<script>
    $('tr').on('click', function (e) {
	    e.preventDefault();
	    // pegando o id e o nome da funcao na linha clicada
	    var id = $(this).closest('tr').data('id');
	    var nome = $(this).closest('tr').data('raw');
	    // mandando isso pra dentro do modal
	    $("#modalFuncao #idFuncao").val(id);
	    $("#modalFuncao #inputFuncao").val(nome);
	});
	</script>

</body>
</html>