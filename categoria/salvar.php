<?php 
    ob_start();
    include_once "../header.php";


    $descricao = $_POST['descricao'];
    $tabela = $_POST['tabela'];

    //buscar id de negócio
    $sql = "SELECT max(id_negocio) FROM tb_categoria WHERE id_master = ". ID_MASTER;
    $result = $conexao->query($sql);
    $row = $result->fetch_assoc();
    $id_negocio = $row['max(id_negocio)'] >= 1 ? $row['max(id_negocio)'] : 0;
    $id_negocio++;

    $sql = "INSERT INTO tb_categoria (id_negocio, id_master, descricao, tabela) VALUES (
        $id_negocio, ".ID_MASTER.", '$descricao', '$tabela')";

    if ($conexao->query($sql)){

        $last_id = $conexao->insert_id;

        //registrar log
        include_once "../auditoria/log.php";
            
        $registro = "Incluir categoria: $last_id -  Descricao: $descricao - Tabela: $tabela";
        $coluna = "descricao; tabela";
        registrar_log($registro, 'tb_categoria', $coluna);

        header("Location: ver.php");
    }
    else{
        ?>
        <div class="container">
            <h4>Não foi possivel adicionar a despesa</h4>
        </div>
        <?php
    }
    $conexao->close();

    ob_end_flush();
?>