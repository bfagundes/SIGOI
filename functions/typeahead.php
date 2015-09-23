<?php
include ("/conexao.php");

if(isset($_GET['solicitante'])){
	$query = $_GET['solicitante'];
	$results = db_select("SELECT nome FROM usuario WHERE nome ILIKE".db_quote("%".$query."%"));
	echo json_encode($results);
}

if(isset($_GET['setor'])){
	$query = $_GET['setor'];
	$results = db_select("SELECT nome FROM setor WHERE nome ILIKE".db_quote("%".$query."%"));
	echo json_encode($results);
}

if(isset($_GET['local'])){
	$query = $_GET['local'];
	$results = db_select("SELECT nome FROM local WHERE nome ILIKE".db_quote("%".$query."%"));
	echo json_encode($results);
}
?>