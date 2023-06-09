<?php 
    ob_start();
    include_once "../header.php";
    //

    $id = $_GET['id'];

    $sql = "UPDATE tb_ordem_servico SET status = -1, dt_aprovacao = curdate() WHERE id_servico = $id";

    if ($conexao->query($sql) === TRUE) {
        echo "Record updated successfully";

        //registrar log
        include_once "../auditoria/log.php";
                    
        $registro = "Reprovar servico: ID: $id";
        $coluna = "status";
        registrar_log($registro, 'tb_ordem_servico', $coluna);

    } else {
    echo "Error updating record: " . $conexao->error;
    }
    
    $conexao->close();

    header("Location: /pitstopcar/servicos/reprovados.php");

    ob_end_flush();
?>