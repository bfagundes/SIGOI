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
$navOptions = "<li class=\"dropdown\">"
	."<a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"false\">Opções <span class=\"caret\"></span></a>"
	."<ul class=\"dropdown-menu\">"
	."<li><a href=\"#\">Editar Chamado</a></li>"
	."<li><a href=\"#\">Excluir Chamado</a></li>"
	."</ul></li>";
require_once('./includes/header.php');
require_once('./includes/navbar_default.php');
?>

<!DOCTYPE html>
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
								<input type="text" class="form-control" placeholder="Data de Abertura" id="data-abertura">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label for="data-abertura">Data de Fechamento:</label>
								<input type="text" class="form-control" placeholder="Data de Fechamento" id="data-fechamento">
							</div>
						</div>
					</div>
					
					<script type="text/javascript">
						$('#data-abertura').datepicker({
						    format: "dd/mm/yyyy",
						    todayBtn: "linked",
						    language: "pt-BR",
						    orientation: "bottom auto",
						    keyboardNavigation: false,
						    autoclose: true,
						    todayHighlight: true
						});
					</script>

					<script type="text/javascript">
						$('#data-fechamento').datepicker({
						    format: "dd/mm/yyyy",
						    todayBtn: "linked",
						    language: "pt-BR",
						    orientation: "bottom auto",
						    keyboardNavigation: false,
						    autoclose: true,
						    todayHighlight: true
						});
					</script>

					<div class="form-group">
						<label>Técnico Respponsável:</label><br>
						<div class="form-group">
								<select id="tipo-chamado" class="selectpicker" data-width="100%">
									<option>Técnico Responsável</option>
									<option>Bruno Fagundes</option>
									<option>Matteus Barragan</option>
								</select> 
							</div>
					</div>

					<!-- Dropdowns -->
					<div class="btn-group btn-group-justified" role="group">
						<div class="btn-group" role="group">
							<div class="form-group">
								<select id="tipo-chamado" class="selectpicker" data-width="100%" data-style="btn-inverse">
									<option>Problema</option>
									<option>Incidente</option>
									<option>Pergunta</option>
								</select> 
							</div>
						</div>
						<div class="btn-group" role="group">
							<div class="form-group">
								<select id="prioridade-chamado" class="selectpicker" data-width="100%" data-style="btn-danger">
									<option>Urgente</option>
									<option>Alta</option>
									<option>Média</option>
									<option>Baixa</option>
								</select> 
							</div>
						</div>
						<div class="btn-group" role="group">
							<div class="form-group">
								<select id="situacao-chamado" class="selectpicker" data-width="100%" data-style="btn-danger">
									<option>Aberto</option>
									<option>Pendente</option>
									<option>Fechado</option>
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
    				<h4><small>#00000 </small>Título do Chamado</h4>

    				<p>Nullam quis risus eget urna mollis ornare vel eu leo. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam id dolor id nibh ultricies vehicula.
					<p>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec ullamcorper nulla non metus auctor fringilla. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Donec ullamcorper nulla non metus auctor fringilla.</p>

					<label for="comentario">Comentário:</label>
					<!-- <textarea class="form-control" rows="3" id="comentario"></textarea> -->

					<div class="input-group">
						<textarea class="form-control custom-control" rows="3" style="resize:none"></textarea><span class="input-group-addon btn btn-primary">Enviar</span>
					</div>

					<!-- Enviar e Resposta Padrão -->
					<div class="btn-group pull-right" role="group">
						<div class="dropdown pull-right">
							<button class="btn btn-default dropdown-toggle pull-right" type="button" id="dropdownMenu1" data-toggle="dropdown">Resposta Padrão<span class="caret"></span></button>
							<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
								<li><a href="#">Action</a></li>
								<li><a href="#">Another action</a></li>
								<li><a href="#">Something else here</a></li>
								<li><a href="#">Separated link</a></li>
							</ul>
						</div>
						<select id="situacao-chamado" class="selectpicker pull-right" data-width="auto">
							<option>Público</option>
							<option>Privado</option>
						</select> 
					</div>

  				</div>
  				<div class="panel-footer">
  					<h5><strong>Bruno Fagundes</strong><small> (14/Ago/15 16:37 | Status > Pendente) </small></h5>
					<p>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec ullamcorper nulla non metus auctor fringilla. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Donec ullamcorper nulla non metus auctor fringilla.</p>

					<p><h5><strong>Matteus Barragan</strong><small> (14/Ago/15 13:08) </small></h5>
					<p>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec ullamcorper nulla non metus auctor fringilla. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Donec ullamcorper nulla non metus auctor fringilla.</p>
  				</div>
			</div>
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