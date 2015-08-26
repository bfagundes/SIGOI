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
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Opções <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="#">Editar Chamado</a></li>
							<li><a href="#">Excluir Chamado</a></li>
						</ul>
					</li>
					<!-- <li class="active"><a href="#">Link</a></li> -->
				</ul>
				<!-- ----- Barra de Navegação: Direita ------ -->
				<ul class="nav navbar-nav navbar-right">
					<form class="navbar-form navbar-left" role="search">
						<!-- <div class="input-group">
							<input type="text" class="form-control" placeholder="Pesquisar">
							<span class="input-group-btn">
								<button class="btn btn-default" type="button">Vai!</button>
							</span>
						</div> -->
					</form>
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

					<div class="form-group">
						<label for="nome-solicitante">Prioridade 1:</label>
						<input type="text" class="form-control" placeholder="Urgente" id="prioridade-1">
					</div>

					<div class="form-group">
						<label for="nome-solicitante">Prioridade 2:</label>
						<input type="text" class="form-control" placeholder="Alta" id="prioridade-2">
					</div>

					<div class="form-group">
						<label for="nome-solicitante">Prioridade 3:</label>
						<input type="text" class="form-control" placeholder="Média" id="prioridade-3">
					</div>

					<div class="form-group">
						<label for="nome-solicitante">Prioridade 4:</label>
						<input type="text" class="form-control" placeholder="Baixa" id="prioridade-4">
					</div>

					<div class="form-group">
						<label for="nome-solicitante">Prioridade 5:</label>
						<input type="text" class="form-control" placeholder="" id="prioridade-5">
					</div>

  				</div> <!-- panel-body -->
			</div> <!-- panel -->
		</div> <!-- col-md-2 -->

		<div class="col-md-2">
			<div class="panel panel-default">
  				<div class="panel-body">

					<div class="form-group">
						<label for="nome-solicitante">Tipo 1:</label>
						<input type="text" class="form-control" placeholder="Problema" id="tipo-1">
					</div>

					<div class="form-group">
						<label for="nome-solicitante">Tipo 2:</label>
						<input type="text" class="form-control" placeholder="Incidente" id="tipo-2">
					</div>

					<div class="form-group">
						<label for="nome-solicitante">Tipo 3:</label>
						<input type="text" class="form-control" placeholder="Acidente" id="tipo-3">
					</div>

					<div class="form-group">
						<label for="nome-solicitante">Tipo 4:</label>
						<input type="text" class="form-control" placeholder="Solicitação" id="tipo-4">
					</div>

					<div class="form-group">
						<label for="nome-solicitante">Tipo 5:</label>
						<input type="text" class="form-control" placeholder="Pergunta" id="tipo-5">
					</div>

  				</div> <!-- panel-body -->
			</div> <!-- panel -->
		</div> <!-- col-md-2 -->

		<div class="col-md-2">
			<div class="panel panel-default">
  				<div class="panel-body">

					<div class="form-group">
						<label for="nome-solicitante">Situação 1:</label>
						<input type="text" class="form-control" placeholder="Aberto" id="situacao-1">
					</div>

					<div class="form-group">
						<label for="nome-solicitante">Situação 2:</label>
						<input type="text" class="form-control" placeholder="Pendente" id="situacao-2">
					</div>

					<div class="form-group">
						<label for="nome-solicitante">Situação 3:</label>
						<input type="text" class="form-control" placeholder="Fechado" id="situacao-3">
					</div>

					<div class="form-group">
						<label for="nome-solicitante">Situação 4:</label>
						<input type="text" class="form-control" placeholder="" id="situacao-4">
					</div>

					<div class="form-group">
						<label for="nome-solicitante">Situação 5:</label>
						<input type="text" class="form-control" placeholder="" id="situacao-5">
					</div>

  				</div> <!-- panel-body -->
			</div> <!-- panel -->
		</div> <!-- col-md-2 -->

		<div class="col-md-6">
			<div class="panel panel-default">
  				<div class="panel-body">

					<div class="form-group">
						<label for="nome-solicitante">Situação 1:</label>
						<input type="text" class="form-control" placeholder="Aberto" id="situacao-1">
					</div>

					<div class="form-group">
						<label for="nome-solicitante">Situação 2:</label>
						<input type="text" class="form-control" placeholder="Pendente" id="situacao-2">
					</div>

					<div class="form-group">
						<label for="nome-solicitante">Situação 3:</label>
						<input type="text" class="form-control" placeholder="Fechado" id="situacao-3">
					</div>

					<div class="form-group">
						<label for="nome-solicitante">Situação 4:</label>
						<input type="text" class="form-control" placeholder="" id="situacao-4">
					</div>

					<div class="form-group">
						<label for="nome-solicitante">Situação 5:</label>
						<input type="text" class="form-control" placeholder="" id="situacao-5">
					</div>

  				</div> <!-- panel-body -->
			</div> <!-- panel -->
		</div> <!-- col-md-6 -->





<!-- 		<div class="col-md-9">
			<div class="panel panel-default">
  				<div class="panel-body">
    				<h4><small>#00000 </small>Título do Chamado</h4>

    				<p>Nullam quis risus eget urna mollis ornare vel eu leo. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam id dolor id nibh ultricies vehicula.
					<p>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec ullamcorper nulla non metus auctor fringilla. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Donec ullamcorper nulla non metus auctor fringilla.</p>

					<label for="comentario">Comentário:</label> -->
					<!-- <textarea class="form-control" rows="3" id="comentario"></textarea> -->

					<!-- <div class="input-group">
						<textarea class="form-control custom-control" rows="3" style="resize:none"></textarea><span class="input-group-addon btn btn-primary">Enviar</span>
					</div> -->

					<!-- Enviar e Resposta Padrão -->
					<!-- <div class="btn-group pull-right" role="group">
						<div class="dropdown pull-right">
							<button class="btn btn-default dropdown-toggle pull-right" type="button" id="dropdownMenu1" data-toggle="dropdown">Resposta Padrão<span class="caret"></span></button>
							<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
								<li><a href="#">Action</a></li>
								<li><a href="#">Another action</a></li>
								<li><a href="#">Something else here</a></li>
								<li><a href="#">Separated link</a></li>
							</ul>
						</div>
						<select id="situacao-chamado" class="selectpicker pull-right" data-width="auto">
							<option>Público</option>
							<option>Privado</option>
						</select> 
					</div>

  				</div>
  				<div class="panel-footer">
  					<h5><strong>Bruno Fagundes</strong><small> (14/Ago/15 16:37 | Status > Pendente) </small></h5>
					<p>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec ullamcorper nulla non metus auctor fringilla. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Donec ullamcorper nulla non metus auctor fringilla.</p>

					<p><h5><strong>Matteus Barragan</strong><small> (14/Ago/15 13:08) </small></h5>
					<p>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec ullamcorper nulla non metus auctor fringilla. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Donec ullamcorper nulla non metus auctor fringilla.</p>
  				</div>
			</div>
		</div> --> <!-- col-md-9 -->
	</div> <!-- Entire Row -->
	</div> <!-- Container Fluid -->

	<script>
		$('.selectpicker').selectpicker();
	</script>

</body>
</html>