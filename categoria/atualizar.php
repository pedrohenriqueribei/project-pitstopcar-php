<?php 
    ob_start();
    include_once "../header.php";
    //


    $id_categoria = $_POST['id_categoria'];
    $descricao = $_POST['descricao'];
    $tabela = $_POST['tabela'];

    $sql = "UPDATE tb_categoria SET descricao = '$descricao', tabela = '$tabela' WHERE id_categoria = $id_categoria";

    if($conexao->query($sql) === TRUE){
        echo "Categoria $id_categoria atualizada com sucesso.";

        //registrar log
        include_once "../auditoria/log.php";
            
        $registro = "Atualizar categoria: $id_categoria -  Descricao: $descricao - Tabela: $tabela";
        $coluna = "descricao; tabela";
        registrar_log($registro, 'tb_categoria', $coluna);

        header("Location: ver.php");
    } else{
        echo "Error: ". $conexao->error;
    }
    $conexao->close;
    
    ob_end_flush();
?>