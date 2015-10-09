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
$pageUrl = "info_chamado.php";
$inputTipo = "inputTipo";
$inputSituacao = "inputSituacao";
$inputPrioridade = "inputPrioridade";
$inputSolicitante = "inputSolicitante";
$inputSetor = "inputSetor";
$inputLocal = "inputLocal";
$inputDataAbertura = "inputDataAbertura";
$inputDataFechamento = "inputDataFechamento";
$inputTecnico = "inputTecnico";
$inputAssunto = "inputAssunto";
$inputDescricao = "inputDescricao";
$inputFollowUp = "inputFollowUp";
$inputNroFo = "inputNroFo";
$dataId = $_GET['id'];
$missedReqField = false;

// altera chamados no banco
if(isset($_POST[$btnUpdate])){
	if(empty($_POST[$inputNroFo])){ $missedReqField = true; }

	// buscando o ID do setor selecionado
	$setorSelected = $_POST[$inputSetor];
	$setorSelected = db_select("SELECT id from ".$sqlTabSetor." WHERE nome =".db_quote($setorSelected));
	if($setorSelected == null){ $missedReqField = true;
	}else{ $setorSelected = $setorSelected[0]['id']; }
	
	// buscando o ID do local selecionada
	$localSelected = $_POST[$inputLocal];
	$localSelected = db_select("SELECT id from ".$sqlTabLocal." WHERE nome =".db_quote($localSelected));
	if($localSelected == null){ $missedReqField = true;
	}else{ $localSelected = $localSelected[0]['id']; }

	// buscando o ID do solicitante selecionado
	$solicitanteSelected = $_POST[$inputSolicitante];
	$solicitanteSelected = db_select("SELECT id from ".$sqlTabUsuario." WHERE nome = ".db_quote($solicitanteSelected));
	if($solicitanteSelected == null){ $missedReqField = true;
	}else{ $solicitanteSelected = $solicitanteSelected[0]['id']; }

	// buscando o ID do tecnico solicitado
	$tecnicoSelected = $_POST[$inputTecnico];
	$tecnicoSelected = db_select("SELECT id from ".$sqlTabUsuario." WHERE nome = ".db_quote($tecnicoSelected));
	if($tecnicoSelected == null){ $missedReqField = true;
	}else{ $tecnicoSelected = $tecnicoSelected[0]['id']; }

	// buscando o ID do tipo solicitado
	$tipoSelected = $_POST[$inputTipo];
	$tipoSelected = db_select("SELECT id from ".$sqlTabTipo." WHERE nome = ".db_quote($tipoSelected));
	if($tipoSelected == null){ $missedReqField = true;
	}else{ $tipoSelected = $tipoSelected[0]['id']; }

	// buscando o ID da prioridade solicitado
	$prioridadeSelected = $_POST[$inputPrioridade];
	$prioridadeSelected = db_select("SELECT id from ".$sqlTabPrioridade." WHERE nome = ".db_quote($prioridadeSelected));
	if($prioridadeSelected == null){ $missedReqField = true;
	}else{ $prioridadeSelected = $prioridadeSelected[0]['id']; }

	$situacaoSelected = $_POST[$inputSituacao];
	$situacaoSelected = db_select("SELECT id from ".$sqlTabSituacao." WHERE nome = ".db_quote($situacaoSelected));
	if($situacaoSelected == null){ $missedReqField = true;
	}else{ $situacaoSelected = $situacaoSelected[0]['id']; }

	if(empty($_POST[$inputAssunto])){ $missedReqField = true; }
	if(empty($_POST[$inputDescricao])){ $missedReqField = true; }

	if(empty($_POST[$inputDataAbertura])){ $missedReqField = true; }
	if(empty($_POST[$inputDataFechamento])){ $dataFechamento = "null"; }else{ $dataFechamento = db_quote($_POST[$inputDataFechamento]); }

	// executa a query	
	if($missedReqField === false){
		$result = db_query("UPDATE ".$sqlTabChamado." SET".
			"  nrofo=".db_quote($_POST[$inputNroFo]).
			", idSolicitante=".$solicitanteSelected.
			", idSetor=".$setorSelected.
			", idLocal=".$localSelected.
			", dataAbertura=".db_quote($_POST[$inputDataAbertura]).
			", dataFechamento=" .$dataFechamento.
			", idTecnico=".$tecnicoSelected.
			", idTipo=".$tipoSelected.
			", idPrioridade=".$prioridadeSelected.
			", idSituacao=".$situacaoSelected.
			", assunto=".db_quote($_POST[$inputAssunto]).
			", descricao=".db_quote($_POST[$inputDescricao]).
			" WHERE id=".$dataId);
		if($result === false) {
			$error = pg_result_error($result);
		}
		header('Location: info_chamado.php?id='.$dataId);
		die();
	}
}

