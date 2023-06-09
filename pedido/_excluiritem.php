<?php
include_once "../header.php";

$id_item = $_GET['id_item'];
$id_pedido = $_GET['id_pedido'];




$sql = "UPDATE tb_itenspedido SET status = -1 WHERE id_item = $id_item";
if ($conexao->query($sql) === TRUE) {
    echo "Item desativado com sucesso";

    //buscar o valor do item
    $sql = "SELECT valor FROM tb_itenspedido WHERE id_item = $id_item";
    $result = $conexao->query($sql);
    $row = $result->fetch_assoc();
    $valor = $row['valor'];

    $sql = "SELECT total, total_pago FROM tb_pedido_externo WHERE id_pedido_externo = $id_pedido";
    $result = $conexao->query($sql);
    $row = $result->fetch_assoc();
    $total = $row['total'];
    $total_pago = $row['total_pago'];
    $total -= $valor;
    $total_pago -= $valor;
    
    $sql = "UPDATE tb_pedido_externo SET 
    total = $total,
    total_pago = $total_pago
    WHERE id_pedido_externo = $id_pedido";
    
    if ($conexao->query($sql) === TRUE) {
        echo "Record updated successfully";



        //registrar log
        include_once "../auditoria/log.php";
                
        $registro = "Atualizar pedido externo: $id_pedido - total $total - TOTAL A PAGAR $total_pago";
        $coluna = "forma de pagamento, desconto, taxa de entrega, total a pagar";
        registrar_log($registro, 'tb_pedido_externo', $coluna);
    } else {
        echo "Error updating record: " . $conexao->error;
    }

    //registrar log
    include_once "../auditoria/log.php";
            
    $registro = "Item desativar: $id_item";
    $coluna = "status";
    registrar_log($registro, 'tb_itenspedido', $coluna);


    header("Location: ".$_SERVER['HTTP_REFERER']);
} else {
    echo "Error updating record: " . $conexao->error;
}

?>