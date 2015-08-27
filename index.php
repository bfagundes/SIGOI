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
	<link rel="stylesheet" type="text/css" href="css/bootstrap-datepicker.css">
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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/bootstrap-datepicker.js"></script>
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
				<!-- ----- Barra de Navegação: Esquerda ------ -->
				<ul class="nav navbar-nav">
					<li class="nav nav-btn"><a href="novo.php">Novo Chamado</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Opções <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li class="disabled"><a href="#">Editar Chamado</a></li>
							<li class="disabled"><a href="#">Excluir Chamado</a></li>
							<li role="separator" class="divider"></li>
							<li class="disabled"><a href="#">Cadastro de Usuários</a></li>
							<li class="disabled"><a href="#">Cadastro de Setores</a></li>
							<li><a href="cadastro_funcao.php">Cadastro de Funções</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="parametros.php">Parâmetros SIGOI</a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Visualizações <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li class="disabled"><a href="#">Seus Chamados</a></li>
							<li class="disabled"><a href="#">Seus Chamados Abertos</a></li>
							<li class="disabled"><a href="#">Seus Chamados Pendentes</a></li>
							<li class="disabled"><a href="#">Seus Chamados Fechados</a></li>
							<li role="separator" class="divider"></li>
							<li class="disabled"><a href="#">Todos os Chamados</a></li>
							<li class="disabled"><a href="#">Todos os Chamados Abertos</a></li>					
							<li class="disabled"><a href="#">Todos os Chamados Pendentes</a></li>
							<li class="disabled"><a href="#">Todos os Chamados Fechados</a></li>
							<li role="separator" class="divider"></li>
							<li class="disabled"><a href="#">Chamados Não Atribuídos</a></li>							
						</ul>
					</li>
					<!-- <li class="active"><a href="#">Link</a></li> -->
				</ul>
				<!-- ----- Barra de Navegação: Direita ------ -->
				<ul class="nav navbar-nav navbar-right">
					<form class="navbar-form navbar-left" role="search">
						<div class="input-group">
							<input type="text" class="form-control" placeholder="Pesquisar">
							<span class="input-group-btn">
								<button class="btn btn-default" type="button">Vai!</button>
							</span>
						</div>
					</form>
				</ul>
			</div>
		</div>
	</nav>

	<!-- Conteúdo -->
	<div class="container-fluid">

		<!-- ----- Tabela de Chamados Abertos ------ -->
		<table class="table table-condensed table-hover">
			<thead>
				<tr>
					<th width="2%"></th>
					<th width="2%"></th>
					<th class="col-sm-3">Chamados Abertos</th>
					<th class="col-sm-2">Solicitante</th>
					<th class="col-sm-2">Local</th>
					<th class="col-sm-1">Data</th>
					<th class="col-sm-2">Técnico</th>
				</tr>
			</thead>
			<tbody>
				<tr>
			  		<td><input type="checkbox" class="Ch-Abertos"></td>
			  		<td><span class="label label-danger">Urgente</span></td> 
			  		<td>Mudar as mesas de lugar</td>
			  		<td>Anne</td>
			  		<td>Assessoria Técnica</td>
			  		<td>10/Ago/15</td>
			  		<td>Matteus Barragan</td>
		  		</tr>
		  		<tr>
			  		<td><input type="checkbox" class="Ch-Abertos"></td>
			  		<td><span class="label label-warning">Alta</span></td> 
			  		<td>A pasta da farmácia sumui do desktop</td>
			  		<td>Karina da Farmácia</td>
			  		<td>Farmácia</td>
			  		<td>10/Ago/15</td>
			  		<td>Elisa Penteado</td>
		  		</tr>
		  		<tr>
			  		<td><input type="checkbox" class="Ch-Abertos"></td>
			  		<td><span class="label label-info">Média</span></td> 
			  		<td>Problemas com terroristas sírios</td>
			  		<td>Tera Giga</td>
			  		<td>Egenharia</td>
			  		<td>10/Ago/15</td>
			  		<td>Bruno Fagundes</td>
		  		</tr>
		  		<tr>
			  		<td><input type="checkbox" class="Ch-Abertos"></td>
			  		<td><span class="label label-success">Baixa</span></td> 
			  		<td>Quebrar 38 contas</td>
			  		<td>Adriana</td>
			  		<td>Faturamento</td>
			  		<td>10/Ago/15</td>
			  		<td>Igor Nunes</td>
		  		</tr>
			</tbody>
		</table>

		<!-- ----- Tabela de Chamados Pendentes ------ -->
		<table class="table table-condensed table-hover">
			<thead>
				<tr>
					<th width="2%"></th>
					<th width="2%"></th>
					<th class="col-sm-3">Chamados Pendentes</th>
					<th class="col-sm-2">Solicitante</th>
					<th class="col-sm-2">Local</th>
					<th class="col-sm-1">Data</th>
					<th class="col-sm-2">Técnico</th>
				</tr>
			</thead>
			<tbody>
				<tr>
			  		<td><input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."></td>
			  		<td><span class="label label-danger">Urgente</span></td> 
			  		<td>Mudar as mesas de lugar</td>
			  		<td>Anne</td>
			  		<td>Assessoria Técnica</td>
			  		<td>10/Ago/15</td>
			  		<td>Matteus Barragan</td>
		  		</tr>
		  		<tr>
			  		<td><input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."></td>
			  		<td><span class="label label-warning">Alta</span></td> 
			  		<td>A pasta da farmácia sumui do desktop</td>
			  		<td>Karina da Farmácia</td>
			  		<td>Farmácia</td>
			  		<td>10/Ago/15</td>
			  		<td>Elisa Penteado</td>
		  		</tr>
		  		<tr>
			  		<td><input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."></td>
			  		<td><span class="label label-info">Média</span></td> 
			  		<td>Problemas com terroristas sírios</td>
			  		<td>Tera Giga</td>
			  		<td>Egenharia</td>
			  		<td>10/Ago/15</td>
			  		<td>Bruno Fagundes</td>
		  		</tr>
		  		<tr>
			  		<td><input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."></td>
			  		<td><span class="label label-success">Baixa</span></td> 
			  		<td>Quebrar 38 contas</td>
			  		<td>Adriana</td>
			  		<td>Faturamento</td>
			  		<td>10/Ago/15</td>
			  		<td>Igor Nunes</td>
		  		</tr>
			</tbody>
		</table>
	</div>

</body>
</html>