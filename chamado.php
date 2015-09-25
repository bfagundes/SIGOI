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
$pageTitle = "SIGOI";
$pageUrl = "index.php";
$inputTipo = "inputTipo";
$inputSituacao = "inputSituacao";
$inputPrioridade = "inputPrioridade";
$inputSolicitante = "inputSolicitante";
$inputSetor = "inputSetor";
$inputLocal = "inputLocal";
$inputDataAbertura = "inputDataAbertura";
$inputDataFechamento = "inputDataFechamento";
$inputTecnico = "inputTecnico";

// buscando a lista de tecnicos
$setorId = db_select("SELECT id from ".$sqlTabSetor." WHERE nome = 'Informatica'");
$tecnicos = db_select("SELECT * from ".$sqlTabUsuario." WHERE idSetor = ".$setorId[0]['id']." ".$sqlOrdUsuario);

// buscando a lista de tipos, prioridades e situacoes
$tipos = db_select("SELECT * from ".$sqlTabTipo." ".$sqlOrdTipo);
$prioridades = db_select("SELECT * FROM ".$sqlTabPrioridade." ".$sqlOrdPrioridade);
$situacoes = db_select("SELECT * FROM ".$sqlTabSituacao." ".$sqlOrdSituacao);

// Header
$navBackUrl = "index.php";
$navOptions = "";
require_once('./includes/header.php');
require_once('./includes/navbar_default.php');

