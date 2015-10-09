<nav class="navbar navbar-default">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
			</button>
			<a class="navbar-brand" href="index.php">FHGV</a>
		</div>
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<!-- <li class="nav nav-btn"><a href="chamado.php?id=0">Novo Chamado</a></li> -->
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Admin <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="lista_usuario.php?view=usr_ativo">Cadastro de Usuários</a></li>
						<li><a href="cadastro_setor.php">Cadastro de Setores</a></li>
						<li><a href="cadastro_local.php">Cadastro de Locais</a></li>
						<li><a href="cadastro_funcao.php">Cadastro de Funções</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="admin_parametros.php?tab=1">Parâmetros SIGOI</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Informática <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="info_index.php">Controle de FOs</a></li>	
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Transporte <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="transp.php">Solicitação de Transportes</a></li>
						<li class="nav nav-btn"><a href="transp_solicitacao_adm.php?id=0">Sol. Administrativo</a></li>
						<li class="nav nav-btn"><a href="transp_solicitacao_ass.php?id=0">Sol. Assistencial</a></li>
					</ul>
				</li>
			</ul>
			<!-- Barra de Navegação: Direita -->
			<!-- <ul class="nav navbar-nav navbar-right">
				<form class="navbar-form navbar-left" role="search">
					<div class="input-group">
						<input type="text" class="form-control" placeholder="Pesquisar">
						<span class="input-group-btn">
							<button class="btn btn-default" type="button">Vai!</button>
						</span>
					</div>
				</form>
			</ul> -->
		</div>
	</div>
</nav>