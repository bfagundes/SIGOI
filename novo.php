<!DOCTYPE html>
<html lang="en">
<head>
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
				<a class="navbar-brand" href="#">SIGOI</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<!-- ----- Barra de Navegação: Esquerda ------ -->
				<ul class="nav navbar-nav">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Opções <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="#">Editar Chamado</a></li>
							<li><a href="#">Excluir Chamado</a></li>
						</ul>
					</li>
					<li class="nav nav-btn"><a href="#">Cancelar</a></li>
				</ul>
				<!-- ----- Barra de Navegação: Direita ------ -->
				<ul class="nav navbar-nav navbar-right">
				</ul>
			</div>
		</div>
	</nav>

	<!-- Conteúdo -->

	<!-- Data de Hoje -->
	<?php $data_hoje = date("d/m/y"); ?>

	<div class="container-fluid">
	<div class="row">
		<div class="col-md-3">
			<div class="panel panel-default">
  				<div class="panel-body">

					<div class="form-group">
						<label for="nome-solicitante">Solicitante:</label>
						<input type="text" class="form-control" placeholder="Solicitante" id="nome-solicitante">
					</div>

					<div class="form-group">
						<label for="nome-setor">Setor:</label>
						<input type="text" class="form-control" placeholder="Setor" id="nome-setor">
					</div>

					<div class="form-group">
						<label for="nome-local">Local:</label>
						<input type="text" class="form-control" placeholder="Local" id="nome-local">
					</div>

					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label for="data-abertura">Data de Abertura:</label>
								<input type="text" class="form-control" placeholder="<?php echo($data_hoje); ?>" id="data-abertura" disabled="disabled">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label for="data-abertura">Data de Fechamento:</label>
								<input type="text" class="form-control" placeholder="Data de Fechamento" id="data-fechamento" disabled="disabled">
							</div>
						</div>
					</div>

					<div class="form-group">
						<label>Técnico Respponsável:</label><br>
						<div class="form-group">
								<select id="tipo-chamado" class="selectpicker" data-width="100%" disabled>
									<option>Técnico Responsável</option>
									<option>Bruno Fagundes</option>
									<option>Matteus Barragan</option>
								</select> 
							</div>
					</div>

					<!-- ----- Dropdowns ------ -->
					<div class="btn-group btn-group-justified" role="group">
						<div class="btn-group" role="group">
							<div class="form-group">
								<select id="tipo-chamado" class="selectpicker" data-width="100%">
									<option>Problema</option>
									<option>Incidente</option>
									<option>Pergunta</option>
								</select> 
							</div>
						</div>
						<div class="btn-group" role="group">
							<div class="form-group">
								<select id="prioridade-chamado" class="selectpicker" data-width="100%">
									<option>Urgente</option>
									<option>Alta</option>
									<option>Média</option>
									<option>Baixa</option>
								</select> 
							</div>
						</div>
						<div class="btn-group" role="group">
							<div class="form-group">
								<select id="situacao-chamado" class="selectpicker" data-width="100%">
									<option>Aberto</option>
									<option>Pendente</option>
									<option>Fechado</option>
								</select> 
							</div>
						</div>
					</div> <!-- dropdonws group -->

					<!-- // <script>
					// 	$(function() {
					// 		$('#prioridade-chamado').on('change', function(){
					// 			if($(this).find("option:selected").val() == "Urgente"){
					// 				$('#prioridade-chamado').selectpicker('setStyle', 'btn-danger');
					// 			} 
					// 			if($(this).find("option:selected").val() == "Alta"){
					// 				$('#prioridade-chamado').selectpicker('setStyle', 'btn-warning');
					// 			} 
					// 			if($(this).find("option:selected").val() == "Média"){
					// 				$('#prioridade-chamado').selectpicker('setStyle', 'btn-success');
					// 			} 
					// 			if($(this).find("option:selected").val() == "Baixa"){
					// 				$('#prioridade-chamado').selectpicker('setStyle', 'btn-info');
					// 			}
					// 		});
					// 	});
					// </script> -->

  				</div> <!-- panel-body -->
			</div> <!-- panel -->
		</div> <!-- col-md-3 -->

		<div class="col-md-9">
			<div class="panel panel-default">
  				<div class="panel-body">
    				<h4><small>#00000 </small>Novo Chamado</h4>

    				<!-- Assunto -->
    				<div class="form-group">
						<label for="nome-solicitante">Assunto:</label>
						<input type="text" class="form-control" placeholder="Assunto do Chamado" id="assunto-chamado">
					</div>

					<!-- Descricao -->
					<label for="comentario">Descrição:</label>
					<div class="input-group">
						<textarea class="form-control custom-control" rows="3" style="resize:none"></textarea><span class="input-group-addon btn btn-primary">Enviar</span>
					</div>
  				</div>
  				<div class="panel-footer"></div>
			</div> <!-- panel-default -->
		</div> <!-- col-md-9 -->
	</div> <!-- Entire Row -->
	</div> <!-- Container Fluid -->

	<script>
		$('.selectpicker').selectpicker();
	</script>

</body>
</html>