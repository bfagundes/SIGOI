<?php
include("./functions/conexao.php");
include("./functions/sessao.php");
include("./functions/defaults.php");
session_start();

// Testa se o usuario está logado
if(!session_isValid()){
	header('Location: login.php');
	die();
}

// variaveis
$pageTitle = "Cadastro de Usuario";
$pageUrl = "cadastro_usuario.php";
$dataId = $_GET['id'];
$defaultPassword = 123;
$hashedPassword;

/* testa se os campos obrigatórios foram preenchidos */
function missedReqField(){
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		if(empty($_POST['inputNome']) || empty($_POST['inputSetor']) || empty($_POST['inputFuncao'])){
			return true;
		}
		return false;
	}
}

// Recuperando dados do $_POST
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	if(isset($_POST['ckAtivo']) && $_POST['ckAtivo'] == 'on'){ $ativo = true; }else{ $ativo=0; }
	if(isset($_POST['ckAdmin']) && $_POST['ckAdmin'] == 'on'){ $admin = true; }else{ $admin=0; }
	if(isset($_POST['ckResetarSenha']) && $_POST['ckResetarSenha'] == 'on'){ 
		$resetarSenha = true; 
		$hashedPassword = password_hash($defaultPassword, PASSWORD_DEFAULT);
	}else{ 
		$resetarSenha = 0; 
	}
}

// altera usuarios no banco
if(isset($_POST[$btnUpdate])){
	// altera a senha no banco pra senha padrao
	if($resetarSenha){
		$result = db_query("UPDATE ".$sqlTabUsuario." SET senha =".db_quote($hashedPassword)." WHERE id = ".$dataId);
	}

	// executa a query
	if(!missedReqField()){
		$result = db_query("UPDATE ".$sqlTabUsuario.
			" SET nome=".db_quote($_POST[$inputNome]).
			", idsetor=".getId($sqlTabSetor, 'nome', $_POST[$inputSetor]).
			", idFuncao=".getId($sqlTabFuncao, 'nome', $_POST[$inputFuncao]).
			", login=".db_quote($_POST[$inputLogin]).
			", ativo=".db_quote($ativo).
			", admin=".db_quote($admin).
			", resetarSenha=".db_quote($resetarSenha).
			", ultimoLogin=null".
			" WHERE id = ".$dataId);
		if($result === false){
			$error = pg_result_error($result);
		}
		header('Location: lista_usuario.php');
		die();
	}
}

/* Insere usuários no banco */
if(isset($_POST[$btnInsert])){
	// executa a query
	if(!missedReqField() && !db_exists($sqlTabUsuario, 'login', $_POST[$inputLogin])){
		$result = db_query("INSERT INTO ".$sqlTabUsuario.
			" (nome, idSetor, idFuncao, login, senha, ativo, admin, resetarSenha, ultimoLogin) VALUES".
			" (".db_quote($_POST[$inputNome]).
			", ".getId($sqlTabSetor, 'nome', $_POST[$inputSetor]).
			", ".getId($sqlTabFuncao, 'nome', $_POST[$inputFuncao]).
			", ".db_quote($_POST[$inputLogin]).
			", ".db_quote($hashedPassword).
			", ".$ativo.
			", ".$admin.
			", ".$resetarSenha.
			", null)");
		if($result === false) {
			$error = pg_result_error($result);
		}
		header('Location: lista_usuario.php');
		die();
	}
}

// evita buscas se estiver no modo 'incluir_usuario'
if($dataId > 0){
	// busca o usuario
	$usuario = db_select("SELECT USUARIO.*, SETOR.nome as setor, FUNCAO.nome as funcao FROM ".$sqlTabUsuario
		." INNER JOIN ".$sqlTabSetor." on (USUARIO.idsetor = SETOR.id)"
		." INNER JOIN ".$sqlTabFuncao." on (USUARIO.idfuncao = FUNCAO.id)"
		." WHERE USUARIO.id = ".$dataId);
	$usuario = $usuario[0];
	// define variaveis pro header
	$navOptions = "<li><button type=\"submit\" name=\"$btnUpdate\" class=\"btn btn-default navbar-btn\">Salvar</button></li>";
	$pageUrl = $pageUrl."?id=".$dataId;
}else{
	// cria um usuario com informacoes genericas
	$usuario = array("nome" => "", "login" => "", "ativo" => "t", "admin" => "f", "resetarsenha" => "t", "setor" => "", "funcao" => "");
	// define variaveis pro header
	$navOptions = "<li><button type=\"submit\" name=\"$btnInsert\" class=\"btn btn-default navbar-btn\">Salvar</button></li>"; 
	$pageUrl = $pageUrl."?id=0";
}

