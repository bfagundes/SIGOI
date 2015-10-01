<?php
include("/conexao.php");
include("/defaults.php");

if(isset($_GET['solicitante'])){
	$query = $_GET['solicitante'];
	$results = db_select("SELECT nome FROM ".$sqlTabUsuario." WHERE nome ILIKE".db_quote("%".$query."%")."ORDER BY nome = ".db_quote($query)."DESC, nome ILIKE ".db_quote($query."%")." DESC, nome");
	echo json_encode($results);
}

if(isset($_GET['setor'])){
	$query = $_GET['setor'];
	$results = db_select("SELECT nome FROM ".$sqlTabSetor." WHERE nome ILIKE".db_quote("%".$query."%")."ORDER BY nome = ".db_quote($query)."DESC, nome ILIKE ".db_quote($query."%")." DESC, nome");
	echo json_encode($results);
}

if(isset($_GET['funcao'])){
	$query = $_GET['funcao'];
	$results = db_select("SELECT nome FROM ".$sqlTabFuncao." WHERE nome ILIKE".db_quote("%".$query."%")."ORDER BY nome = ".db_quote($query)."DESC, nome ILIKE ".db_quote($query."%")." DESC, nome");
	echo json_encode($results);
}

if(isset($_GET['local'])){
	$query = $_GET['local'];
	$results = db_select("SELECT nome FROM ".$sqlTabLocal." WHERE nome ILIKE".db_quote("%".$query."%")."ORDER BY nome = ".db_quote($query)."DESC, nome ILIKE ".db_quote($query."%")." DESC, nome");
	echo json_encode($results);
}

if(isset($_GET['tecnico'])){
	$setorId = db_select("SELECT id from ".$sqlTabSetor." WHERE nome = 'Informatica'");
	$query = $_GET['tecnico'];
	$results = db_select("SELECT nome FROM ".$sqlTabUsuario." WHERE idSetor = ".$setorId[0]['id']." AND nome ILIKE".db_quote("%".$query."%")."ORDER BY nome = ".db_quote($query)."DESC, nome ILIKE ".db_quote($query."%")." DESC, nome");
	echo json_encode($results);
}
?>