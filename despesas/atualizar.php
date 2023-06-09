<?php 
    ob_start();
    include_once "../header.php";
    //

    $id_desp = $_POST['id_despesa'];
    $descricao = $_POST['descricao'];
    $valor = $_POST['valor'];
    $dt_compra = $_POST['dt_compra'];
    $categoria = $_POST['categoria'];
    $comentario = $_POST['comentario'];

    //substituir a virgula do preço
    $valor = str_replace('.','', $valor);
    $valor = str_replace(',','.', $valor);

    $sql = "UPDATE tb_despesa SET 
        descricao = '$descricao', 
        dt_compra = '$dt_compra', 
        valor = $valor, 
        categoria = $categoria, 
        total = $valor, 
        comentario = '$comentario'
        WHERE id_despesa = $id_desp";


    if ($conexao->query($sql) === TRUE) {
        echo "Record updated successfully";

        //registrar log
        include_once "../auditoria/log.php";
            
        $registro = "Atualizar despesa: $id_desp -  Descricao: $descricao - Categoria: $categoria - Valor R$ $valor";
        $coluna = "descricao; dt_compra; valor; quantidade; total;";
        registrar_log($registro, 'tb_despesa', $coluna);
        
    } else {
        echo "Error updating record: " . $conexao->error;
    }

    $conexao->close();

    header("Location: lista.php");

    ob_end_flush();
?>