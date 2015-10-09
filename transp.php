<?php
include("./functions/conexao_sginfra.php");
include("./functions/sessao.php");
include("./functions/defaults.php");
session_start();

// Testa se o usuario está logado
if(!session_isValid()){
	header('Location: login.php');
	die();
}

// variaveis
$pageTitle = "Solicitação de Transporte - Área Administrativa";
$pageUrl = "transp.php";
$data_hoje = date("d/m/Y");

// Header
$navBackUrl = "index.php";
$navOptions = "";
require_once('./includes/header.php');
require_once('./includes/navbar_transp.php');
?>

		<div class="container-fluid">
			<div class="row">

				<?php 
				//if(missedReqField()){
					//$errorMessage="<strong>Atenção!</strong> Preencha todos os campos obrigatórios"; 
					//require('./includes/alert_error.php');
				//} 
				//if(isset($_POST[$inputLogin])){
					//if(db_exists($sqlTabUsuario, 'login', $_POST[$inputLogin])){
						//$errorMessage="<strong>Atenção!</strong> Login já cadastrado!"; 
						//require('./includes/alert_error.php');
					//}
				//}
				?>
			</div>
		</div>


	<!-- Footer -->
	<?php require_once('./includes/footer.php'); ?>

	<script type="text/javascript">
	    // altera o estilo do selectpicker
	    $('.selectpicker').selectpicker();
		</script>

	</body>
	</html>