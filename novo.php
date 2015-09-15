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
						<input type="text" class="form-control" placeholder="Solicitante" id="nome-solicitante">
					</div>

					<div class="form-group">
						<label for="nome-setor">Setor:</label>
						<input type="text" class="form-control" placeholder="Setor" id="nome-setor">
					</div>

					<div class="form-group">
						<label for="nome-local">Local:</label>
						<input type="text" class="form-control" placeholder="Local" id="nome-local">
					</div>

					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label for="data-abertura">Data de Abertura:</label>
								<input type="text" class="form-control" placeholder="<?php echo($data_hoje); ?>" id="data-abertura" disabled="disabled">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label for="data-abertura">Data de Fechamento:</label>
								<input type="text" class="form-control" placeholder="Data de Fechamento" id="data-fechamento" disabled="disabled">
							</div>
						</div>
					</div>

					<div class="form-group">
						<label>Técnico Respponsável:</label><br>
						<div class="form-group">
								<select id="tipo-chamado" class="selectpicker" data-width="100%" disabled>
									<option>Técnico Responsável</option>
									<option>Bruno Fagundes</option>
									<option>Matteus Barragan</option>
								</select> 
							</div>
					</div>

					<!-- ----- Dropdowns ------ -->
					<div class="btn-group btn-group-justified" role="group">
						<div class="btn-group" role="group">
							<div class="form-group">
								<select id="tipo-chamado" class="selectpicker" data-width="100%">
									<option>Problema</option>
									<option>Incidente</option>
									<option>Pergunta</option>
								</select> 
							</div>
						</div>
						<div class="btn-group" role="group">
							<div class="form-group">
								<select id="prioridade-chamado" class="selectpicker" data-width="100%">
									<option>Urgente</option>
									<option>Alta</option>
									<option>Média</option>
									<option>Baixa</option>
								</select> 
							</div>
						</div>
						<div class="btn-group" role="group">
							<div class="form-group">
								<select id="situacao-chamado" class="selectpicker" data-width="100%">
									<option>Aberto</option>
									<option>Pendente</option>
									<option>Fechado</option>
								</select> 
							</div>
						</div>
					</div> <!-- dropdonws group -->

					<!-- // <script>
					// 	$(function() {
					// 		$('#prioridade-chamado').on('change', function(){
					// 			if($(this).find("option:selected").val() == "Urgente"){
					// 				$('#prioridade-chamado').selectpicker('setStyle', 'btn-danger');
					// 			} 
					// 			if($(this).find("option:selected").val() == "Alta"){
					// 				$('#prioridade-chamado').selectpicker('setStyle', 'btn-warning');
					// 			} 
					// 			if($(this).find("option:selected").val() == "Média"){
					// 				$('#prioridade-chamado').selectpicker('setStyle', 'btn-success');
					// 			} 
					// 			if($(this).find("option:selected").val() == "Baixa"){
					// 				$('#prioridade-chamado').selectpicker('setStyle', 'btn-info');
					// 			}
					// 		});
					// 	});
					// </script> -->

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
	</script>

</body>
</html>