// insere chamados no banco
if(isset($_POST[$btnInsert])){
	if(empty($_POST[$inputNroFo])){ $missedReqField = true; }
	// buscando o ID do setor selecionado
	$setorSelected = $_POST[$inputSetor];
	$setorSelected = db_select("SELECT id from ".$sqlTabSetor." WHERE nome =".db_quote($setorSelected));
	if($setorSelected == null){ $missedReqField = true;
	}else{ $setorSelected = $setorSelected[0]['id']; }
	
	// buscando o ID do local selecionada
	$localSelected = $_POST[$inputLocal];
	$localSelected = db_select("SELECT id from ".$sqlTabLocal." WHERE nome =".db_quote($localSelected));
	if($localSelected == null){ $missedReqField = true;
	}else{ $localSelected = $localSelected[0]['id']; }

	// buscando o ID do solicitante selecionado
	$solicitanteSelected = $_POST[$inputSolicitante];
	$solicitanteSelected = db_select("SELECT id from ".$sqlTabUsuario." WHERE nome = ".db_quote($solicitanteSelected));
	if($solicitanteSelected == null){ $missedReqField = true;
	}else{ $solicitanteSelected = $solicitanteSelected[0]['id']; }

	// buscando o ID do tecnico solicitado
	$tecnicoSelected = $_POST[$inputTecnico];
	$tecnicoSelected = db_select("SELECT id from ".$sqlTabUsuario." WHERE nome = ".db_quote($tecnicoSelected));
	if($tecnicoSelected == null){ $missedReqField = true;
	}else{ $tecnicoSelected = $tecnicoSelected[0]['id']; }

	// buscando o ID do tipo solicitado
	$tipoSelected = $_POST[$inputTipo];
	$tipoSelected = db_select("SELECT id from ".$sqlTabTipo." WHERE nome = ".db_quote($tipoSelected));
	if($tipoSelected == null){ $missedReqField = true;
	}else{ $tipoSelected = $tipoSelected[0]['id']; }

	// buscando o ID da prioridade solicitado
	$prioridadeSelected = $_POST[$inputPrioridade];
	$prioridadeSelected = db_select("SELECT id from ".$sqlTabPrioridade." WHERE nome = ".db_quote($prioridadeSelected));
	if($prioridadeSelected == null){ $missedReqField = true;
	}else{ $prioridadeSelected = $prioridadeSelected[0]['id']; }

	$situacaoSelected = $_POST[$inputSituacao];
	$situacaoSelected = db_select("SELECT id from ".$sqlTabSituacao." WHERE nome = ".db_quote($situacaoSelected));
	if($situacaoSelected == null){ $missedReqField = true;
	}else{ $situacaoSelected = $situacaoSelected[0]['id']; }

	if(empty($_POST[$inputAssunto])){ $missedReqField = true; }
	if(empty($_POST[$inputDescricao])){ $missedReqField = true; }

	if(empty($_POST[$inputDataAbertura])){ $missedReqField = true; }
	if(empty($_POST[$inputDataFechamento])){ $dataFechamento = "null"; }else{ $dataFechamento = db_quote($_POST[$inputDataFechamento]); }

	// executa a query	
	if($missedReqField === false){
		$result = db_query("INSERT INTO ".$sqlTabChamado.
			" (nrofo, idSolicitante, idSetor, idLocal, dataAbertura, dataFechamento, idTecnico, idTipo, idPrioridade, idSituacao, assunto, descricao) VALUES".
			" (".db_quote($_POST[$inputNroFo]).
			", ".$solicitanteSelected.
			", ".$setorSelected.
			", ".$localSelected.
			", ".db_quote($_POST[$inputDataAbertura]).
			"," .$dataFechamento.
			", ".$tecnicoSelected.
			", ".$tipoSelected.
			", ".$prioridadeSelected.
			", ".$situacaoSelected.
			", ".db_quote($_POST[$inputAssunto]).
			", ".db_quote($_POST[$inputDescricao]).
			")");
		if($result === false) {
			$error = pg_result_error($result);
		}
		header('Location: info_index.php');
		die();
	}
}

