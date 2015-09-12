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
$pageTitle = "Cadastro de Funções";
$pageUrl = "cadastro_funcao.php";
$btnUpdate = "btnUpdate";
$btnInsert = "btnInsert";
$btnDelete = "btnDelete";
$modalInsert = "insert-funcao";
$modalUpdate = "update-funcao";
$inputFuncao = "inputFuncao";
$dataId = "idFuncao";
$duplicate = false;
$blocked = false;
$sqlTabFuncao = "funcao";
$sqlOrder = "ORDER BY LOWER(nome)";
$sqlTabUsuario = "usuario";

// busca a lista de funcoes no banco
$funcoes = db_select("SELECT * FROM ".$sqlTabFuncao." ".$sqlOrder);

// altera funcoes no banco
if(isset($_POST[$btnUpdate])){
	$result = db_query("UPDATE ".$sqlTabFuncao." SET nome = ".db_quote($_POST[$inputFuncao])." WHERE id = ".db_quote($_POST[$dataId]));
	if($result === false) {
		$error = pg_result_error($result);
	}
	header("Refresh:0");
}

// deleta funcoes do banco
if(isset($_POST[$btnDelete])){
	// testa se não existe dependências
	$blocked = false;
	$funcoesBlocked = db_select("SELECT DISTINCT idfuncao FROM ".$sqlTabUsuario);
	for ($i = 0; $i < count($funcoesBlocked); $i++){
		if(strcasecmp($_POST[$dataId], $funcoesBlocked[$i]['idfuncao']) == 0){
			$blocked = true;
		}
	}

	// executa a exclusao
	if($blocked === false){
		$result = db_query("DELETE from ".$sqlTabFuncao." WHERE id = ".db_quote($_POST[$dataId]));
		if($result === false) {
			$error = pg_result_error($result);
		}
		header("Refresh:0");
	}
}

// insere funcoes no banco
if(isset($_POST[$btnInsert])){
	// testa se já não existe uma entrada duplicada (case insensitive)
	$duplicate = false;
	for ($i = 0; $i < count($funcoes); $i++) {
		if(strcasecmp($funcoes[$i]['nome'], $_POST[$inputFuncao]) == 0){
			$duplicate = true;
		}
	}

	// executa a inclusao
	if($duplicate === false){
		$result = db_query("INSERT INTO ".$sqlTabFuncao." (nome) VALUES (".db_quote($_POST[$inputFuncao]).")");
		if($result === false) {
			$error = pg_result_error($result);
		}
		// atualiza a lista de funcoes
		$funcoes = db_select("SELECT * FROM ".$sqlTabFuncao." ".$sqlOrder);
		header("Refresh:0");	
	}
}

// Modals
$inputName1 = $inputFuncao;
$inputTitle1 = "Função";
include('./includes/modal_single_insert.php');
include('./includes/modal_single_update.php');

// Header
$navOptions = "<li class=\"nav nav-btn\" data-toggle=\"modal\" data-target=\"#$modalInsert\"><a href=\"#\">Incluir Funcao</a></li>";
require_once('./includes/header.php');
require_once('./includes/navbar_default.php');
?>
	<div class="container-fluid">
		<div class="row">
			<?php
			// Mensagem de erro ao cadastrar uma funcao duplicada
			if($duplicate === true){
				$errorMessage="<strong>Atenção!</strong> Essa função já existe no cadastro.";
				require('./includes/alert_error.php');
			}
			// Mensagem de erro ao tentar deletar uma funcao com dependências
			if($blocked === true){
				$errorMessage="<strong>Atenção!</strong> Essa função está vinculada a um ou mais usuários. Não é possível efetuar a exclusão."; 
				require('./includes/alert_error.php');
			} ?>
				
			<!-- Tabela com a lista de funções -->
			<table class="table table-condensed table-hover">
				<thead>
					<tr>
						<th width="1%"></th>
						<th class="col-sm-3">Função</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					for ($i = 0; $i < count($funcoes); $i++) {
						echo "<tr data-toggle=\"modal\" data-id=\"".$funcoes[$i]['id']."\" data-target=\"#".$modalUpdate."\" data-raw=\"".$funcoes[$i]['nome']."\">";
						echo "<td></td>";
						echo "<td>".$funcoes[$i]['nome']."</td>";
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
		    // pegando o id e o nome da funcao na linha clicada
		    var id = $(this).closest('tr').data('id');
		    var nome = $(this).closest('tr').data('raw');
		    // mandando isso pra dentro do modal
		    $("#update-funcao #idFuncao").val(id);
		    $("#update-funcao #inputFuncao").val(nome);
		});

	    // seta o foco pro text field
		$("#insert-funcao").on('shown.bs.modal', function(){
	        $(this).find('#inputFuncao').focus();
	    });
	    $("#update-funcao").on('shown.bs.modal', function(){
	        $(this).find('#inputFuncao').focus();
	    });
	</script>

</body>
</html>