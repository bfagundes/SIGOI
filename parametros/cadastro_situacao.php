<?php

// variaveis
$modalUpdateSituacao = "update-situacao";
$inputSituacao = "inputSituacao";
$inputName = "Situação";
$dataId = "idSituacao";
$btnUpdateSituacao = "btnUpdateSituacao";
$btnDeleteSituacao = "btnDeleteSituacao";
$sqlTabSituacao = "situacao";

// altera situacoes no banco
if(isset($_POST[$btnUpdateSituacao])){
	$result = db_query("UPDATE ".$sqlTabSituacao." SET nome = ".db_quote($_POST[$inputSituacao])." WHERE id = ".db_quote($_POST[$dataId]));
	if($result === false) {
		$error = pg_result_error($result);
	}
	header('Location: parametros.php');
}

// deleta situacoes do banco
if(isset($_POST[$btnDeleteSituacao])){
	$result = db_query("DELETE from ".$sqlTabSituacao." WHERE id = ".db_quote($_POST[$dataId]));
	if($result === false) {
		$error = pg_result_error($result);
	}
	header('Location: parametros.php');
}

?>

<table class="table table-condensed table-hover">
	<thead>
		<tr>
			<th width="1%"></th>
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

<!-- Modal -->
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
</script>