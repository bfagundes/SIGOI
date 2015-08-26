<!DOCTYPE html>
<html lang="en">
<head>
	<!-- PHP Includes -->
	<?php include "conexao.php"; ?>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head -->
	<title>Lista de Chamados</title>

	<!-- CSS Styles -->
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="datepicker/css/bootstrap-datepicker.css">
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
	<script type="text/javascript" src="datepicker/js/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="js/bootstrap-select.min.js"></script>
	<script type="text/javascript" src="js/custom.js"></script>	

	<!-- ------------------------------------------------------------- Barra de Navegação -------------------------------------------------------------------------------->
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">SIGOI</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<!-- ----- Barra de Navegação: Esquerda ------ -->
				<ul class="nav navbar-nav">
					<li><a href="#">Cancelar</a></li>
					<li><a href="#">Salvar</a></li>
				</ul>
				<!-- ----- Barra de Navegação: Direita ------ -->
				<ul class="nav navbar-nav navbar-right">
				</ul>
			</div>
		</div>
	</nav>

	<!-- ------------------------------------------------------------ Conteúdo ------------------------------------------------------------------------------ -->

	<div class="container-fluid">
	<div class="row">
		<div class="col-md-2">
			<div class="panel panel-default">
  				<div class="panel-body">

  					<!-- buscando a lista de prioridades no banco -->
  					<?php $tabPrioridade = "prioridade";
  					$prioridades = db_select("SELECT * FROM ".$tabPrioridade); ?>

					<div class="form-group">
						<label for="nome-solicitante">Prioridade 1</label>
						<input type="text" class="form-control" placeholder="<?php echo $prioridades[0]['nome']; ?>" id="prioridade-1">
					</div>

					<div class="form-group">
						<label for="nome-solicitante">Prioridade 2</label>
						<input type="text" class="form-control" placeholder="<?php echo $prioridades[1]['nome']; ?>" id="prioridade-2">
					</div>

					<div class="form-group">
						<label for="nome-solicitante">Prioridade 3</label>
						<input type="text" class="form-control" placeholder="<?php echo $prioridades[2]['nome']; ?>" id="prioridade-3">
					</div>

					<div class="form-group">
						<label for="nome-solicitante">Prioridade 4</label>
						<input type="text" class="form-control" placeholder="<?php echo $prioridades[3]['nome']; ?>" id="prioridade-4">
					</div>

					<div class="form-group">
						<label for="nome-solicitante">Prioridade 5</label>
						<input type="text" class="form-control" placeholder="<?php echo $prioridades[4]['nome']; ?>" id="prioridade-5">
					</div>

  				</div> <!-- panel-body -->
			</div> <!-- panel -->
		</div> <!-- col-md-2 -->

		<div class="col-md-2">
			<div class="panel panel-default">
  				<div class="panel-body">

  					<!-- buscando a lista de tipos no banco -->
  					<?php $tabTipo = "tipo";
  					$tipos = db_select("SELECT * FROM ".$tabTipo); ?>

					<div class="form-group">
						<label for="nome-solicitante">Tipo 1</label>
						<input type="text" class="form-control" placeholder="<?php echo $tipos[0]['nome']; ?>" id="tipo-1">
					</div>

					<div class="form-group">
						<label for="nome-solicitante">Tipo 2</label>
						<input type="text" class="form-control" placeholder="<?php echo $tipos[1]['nome']; ?>" id="tipo-2">
					</div>

					<div class="form-group">
						<label for="nome-solicitante">Tipo 3</label>
						<input type="text" class="form-control" placeholder="<?php echo $tipos[2]['nome']; ?>" id="tipo-3">
					</div>

					<div class="form-group">
						<label for="nome-solicitante">Tipo 4</label>
						<input type="text" class="form-control" placeholder="<?php echo $tipos[3]['nome']; ?>" id="tipo-4">
					</div>

					<div class="form-group">
						<label for="nome-solicitante">Tipo 5</label>
						<input type="text" class="form-control" placeholder="<?php echo $tipos[4]['nome']; ?>" id="tipo-5">
					</div>

  				</div> <!-- panel-body -->
			</div> <!-- panel -->
		</div> <!-- col-md-2 -->

		<div class="col-md-2">
			<div class="panel panel-default">
  				<div class="panel-body">

  					<!-- buscando a lista de situacoes no banco -->
  					<?php $tabSituacao = "situacao";
  					$situacoes = db_select("SELECT * FROM ".$tabSituacao); ?>

					<div class="form-group">
						<label for="nome-solicitante">Situação 1</label>
						<input type="text" class="form-control" placeholder="<?php echo $situacoes[0]['nome']; ?>" id="situacao-1">
					</div>

					<div class="form-group">
						<label for="nome-solicitante">Situação 2</label>
						<input type="text" class="form-control" placeholder="<?php echo $situacoes[1]['nome']; ?>" id="situacao-2">
					</div>

					<div class="form-group">
						<label for="nome-solicitante">Situação 3</label>
						<input type="text" class="form-control" placeholder="<?php echo $situacoes[2]['nome']; ?>" id="situacao-3">
					</div>

					<div class="form-group">
						<label for="nome-solicitante">Situação 4</label>
						<input type="text" class="form-control" placeholder="<?php echo $situacoes[3]['nome']; ?>" id="situacao-4">
					</div>

					<div class="form-group">
						<label for="nome-solicitante">Situação 5</label>
						<input type="text" class="form-control" placeholder="<?php echo $situacoes[4]['nome']; ?>" id="situacao-5">
					</div>

  				</div> <!-- panel-body -->
			</div> <!-- panel -->
		</div> <!-- col-md-2 -->

		<div class="col-md-6">
			<div class="panel panel-default">
  				<div class="panel-body">

					<div class="form-group">
						<label for="nome-solicitante">Situação 1</label>
						<input type="text" class="form-control" placeholder="Aberto" id="situacao-1">
					</div>

					<div class="form-group">
						<label for="nome-solicitante">Situação 2</label>
						<input type="text" class="form-control" placeholder="Pendente" id="situacao-2">
					</div>

					<div class="form-group">
						<label for="nome-solicitante">Situação 3</label>
						<input type="text" class="form-control" placeholder="Fechado" id="situacao-3">
					</div>

					<div class="form-group">
						<label for="nome-solicitante">Situação 4</label>
						<input type="text" class="form-control" placeholder="" id="situacao-4">
					</div>

					<div class="form-group">
						<label for="nome-solicitante">Situação 5</label>
						<input type="text" class="form-control" placeholder="" id="situacao-5">
					</div>

  				</div> <!-- panel-body -->
			</div> <!-- panel -->
		</div> <!-- col-md-6 -->
	</div> <!-- Entire Row -->
	</div> <!-- Container Fluid -->

	<script>
		$('.selectpicker').selectpicker();
	</script>

</body>
</html>