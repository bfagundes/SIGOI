<?php
include ("./functions/conexao.php");
include ("./functions/sessao.php");
session_start();

// Testa se o usuario está logado
if(session_isValid() === false){
	header('Location: login.php');
	die();
}

// variaveis
$pageTitle = "Cadastro de Usuarios";
$pageUrl = "cadastro_usuario.php";
$btnUpdate = "btnUpdate";
$btnInsert = "btnInsert";
$btnDelete = "btnDelete";
$inputNome = "inputNome";
$inputSetor = "inputSetor";
$inputFuncao = "inputFuncao";
$inputLogin = "inputLogin";
$dataId = $_GET['id'];
$duplicate = false;
$missedReqField = false;
$sqlTabUsuario = "usuario";
// $sqlJoinUsuario = "INNER JOIN setor on (usuario.idsetor = setor.id)";
// $sqlOrderUsuario = "ORDER BY LOWER(USUARIO.nome)";
$sqlTabSetor = "setor";
$sqlTabFuncao = "funcao";
$sqlOrder = "ORDER BY LOWER(nome)";
$defaultPassword = 123;
$hashedPassword;



// altera usuarios no banco
if(isset($_POST[$btnUpdate])){
	// buscando o ID do setor selecionado
	$setorSelected = $_POST[$inputSetor];
	$setorSelected = db_select("SELECT id from ".$sqlTabSetor." WHERE nome =".db_quote($setorSelected));
	$setorSelected = $setorSelected[0]['id'];
	// buscando o ID da funcao selecionada
	$funcaoSelected = $_POST[$inputFuncao];
	$funcaoSelected = db_select("SELECT id from ".$sqlTabFuncao." WHERE nome =".db_quote($funcaoSelected));
	$funcaoSelected = $funcaoSelected[0]['id'];
	// pegando os valores dos checkboxes
	$ativo="false"; 
	$admin="false"; 
	$resetarSenha="false";
	if(isset($_POST['ckAtivo']) && $_POST['ckAtivo'] == 'on'){ $ativo = "true"; }
	if(isset($_POST['ckAdmin']) && $_POST['ckAdmin'] == 'on'){ $admin = "true"; }
	
	if(isset($_POST['ckResetarSenha']) && $_POST['ckResetarSenha'] == 'on'){
		$hashedPassword = password_hash($defaultPassword, PASSWORD_DEFAULT);
		$result = db_query("UPDATE ".$sqlTabUsuario." SET senha =".db_quote($hashedPassword)." WHERE id = ".$_POST['idUsuario']);
		$resetarSenha = "true"; 
	}

	// executa a query
	$result = db_query("UPDATE ".$sqlTabUsuario.
		" SET nome=".db_quote($_POST['inputNome']).
		", idSetor=".$setorSelected.
		", idFuncao=".$funcaoSelected.
		", login=".db_quote($_POST['inputLogin']).
		", ativo=".$ativo.
		", admin=".$admin.
		", resetarSenha=".$resetarSenha.
		", ultimoLogin=null".
		" WHERE id = ".$_POST['idUsuario']);
	if($result === false){
		$error = pg_result_error($result);
	}
}

