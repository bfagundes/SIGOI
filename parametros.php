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

	<!-- Footer -->
	<?php require_once('./includes/footer.php'); ?>

</body>
</html>