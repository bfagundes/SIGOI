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

// buscando a lista de chamados abertos
$chamados = db_select("SELECT ".
	"CHAMADO.id as id, ".
	"USUARIO.nome as solicitante, ".
    "SETOR.nome as setor, ".
   	"LOCAL.nome as local, ".
   	"CHAMADO.nrofo as nrofo, ".
    "CHAMADO.dataabertura as dataabertura, ".
    "CHAMADO.datafechamento as datafechamento, ".
    "USUARIO.nome as tecnico, ".
    "TIPO.nome as tipo, ".
    "PRIORIDADE.nome as prioridade, ".
    "SITUACAO.nome as situacao, ".
    "CHAMADO.ASSUNTO as assunto, ".
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
 	"ORDER BY idPrioridade");

$situacoes = db_select("SELECT DISTINCT chamado.idsituacao, situacao.nome FROM chamado INNER JOIN situacao on (chamado.idsituacao = situacao.id) ORDER BY idsituacao");

// Header
require_once('./includes/header.php');
require_once('./includes/navbar_index.php');
?>
	<div class="container-fluid">
		<!-- Tabela de Chamados -->
		<?php if(!empty($chamados)){
			foreach($situacoes as $situacao){ ?>
				<table class="table table-condensed table-hover">
					<thead>
						<tr>
							<th width="2%"></th>
							<th width="4%"></th>
							<th width="4%">FO</th>
							<th class="col-sm-3"><?php echo $situacao['nome'] ?></th>
							<th class="col-sm-2">Solicitante</th>
							<th class="col-sm-2">Local</th>
							<th class="col-sm-1">Data</th>
							<th class="col-sm-2">Técnico</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach($chamados as $chamado){
							if($chamado['idsituacao'] == $situacao['idsituacao']){
								echo "<tr data-id=\"".$chamado['id']."\">";
								echo "<td></td>";

								if($chamado['idprioridade'] == 1){ echo "<td><span class=\"label label-danger\">".$chamado['prioridade']."</span></td>";}
								else if($chamado['idprioridade'] == 2){ echo "<td><span class=\"label label-warning\">".$chamado['prioridade']."</span></td>";}
								else if($chamado['idprioridade'] == 3){ echo "<td><span class=\"label label-primary\">".$chamado['prioridade']."</span></td>";}
								else if($chamado['idprioridade'] == 4){ echo "<td><span class=\"label label-info\">".$chamado['prioridade']."</span></td>";}
								else if($chamado['idprioridade'] == 5){ echo "<td><span class=\"label label-success\">".$chamado['prioridade']."</span></td>";}
								
								echo "<td>".$chamado['nrofo']."</td>";
								echo "<td>".$chamado['assunto']."</td>";
								echo "<td>".$chamado['solicitante']."</td>";
								echo "<td>".$chamado['setor']."</td>";
								echo("<td>".date('d/m/Y H:i',strtotime($chamado['dataabertura']))."</td>");
								echo "<td>".$chamado['tecnico']."</td>";
								echo "</tr>";
						}} ?>
					</tbody>
				</table>
		<?php }} ?>
	</div>

	<!-- Footer -->
	<?php require_once('./includes/footer.php'); ?>

	<script type="text/javascript">
		jQuery( function($) {
			$('tr').addClass('clickable').click(function() {
				var id = $(this).closest('tr').data('id');
				window.location = "chamado.php?id=" + id;
			});
		});
	</script>

</body>
</html>