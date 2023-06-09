<?php 
    ob_start();
    include_once "../header.php";
    //

    $id_marca = $_GET['id'];
    $descricao = $_GET['descricao'];

    $sql = "DELETE FROM tb_marca WHERE id_marca = $id_marca";
    
    if ($conexao->query($sql) === TRUE) {
        echo "Descrição Marca atualizado com sucesso";

        //registrar log
        include_once "../auditoria/log.php";
                    
        $registro = "DELETAR: $id_marca - Descrição: $descricao";
        $coluna = "DESCRICAO";
        registrar_log($registro, 'tb_marca', $coluna);
    } else {
        echo "Error updating record: " . $conexao->error;
    }
      
      $conexao->close();

      header("Location: /pitstopcar/marcas/lista.php");
      ob_end_flush();
?>