// insere usuarios no banco
if(isset($_POST[$btnInsert])){
	// testando se já não existe um login com esses dados
	$duplicate = false;
	$usuarios = db_select("SELECT login from ".$sqlTabUsuario);
	for ($i = 0; $i < count($usuarios); $i++) {
		if((strcasecmp($usuarios[$i]['login'], $_POST[$inputLogin]) == 0)){
			$duplicate = true;
		}
	}

	if($duplicate === false){
		// verifica se os campos obrigatórios foram preenchidos
		if(empty($_POST[$inputNome])){
			$missedReqField = true;
		}

		// buscando o ID do setor selecionado
		$setorSelected = $_POST[$inputSetor];
		$setorSelected = db_select("SELECT id from ".$sqlTabSetor." WHERE nome =".db_quote($setorSelected));
		if($setorSelected == null){ $missedReqField = true; 
		}else{ $setorSelected = $setorSelected[0]['id']; }
		
		// buscando o ID da funcao selecionada
		$funcaoSelected = $_POST[$inputFuncao];
		$funcaoSelected = db_select("SELECT id from ".$sqlTabFuncao." WHERE nome =".db_quote($funcaoSelected));
		if($funcaoSelected == null){ $missedReqField = true; 
		}else{ $funcaoSelected = $funcaoSelected[0]['id']; }

		// pegando os valores dos checkboxes
		$ativo="false"; 
		$admin="false"; 
		$resetarSenha="false";
		if(isset($_POST['ckAtivo']) && $_POST['ckAtivo'] == 'on'){ $ativo = "true"; }
		if(isset($_POST['ckAdmin']) && $_POST['ckAdmin'] == 'on'){ $admin = "true"; }
		
		if(isset($_POST['ckResetarSenha']) && $_POST['ckResetarSenha'] == 'on'){
			$hashedPassword = password_hash($defaultPassword, PASSWORD_DEFAULT);
			$resetarSenha = "true"; 
		}

		// executa a query	
		if($missedReqField === false){
			$result = db_query("INSERT INTO ".$sqlTabUsuario.
				" (nome, idSetor, idFuncao, login, senha, ativo, admin, resetarSenha, ultimoLogin) VALUES".
				" (".db_quote($_POST['inputNome']).
				", ".$setorSelected.
				", ".$funcaoSelected.
				", ".db_quote($_POST['inputLogin']).
				", ".db_quote($hashedPassword).
				", ".$ativo.
				", ".$admin.
				", ".$resetarSenha.
				", null)");
			if($result === false) {
				$error = pg_result_error($result);
			}
		}
	}
}

// evita buscas se estiver no modo 'incluir_usuario'
if($dataId > 0){
	// busca no banco o usuario e seus respectivos setor e funcao
	$usuarios = db_select("SELECT * FROM ".$sqlTabUsuario." WHERE id = ".$dataId);
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

// Header
$navBackUrl = "lista_usuario.php";
if($dataId > 0){ 
	$navOptions = "<li><button type=\"submit\" name=\"$btnUpdate\" class=\"btn btn-default navbar-btn\">Salvar</button></li>";
	$pageUrl = $pageUrl."?id=".$dataId; 
}else{ 
	$navOptions = "<li><button type=\"submit\" name=\"$btnInsert\" class=\"btn btn-default navbar-btn\">Salvar</button></li>"; 
	$pageUrl = $pageUrl."?id=0";
}
require_once('./includes/header.php');
?>
	<form role="form" method="post" <?php echo "action=\"".$pageUrl."\""; ?>>
	<?php require_once('./includes/navbar_default.php'); ?>

	<!-- Conteúdo -->
	<div class="container-fluid">
		<div class="row">

			<?php 
			if($missedReqField === true){
				$errorMessage="<strong>Atenção!</strong> Preencha todos os campos obrigatórios"; 
				require('./includes/alert_error.php');
			} ?>
			

			<div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel-body" style="height: 500px;">
						<div class="form-group">
							<div class="form-group">
								<input type="hidden" name="idUsuario" class="form-control" <?php echo(" value=\"".$dataId."\""); ?>>
							</div>
							<div class="form-group">
								<label for="usuario-nome">Nome*</label>
								<input type="text" name=<?php echo("\"".$inputNome."\" value=\"".$usuarios[0]['nome']."\""); ?> class="form-control">
							</div>
							<div class="btn-group" role="group">
								<div class="form-group">
									<label for="usuario-setor">Setor*</label>
									<select <?php echo(" id=\"".$inputSetor."\" name=\"".$inputSetor."\""); ?> class="selectpicker" title="Selecione um Setor" data-width="100%">
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
									<label for="usuario-funcao">Funcao*</label>
									<select <?php echo(" id=\"".$inputFuncao."\" name=\"".$inputFuncao."\""); ?> class="selectpicker" title="Selecione uma Função" data-width="100%">
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
								<input type="text" <?php echo("name=\"".$inputLogin."\" value=\"".$usuarios[0]['login']."\""); ?> class="form-control">
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

	<!-- Footer -->
	<?php require_once('./includes/footer.php'); ?>

	<script type="text/javascript">
	    // altera o estilo do selectpicker
		$('.selectpicker').selectpicker();
		$("#inputSetor").selectpicker('val', <?php echo '\''.$usrSetor[0]['nome'].'\''; ?> );
		$("#inputFuncao").selectpicker('val', <?php echo '\''.$usrFuncao[0]['nome'].'\''; ?> );
	</script>

</body>
</html>