if(isset($_POST[$btnFollowUp])){
	if(!empty($_POST[$inputFollowUp])){
		$result = db_query("INSERT INTO ".$sqlTabFollowUp."(idChamado, idUsuario, data, texto, observacoes)".
			"VALUES (".$dataId.", ".$_SESSION['userid'].", ".db_quote(date('d/m/Y H:i')).", ".db_quote($_POST[$inputFollowUp]).", ".db_quote('').")");
	}
}

// evita buscas se estiver no modo incluir_chamado
if($dataId > 0){
	// busca no banco o usuario e seus respectivos setor e funcao
	$chamado = db_select("SELECT ".
		"CHAMADO.id as id, ".
		"CHAMADO.nrofo as nrofo, ".
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

	$followups = db_select("SELECT * FROM ".$sqlTabFollowUp." WHERE idchamado=".$dataId." ".$sqlOrdFollowUp);
	$usuarios = db_select("SELECT id,nome from ".$sqlTabUsuario);
}else{
	$chamado = array(
		"nrofo" => "",
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
$navBackUrl = "info_index.php";
$navOptions = "";
require_once('./includes/header.php');
require_once('./includes/navbar_default.php');

$data_hoje = date("d/m/Y");
?>
	<form role="form" method="post" <?php echo "action=\"".$pageUrl."?id=".$dataId."\""; ?>>
	<div class="container-fluid">
	<div class="row">

		<?php 
		if($missedReqField === true){
			$errorMessage="<strong>Atenção!</strong> Preencha todos os campos obrigatórios"; 
			require('./includes/alert_error.php');
		} ?>

		<div class="col-md-3">
			<div class="panel panel-default">
  				<div class="panel-body">

					<div class="form-group">
						<label for="nome-solicitante">Solicitante*</label>
						<div id="solicitante"><input type="text" class="typeahead form-control" placeholder="Solicitante" <?php echo(" id=\"".$inputSolicitante."\" name=\"".$inputSolicitante."\" value=\"".$chamado['solicitante']."\""); ?>></div>
					</div>

					<div class="form-group">
						<label for="nome-setor">Setor*</label>
						<div id="setor"><input type="text" class="typeahead form-control" placeholder="Setor" <?php echo(" id=\"".$inputSetor."\" name=\"".$inputSetor."\" value=\"".$chamado['setor']."\""); ?>></div>
					</div>

					<div class="form-group">
						<label for="nome-local">Local*</label>
						<div id="local"><input type="text" class="typeahead form-control" placeholder="Local" <?php echo(" id=\"".$inputLocal."\" name=\"".$inputLocal."\" value=\"".$chamado['local']."\""); ?>></div>
					</div>

					<div class="row">
						<div class="col-lg-6">
							<label for="dtp_input1" class="control-label">Data Abertura*</label>
			                <div class="input-group date form_abertura" data-date="01-01-2000T00:00:00Z" data-date-format="dd/mm/yyyy HH:ii" data-link-field="dtp_input1">
			                    <input class="form-control" type="text" <?php echo("id=\"".$inputDataAbertura."\" name=\"".$inputDataAbertura."\""); if(empty($chamado['dataabertura'])){ echo("value=\"\""); } else { echo("value=\"".date('d/m/Y H:00',strtotime($chamado['dataabertura']))."\""); }?> readonly>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								<span class="input-group-addon remove"><span class="glyphicon glyphicon-remove"></span></span>
			                </div>
							<input type="hidden" id="dtp_input1" value="" /><br/>
						</div>
						<div class="col-lg-6">
							<label for="dtp_input1" class="control-label">Data Fechamento</label>
			                <div class="input-group date form_abertura" data-date="01-01-2000T00:00:00Z" data-date-format="dd/mm/yyyy HH:ii" data-link-field="dtp_input1">
			                    <input class="form-control" type="text" <?php echo("id=\"".$inputDataFechamento."\" name=\"".$inputDataFechamento."\""); if(empty($chamado['datafechamento'])){ echo("value=\"\""); } else { echo("value=\"".date('d/m/Y H:00',strtotime($chamado['datafechamento']))."\""); }?> readonly>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								<span class="input-group-addon remove"><span class="glyphicon glyphicon-remove"></span></span>
			                </div>
							<input type="hidden" id="dtp_input1" value="" /><br/>
						</div>
					</div>

					<div class="form-group">
						<label for="nome-solicitante">Técnico Responsável*</label>
						<div id="tecnico"><input type="text" class="typeahead form-control" placeholder="Técnico Responsável" <?php echo(" id=\"".$inputTecnico."\" name=\"".$inputTecnico."\" value=\"".$chamado['tecnico']."\""); ?>></div>
					</div>

					<!-- Dropdowns -->
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
    				<!-- Assunto -->
    				<div class="col-md-1">
	    				<div class="form-group">
							<label for="nro-fo">Nro FO</label>
							<input type="text" class="form-control inputNroFo" placeholder="Nro FO" <?php echo("value=\"".$chamado['nrofo']."\" id=\"".$inputNroFo."\" name=\"".$inputNroFo."\""); ?>>
						</div>
					</div>
					<div class="col-md-11">
						<div class="form-group">
							<label for="nome-solicitante"><?php echo("Assunto"); ?></label>
							<input type="text" class="form-control" placeholder="Assunto" <?php echo("value=\"".$chamado['assunto']."\" id=\"".$inputAssunto."\" name=\"".$inputAssunto."\""); ?>>
						</div>
					</div>

					<!-- Descricao -->
					<label for="comentario">Descrição:</label>
					<div class="form-group">
						<textarea class="form-control custom-control" rows="4" style="resize:none" placeholder="Descrição" <?php echo("id=\"".$inputDescricao."\" name=\"".$inputDescricao."\""); ?>><?php echo($chamado['descricao']); ?></textarea>
					</div>
					<div class="form-group">
						<?php 
						if($dataId == 0){
							echo("<input name=\"".$btnInsert."\" type=\"submit\" class=\"btn btn-primary\" value=\"Adicionar Chamado\"/>");
						}else{
							echo("<input name=\"".$btnUpdate."\" type=\"submit\" class=\"btn btn-primary\" value=\"Alterar Chamado\"/>");
						} ?>
					</div>
  				</div>
  				<div class="panel-footer">
  					<?php if($dataId > 0){ ?>
						<div class="form-group">
							<textarea class="form-control custom-control" rows="4" style="resize:none" placeholder="Follow Up" <?php echo("id=\"".$inputFollowUp."\" name=\"".$inputFollowUp."\""); ?>></textarea>
						</div>
						<div class="form-group">
							<input <?php echo("name=".$btnFollowUp); ?> type="submit" class="btn btn-primary" value="Adicionar Follow Up"/>
						</div>

						<?php
						if($dataId > 0){
							foreach($followups as $followup){
								echo("<h5><strong>".$usuarios[$followup['idusuario']]['nome']."</strong><small> (".date('d/m/Y H:i',strtotime($followup['data'])));
								if(!empty($followup['observacoes'])){
									echo(" | ".$followup['observacoes'].")</small></h5>");
								}else{
									echo(")</small></h5>");
								}
								echo("<p>".$followup['texto']);
							}
						}
					} ?>
  				</div>
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