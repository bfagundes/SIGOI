<?php
include("./functions/conexao.php");
include("./functions/sessao.php");
include("./functions/defaults.php");
session_start();
session_logout();
header('Location: login.php');
die();
?>