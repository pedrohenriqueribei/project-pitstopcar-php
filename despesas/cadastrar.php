<?php 
    ob_start();
    include_once "../header.php";
    //
    
    
    
    $descricao = $_POST['descricao'];
    $dt_compra = $_POST['dt_compra'];
    //$produto = $_POST[''];
    $valor = $_POST['valor'];
    $categoria = $_POST['categoria'];

    $comentario = $_POST['comentario'];

    //substituir a virgula do preço
    $valor = str_replace('.','', $valor);
    $valor = str_replace(',','.', $valor);


    //buscar id de negócio
    $sql = "SELECT max(id_negocio) FROM tb_despesa WHERE id_master = ". ID_MASTER;
    $result = $conexao->query($sql);
    $row = $result->fetch_assoc();
    $id_negocio = $row['max(id_negocio)'] >= 1 ? $row['max(id_negocio)'] : 0;
    $id_negocio++;

    $sql = "INSERT INTO tb_despesa (id_negocio, id_master, descricao, dt_compra, valor, categoria, total, comentario) VALUES (
        $id_negocio, ".ID_MASTER.", '$descricao', '$dt_compra', $valor, $categoria, $valor,'$comentario')";

    if ($conexao->query($sql)){

        $last_id = $conexao->insert_id;

        //registrar log
        include_once "../auditoria/log.php";
            
        $registro = "Incluir despesa: $last_id -  Descricao: $descricao - Categoria: $categoria - Valor R$ $valor ";
        $coluna = "descricao; dt_compra; valor; total;";
        registrar_log($registro, 'tb_despesa', $coluna);

        header("Location: lista.php");
    }
    else{
        ?>
        <div class="container">
            <h4>Não foi possivel adicionar a despesa</h4>

            <h6><?= "Error: " . $sql . "<br>" . $conexao->error; ?></h6>
        </div>
        <?php
    }
    $conexao->close();

    ob_end_flush();
?>






