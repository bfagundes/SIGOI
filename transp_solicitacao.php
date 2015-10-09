<?php
include("./functions/conexao_sginfra.php");
include("./functions/sessao.php");
include("./functions/defaults.php");
session_start();

// Testa se o usuario está logado
if(!session_isValid()){
	header('Location: login.php');
	die();
}

// variaveis
$pageTitle = "Solicitação de Transporte - Área Administrativa";
$pageUrl = "transp_solicitacao_adm.php";

// Header
$navBackUrl = "transp.php";
$navOptions = "";
require_once('./includes/header.php');
require_once('./includes/navbar_default.php');
?>
	<form role="form" method="post" <?php echo "action=\"".$pageUrl."\""; ?>>
		<div class="container-fluid">
			<div class="row">

				<?php 
				//if(missedReqField()){
					//$errorMessage="<strong>Atenção!</strong> Preencha todos os campos obrigatórios"; 
					//require('./includes/alert_error.php');
				//} 
				//if(isset($_POST[$inputLogin])){
					//if(db_exists($sqlTabUsuario, 'login', $_POST[$inputLogin])){
						//$errorMessage="<strong>Atenção!</strong> Login já cadastrado!"; 
						//require('./includes/alert_error.php');
					//}
				//}
				?>

				<div class="col-md-3">
					<div class="panel panel-default">
						<div class="panel-body">

							<label>Número da Solicitação: 12345</label>

							<div class="form-group">
								<label for="nome-local">Unidade*</label>
								<div id="local"><input type="text" class="typeahead form-control" placeholder="Unidade" id="inputUnidade" name="inputUnidade" value=""></div>
							</div>

							<div class="form-group">
								<label for="nome-solicitante">Solicitante*</label>
								<div id="solicitante"><input type="text" class="typeahead form-control" placeholder="Solicitante" id="inputSolicitante" name="inputSolicitante" value=""></div>
							</div>

							<div class="form-group">
								<label for="nome-setor">Setor*</label>
								<div id="setor"><input type="text" class="typeahead form-control" placeholder="Setor" id="inputSetor" name="inputSetor" value=""></div>
							</div>

							<div class="row">
								<div class="col-lg-6">
									<label for="dtp_input1" class="control-label">Data Abertura*</label>
									<div class="input-group date form_abertura" data-date="01-01-2000T00:00:00Z" data-date-format="dd/mm/yyyy HH:ii" data-link-field="dtp_input1">
										<input class="form-control" type="text" id="inputDataAbertura" name="inputDataAbertura" <?php echo("value=\"".date('d/m/Y H:00')."\""); ?>>
										<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
										<span class="input-group-addon remove"><span class="glyphicon glyphicon-remove"></span></span>
									</div>
									<input type="hidden" id="dtp_input1" value="" /><br/>
								</div>
								<div class="col-lg-6">
									<label for="dtp_input1" class="control-label">Data Transporte*</label>
									<div class="input-group date form_abertura" data-date="01-01-2000T00:00:00Z" data-date-format="dd/mm/yyyy HH:ii" data-link-field="dtp_input1">
										<input class="form-control" type="text" id="inputDataFechamento" name="inputDataFechamento" <?php if(empty($chamado['datafechamento'])){ echo("value=\"\""); } else { echo("value=\"".date('d/m/Y H:00',strtotime($chamado['datafechamento']))."\""); }?>>
										<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
										<span class="input-group-addon remove"><span class="glyphicon glyphicon-remove"></span></span>
									</div>
									<input type="hidden" id="dtp_input1" value="" /><br/>
								</div>
							</div>

							<div class="row">
								<!-- <div class="col-lg-6">
									<div class="checkbox" style="padding-top: 20px">
										<label><input type="checkbox" name="ckAtivo">Necessita Retorno?</label>
									</div>
								</div> -->
								<div class="col-lg-6">
									<label for="dtp_input1" class="control-label">Data Retorno (se houver)</label>
									<div class="input-group date form_abertura" data-date="01-01-2000T00:00:00Z" data-date-format="dd/mm/yyyy HH:ii" data-link-field="dtp_input1">
										<input class="form-control" type="text" id="inputDataRetorno" name="inputDataRetorno" <?php if(empty($chamado['datafechamento'])){ echo("value=\"\""); } else { echo("value=\"".date('d/m/Y H:00',strtotime($chamado['datafechamento']))."\""); }?>>
										<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
										<span class="input-group-addon remove"><span class="glyphicon glyphicon-remove"></span></span>
									</div>
									<input type="hidden" id="dtp_input1" value="" /><br/>
								</div>
							</div>
						</div> <!-- panel-body -->
					</div> <!-- panel -->
				</div> <!-- col-md-3 -->

				<div class="col-md-9">
					<div class="panel panel-default">
						<div class="panel-body">
							<!-- Assunto -->
							<div class="col-md-1">
								<div class="form-group">
									<label for="nro-fo">Nº Pessoas</label>
									<input type="text" class="form-control inputNroFo" placeholder="Pessoas" id="inputFuncionario" name="inputFuncionario" value="">
								</div>
							</div>
							<div class="col-md-11">
								<div class="form-group">
									<label for="nome-solicitante">Destino</label>
									<input type="text" class="form-control" placeholder="Destino" id="inputDestino" name="inputDestino" value="">
								</div>
							</div>

							<!-- Descricao -->
							<label for="comentario">Justificativa:</label>
							<div class="form-group">
								<textarea class="form-control custom-control" rows="4" style="resize:none" placeholder="Justificativa" id="inputJustificativa" name="inputJustificativa"><?php //echo($chamado['descricao']); ?></textarea>
							</div>
							<label for="comentario">Observações:</label>
							<div class="form-group">
								<textarea class="form-control custom-control" rows="4" style="resize:none" placeholder="Observações" id="inputObservacoes" name="inputObservacoes"><?php //echo($chamado['descricao']); ?></textarea>
							</div>
							<div class="form-group">
								<input name="btnInsert" type="submit" class="btn btn-primary" value="Incluir Solicitação"/>
								<?php 
								//if($dataId == 0){
								// 	echo("<input name=\"".$btnInsert."\" type=\"submit\" class=\"btn btn-primary\" value=\"Adicionar Chamado\"/>");
								// }else{
								// 	echo("<input name=\"".$btnUpdate."\" type=\"submit\" class=\"btn btn-primary\" value=\"Alterar Chamado\"/>");
								// } ?>
							</div>
						</div>
						<div class="panel-footer">
						</div>
					</div> <!-- panel-default -->
				</div> <!-- col-md-9 -->
			</div>
		</div>
	</form>

	<!-- Footer -->
	<?php require_once('./includes/footer.php'); ?>

	<script type="text/javascript">
	    // altera o estilo do selectpicker
		$('.selectpicker').selectpicker();

		// datetimepickers
		var dp_now = new Date();
	    dp_now.setHours(0,0,0,0);
	    $('.form_abertura').datetimepicker({
	        format: "dd/mm/yyyy hh:ii",
	        startDate: dp_now,
	        language:  'pt-BR',
	        weekStart: 1,
	        todayBtn:  1,
			autoclose: 1,
			todayHighlight: 1,
			startView: 2,
	        minView: 0,
			forceParse: 0,
	        showMeridian: 1,
	        minuteStep: 15,
	    });

	  //   $('.form_abertura').datetimepicker({
	  //       format: "dd/mm/yyyy hh:ii",
	  //       startDate: dp_now,
	  //       language:  'pt-BR',
	  //       weekStart: 1,
	  //       todayBtn:  1,
			// autoclose: 1,
			// todayHighlight: 1,
			// startView: 2,
	  //       minView: 0,
			// forceParse: 0,
	  //       showMeridian: 1,
	  //       minuteStep: 15,
	  //   });
	</script>

</body>
</html>