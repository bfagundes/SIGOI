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
$pageUrl = "chamado.php";
$inputTipo = "inputTipo";
$inputSituacao = "inputSituacao";
$inputPrioridade = "inputPrioridade";
$inputSolicitante = "inputSolicitante";
$inputSetor = "inputSetor";
$inputLocal = "inputLocal";
$inputDataAbertura = "inputDataAbertura";
$inputDataFechamento = "inputDataFechamento";
$inputTecnico = "inputTecnico";
$dataId = $_GET['id'];

// altera chamados no banco
// insere chamados no banco

// evita buscas se estiver no modo incluir_chamado
if($dataId > 0){
	// busca no banco o usuario e seus respectivos setor e funcao
	$chamado = db_select("SELECT ".
		"CHAMADO.id as id, ".
		"USUARIO.nome as solicitante, ".
    	"SETOR.nome as setor, ".
   		"LOCAL.nome as local, ".
    	"CHAMADO.dataabertura as dataabertura, ".
    	"CHAMADO.datafechamento as datafechamento, ".
    	"USUARIO.nome as tecnico, ".
    	"TIPO.nome as tipo, ".
    	"PRIORIDADE.nome as prioridade, ".
    	"SITUACAO.nome as situacao, ".
    	"CHAMADO.assunto as assunto, ".
    	"CHAMADO.descricao as descricao, ".
    	"CHAMADO.idsituacao as idsituacao, ".
    	"CHAMADO.idprioridade as idprioridade, ".
    	"CHAMADO.idtipo as idtipo ".
    	"FROM chamado ".
 		"INNER JOIN usuario on (chamado.idsolicitante = usuario.id) ".
 		"INNER JOIN setor on (chamado.idsetor = setor.id) ".
 		"INNER JOIN local on (chamado.idlocal = local.id) ".
 		"INNER JOIN tipo on (chamado.idtipo = tipo.id) ".
 		"INNER JOIN prioridade on (chamado.idprioridade = prioridade.id) ".
 		"INNER JOIN situacao on (chamado.idsituacao = situacao.id) ".
 		"WHERE CHAMADO.id = ".$dataId);
		$chamado = $chamado[0];
}else{
	$chamado = array(
		"solicitante" => "",
		"setor" => "",
		"local" => "",
		"dataabertura" => "",
		"datafechamento" => "",
		"tecnico" => "",
		"tipo" => "Incidente",
		"prioridade" => "Média",
		"situacao" => "Aberto",
		"assunto" => "",
		"descricao" => ""
	);
}

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
	<form role="form" method="post" <?php echo "action=\"".$pageUrl."?id=".$dataId."\""; ?>>
	<div class="container-fluid">
	<div class="row">
		<div class="col-md-3">
			<div class="panel panel-default">
  				<div class="panel-body">

					<div class="form-group">
						<label for="nome-solicitante">Solicitante:</label>
						<div id="solicitante"><input type="text" class="typeahead form-control" placeholder="Solicitante" <?php echo(" id=\"".$inputSolicitante."\" name=\"".$inputSolicitante."\" value=\"".$chamado['solicitante']."\""); ?>></div>
					</div>

					<div class="form-group">
						<label for="nome-setor">Setor:</label>
						<div id="setor"><input type="text" class="typeahead form-control" placeholder="Setor" <?php echo(" id=\"".$inputSetor."\" name=\"".$inputSetor."\" value=\"".$chamado['setor']."\""); ?>></div>
					</div>

					<div class="form-group">
						<label for="nome-local">Local:</label>
						<div id="local"><input type="text" class="typeahead form-control" placeholder="Local" <?php echo(" id=\"".$inputLocal."\" name=\"".$inputLocal."\" value=\"".$chamado['local']."\""); ?>></div>
					</div>

					<div class="row">
						<div class="col-lg-6">
							<label for="dtp_input1" class="control-label">Data Abertura</label>
			                <div class="input-group date form_abertura" data-date="01-01-2000T00:00:00Z" data-date-format="dd/mm/yyyy hh:ii" data-link-field="dtp_input1">
			                    <input class="form-control" size="16" type="text" <?php if(empty($chamado['dataabertura'])){ echo("value=\"\""); } else { echo("value=\"".date('d/m/Y h:i',strtotime($chamado['dataabertura']))."\""); }?> readonly>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
			                </div>
							<input type="hidden" id="dtp_input1" value="" /><br/>
						</div>
						<div class="col-lg-6">
							<label for="dtp_input1" class="control-label">Data Fechamento</label>
			                <div class="input-group date form_abertura" data-date="01-01-2000T00:00:00Z" data-date-format="dd/mm/yyyy hh:ii" data-link-field="dtp_input1">
			                    <input class="form-control" size="16" type="text" <?php if(empty($chamado['datafechamento'])){ echo("value=\"\""); } else { echo("value=\"".date('d/m/Y h:i',strtotime($chamado['datafechamento']))."\""); }?> readonly>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
			                </div>
							<input type="hidden" id="dtp_input1" value="" /><br/>
						</div>
					</div>

					<div class="form-group">
						<label for="nome-solicitante">Técnico Responsável:</label>
						<div id="tecnico"><input type="text" class="typeahead form-control" placeholder="Técnico Responsável" <?php echo(" id=\"".$inputTecnico."\" name=\"".$inputTecnico."\" value=\"".$chamado['tecnico']."\""); ?>></div>
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
    				<!-- <h4><small><?php printf("#%05d", $dataId); ?> </small><?php echo($chamado['assunto']); ?></h4> -->

    				<!-- Assunto -->
    				<div class="form-group">
						<label for="nome-solicitante"><?php printf("Chamado #%05d", $dataId); ?></label>
						<input type="text" class="form-control" placeholder="Assunto" id="assunto-chamado" placeholder="Assunto" <?php echo("value=\"".$chamado['assunto']."\""); ?>>
					</div>

					<!-- Descricao -->
					<label for="comentario">Descrição:</label>
					<div class="form-group">
						<textarea class="form-control custom-control" rows="4" style="resize:none" placeholder="Descrição"><?php echo($chamado['descricao']); ?></textarea>
					</div>
					<div class="form-group">
						<input <?php echo(" name=\"".$btnUpdate."\""); ?> type="submit" class="btn btn-primary" value="Botao 1"/>
						<input <?php echo(" name=\"".$btnDelete."\""); ?> type="submit" class="btn btn-danger" value="Botao 2" onclick="return confirm('Você tem certeza?');"/>
					</div>
  				</div>
  				<div class="panel-footer"></div>
			</div> <!-- panel-default -->
		</div> <!-- col-md-9 -->
	</div> <!-- Entire Row -->
	</div> <!-- Container Fluid -->
	</form>

	<!-- Footer -->
	<?php require_once('./includes/footer.php'); ?>

	<script type="text/javascript">
		// selecionando valores nos dropdowns
		$('.selectpicker').selectpicker();
		$("#inputTipo").selectpicker('val', <?php echo '\''.$chamado['tipo'].'\''; ?> );
		$("#inputPrioridade").selectpicker('val', <?php echo '\''.$chamado['prioridade'].'\''; ?> );
		$("#inputSituacao").selectpicker('val', <?php echo '\''.$chamado['situacao'].'\''; ?> );

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