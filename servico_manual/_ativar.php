<?php 

include_once "../header.php";

$id = $_GET['id'];

$sql = "UPDATE tb_servico_manual SET ativo = 1 WHERE id_servico_manual = $id";
$conexao->query($sql);

header("Location: /pitstopcar/servico_manual/lista.php");

$conexao->close();

?>