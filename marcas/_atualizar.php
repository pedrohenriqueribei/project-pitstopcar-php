<?php 
    ob_start();
    include_once "../header.php";
    //

    $id_marca = $_POST['id_marca'];
    $descricao = $_POST['descricao'];

    $sql = "UPDATE tb_marca SET descricao = '$descricao' WHERE id_marca = $id_marca";
    
    if ($conexao->query($sql) === TRUE) {
        echo "Descrição Marca atualizado com sucesso";

        //registrar log
        include_once "../auditoria/log.php";
                    
        $registro = "ATUALIZAR MARCA: $id_marca - Descrição: $descricao";
        $coluna = "DESCRICAO";
        registrar_log($registro, 'tb_marca', $coluna);
    } else {
        echo "Error updating record: " . $conexao->error;
    }
      
      $conexao->close();

      header("Location: lista.php");
      ob_end_flush();
?>