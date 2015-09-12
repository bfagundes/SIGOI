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
$pageTitle = "Cadastro de Usuários";
$pageUrl = "lista_usuario.php";
$sqlTabUsuario = "usuario";
$sqlJoin = "INNER JOIN setor on (usuario.idsetor = setor.id)";
$sqlOrder = "ORDER BY LOWER(USUARIO.nome)";

// busca a lista de usuarios no banco
$usuarios = db_select("SELECT USUARIO.id AS id, USUARIO.nome AS nome, USUARIO.login AS login, SETOR.nome as setor FROM ".$sqlTabUsuario." ".$sqlJoin." ".$sqlOrder);

// Header
$navBackUrl = "index.php";
$navOptions = "<li class=\"nav nav-btn\"><a href=\"cadastro_usuario.php?id=0\">Incluir Usuario</a></li>";
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