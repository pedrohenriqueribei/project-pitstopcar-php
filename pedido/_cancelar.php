<?php
include_once "../header.php";

$id_pedido = $_GET['id'];

$sql = "SELECT status FROM tb_pedido_externo WHERE id_pedido_externo = $id_pedido";
$result = $conexao->query($sql);
$row = $result->fetch_assoc();
$status = $row['status'];

if($status != "Recebido"){
    $sql = "UPDATE tb_pedido_externo SET status = 'Cancelado' WHERE id_pedido_externo = $id_pedido";
    $conexao->query($sql);
} else {
    $_SESSION['erro'] = "Pedido não pode ser cancelado";
}

header("Location: /pitstopcar/pedido/abrir.php/?id=".$id_pedido);

?>