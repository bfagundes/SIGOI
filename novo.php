<?php
include ("./functions/conexao.php");
include ("./functions/sessao.php");
session_start();

// Testa se o usuario está logado
if(session_isValid() === false){
	header('Location: login.php');
	die();
}

// variaveis
$pageTitle = "SIGOI";
$pageUrl = "index.php";
$sqlTabSetor = "setor";
$sqlTabUsuario = "usuario";
$sqlOrderUsuario = "ORDER BY LOWER(nome)";
$sqlTabTipo = "tipo";
$sqlOrderTipo = "ORDER BY LOWER(nome)";
$sqlTabPrioridade = "prioridade";
$sqlOrderPrioridade = "ORDER BY id";
$sqlTabSituacao = "situacao";
$sqlOrderSituacao = "ORDER BY LOWER(nome)";
$inputTipo = "inputTipo";
$inputSituacao = "inputSituacao";
$inputPrioridade = "inputPrioridade";
$inputSolicitante = "inputSolicitante";
$inputSetor = "inputSetor";
$inputLocal = "inputLocal";
$inputDataAbertura = "inputDataAbertura";
$inputDataFechamento = "inputDataFechamento";

// buscando a lista de tecnicos
$setorId = db_select("SELECT id from ".$sqlTabSetor." WHERE nome = 'Informatica'");
$tecnicos = db_select("SELECT * from ".$sqlTabUsuario." WHERE idSetor = ".$setorId[0]['id']." ".$sqlOrderUsuario);

// buscando a lista de tipos, prioridades e situacoes
$tipos = db_select("SELECT * from ".$sqlTabTipo." ".$sqlOrderTipo);
$prioridades = db_select("SELECT * FROM ".$sqlTabPrioridade." ".$sqlOrderPrioridade);
$situacoes = db_select("SELECT * FROM ".$sqlTabSituacao." ".$sqlOrderSituacao);

// Header
$navBackUrl = "index.php";
$navOptions = "";
require_once('./includes/header.php');
require_once('./includes/navbar_default.php');

$data_hoje = date("d/m/y");
?>
	<div class="container-fluid">
	<div class="row">
		<div class="col-md-3">
			<div class="panel panel-default">
  				<div class="panel-body">

					<div class="form-group">
						<label for="nome-solicitante">Solicitante:</label>
						<div id="prefetch"><input type="text" class="typeahead form-control" placeholder="Solicitante" <?php echo(" id=\"".$inputSolicitante."\" name=\"".$inputSolicitante."\""); ?>></div>
					</div>

					<div class="form-group">
						<label for="nome-setor">Setor:</label>
						<input type="text" class="form-control" placeholder="Setor" <?php echo(" id=\"".$inputSetor."\" name=\"".$inputSetor."\""); ?>>
					</div>

					<div class="form-group">
						<label for="nome-local">Local:</label>
						<input type="text" class="form-control" placeholder="Local" <?php echo(" id=\"".$inputLocal."\" name=\"".$inputLocal."\""); ?>>
					</div>

					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label for="data-abertura">Data de Abertura:</label>
								<input type="text" class="form-control" placeholder="<?php echo($data_hoje); ?>" <?php echo(" id=\"".$inputDataAbertura."\" name=\"".$inputDataAbertura."\""); ?> disabled="disabled">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label for="data-abertura">Data de Fechamento:</label>
								<input type="text" class="form-control" placeholder="Data de Fechamento" <?php echo(" id=\"".$inputDataFechamento."\" name=\"".$inputDataFechamento."\""); ?> disabled="disabled">
							</div>
						</div>
					</div>

					<div class="form-group">
						<label>Técnico Respponsável:</label><br>
						<div class="form-group">
							<select id="tipo-chamado" class="selectpicker" data-width="100%">
								<?php echo "<option>Técnico Responsável</option>";
								foreach($tecnicos as $tecnico){
									echo "<option>".$tecnico['nome']."</option>";
								} ?>
							</select> 
						</div>
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

	<script>
		$('.selectpicker').selectpicker();
		$("#inputPrioridade").selectpicker('val', 'Média' );

		// Autocomplete for inputSolicitante
		var countries = new Bloodhound({
			datumTokenizer: Bloodhound.tokenizers.whitespace,
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			prefetch: 'data/countries.json'
		});

		$('#prefetch .typeahead').typeahead({
		    autoselect: true,
		    highlight: true,
		},
		{
		  name: 'countries',
		  source: countries
		});
	</script>

</body>
</html>