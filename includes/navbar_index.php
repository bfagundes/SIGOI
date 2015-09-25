<nav class="navbar navbar-default">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
			</button>
			<a class="navbar-brand" href="index.php">SIGOI</a>
		</div>
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li class="nav nav-btn"><a href="chamado.php?id=0">Novo Chamado</a></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Opções <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li class="disabled"><a href="#">Excluir Chamado</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="lista_usuario.php">Cadastro de Usuários</a></li>
						<li><a href="cadastro_setor.php">Cadastro de Setores</a></li>
						<li><a href="cadastro_local.php">Cadastro de Locais</a></li>
						<li><a href="cadastro_funcao.php">Cadastro de Funções</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="parametros.php?tab=1">Parâmetros SIGOI</a></li>
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
			</ul>
			<!-- Barra de Navegação: Direita -->
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