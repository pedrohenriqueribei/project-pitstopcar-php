<?php 
ob_start();
include_once "../header.php";

$id_pedido_externo = $_POST['id_pedido_externo'];
$produto = $_POST['produto'];
$quantidade = $_POST['quantidade'];
$preco = $_POST['preco'];

//substituir a virgula do preço
$preco = str_replace('.','', $preco);
$preco = str_replace(',','.', $preco);

$sql = "SELECT descricao FROM tb_produto WHERE idProduto = $produto";
$result = $conexao->query($sql);
$row = $result->fetch_assoc();
$descricao = $row['descricao'];
$valor = $quantidade * $preco;

$sql = "SELECT status FROM tb_pedido_externo WHERE id_pedido_externo = $id_pedido_externo";
$result = $conexao->query($sql);
$row = $result->fetch_assoc();
$status = $row['status'];

//permissão para adicionar itens apenas se o pedido estiver aberto
if($status == "Aberto"):

$sql = "INSERT INTO tb_itenspedido (id_pedido, id_produto, quantidade, descricao, preco, valor, status, id_master) VALUES ($id_pedido_externo, $produto, $quantidade, '$descricao', $preco, $valor, 1, ".ID_MASTER.")";
if ($conexao->query($sql) === TRUE) {
    $last_id = $conexao->insert_id;
    echo "New record created successfully. Last inserted ID is: " . $last_id;

    $sql = "SELECT total, total_pago FROM tb_pedido_externo WHERE id_pedido_externo = $id_pedido_externo";
    $result = $conexao->query($sql);
    $row = $result->fetch_assoc();
    $total = $row['total'];
    $total_pago = $row['total_pago'];
    $total += $valor;
    $total_pago += $valor;
    
    $sql = "UPDATE tb_pedido_externo SET 
    total = $total,
    total_pago = $total_pago
    WHERE id_pedido_externo = $id_pedido_externo";
    
    if ($conexao->query($sql) === TRUE) {
        echo "Record updated successfully";



        //registrar log
        include_once "../auditoria/log.php";
                
        $registro = "Atualizar pedido externo: $id_pedido_externo - total $total - TOTAL A PAGAR $total_pago";
        $coluna = "forma de pagamento, desconto, taxa de entrega, total a pagar";
        registrar_log($registro, 'tb_pedido_externo', $coluna);
    } else {
        echo "Error updating record: " . $conexao->error;
    }
} else {
    echo "Error: " . $sql . "<br>" . $conexao->error;
}

else :
    $_SESSION['erro'] = "Não é permitido adicionar itens em pedidos com status $status.";
endif;

header("Location: abrir.php/?id=".$id_pedido_externo."#item");
  
$conexao->close();

include_once "../footer.html";
ob_end_flush();
?>