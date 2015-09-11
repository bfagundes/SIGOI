<?php
include "./functions/conexao.php";

// variaveis
$page = "cadastro_usuario.php";
$btnUpdate = "btnUpdate";
$btnInsert = "btnInsert";
$btnDelete = "btnDelete";
$inputNome = "inputNome";
$inputSetor = "inputSetor";
$inputFuncao = "inputFuncao";
$inputLogin = "inputLogin";
$dataId = $_GET['id'];
//$duplicate = false;
$sqlTabUsuario = "usuario";
$sqlTabSetor = "setor";
$sqlTabFuncao = "funcao";
$sqlOrder = "ORDER BY LOWER(nome)";

// evita buscas se estiver no modo 'incluir_usuario'
if($dataId > 0){
	// busca o usuario no banco
	$usuarios = db_select("SELECT * FROM ".$sqlTabUsuario." WHERE id = ".$dataId);

	// busca o setor e a funcao do usuario no banco
	$usrSetor = db_select("SELECT nome from ".$sqlTabSetor." WHERE id = ".$usuarios[0]['idsetor']);
	$usrFuncao = db_select("SELECT nome from ".$sqlTabFuncao." WHERE id = ".$usuarios[0]['idfuncao']);
}else{
	$usuarios = array(0 => array("nome" => "", "login" => "", "ativo" => "t", "admin" => "f", "resetarsenha" => "t"));
	$usrSetor = array(0 => array("nome" => ""));
	$usrFuncao = array(0 => array("nome" => ""));
}
// busca a lista de setores e funcoes
$setores = db_select("SELECT * FROM ".$sqlTabSetor." ".$sqlOrder);
$funcoes = db_select("SELECT * FROM ".$sqlTabFuncao." ".$sqlOrder);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastro de Usuário</title>
 
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
    <!-- jQuery & JavaScript -->
	<!-- <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->
	<script type="text/javascript" src="js/jquery1-11-3.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="js/bootstrap-select.min.js"></script>
	<script type="text/javascript" src="js/custom.js"></script>	

	<form role="form" method="post" action="lista_usuario.php">

		<!-- Barra de Navegação -->
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="index.php">SIGOI</a>
				</div>
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<!--  Barra de Navegação: Esquerda -->
					<ul class="nav navbar-nav">
						<li class="nav nav-btn"><a href="lista_usuario.php">Sair</a></li>
						<li><button type="submit" <?php if($dataId > 0){echo "name=\"".$btnUpdate."\"";}else{echo "name=\"".$btnInsert."\"";} ?> class="btn btn-default navbar-btn">Salvar</button></li>
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
					<div class="col-md-3">
						<div class="panel panel-default">
			  				<div class="panel-body" style="height: 500px;">
								<div class="form-group">
										<div class="form-group">
											<input type="hidden" name="idUsuario" class="form-control" <?php echo(" value=\"".$dataId."\""); ?>>
										</div>
										<div class="form-group">
											<label for="usuario-nome">Nome</label>
											<input type="text" name=<?php echo("\"".$inputNome."\""); ?> class="form-control" <?php echo(" value=\"".$usuarios[0]['nome']."\""); ?> required>
										</div>
										<div class="btn-group" role="group">
											<div class="form-group">
												<label for="usuario-setor">Setor</label>
												<select <?php echo(" id=\"".$inputSetor."\""); ?> <?php echo(" name=\"".$inputSetor."\""); ?> class="selectpicker" title="Selecione um Setor" data-width="100%" required>
													<?php
													if($dataId <= 0){ echo "<option></option>"; }
													for($i = 0; $i <count($setores); $i++){
														echo "<option>".$setores[$i]['nome']."</option>";
													}
													?>
												</select> 
											</div>
										</div>
										<div class="btn-group" role="group">
											<div class="form-group">
												<label for="usuario-funcao">Funcao</label>
												<select <?php echo(" id=\"".$inputFuncao."\""); ?> <?php echo(" name=\"".$inputFuncao."\""); ?> class="selectpicker" title="Selecione uma Função" data-width="100%" required>
													<?php
													if($dataId <= 0){ echo "<option></option>"; }
													for($i = 0; $i <count($funcoes); $i++){
														echo "<option>".$funcoes[$i]['nome']."</option>";
													}
													?>
												</select> 
											</div>
										</div>
										<div class="form-group">
											<label for="usuario-login">Login</label>
											<input type="text" name=<?php echo("\"".$inputLogin."\""); ?> class="form-control" <?php echo(" value=\"".$usuarios[0]['login']."\""); ?>>
										</div>
										Último Acesso: 20/09/1835

										<div class="checkbox">
											<label><input type="checkbox" name="ckAtivo" <?php if($usuarios[0]['ativo'] === 't'){echo "checked";} ?>>Usuário Ativo</label>
										</div>

										<div class="checkbox">
											<label><input type="checkbox" name="ckAdmin" <?php if($usuarios[0]['admin'] === 't'){echo "checked";} ?>>Usuário Administrador</label>
										</div>

										<div class="checkbox">
											<label><input type="checkbox" name="ckResetarSenha" <?php if($usuarios[0]['resetarsenha'] === 't'){echo "checked";} ?>>Resetar a Senha</label>
										</div>
			  					</div> <!-- /Form-Group -->
			  				</div> <!-- /Panel-Body -->
						</div> <!-- /Panel -->
					</div> <!-- /Col -->
					<div class="col-md-3">
						<div class="panel panel-default">
			  				<div class="panel-body" style="height: 500px;">
								<div class="form-group">
										<label style="margin-bottom:-5px;">Permissões:</label>
										<div class="checkbox"><label><input type="checkbox" value="">Abrir Chamados</label></div>
										<div class="checkbox"><label><input type="checkbox" value="">Responder Chamados</label></div>
										<div class="checkbox"><label><input type="checkbox" value="">Alterar Chamados</label></div>
										<div class="checkbox"><label><input type="checkbox" value="">Fechar Chamados</label></div>
										<div class="checkbox"><label><input type="checkbox" value="">Excluir Chamados</label></div>
										
										<label style="margin-top: 10px; margin-bottom:-5px;">Visualizações:</label>
										<div class="checkbox"><label><input type="checkbox" value="">Visualizar os seus Chamados</label></div>
										<div class="checkbox"><label><input type="checkbox" value="">Visualizar todos os Chamados</label></div>
										
										<label style="margin-top: 10px; margin-bottom:-5px;">Funções de Administrador:</label>
										<div class="checkbox"><label><input type="checkbox" value="">Cadastro de Usuários</label></div>
										<div class="checkbox"><label><input type="checkbox" value="">Cadastro de Setores</label></div>
										<div class="checkbox"><label><input type="checkbox" value="">Cadastro de Locais</label></div>
										<div class="checkbox"><label><input type="checkbox" value="">Cadastro de Funções</label></div>
										<div class="checkbox"><label><input type="checkbox" value="">Parâmetros SIGOI</label></div>
								</div> <!-- /Form-Group -->
			  				</div> <!-- /Panel-Body -->
						</div> <!-- /Panel -->
					</div> <!-- /Col -->
			</div> <!-- /Row -->
		</div> <!-- /Container-Fluid -->
	</form>

	<script type="text/javascript">
	    // altera o estilo do selectpicker
		$('.selectpicker').selectpicker();
		$("#inputSetor").selectpicker('val', <?php echo '\''.$usrSetor[0]['nome'].'\''; ?> );
		$("#inputFuncao").selectpicker('val', <?php echo '\''.$usrFuncao[0]['nome'].'\''; ?> );
	</script>

</body>
</html>