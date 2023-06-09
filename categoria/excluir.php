<?php 
ob_start();
    include_once "../header.php";
    //

    $id_categoria = $_GET['id'];

    $sql = "SELECT * FROM tb_categoria WHERE id_master = ". ID_MASTER. " AND id_categoria = $id";

    $result = $conexao->query($sql);

    while ($row = $result->fetch_assoc()) {
        $descricao = $row['descricao'];
        $tabela = $row['tabela'];
    }


    $sql = "DELETE FROM tb_categoria WHERE id_categoria = $id";

    if($conexao->query($sql) === TRUE){
        echo "Categoria $id_categoria - $descricao EXCLUÍDA com sucesso.";

        //registrar log
        include_once "../auditoria/log.php";
            
        $registro = "Excluir categoria: $id_categoria -  Descricao: $descricao - Tabela: $tabela";
        $coluna = "descricao; tabela";
        registrar_log($registro, 'tb_categoria', $coluna);

        header("Location: ver.php");
    } else{
        echo "Error: ". $conexao->error;
    }
    $conexao->close;
    
ob_end_flush();
?>