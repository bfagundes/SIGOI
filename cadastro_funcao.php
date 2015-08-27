<!DOCTYPE html>
<html lang="en">
<head>
	<!-- PHP Includes -->
	<?php 
		include "conexao.php"; 
		//buscando a lista de funcoes no banco
		$tabFuncao = "funcao";
		$funcoes = db_select("SELECT * FROM ".$tabFuncao." ORDER BY nome");
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
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
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
					<th width="1%">#</th>
					<th class="col-sm-3">Função</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				for ($i = 0; $i < count($funcoes); $i++) {
					echo "<tr data-toggle=\"modal\" data-id=\"".$funcoes[$i]['id']."\" data-target=\"#modalFuncao\">";
					echo "<td></td>";
					echo "<td>".($i+1)."</td>";
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
					<form role="form" method="post" action="parametros.php">
						<div class="form-group">
							<label for="funcao-heading">Função</label>
							<input type="text" name="nomeFuncao" class="form-control" value="<?php echo $prioridades[0]['nome']; ?>" id="nomeFuncao">
						</div>
						<!-- <div class="form-group">
                			<input name="submit-rrr" type="submit" class="btn btn-primary" value="Salvar"/>
        				</div> -->
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
					<button type="button" class="btn btn-primary">Salvar</button>
				</div>
			</div>
		</div>
	</div>

	<script>
	$(function(){
	    $('#modalFuncao').modal.on('show', function(){ //subscribe to show method
	          var getIdFromRow = $(event.target).closest('tr').data('id'); //get the id from tr
	        //make your ajax call populate items or what even you need
	        $(this).find('#myModalLabel').html($('<b> Order Id selected: ' + getIdFromRow  + '</b>'))
	    });
	});
	</script>

</body>
</html>