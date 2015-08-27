<!DOCTYPE html>
<html lang="en">
<head>
	<!-- PHP Includes -->
	<?php 
		include "conexao.php"; 

		$tabPrioridade = "prioridade";
		$tabTipo = "tipo";
		$tabSituacao = "situacao";
		$tabRespPadrao = "respostaPadrao";

		if(isset($_POST['submit-prioridade'])){
			$result = db_query("UPDATE prioridade SET nome = ".db_quote($_POST['prioridade-1'])." WHERE id = 1");
			$result = db_query("UPDATE prioridade SET nome = ".db_quote($_POST['prioridade-2'])." WHERE id = 2");
			$result = db_query("UPDATE prioridade SET nome = ".db_quote($_POST['prioridade-3'])." WHERE id = 3");
			$result = db_query("UPDATE prioridade SET nome = ".db_quote($_POST['prioridade-4'])." WHERE id = 4");
			$result = db_query("UPDATE prioridade SET nome = ".db_quote($_POST['prioridade-5'])." WHERE id = 5");
			if($result === false) {
				$error = pg_result_error($result);
			}
		}
	?>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head -->
	<title>Lista de Chamados</title>

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
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="index.php">SIGOI</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<!-- Barra de Navegação: Esquerda -->
				<ul class="nav navbar-nav">
					<li><a href="index.php">Sair</a></li>
					<!-- <li><a href="#">Salvar</a></li> -->
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
		<div class="col-md-2">
			<div class="panel panel-default">
  				<div class="panel-body">
  					<!-- buscando a lista de prioridades no banco -->
  					<?php $prioridades = db_select("SELECT * FROM ".$tabPrioridade." ORDER by id"); ?>
						<div class="form-group">
							<form role="form" method="post" action="parametros.php">
								<div class="form-group">
									<label for="nome-solicitante">Prioridade 1</label>
									<input type="text" name='prioridade-1' class="form-control" value="<?php echo $prioridades[0]['nome']; ?>" id="prioridade-1">
								</div>
								<div class="form-group">
									<label for="nome-solicitante">Prioridade 2</label>
									<input type="text" name='prioridade-2' class="form-control" value="<?php echo $prioridades[1]['nome']; ?>" id="prioridade-2">
								</div>
								<div class="form-group">
									<label for="nome-solicitante">Prioridade 3</label>
									<input type="text" name='prioridade-3' class="form-control" value="<?php echo $prioridades[2]['nome']; ?>" id="prioridade-3">
								</div>
								<div class="form-group">
									<label for="nome-solicitante">Prioridade 4</label>
									<input type="text" name='prioridade-4' class="form-control" value="<?php echo $prioridades[3]['nome']; ?>" id="prioridade-4">
								</div>
								<div class="form-group">
									<label for="nome-solicitante">Prioridade 5</label>
									<input type="text" name='prioridade-5' class="form-control" value="<?php echo $prioridades[4]['nome']; ?>" id="prioridade-5">
								</div>
								<div class="form-group">
                        			<input name="submit-prioridade" type="submit" class="btn btn-primary" value="Salvar"/>
                				</div>
							</form/>
						</div>
  				</div> <!-- panel-body -->
			</div> <!-- panel -->
		</div> <!-- col-md-2 -->

		<div class="col-md-2">
			<div class="panel panel-default">
  				<div class="panel-body">

  					<!-- buscando a lista de tipos no banco -->
  					<?php $tipos = db_select("SELECT * FROM ".$tabTipo); ?>

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
  					<?php $situacoes = db_select("SELECT * FROM ".$tabSituacao); ?>

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
	</div> <!-- Entire Row -->

	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-default">
  				<div class="panel-body">
  					<div class="col-md-3">

  						<!-- buscando a lista de respostas padrao no banco -->
  						<?php $respostasPadrao = db_select("SELECT * FROM ".$tabRespPadrao); ?>

						<div class="form-group">
							<label for="nome-solicitante">Titulo</label>
							<input type="text" class="form-control" placeholder="<?php echo $respostasPadrao[0]['titulo']; ?>" id="resp-padrao-assunto-1">
						</div>

						<div class="form-group">
							<label for="nome-solicitante">Titulo</label>
							<input type="text" class="form-control" placeholder="<?php echo $respostasPadrao[1]['titulo']; ?>" id="resp-padrao-assunto-2">
						</div>

						<div class="form-group">
							<label for="nome-solicitante">Titulo</label>
							<input type="text" class="form-control" placeholder="<?php echo $respostasPadrao[2]['titulo']; ?>" id="resp-padrao-assunto-3">
						</div>

						<div class="form-group">
							<label for="nome-solicitante">Titulo</label>
							<input type="text" class="form-control" placeholder="<?php echo $respostasPadrao[3]['titulo']; ?>" id="resp-padrao-assunto-4">
						</div>

						<div class="form-group">
							<label for="nome-solicitante">Titulo</label>
							<input type="text" class="form-control" placeholder="<?php echo $respostasPadrao[4]['titulo']; ?>" id="resp-padrao-assunto-5">
						</div>
					</div>
					<div class="col-md-9">
						<div class="form-group">
							<label for="nome-solicitante">Resposta Padrão 1</label>
							<input type="text" class="form-control" placeholder="<?php echo $respostasPadrao[0]['texto']; ?>" id="resp-padrao-texto-1">
						</div>

						<div class="form-group">
							<label for="nome-solicitante">Resposta Padrão 2</label>
							<input type="text" class="form-control" placeholder="<?php echo $respostasPadrao[1]['texto']; ?>" id="resp-padrao-texto-2">
						</div>

						<div class="form-group">
							<label for="nome-solicitante">Resposta Padrão 3</label>
							<input type="text" class="form-control" placeholder="<?php echo $respostasPadrao[2]['texto']; ?>" id="resp-padrao-texto-3">
						</div>

						<div class="form-group">
							<label for="nome-solicitante">Resposta Padrão 4</label>
							<input type="text" class="form-control" placeholder="<?php echo $respostasPadrao[3]['texto']; ?>" id="resp-padrao-texto-4">
						</div>

						<div class="form-group">
							<label for="nome-solicitante">Resposta Padrão 5</label>
							<input type="text" class="form-control" placeholder="<?php echo $respostasPadrao[4]['texto']; ?>" id="resp-padrao-texto-5">
						</div>
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