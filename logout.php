<?php
include("./functions/sessao.php");
session_start();
session_logout();
header('Location: login.php');
die();
?>