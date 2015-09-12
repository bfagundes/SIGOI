<?php

// variaveis
$modalUpdateResPadrao = "update-respadrao";
$inputTituloNome = "Titulo";
$inputTitulo = "inputResPadraoTitulo";
$inputTextoNome = "Texto";
$inputTexto = "inputResPadraoTexto";
$dataId = "idResPadrao";
$btnUpdateResPadrao = "btnUpdateRespadrao";
$btnDeleteResPadrao = "btnDeleteResPadrao";
$sqlTabResPadrao = "respostaPadrao";

// altera respostas padrao no banco
if(isset($_POST[$btnUpdateResPadrao])){
	$result = db_query("UPDATE ".$sqlTabResPadrao.
		" SET titulo = ".db_quote($_POST[$inputTitulo]).
		", texto = ".db_quote($_POST[$inputTexto]).
		" WHERE id = ".db_quote($_POST[$dataId]));
	if($result === false) {
		$error = pg_result_error($result);
	}
	header('Location: parametros.php');
}

// deleta respostas padrao do banco
if(isset($_POST[$btnDeleteResPadrao])){
	$result = db_query("DELETE from ".$sqlTabResPadrao." WHERE id = ".db_quote($_POST[$dataId]));
	if($result === false) {
		$error = pg_result_error($result);
	}
	header('Location: parametros.php');
}

?>

<table class="table table-condensed table-hover">
	<thead>
		<tr>
			<th width="3%"></th>
			<th class="col-sm-3">Título</th>
			<th class="col-sm-8">Texto</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		for ($i = 0; $i < count($respostasPadrao); $i++) {
			echo "<tr data-toggle=\"modal\" data-id=\"".$respostasPadrao[$i]['id']."\" data-target=\"#".$modalUpdateResPadrao."\" data-tit=\"".$respostasPadrao[$i]['titulo']."\" data-txt=\"".$respostasPadrao[$i]['texto']."\">";
			echo "<td></td>";
			echo "<td>".$respostasPadrao[$i]['titulo']."</td>";
			echo "<td>".$respostasPadrao[$i]['texto']."</td>";
			echo "</tr>";
		} ?>
	</tbody>
</table>

<!-- Modal -->
<div class="modal fade" <?php echo(" id=\"".$modalUpdateResPadrao."\""); ?> tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><?php echo $pageTitle; ?></h4>
			</div>
			<div class="modal-body">
				<form role="form" method="post" <?php echo(" action=\"".$pageUrl."\""); ?>>
					<div class="form-group">
						<label for="funcao-heading"><?php echo $inputTituloNome; ?></label>
						<input type="hidden" <?php echo(" name=\"".$dataId."\" id=\"".$dataId."\""); ?> value=""/>
						<input type="text" <?php echo("name=\"".$inputTitulo."\" id=\"".$inputTitulo."\""); ?> class="form-control" value="" required>
					</div>
					<div class="form-group">
						<label for="funcao-heading"><?php echo $inputTextoNome; ?></label>
						<input type="hidden" <?php echo(" name=\"".$dataId."\" id=\"".$dataId."\""); ?> value=""/>
						<input type="text" <?php echo("name=\"".$inputTexto."\" id=\"".$inputTexto."\""); ?> class="form-control" value="" required>
					</div>
					<div class="form-group">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
						<input <?php echo(" name=\"".$btnUpdateResPadrao."\""); ?> type="submit" class="btn btn-primary" value="Salvar"/>
						<input <?php echo(" name=\"".$btnDeleteResPadrao."\""); ?> type="submit" class="btn btn-danger" value="Delete" onclick="return confirm('Você tem certeza?');"/>
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
	    var titulo = $(this).closest('tr').data('tit');
	    var texto = $(this).closest('tr').data('txt');
	    // mandando isso pra dentro do modal
	    $("#update-respadrao #idResPadrao").val(id);
	    $("#update-respadrao #inputResPadraoTitulo").val(titulo);
	    $("#update-respadrao #inputResPadraoTexto").val(texto);
	});
    $("#update-respadrao").on('shown.bs.modal', function(){
        $(this).find('#inputResPadraoTitulo').focus();
    });
</script>