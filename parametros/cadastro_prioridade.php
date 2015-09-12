<?php

// variaveis
$modalUpdatePrioridade = "update-prioridade";
$inputPrioridade = "inputPrioridade";
$inputTitle1 = "Prioridade";
$dataId = "idPrioridade";
$btnUpdatePrioridade = "btnUpdatePrioridade";
$sqlTabPrioridade = "prioridade";

// altera prioridades no banco
if(isset($_POST[$btnUpdatePrioridade])){
	$result = db_query("UPDATE ".$sqlTabPrioridade." SET nome = ".db_quote($_POST[$inputPrioridade])." WHERE id = ".db_quote($_POST[$dataId]));
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
			<th width="1%">Nível</th>
			<th class="col-sm-3">Prioridade</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		for ($i = 0; $i < count($prioridades); $i++) {
			echo "<tr data-toggle=\"modal\" data-id=\"".$prioridades[$i]['id']."\" data-target=\"#".$modalUpdatePrioridade."\" data-raw=\"".$prioridades[$i]['nome']."\">";
			echo "<td></td>";
			echo "<td>".$prioridades[$i]['id']."</td>";
			echo "<td>".$prioridades[$i]['nome']."</td>";
			echo "</tr>";
		} ?>
	</tbody>
</table>

<!-- Modal -->
<div class="modal fade" <?php echo(" id=\"".$modalUpdatePrioridade."\""); ?> tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><?php echo $pageTitle; ?></h4>
			</div>
			<div class="modal-body">
				<form role="form" method="post" <?php echo(" action=\"".$pageUrl."\""); ?>>
					<div class="form-group">
						<label for="funcao-heading"><?php echo $inputTitle1; ?></label>
						<input type="hidden" <?php echo(" name=\"".$dataId."\" id=\"".$dataId."\""); ?> value=""/>
						<input type="text" <?php echo("name=\"".$inputPrioridade."\" id=\"".$inputPrioridade."\""); ?> class="form-control" value="" required>
					</div>
					<div class="form-group">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
						<input <?php echo(" name=\"".$btnUpdatePrioridade."\""); ?> type="submit" class="btn btn-primary" value="Salvar"/>
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
	    $("#update-prioridade #idPrioridade").val(id);
	    $("#update-prioridade #inputPrioridade").val(nome);
	});
    $("#update-prioridade").on('shown.bs.modal', function(){
        $(this).find('#inputPrioridade').focus();
    });
</script>