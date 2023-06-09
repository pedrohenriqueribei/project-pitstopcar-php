<?php

session_start();



//registrar log
include_once "../auditoria/log.php";
$usuario = $_SESSION['usuario'];
$registro = "Usuario deslogado";
$coluna = "usuario; senha;";
registrar_log($registro, 'tb_user', $coluna);

session_destroy();

header("Location: login.php");

exit;
?>