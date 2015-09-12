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
$pageTitle = "Cadastro de Locais";
$pageUrl = "cadastro_local.php";
$btnUpdate = "btnUpdate";
$btnInsert = "btnInsert";
$btnDelete = "btnDelete";
$modalInsert = "insert-local";
$modalUpdate = "update-local";
$inputLocal = "inputLocal";
$dataId = "idLocal";
$duplicate = false;
$blocked = false;
$sqlTabLocal = "local";
$sqlTabSetor = "setor";
$sqlOrder = "ORDER BY LOWER(nome)";

// busca a lista de locais no banco
$locais = db_select("SELECT * FROM ".$sqlTabLocal." ".$sqlOrder);

// altera locais no banco
if(isset($_POST[$btnUpdate])){
	$result = db_query("UPDATE ".$sqlTabLocal." SET nome = ".db_quote($_POST[$inputLocal])." WHERE id = ".db_quote($_POST[$dataId]));
	if($result === false) {
		$error = pg_result_error($result);
	}
	header("Refresh:0");
}

// exclui locais do banco
if(isset($_POST[$btnDelete])){
	// testa se não existe dependências
	$blocked = false;
	$locaisBlocked = db_select("SELECT DISTINCT idLocal FROM ".$sqlTabSetor);
	for ($i = 0; $i < count($locaisBlocked); $i++){
		if(strcasecmp($_POST[$dataId], $locaisBlocked[$i]['idlocal']) == 0){
			$blocked = true;
		}
	}

	// executa a exclusao
	if($blocked === false){
		$result = db_query("DELETE from ".$sqlTabLocal." WHERE id = ".db_quote($_POST[$dataId]));
		if($result === false) {
			$error = pg_result_error($result);
		}
		header("Refresh:0");	
	}
}

// insere locais no banco
if(isset($_POST[$btnInsert])){
	// testa se já não existe uma entrada duplicada (case insensitive)
	$duplicate = false;
	for ($i = 0; $i < count($locais); $i++) {
		if(strcasecmp($locais[$i]['nome'], $_POST[$inputLocal]) == 0){
			$duplicate = true;
		}
	}

	// executa a inclusao
	if($duplicate == false){
		$result = db_query("INSERT INTO ".$sqlTabLocal." (nome) VALUES (".db_quote($_POST[$inputLocal]).")");
		if($result === false) {
			$error = pg_result_error($result);
		}
		// atualiza a lista de locais
		$locais = db_select("SELECT * FROM ".$sqlTabLocal." ".$sqlOrder);
		header("Refresh:0");	
	}
}

// Modals
$inputName1 = $inputLocal;
$inputTitle1 = "Local";
include('./includes/modal_single_insert.php');
include('./includes/modal_single_update.php');

// Header
$navBackUrl = "index.php";
$navOptions = "<li class=\"nav nav-btn\" data-toggle=\"modal\" data-target=\"#$modalInsert\"><a href=\"#\">Incluir Local</a></li>";  
require_once('./includes/header.php');
require_once('./includes/navbar_default.php');
?>
	<div class="container-fluid">
		<div class="row">
			<?php
			// Mensagem de erro ao cadastrar um local duplicado
			if($duplicate === true){
				$errorMessage="<strong>Atenção!</strong> Esse local já existe no cadastro.";
				require('./includes/alert_error.php');
			}
			// Mensagem de erro ao tentar deletar um local com dependências
			if($blocked === true){
				$errorMessage="<strong>Atenção!</strong> Esse local está vinculado a um ou mais setores. Não é possível efetuar a exclusão."; 
				require('./includes/alert_error.php');
			} ?>
				
			<!-- Tabela com a lista de locais -->
			<table class="table table-condensed table-hover">
				<thead>
					<tr>
						<th width="1%"></th>
						<th class="col-sm-3">Local</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					for ($i = 0; $i < count($locais); $i++) {
						echo "<tr data-toggle=\"modal\" data-id=\"".$locais[$i]['id']."\" data-target=\"#".$modalUpdate."\" data-raw=\"".$locais[$i]['nome']."\">";
						echo "<td></td>";
						echo "<td>".$locais[$i]['nome']."</td>";
						echo "</tr>";
					} ?>
				</tbody>
			</table>
		</div>
	</div>

	<!-- Footer -->
	<?php require_once('./includes/footer.php'); ?>

	<!-- Scripts -->
	<script type="text/javascript">
	    $('tr').on('click', function (e) {
		    e.preventDefault();
		    // pegando o id e o nome do local na linha clicada
		    var id = $(this).closest('tr').data('id');
		    var nome = $(this).closest('tr').data('raw');
		    // mandando isso pra dentro do modal
		    $("#update-local #idLocal").val(id);
		    $("#update-local #inputLocal").val(nome);
		});

	    // seta o foco pro text field
		$("#insert-local").on('shown.bs.modal', function(){
	        $(this).find('#inputLocal').focus();
	    });
	    $("#update-local").on('shown.bs.modal', function(){
	        $(this).find('#inputLocal').focus();
	    });
	</script>

</body>
</html>