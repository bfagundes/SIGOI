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
$pageTitle = "Cadastro de Usuários";
$pageUrl = "lista_usuario.php";
$sqlSelect = "SELECT USUARIO.*, SETOR.nome as setor";
$sqlJoin = "INNER JOIN setor on (usuario.idsetor = setor.id)";
$sqlOrder = "ORDER BY LOWER(USUARIO.nome)";

// busca a lista de usuarios no banco
$usuarios = db_select($sqlSelect." FROM ".$sqlTabUsuario." ".$sqlJoin." ".$sqlOrder);

// busca a lista de usuarios de acordo com visualizacoes personalizadas
if(isset($_GET['view'])){
	if(strcasecmp($_GET['view'], 'usr_ativo') == 0){
		$usuarios = db_select($sqlSelect." FROM ".$sqlTabUsuario." ".$sqlJoin." WHERE ativo = true ".$sqlOrder);
	}
	if(strcasecmp($_GET['view'], 'usr_inativo') == 0){
		$usuarios = db_select($sqlSelect." FROM ".$sqlTabUsuario." ".$sqlJoin." WHERE ativo = false AND login IS NOT NULL ".$sqlOrder);
	}
	if(strcasecmp($_GET['view'], 'all') == 0){
		$usuarios = db_select($sqlSelect." FROM ".$sqlTabUsuario." ".$sqlJoin." ".$sqlOrder);
	}
	if(strcasecmp($_GET['view'], 'ppl') == 0){
		$usuarios = db_select($sqlSelect." FROM ".$sqlTabUsuario." ".$sqlJoin." WHERE login IS NULL ".$sqlOrder);
	}
}

// Header
$navBackUrl = "index.php";
$navOptions = "<li class=\"nav nav-btn\"><a href=\"cadastro_usuario.php?id=0\">Incluir Usuario</a></li>";
$navOptions = $navOptions."<li class=\"dropdown\">";
$navOptions = $navOptions."<a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"false\">Visualizações <span class=\"caret\"></span></a>";
$navOptions = $navOptions."<ul class=\"dropdown-menu\">";
$navOptions = $navOptions."<li><a href=\"".$pageUrl."?view=usr_ativo\">Usuarios Ativos</a></li>";
$navOptions = $navOptions."<li><a href=\"".$pageUrl."?view=usr_inativo\">Usuarios Inativos</a></li>";
$navOptions = $navOptions."<li role=\"separator\" class=\"divider\"></li>";
$navOptions = $navOptions."<li><a href=\"".$pageUrl."?view=ppl\">Pessoas</a></li>";
$navOptions = $navOptions."<li><a href=\"".$pageUrl."?view=all\">Todos</a></li>";
$navOptions = $navOptions."</ul></li>";

require_once('./includes/header.php');
require_once('./includes/navbar_default.php');
?>
	<div class="container-fluid">
		<div class="row">
			<!-- Tabela com a lista de usuarios -->
			<table class="table table-condensed table-hover">
				<thead>
					<tr>
						<th width="3%"></th>
						<th class="col-sm-2">Usuario</th>
						<th class="col-sm-3">Nome</th>
						<th class="col-sm-3">Setor</th>
						<th class="col-sm-3"></th>
					</tr>
				</thead>
				<tbody>
					<?php 
					for ($i = 0; $i < count($usuarios); $i++) {
						echo "<tr data-id=\"".$usuarios[$i]['id']."\">";
						echo "<td></td>";
						echo "<td>".$usuarios[$i]['login']."</td>";
						echo "<td>".$usuarios[$i]['nome']."</td>";
						echo "<td>".$usuarios[$i]['setor']."</td>";
						echo "<td></td>";
						echo "</tr>";
					} ?>
				</tbody>
			</table>
		</div>
	</div>

	<!-- Footer -->
	<?php require_once('./includes/footer.php'); ?>

	<script type="text/javascript">
		jQuery( function($) {
			$('tr').addClass('clickable').click(function() {
				var id = $(this).closest('tr').data('id');
				window.location = "cadastro_usuario.php?id=" + id;
			});
		});
	</script>

</body>
</html>