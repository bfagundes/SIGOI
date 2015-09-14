<?php

// variaveis
$modalUpdateTipo = "update-tipo";
$modalInsertTipo = "insert-tipo";
$inputTipo = "inputTipo";
$inputName = "Tipo";
$dataId = "idTipo";
$btnInsertTipo = "btnInsertTipo";
$btnUpdateTipo = "btnUpdateTipo";
$btnDeleteTipo = "btnDeleteTipo";
$sqlTabTipo = "tipo";
$duplicate = false;

// altera tipos no banco
if(isset($_POST[$btnUpdateTipo])){
	$result = db_query("UPDATE ".$sqlTabTipo." SET nome = ".db_quote($_POST[$inputTipo])." WHERE id = ".db_quote($_POST[$dataId]));
	if($result === false) {
		$error = pg_result_error($result);
	}
	header('Location: parametros.php?tab=3');
}

// deleta tipos do banco
if(isset($_POST[$btnDeleteTipo])){
	$result = db_query("DELETE from ".$sqlTabTipo." WHERE id = ".db_quote($_POST[$dataId]));
	if($result === false) {
		$error = pg_result_error($result);
	}
	header('Location: parametros.php?tab=3');
}

// insere tipos no banco
if(isset($_POST[$btnInsertTipo])){
	// testa se já não existe uma entrada duplicada (case insensitive)
	$duplicate = false;
	for ($i = 0; $i < count($tipos); $i++) {
		if(strcasecmp($tipos[$i]['nome'], $_POST[$inputTipo]) == 0){
			$duplicate = true;
		}
	}

	// executa a inclusao
	if($duplicate === false){
		$result = db_query("INSERT INTO ".$sqlTabTipo." (nome) VALUES (".db_quote($_POST[$inputTipo]).")");
		if($result === false) {
			$error = pg_result_error($result);
		}
		// atualiza a lista de funcoes
		$tipos = db_select("SELECT * FROM ".$sqlTabTipo." ".$sqlOrderTipo);
		header('Location: parametros.php?tab=3');
	}
}

?>

<?php
// Mensagem de erro ao cadastrar um tipo duplicada
if($duplicate === true){
	$errorMessage="<strong>Atenção!</strong> Esse tipo já existe no cadastro.";
	echo "<br>";
	require('./includes/alert_error.php');
}?>

<table class="table table-condensed table-hover">
	<thead>
		<tr>
			<th width="1%"><div style="text-align: center;"><input <?php echo(" name=\"".$btnInsertTipo."\""); ?> data-toggle="modal" <?php echo ("data-target=\"#".$modalInsertTipo."\""); ?> class="btn btn-warning btn-add-small" value="+"/></div></th>
			<th class="col-sm-3">Tipo</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		for ($i = 0; $i < count($tipos); $i++) {
			echo "<tr data-toggle=\"modal\" data-id=\"".$tipos[$i]['id']."\" data-target=\"#".$modalUpdateTipo."\" data-raw=\"".$tipos[$i]['nome']."\">";
			echo "<td></td>";
			echo "<td>".$tipos[$i]['nome']."</td>";
			echo "</tr>";
		} ?>
	</tbody>
</table>

<!-- Modal-Update -->
<div class="modal fade" <?php echo(" id=\"".$modalUpdateTipo."\""); ?> tabindex="-1" role="dialog">
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
						<input type="text" <?php echo("name=\"".$inputTipo."\" id=\"".$inputTipo."\""); ?> class="form-control" value="" required>
					</div>
					<div class="form-group">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
						<input <?php echo(" name=\"".$btnUpdateTipo."\""); ?> type="submit" class="btn btn-primary" value="Salvar"/>
						<input <?php echo(" name=\"".$btnDeleteTipo."\""); ?> type="submit" class="btn btn-danger" value="Delete" onclick="return confirm('Você tem certeza?');"/>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- Modal-Insert -->
<div class="modal fade" <?php echo(" id=\"".$modalInsertTipo."\""); ?> tabindex="-1" role="dialog">
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
						<input type="text" <?php echo("name=\"".$inputTipo."\" id=\"".$inputTipo."\""); ?> class="form-control" value="" required>
					</div>
					<div class="form-group">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
						<input <?php echo(" name=\"".$btnInsertTipo."\""); ?> type="submit" class="btn btn-primary" value="Salvar"/>
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
	    $("#update-tipo #idTipo").val(id);
	    $("#update-tipo #inputTipo").val(nome);
	});
    $("#update-tipo").on('shown.bs.modal', function(){
        $(this).find('#inputTipo').focus();
    });
    $("#insert-tipo").on('shown.bs.modal', function(){
        $(this).find('#inputTipo').focus();
    });
</script>