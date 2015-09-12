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
$pageTitle = "Parâmetros SIGOI";
$pageUrl = "parametros.php";
$sqlTabPrioridade = "prioridade";
$sqlTabSituacao = "situacao";
$sqlTabTipo = "tipo";
$sqlTabResPadrao = "respostaPadrao";
$sqlOrderPrioridade = "ORDER BY id";
$sqlOrderSituacao = "ORDER BY LOWER(nome)";
$sqlOrderTipo = "ORDER BY LOWER(nome)";
$sqlOrderResPadrao = "ORDER by LOWER(titulo)";

// variaveis: respostas padrao
// $modalUpdateResPadrao = "update-respadrao";
// $inputResPadrao = "InputRespadrao";
// $inputResPadraoTitulo = "Titulo";
// $inputResPadraoTexto = "Texto";
// $resPadraoId = "idRespadrao";
// $btnUpdateResPadrao = "btnUpdateRespadrao";

// buscando as listas no banco
$prioridades = db_select("SELECT * FROM ".$sqlTabPrioridade." ".$sqlOrderPrioridade);
$situacoes = db_select("SELECT * FROM ".$sqlTabSituacao." ".$sqlOrderSituacao);
$tipos = db_select("SELECT * FROM ".$sqlTabTipo." ".$sqlOrderTipo);
$respostasPadrao = db_select("SELECT * FROM ".$sqlTabResPadrao." ".$sqlOrderResPadrao); 

// Header
$navBackUrl = "index.php";
$navOptions = "";
require_once('./includes/header.php');
require_once('./includes/navbar_default.php');
?>	
	<div class="container-fluid">
	<div class="row">

		<div id="exTab2">	
			<ul class="nav nav-tabs">
				<li class="active"><a href="#1" data-toggle="tab"><span class="glyphicon glyphicon-alert"></span> Prioridades</a></li>
				<li><a href="#2" data-toggle="tab"><span class="glyphicon glyphicon-alert"></span> Situações</a></li>
				<li><a href="#3" data-toggle="tab"><span class="glyphicon glyphicon-alert"></span> Tipos</a></li>
				<li><a href="#4" data-toggle="tab"><span class="glyphicon glyphicon-align-justify"></span> Respostas Padrão</a></li>
			</ul>

			<div class="tab-content ">
				<div class="tab-pane active" id="1">
					<?php require('parametros/cadastro_prioridade.php'); ?>
				</div>
				<div class="tab-pane" id="2">
					<?php require('parametros/cadastro_situacao.php'); ?>
				</div>
				<div class="tab-pane" id="3">
					<?php require('parametros/cadastro_tipo.php'); ?>
				</div>
				<div class="tab-pane" id="4">
					<?php require('parametros/cadastro_respadrao.php'); ?>
				</div>
			</div>
		</div>

		<!-- <div class="col-md-2">
			<div class="panel panel-default">
  				<div class="panel-body">
					
					<div class="form-group">
						<form role="form" method="post" action="parametros.php">
							<div class="form-group">
								<label for="nome-solicitante">Prioridade 1</label>
								<input type="text" name='prioridade-1' class="form-control" value="<?php echo $prioridades[0]['nome']; ?>" id="prioridade-1">
							</div>
							<div class="form-group">
								<label for="nome-solicitante">Prioridade 2</label>
								<input type="text" name='prioridade-2' class="form-control" value="<?php echo $prioridades[1]['nome']; ?>" id="prioridade-2">
							</div>
							<div class="form-group">
								<label for="nome-solicitante">Prioridade 3</label>
								<input type="text" name='prioridade-3' class="form-control" value="<?php echo $prioridades[2]['nome']; ?>" id="prioridade-3">
							</div>
							<div class="form-group">
								<label for="nome-solicitante">Prioridade 4</label>
								<input type="text" name='prioridade-4' class="form-control" value="<?php echo $prioridades[3]['nome']; ?>" id="prioridade-4">
							</div>
							<div class="form-group">
								<label for="nome-solicitante">Prioridade 5</label>
								<input type="text" name='prioridade-5' class="form-control" value="<?php echo $prioridades[4]['nome']; ?>" id="prioridade-5">
							</div>
							<div class="form-group">
                    			<input name="submit-prioridade" type="submit" class="btn btn-primary" value="Salvar"/>
            				</div>
						</form>
					</div> -->
  				<!-- </div> --> <!-- panel-body -->
			<!-- </div> --> <!-- panel -->
		<!-- </div> --> <!-- col-md-2 -->

