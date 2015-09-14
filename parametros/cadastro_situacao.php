<?php

// variaveis
$modalUpdateSituacao = "update-situacao";
$modalInsertSituacao = "insert-situacao";
$inputSituacao = "inputSituacao";
$inputName = "Situação";
$dataId = "idSituacao";
$btnInsertSituacao = "btnInsertSituacao";
$btnUpdateSituacao = "btnUpdateSituacao";
$btnDeleteSituacao = "btnDeleteSituacao";
$duplicate = false;

// altera situacoes no banco
if(isset($_POST[$btnUpdateSituacao])){
	$result = db_query("UPDATE ".$sqlTabSituacao." SET nome = ".db_quote($_POST[$inputSituacao])." WHERE id = ".db_quote($_POST[$dataId]));
	if($result === false) {
		$error = pg_result_error($result);
	}
	header('Location: parametros.php?tab=2');
}

// deleta situacoes do banco
if(isset($_POST[$btnDeleteSituacao])){
	$result = db_query("DELETE from ".$sqlTabSituacao." WHERE id = ".db_quote($_POST[$dataId]));
	if($result === false) {
		$error = pg_result_error($result);
	}
	header('Location: parametros.php?tab=2');
}

// insere situacoes no banco
if(isset($_POST[$btnInsertSituacao])){
	// testa se já não existe uma entrada duplicada (case insensitive)
	$duplicate = false;
	for ($i = 0; $i < count($situacoes); $i++) {
		if(strcasecmp($situacoes[$i]['nome'], $_POST[$inputSituacao]) == 0){
			$duplicate = true;
		}
	}

	// executa a inclusao
	if($duplicate === false){
		$result = db_query("INSERT INTO ".$sqlTabSituacao." (nome) VALUES (".db_quote($_POST[$inputSituacao]).")");
		if($result === false) {
			$error = pg_result_error($result);
		}
		// atualiza a lista de funcoes
		$situacoes = db_select("SELECT * FROM ".$sqlTabSituacao." ".$sqlOrderSituacao);
		header('Location: parametros.php?tab=2');
	}
}

?>

<?php
// Mensagem de erro ao cadastrar um tipo duplicada
if($duplicate === true){
	$errorMessage="<strong>Atenção!</strong> Essa situação já existe no cadastro.";
	echo "<br>";
	require('./includes/alert_error.php');
}?>

<table class="table table-condensed table-hover">
	<thead>
		<tr>
			<th width="1%"><div style="text-align: center;"><input <?php echo(" name=\"".$btnInsertSituacao."\""); ?> data-toggle="modal" <?php echo ("data-target=\"#".$modalInsertSituacao."\""); ?> class="btn btn-warning btn-add-small" value="+"/></div></th>
			<th class="col-sm-3">Situação</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		for ($i = 0; $i < count($situacoes); $i++) {
			echo "<tr data-toggle=\"modal\" data-id=\"".$situacoes[$i]['id']."\" data-target=\"#".$modalUpdateSituacao."\" data-raw=\"".$situacoes[$i]['nome']."\">";
			echo "<td></td>";
			echo "<td>".$situacoes[$i]['nome']."</td>";
			echo "</tr>";
		} ?>
	</tbody>
</table>

<!-- Modal-Update -->
<div class="modal fade" <?php echo(" id=\"".$modalUpdateSituacao."\""); ?> tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><?php echo $pageTitle; ?></h4>
			</div>
			<div class="modal-body">
				<form role="form" method="post" <?php echo(" action=\"".$pageUrl."\""); ?>>
					<div class="form-group">
						<label for="funcao-heading"><?php echo $inputName; ?></label>
						<input type="hidden" <?php echo(" name=\"".$dataId."\" id=\"".$dataId."\""); ?> value=""/>
						<input type="text" <?php echo("name=\"".$inputSituacao."\" id=\"".$inputSituacao."\""); ?> class="form-control" value="" required>
					</div>
					<div class="form-group">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
						<input <?php echo(" name=\"".$btnUpdateSituacao."\""); ?> type="submit" class="btn btn-primary" value="Salvar"/>
						<input <?php echo(" name=\"".$btnDeleteSituacao."\""); ?> type="submit" class="btn btn-danger" value="Delete" onclick="return confirm('Você tem certeza?');"/>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- Modal-Insert -->
<div class="modal fade" <?php echo(" id=\"".$modalInsertSituacao."\""); ?> tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><?php echo $pageTitle; ?></h4>
			</div>
			<div class="modal-body">
				<form role="form" method="post" <?php echo(" action=\"".$pageUrl."\""); ?>>
					<div class="form-group">
						<label for="funcao-heading"><?php echo $inputName; ?></label>
						<input type="hidden" <?php echo(" name=\"".$dataId."\" id=\"".$dataId."\""); ?> value=""/>
						<input type="text" <?php echo("name=\"".$inputSituacao."\" id=\"".$inputSituacao."\""); ?> class="form-control" value="" required>
					</div>
					<div class="form-group">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
						<input <?php echo(" name=\"".$btnInsertSituacao."\""); ?> type="submit" class="btn btn-primary" value="Salvar"/>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$('tr').on('click', function (e) {
	    e.preventDefault();
	    // pegando o id e o nome da funcao na linha clicada
	    var id = $(this).closest('tr').data('id');
	    var nome = $(this).closest('tr').data('raw');
	    // mandando isso pra dentro do modal
	    $("#update-situacao #idSituacao").val(id);
	    $("#update-situacao #inputSituacao").val(nome);
	});
    $("#update-situacao").on('shown.bs.modal', function(){
        $(this).find('#inputSituacao').focus();
    });
    $("#insert-situacao").on('shown.bs.modal', function(){
        $(this).find('#inputSituacao').focus();
    });
</script>