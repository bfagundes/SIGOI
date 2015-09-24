<?php
include ("./functions/conexao.php");
$pageTitle = "SIGOI";
require_once('./includes/header.php');

date_default_timezone_set('America/Sao_Paulo');
$data_hoje = date("d/m/Y H:i", time());
echo $data_hoje;
?>

<input type="text" id="datetimepicker">

<script>
$('#datetimepicker').datepicker({
	format: "dd/mm/yyyy HH:mm",
	startDate: "2015-01-01",
    todayBtn: "linked",
    language: "pt-BR",
    orientation: "bottom auto",
    keyboardNavigation: false,
    autoclose: true,
    todayHighlight: true,
    minuteStep: 60
});
</script>

</body>
</html>