<!-- 		<div class="col-md-2">
			<div class="panel panel-default">
  				<div class="panel-body">
  					
					<div class="form-group">
						<form role="form" method="post" action="parametros.php">
							<div class="form-group">
								<label for="nome-solicitante">Tipo 1</label>
								<input type="text" name='tipo-1' class="form-control" value="<?php echo $tipos[0]['nome']; ?>" id="tipo-1">
							</div>
							<div class="form-group">
								<label for="nome-solicitante">Tipo 2</label>
								<input type="text" name='tipo-2' class="form-control" value="<?php echo $tipos[1]['nome']; ?>" id="tipo-2">
							</div>
							<div class="form-group">
								<label for="nome-solicitante">Tipo 3</label>
								<input type="text" name='tipo-3' class="form-control" value="<?php echo $tipos[2]['nome']; ?>" id="tipo-3">
							</div>
							<div class="form-group">
								<label for="nome-solicitante">Tipo 4</label>
								<input type="text" name='tipo-4' class="form-control" value="<?php echo $tipos[3]['nome']; ?>" id="tipo-4">
							</div>
							<div class="form-group">
								<label for="nome-solicitante">Tipo 5</label>
								<input type="text" name='tipo-5' class="form-control" value="<?php echo $tipos[4]['nome']; ?>" id="tipo-5">
							</div>
							<div class="form-group">
                    			<input name="submit-tipo" type="submit" class="btn btn-primary" value="Salvar"/>
            				</div>
						</form>
					</div> -->
  				<!-- </div> --> <!-- panel-body -->
			<!-- </div> --> <!-- panel -->
		<!-- </div> --> <!-- col-md-2 -->

<!-- 		<div class="col-md-2">
			<div class="panel panel-default">
  				<div class="panel-body">
					
					<div class="form-group">
						<form role="form" method="post" action="parametros.php">
							<div class="form-group">
								<label for="nome-solicitante">Situação 1</label>
								<input type="text" name='situacao-1' class="form-control" value="<?php echo $situacoes[0]['nome']; ?>" id="situacao-1">
							</div>
							<div class="form-group">
								<label for="nome-solicitante">Situação 2</label>
								<input type="text" name='situacao-2' class="form-control" value="<?php echo $situacoes[1]['nome']; ?>" id="situacao-2">
							</div>
							<div class="form-group">
								<label for="nome-solicitante">Situação 3</label>
								<input type="text" name='situacao-3' class="form-control" value="<?php echo $situacoes[2]['nome']; ?>" id="situacao-3">
							</div>
							<div class="form-group">
								<label for="nome-solicitante">Situação 4</label>
								<input type="text" name='situacao-4' class="form-control" value="<?php echo $situacoes[3]['nome']; ?>" id="situacao-4">
							</div>
							<div class="form-group">
								<label for="nome-solicitante">Situação 5</label>
								<input type="text" name='situacao-5' class="form-control" value="<?php echo $situacoes[4]['nome']; ?>" id="situacao-5">
							</div>
							<div class="form-group">
                    			<input name="submit-situacao" type="submit" class="btn btn-primary" value="Salvar"/>
            				</div>
						</form>
					</div> -->
  				<!-- </div> --> <!-- panel-body -->
			<!-- </div> --> <!-- panel -->
		<!-- </div> --> <!-- col-md-2 -->
	<!-- </div> --> <!-- Entire Row -->