// evita perder os dados prenchidos no $_POST com erros
if(isset($_POST[$inputNome])){ $usuario['nome'] = $_POST[$inputNome]; }
if(isset($_POST[$inputSetor])){ $usuario['setor'] = $_POST[$inputSetor]; }
if(isset($_POST[$inputFuncao])){ $usuario['funcao'] = $_POST[$inputFuncao]; }
if(isset($_POST[$inputLogin])){ $usuario['login'] = $_POST[$inputLogin]; }

// Header
$navBackUrl = "lista_usuario.php";
require_once('./includes/header.php');
?>
	<form role="form" method="post" <?php echo "action=\"".$pageUrl."\""; ?>>
		<?php require_once('./includes/navbar_default.php'); ?>

		<div class="container-fluid">
			<div class="row">

				<?php 
				if(missedReqField()){
					$errorMessage="<strong>Atenção!</strong> Preencha todos os campos obrigatórios"; 
					require('./includes/alert_error.php');
				} 
				if(isset($_POST[$inputLogin])){
					if(db_exists($sqlTabUsuario, 'login', $_POST[$inputLogin])){
						$errorMessage="<strong>Atenção!</strong> Login já cadastrado!"; 
						require('./includes/alert_error.php');
					}
				}
				?>
				
				<div class="col-md-3">
					<div class="panel panel-default">
						<div class="panel-body" style="height: 500px;">
							<div class="form-group">
								<div class="form-group">
									<label for="usuario-nome">Nome*</label>
									<input type="text" placeholder="Nome" <?php echo("name=\"".$inputNome."\" id=\"".$inputNome."\" value=\"".$usuario['nome']."\""); ?> class="form-control">
								</div>
								<div class="btn-group" role="group">
									<div class="form-group">
										<label for="nome-setor">Setor*</label>
										<div id="setor"><input type="text" class="typeahead form-control" placeholder="Setor" <?php echo(" id=\"".$inputSetor."\" name=\"".$inputSetor."\" value=\"".$usuario['setor']."\""); ?>></div>
									</div>
								</div>
								<div class="btn-group" role="group">
									<div class="form-group">
										<label for="nome-setor">Função*</label>
										<div id="funcao"><input type="text" class="typeahead form-control" placeholder="Função" <?php echo(" id=\"".$inputFuncao."\" name=\"".$inputFuncao."\" value=\"".$usuario['funcao']."\""); ?>></div>
									</div>
								</div>
								<div class="form-group">
									<label for="usuario-login">Login</label>
									<input type="text" <?php echo("name=\"".$inputLogin."\" value=\"".$usuario['login']."\""); ?> class="form-control">
								</div>
								Último Acesso: 20/09/1835

								<div class="checkbox">
									<label><input type="checkbox" name="ckAtivo" <?php if($usuario['ativo'] === 't'){echo "checked";} ?>>Usuário Ativo</label>
								</div>

								<div class="checkbox">
									<label><input type="checkbox" name="ckAdmin" <?php if($usuario['admin'] === 't'){echo "checked";} ?>>Usuário Administrador</label>
								</div>

								<div class="checkbox">
									<label><input type="checkbox" name="ckResetarSenha" <?php if($usuario['resetarsenha'] === 't'){echo "checked";} ?>>Resetar a Senha</label>
								</div>
							</div>
						</div>
					</div>
				</div>

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
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>

	<!-- Footer -->
	<?php require_once('./includes/footer.php'); ?>

	<script type="text/javascript">
	    // altera o estilo do selectpicker
		$('.selectpicker').selectpicker();

		// Autocomplete de setores
		var setores = getPrediction('setor');
		$('#setor .typeahead').typeahead(null, { name:'nome', display:'nome', source:setores });

		// Autocomplete de funcoes
		var funcoes = getPrediction('funcao');
		$('#funcao .typeahead').typeahead(null, { name:'nome', display:'nome', source:funcoes });
	</script>

</body>
</html>