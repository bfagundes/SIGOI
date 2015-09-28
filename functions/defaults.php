<?php

// SQL Tables
$sqlTabChamado = "chamado";
$sqlTabComentario = "comentario";
$sqlTabFollowUp = "followup";
$sqlTabFuncao = "Funcao";
$sqlTabLocal = "local";
$sqlTabPrioridade = "prioridade";
$sqlTabResPadrao = "respostaPadrao";
$sqlTabSetor = "setor";
$sqlTabSituacao = "situacao";
$sqlTabTeste = "teste";
$sqlTabTipo = "tipo";
$sqlTabUsuario = "usuario";

// SQL ORDER BY's
$sqlOrdChamado = "";
$sqlOrdComentario = "";
$sqlOrdFollowUp = "ORDER BY data DESC";
$sqlOrdFuncao = "ORDER BY LOWER(nome)";
$sqlOrdLocal = "ORDER BY LOWER(nome)";
$sqlOrdPrioridade = "ORDER BY id";
$sqlOrdResPadrao = "ORDER by LOWER(titulo)";
$sqlOrdSetor = "ORDER BY LOWER(nome)";
$sqlOrdSituacao = "ORDER BY LOWER(nome)";
$sqlOrdTeste = "ORDER BY id";
$sqlOrdTipo = "ORDER BY LOWER(nome)";
$sqlOrdUsuario = "ORDER BY LOWER(nome)";

// Buttons
$btnUpdate = "btnUpdate";
$btnInsert = "btnInsert";
$btnDelete = "btnDelete";
$btnSubmit = "btnSubmit";
$btnFollowUp = "btnFollowUp";

?>