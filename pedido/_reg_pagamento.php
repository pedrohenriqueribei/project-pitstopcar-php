<?php 
ob_start();

include_once "../header.php";

$id = $_GET['id'];

$sql = "UPDATE tb_cprestacao SET pago = TRUE, dt_pag = curdate() WHERE id_cprestacao = $id";

if ($conexao->query($sql) === TRUE) {
    echo "Pagamento realizado";

    //registrar log
    include_once "../auditoria/log.php";
                
    $registro = "Registrar pagamento de prestacao: $id - Pago em ".date("d/m/Y");
    $coluna = "pago, dt_pago, vl_pago";
    registrar_log($registro, 'tb_cprestacao', $coluna);
} else {
    echo "Error: " . $sql . "<br>" . $conexao->error;
}
 
header("Location: ".$_SERVER['HTTP_REFERER']);

$conexao->close();

ob_end_flush();
?>