<!-- 	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-default">
  				<div class="panel-body">
					
					<div class="form-group">
						<form role="form" method="post" action="parametros.php">
							<div class="col-md-3">
								<div class="form-group">
									<label for="nome-solicitante">Titulo</label>
									<input type="text" name='titulo-1' class="form-control" value="<?php echo $respostasPadrao[0]['titulo']; ?>" id="resp-padrao-assunto-1">
								</div>
								<div class="form-group">
									<label for="nome-solicitante">Titulo</label>
									<input type="text" name='titulo-2' class="form-control" value="<?php echo $respostasPadrao[1]['titulo']; ?>" id="resp-padrao-assunto-2">
								</div>
								<div class="form-group">
									<label for="nome-solicitante">Titulo</label>
									<input type="text" name='titulo-3' class="form-control" value="<?php echo $respostasPadrao[2]['titulo']; ?>" id="resp-padrao-assunto-3">
								</div>
								<div class="form-group">
									<label for="nome-solicitante">Titulo</label>
									<input type="text" name='titulo-4' class="form-control" value="<?php echo $respostasPadrao[3]['titulo']; ?>" id="resp-padrao-assunto-4">
								</div>
								<div class="form-group">
									<label for="nome-solicitante">Titulo</label>
									<input type="text" name='titulo-5' class="form-control" value="<?php echo $respostasPadrao[4]['titulo']; ?>" id="resp-padrao-assunto-5">
								</div>
								<div class="form-group">
                        			<input style="margin-left = 10px;" name="submit-resp-padrao" type="submit" class="btn btn-primary" value="Salvar"/>
                				</div>
							</div>
							<div class="col-md-9">
								<div class="form-group">
									<label for="nome-solicitante">Resposta Padrão 1</label>
									<input type="text" name='texto-1' class="form-control" value="<?php echo $respostasPadrao[0]['texto']; ?>" id="resp-padrao-texto-1">
								</div>
								<div class="form-group">
									<label for="nome-solicitante">Resposta Padrão 2</label>
									<input type="text" name='texto-2' class="form-control" value="<?php echo $respostasPadrao[1]['texto']; ?>" id="resp-padrao-texto-2">
								</div>
								<div class="form-group">
									<label for="nome-solicitante">Resposta Padrão 3</label>
									<input type="text" name='texto-3' class="form-control" value="<?php echo $respostasPadrao[2]['texto']; ?>" id="resp-padrao-texto-3">
								</div>
								<div class="form-group">
									<label for="nome-solicitante">Resposta Padrão 4</label>
									<input type="text" name='texto-4' class="form-control" value="<?php echo $respostasPadrao[3]['texto']; ?>" id="resp-padrao-texto-4">
								</div>
								<div class="form-group">
									<label for="nome-solicitante">Resposta Padrão 5</label>
									<input type="text" name='texto-5' class="form-control" value="<?php echo $respostasPadrao[4]['texto']; ?>" id="resp-padrao-texto-5">
								</div>
							</div>
						</form>
					</div> -->
  				<!-- </div> --> <!-- panel-body -->
			<!-- </div> --> <!-- panel -->
		<!-- </div> --> <!-- col-md-6 -->
	</div> <!-- Entire Row -->
	</div> <!-- Container Fluid -->

	<!-- Footer -->
	<?php require_once('./includes/footer.php'); ?>

	<script type="text/javascript">
	 //    $('tr').on('click', function (e) {
		//     e.preventDefault();
		//     // pegando o id e o nome da funcao na linha clicada
		//     var id = $(this).closest('tr').data('id');
		//     var nome = $(this).closest('tr').data('raw');
		//     // mandando isso pra dentro do modal
		//     $("#update-prioridade #idPrioridade").val(id);
		//     $("#update-prioridade #inputPrioridade").val(nome);
		// });

	 //    // seta o foco pro text field
		// $("#insert-funcao").on('shown.bs.modal', function(){
	 //        $(this).find('#inputFuncao').focus();
	 //    });
	 //    $("#update-funcao").on('shown.bs.modal', function(){
	 //        $(this).find('#inputFuncao').focus();
	 //    });
	</script>

</body>
</html>