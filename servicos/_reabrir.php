<?php
ob_start();
include_once "../header.php";
//

$id = $_GET['id'];

$sql = "SELECT * FROM tb_ordem_servico WHERE id_servico = $id";
$result = $conexao->query($sql);
$row = $result->fetch_assoc();
$dt_manutencao = $row['dt_manutencao'];
$garantia = $row['garantia'];

$prazo = date('Y-m-d', strtotime('+'.$garantia.' days', strtotime($dt_manutencao)));

if(date('Y-m-d') <= $prazo):

    $sql = "UPDATE tb_ordem_servico SET status = 7, dt_reaberto = curdate() WHERE id_servico = $id";

    if ($conexao->query($sql) === TRUE) {
        echo "Record updated successfully";

        //registrar log
        include_once "../auditoria/log.php";
                        
        $registro = "Reabrir servico: ID: $id";
        $coluna = "status";
        registrar_log($registro, 'tb_ordem_servico', $coluna);

        header("Location: /pitstopcar/servicos/5_garantia.php");

    } else {
    echo "Error updating record: " . $conexao->error;
    }
else:
    $_SESSION['erro'] = "Ordem de Serviço fora do prazo de garantia";
    header("Location:  /pitstopcar/servicos/abrir.php/?id=".$id);
endif;

$conexao->close();

ob_end_flush();
?>