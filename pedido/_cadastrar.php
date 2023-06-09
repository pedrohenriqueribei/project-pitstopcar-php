<?php
ob_start();

include_once "../header.php";

$codigo_externo = $_POST['codigo_externo'];
$fornecedor = $_POST['fornecedor'];
$dt_pedido = $_POST['dt_pedido'];
$dt_entrega = $_POST['dt_entrega'];



//buscar id de negócio
$sql = "SELECT max(id_negocio) FROM tb_pedido_externo WHERE id_master = ". ID_MASTER;
$result = $conexao->query($sql);
$row = $result->fetch_assoc();
$id_negocio = $row['max(id_negocio)'] >= 1 ? $row['max(id_negocio)'] : 0;
$id_negocio++;



$sql = "INSERT INTO tb_pedido_externo (id_negocio, codigo_externo, id_fornecedor, dt_pedido, dt_entrega, status, id_master) VALUES ($id_negocio, $codigo_externo, $fornecedor, '$dt_pedido', '$dt_entrega', 'Aberto', ". ID_MASTER .")";
if ($conexao->query($sql) === TRUE) {
    $last_id = $conexao->insert_id;

    //registrar log
    include_once "../auditoria/log.php";
            
    $registro = "Incluir pedido externo: $last_id - Fornecedor $fornecedor - data $dt_pedido - entrega $dt_entrega";
    $coluna = "codigo_externo, id_fornecedor, dt_pedido, dt_entrega, status, id_master";
    registrar_log($registro, 'tb_pedido_externo', $coluna);

    
    header("Location: abrir.php/?id=".$last_id);

  } else {
    echo "Error: " . $sql . "<br>" . $conexao->error;
  }

    $conexao->close();

    ob_end_flush();
?>