<?php
include("./functions/conexao.php");
include("./functions/sessao.php");
include("./functions/defaults.php");
session_start();

// Testa se o usuario está logado
if(session_isValid() === false){
	header('Location: login.php');
	die();
}

// variaveis
$pageTitle = "Cadastro de Setores";
$pageUrl = "cadastro_setor.php";
$modalInsert = "insert-setor";
$modalUpdate = "update-setor";
$inputSetor = "inputSetor";
$inputLocal = "inputLocal";
$dataId = "idSetor";
$duplicate = false;
$blocked = false;
$missedReqField = false;
$sqlJoin = "INNER JOIN local on (setor.idlocal = local.id)";
$sqlOrdSetor = "ORDER BY LOWER(SETOR.nome)";

// busca a lista de locais e setores no banco
$setores = db_select("SELECT SETOR.id AS id, SETOR.nome AS setor, LOCAL.nome AS local FROM ".$sqlTabSetor." ".$sqlJoin." ".$sqlOrdSetor);
$locais = db_select("SELECT * FROM ".$sqlTabLocal." ".$sqlOrdLocal);

// altera setores no banco
if(isset($_POST[$btnUpdate])){
	// buscando o ID do setor selecionado
	$localSelected = $_POST[$inputLocal];
	$localSelected = db_select("SELECT id from ".$sqlTabLocal." WHERE nome =".db_quote($localSelected));
	$localSelected = $localSelected[0]['id'];
	// executando a query
	$result = db_query("UPDATE ".$sqlTabSetor." SET nome = ".db_quote($_POST[$inputSetor]).", idLocal =".$localSelected." WHERE id = ".db_quote($_POST[$dataId]));
	if($result === false){
		$error = pg_result_error($result);
	}
	header('Location: cadastro_setor.php');
}

// exclui setores do banco
if(isset($_POST[$btnDelete])){
	// testa se não existe dependências
	$blocked = false;
	$setoresBlocked = db_select("SELECT DISTINCT idSetor FROM ".$sqlTabUsuario);
	for ($i = 0; $i < count($setoresBlocked); $i++){
		if(strcasecmp($_POST[$dataId], $setoresBlocked[$i]['idsetor']) == 0){
			$blocked = true;
		}
	}

	// executa a exclusao
	if($blocked === false){
		$result = db_query("DELETE from ".$sqlTabSetor." WHERE id = ".db_quote($_POST[$dataId]));
		if($result === false) {
			$error = pg_result_error($result);
		}
		header('Location: cadastro_setor.php');	
	}
}

// insere setores no banco
if(isset($_POST[$btnInsert])){
	// testando se já não existe uma entrada com esses valores (case insensitive)
	$duplicate = false;
	for ($i = 0; $i < count($setores); $i++) {
		if((strcasecmp($setores[$i]['setor'], $_POST[$inputSetor]) == 0) && (strcasecmp($setores[$i]['local'], $_POST[$inputLocal]) == 0)){
			$duplicate = true;
		}
	}

	// executa a inclusao
	if($duplicate === false){
		// buscando o ID do local selecionado
		$localSelected = $_POST[$inputLocal];
		$localSelected = db_select("SELECT id from ".$sqlTabLocal." WHERE nome =".db_quote($localSelected));
		$missedReqField = false;
		if($localSelected == null){
			$missedReqField = true;
		} else {
			$localSelected = $localSelected[0]['id'];
			$result = db_query("INSERT INTO ".$sqlTabSetor." (nome, idLocal) VALUES (".db_quote($_POST[$inputSetor]).", ".$localSelected.")");
			if($result === false) {
				$error = pg_result_error($result);
			}
			// atualiza a lista de setores
			$setores = db_select("SELECT SETOR.id AS id, SETOR.nome AS setor, LOCAL.nome AS local FROM ".$sqlTabSetor." ".$sqlJoin." ".$sqlOrdSetor);
			header('Location: cadastro_setor.php');
		}
	}
}

// Modals
$inputName1 = $inputSetor;
$inputName2 = $inputLocal;
$inputTitle1 = "Setor";
$inputTitle2 = "Local";
$array = $locais;
include('./includes/modal_double_insert.php');
include('./includes/modal_double_update.php');

// Header
$navBackUrl = "index.php";
$navOptions = "<li class=\"nav nav-btn\" data-toggle=\"modal\" data-target=\"#$modalInsert\"><a href=\"#\">Incluir Setor</a></li>";
require_once('./includes/header.php');
require_once('./includes/navbar_default.php');
?>
	<div class="container-fluid">
		<div class="row">
			<?php
			// Mensagem de erro ao cadastrar um setor duplicado
			if($duplicate === true){
				$errorMessage="<strong>Atenção!</strong> Esse setor já existe no cadastro.";
				require('./includes/alert_error.php');
			}
			// Mensagem de erro ao tentar cadastrar um setor sem selecionar um local
			if($missedReqField === true){
				$errorMessage="<strong>Atenção!</strong> Você não selecionou um local.";
				require('./includes/alert_error.php');
			}
			// Mensagem de erro ao tentar deletar um setor com dependências
			if($blocked === true){
				$errorMessage="<strong>Atenção!</strong> Esse setor está vinculado a um ou mais usuários. Não é possível efetuar a exclusão."; 
				require('./includes/alert_error.php');
			} ?>
				
			<!-- Tabela com a lista de locais -->
			<table class="table table-condensed table-hover">
				<thead>
					<tr>
						<th width="3%"></th>
						<th class="col-sm-3">Setor</th>
						<th class="col-sm-3">Local</th>
						<th class="col-sm-5"></th>
					</tr>
				</thead>
				<tbody>
					<?php 
					for ($i = 0; $i < count($setores); $i++) {
						echo "<tr data-toggle=\"modal\" data-id=\"".$setores[$i]['id']."\" data-target=\"#".$modalUpdate."\" data-nome=\"".$setores[$i]['setor']."\" data-local=\"".$setores[$i]['local']."\">";
						echo "<td></td>";
						echo "<td>".$setores[$i]['setor']."</td>";
						echo "<td>".$setores[$i]['local']."</td>";
						echo "<td></td>";
						echo "</tr>";
					} ?>
				</tbody>
			</table>
		</div>
	</div>

	<!-- Footer -->
	<?php require_once('./includes/footer.php'); ?>

	<script type="text/javascript">
	    $('tr').on('click', function (e) {
		    e.preventDefault();
		    // pegando os valores dos parametros
		    var id = $(this).closest('tr').data('id');
		    var nome = $(this).closest('tr').data('nome');
		    var local = $(this).closest('tr').data('local');
		    // e setando eles dentro do modal
		    $("#update-setor #idSetor").val(id);
		    $("#update-setor #inputSetor").val(nome);
		    $("#update-setor #inputLocal").selectpicker('val', local);
		});

	    // seta o foco pro text field
		$("#insert-setor").on('shown.bs.modal', function(){
	        $(this).find('#inputSetor').focus();
	    });
	    $("#update-setor").on('shown.bs.modal', function(){
	        $(this).find('#inputSetor').focus();
	    });

	    // altera o estilo do selectpicker
		$('.selectpicker').selectpicker();	
	</script>

</body>
</html>