$data_hoje = date("d/m/Y");
?>
	<div class="container-fluid">
	<div class="row">
		<div class="col-md-3">
			<div class="panel panel-default">
  				<div class="panel-body">

					<div class="form-group">
						<label for="nome-solicitante">Solicitante:</label>
						<div id="solicitante"><input type="text" class="typeahead form-control" placeholder="Solicitante" <?php echo(" id=\"".$inputSolicitante."\" name=\"".$inputSolicitante."\""); ?>></div>
					</div>

					<div class="form-group">
						<label for="nome-setor">Setor:</label>
						<div id="setor"><input type="text" class="typeahead form-control" placeholder="Setor" <?php echo(" id=\"".$inputSetor."\" name=\"".$inputSetor."\""); ?>></div>
					</div>

					<div class="form-group">
						<label for="nome-local">Local:</label>
						<div id="local"><input type="text" class="typeahead form-control" placeholder="Local" <?php echo(" id=\"".$inputLocal."\" name=\"".$inputLocal."\""); ?>></div>
					</div>

					<div class="row">
						<div class="col-lg-6">
							<label for="dtp_input1" class="control-label">Data Abertura</label>
			                <div class="input-group date form_abertura" data-date="01-01-2000T00:00:00Z" data-date-format="dd/mm/yyyy hh:ii" data-link-field="dtp_input1">
			                    <input class="form-control" size="16" type="text" value="" readonly>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
			                </div>
							<input type="hidden" id="dtp_input1" value="" /><br/>
						</div>
						<div class="col-lg-6">
							<label for="dtp_input1" class="control-label">Data Fechamento</label>
			                <div class="input-group date form_abertura" data-date="01-01-2000T00:00:00Z" data-date-format="dd/mm/yyyy hh:ii" data-link-field="dtp_input1">
			                    <input class="form-control" size="16" type="text" value="" readonly>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
			                </div>
							<input type="hidden" id="dtp_input1" value="" /><br/>
						</div>
					</div>

					<div class="form-group">
						<label for="nome-solicitante">Técnico Responsável:</label>
						<div id="tecnico"><input type="text" class="typeahead form-control" placeholder="Técnico Responsável" <?php echo(" id=\"".$inputTecnico."\" name=\"".$inputTecnico."\""); ?>></div>
					</div>

					<!-- ----- Dropdowns ------ -->
					<div class="btn-group btn-group-justified" role="group">
						<div class="btn-group" role="group">
							<div class="form-group">
								<select <?php echo(" id=\"".$inputTipo."\" name=\"".$inputTipo."\""); ?> class="selectpicker" data-width="100%">
									<?php 
									foreach($tipos as $tipo){
										echo "<option>".$tipo['nome']."</option>";
									} ?>
								</select> 
							</div>
						</div>
						<div class="btn-group" role="group">
							<div class="form-group">
								<select <?php echo(" id=\"".$inputPrioridade."\" name=\"".$inputPrioridade."\""); ?> class="selectpicker" data-width="100%">
									<?php 
									foreach($prioridades as $prioridade){
										echo "<option>".$prioridade['nome']."</option>";
									} ?>
								</select> 
							</div>
						</div>
						<div class="btn-group" role="group">
							<div class="form-group">
								<select <?php echo(" id=\"".$inputSituacao."\" name=\"".$inputSituacao."\""); ?> class="selectpicker" data-width="100%">
									<?php 
									foreach($situacoes as $situacao){
										echo "<option>".$situacao['nome']."</option>";
									} ?>
								</select> 
							</div>
						</div>
					</div> <!-- dropdonws group -->
  				</div> <!-- panel-body -->
			</div> <!-- panel -->
		</div> <!-- col-md-3 -->

		<div class="col-md-9">
			<div class="panel panel-default">
  				<div class="panel-body">
    				<h4><small>#00000 </small>Novo Chamado</h4>

    				<!-- Assunto -->
    				<div class="form-group">
						<label for="nome-solicitante">Assunto:</label>
						<input type="text" class="form-control" placeholder="Assunto do Chamado" id="assunto-chamado">
					</div>

					<!-- Descricao -->
					<label for="comentario">Descrição:</label>
					<div class="input-group">
						<textarea class="form-control custom-control" rows="3" style="resize:none"></textarea><span class="input-group-addon btn btn-primary">Enviar</span>
					</div>
  				</div>
  				<div class="panel-footer"></div>
			</div> <!-- panel-default -->
		</div> <!-- col-md-9 -->
	</div> <!-- Entire Row -->
	</div> <!-- Container Fluid -->

	<!-- Footer -->
	<?php require_once('./includes/footer.php'); ?>

	<script type="text/javascript">
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
	        minView: 1,
			forceParse: 0,
	        showMeridian: 1
	    });

	    $('.form_abertura').datetimepicker({
	        format: "dd/mm/yyyy hh:ii",
	        startDate: dp_now,
	        language:  'pt-BR',
	        weekStart: 1,
	        todayBtn:  1,
			autoclose: 1,
			todayHighlight: 1,
			startView: 2,
	        minView: 1,
			forceParse: 0,
	        showMeridian: 1
	    });

		$('.selectpicker').selectpicker();
		$("#inputPrioridade").selectpicker('val', 'Média' );

		// Autocomplete do inputSolicitante
		var solicitantes = new Bloodhound({
			datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			prefetch: '../data/films/post_1960.json',
			remote: {
				url: 'functions/typeahead.php?solicitante=%QUERY',
				wildcard: '%QUERY'
			}
		});
		$('#solicitante .typeahead').typeahead(null, {
			name: 'nome',
			display: 'nome',
			source: solicitantes
		});

		// Autocomplete do inputSetor
		var setores = new Bloodhound({
			datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			prefetch: '../data/films/post_1960.json',
			remote: {
				url: 'functions/typeahead.php?setor=%QUERY',
				wildcard: '%QUERY'
			}
		});
		$('#setor .typeahead').typeahead(null, {
			name: 'nome',
			display: 'nome',
			source: setores
		});

		// Autocomplete do inputLocal
		var locais = new Bloodhound({
			datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			prefetch: '../data/films/post_1960.json',
			remote: {
				url: 'functions/typeahead.php?local=%QUERY',
				wildcard: '%QUERY'
			}
		});
		$('#local .typeahead').typeahead(null, {
			name: 'nome',
			display: 'nome',
			source: locais
		});

		// Autocomplete do inputTecnico
		var tecnicos = new Bloodhound({
			datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			prefetch: '../data/films/post_1960.json',
			remote: {
				url: 'functions/typeahead.php?tecnico=%QUERY',
				wildcard: '%QUERY'
			}
		});
		$('#tecnico .typeahead').typeahead(null, {
			name: 'nome',
			display: 'nome',
			source: tecnicos
		});
		
	</script>

</body>
</html>