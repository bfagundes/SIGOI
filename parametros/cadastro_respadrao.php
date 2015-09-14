<?php

// variaveis
$modalUpdateResPadrao = "update-respadrao";
$modalInsertResPadrao = "insert-respadrao";
$inputTituloNome = "Titulo";
$inputTitulo = "inputResPadraoTitulo";
$inputTextoNome = "Texto";
$inputTexto = "inputResPadraoTexto";
$dataId = "idResPadrao";
$btnInsertResPadrao = "btnInsertRespadrao";
$btnUpdateResPadrao = "btnUpdateRespadrao";
$btnDeleteResPadrao = "btnDeleteResPadrao";
$sqlTabResPadrao = "respostaPadrao";
$duplicate = false;

// altera respostas padrao no banco
if(isset($_POST[$btnUpdateResPadrao])){
	$result = db_query("UPDATE ".$sqlTabResPadrao.
		" SET titulo = ".db_quote($_POST[$inputTitulo]).
		", texto = ".db_quote($_POST[$inputTexto]).
		" WHERE id = ".db_quote($_POST[$dataId]));
	if($result === false) {
		$error = pg_result_error($result);
	}
	header('Location: parametros.php?tab=4');
}

// deleta respostas padrao do banco
if(isset($_POST[$btnDeleteResPadrao])){
	$result = db_query("DELETE from ".$sqlTabResPadrao." WHERE id = ".db_quote($_POST[$dataId]));
	if($result === false) {
		$error = pg_result_error($result);
	}
	header('Location: parametros.php?tab=4');
}

// insere respostas no banco
if(isset($_POST[$btnInsertResPadrao])){
	// testa se já não existe uma entrada duplicada (case insensitive)
	$duplicate = false;
	for ($i = 0; $i < count($respostasPadrao); $i++) {
		if(strcasecmp($respostasPadrao[$i]['titulo'], $_POST[$inputTitulo]) == 0){
			$duplicate = true;
		}
	}

	// executa a inclusao
	if($duplicate === false){
		$result = db_query("INSERT INTO ".$sqlTabResPadrao." (titulo, texto) VALUES (".db_quote($_POST[$inputTitulo]).", ".db_quote($_POST[$inputTexto]).")");
		if($result === false) {
			$error = pg_result_error($result);
		}
		// atualiza a lista de funcoes
		$respostasPadrao = db_select("SELECT * FROM ".$sqlTabResPadrao." ".$sqlOrderResPadrao);
		header('Location: parametros.php?tab=4');
	}
}

?>

<?php
// Mensagem de erro ao cadastrar uma resposta padrao duplicada
if($duplicate === true){
	$errorMessage="<strong>Atenção!</strong> Essa resposta padrão já existe no cadastro.";
	echo "<br>";
	require('./includes/alert_error.php');
}?>

<table class="table table-condensed table-hover">
	<thead>
		<tr>
			<th width="4.5%"><div style="text-align: center;"><input <?php echo(" name=\"".$btnInsertResPadrao."\""); ?> data-toggle="modal" <?php echo ("data-target=\"#".$modalInsertResPadrao."\""); ?> class="btn btn-warning btn-add-small" value="+"/></div></th>
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

<!-- Modal-Update -->
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

<!-- Modal-Insert -->
<div class="modal fade" <?php echo(" id=\"".$modalInsertResPadrao."\""); ?> tabindex="-1" role="dialog">
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
						<input <?php echo(" name=\"".$btnInsertResPadrao."\""); ?> type="submit" class="btn btn-primary" value="Salvar"/>
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
    $("#insert-respadrao").on('shown.bs.modal', function(){
        $(this).find('#inputResPadraoTitulo').focus();
    });
</script>