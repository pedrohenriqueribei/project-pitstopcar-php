<?php
ob_start();

include_once "../header.php";

$descricao = $_POST['descricao'];
$categoria = $_POST['categoria'];
$subcategoria = $_POST['subcategoria'];
$fabricante = $_POST['fabricante'];
$preco = $_POST['preco'];
$quantidade = $_POST['quantidade'];
$estado = $_POST['estado'];
$tamanho = $_POST['tamanho'];
$perc_lucro = $_POST['perc_lucro'];
$comentario = $_POST['comentario'];

//substituir a virgula do preço
$preco = str_replace('.','', $preco);
$preco = str_replace(',','.', $preco);
$perc_lucro = str_replace('.','', $perc_lucro);
$perc_lucro = str_replace(',','.', $perc_lucro);


//buscar id de negócio
$sql = "SELECT max(id_negocio) FROM tb_produto WHERE id_master = ". ID_MASTER;
$result = $conexao->query($sql);
$row = $result->fetch_assoc();
$id_negocio = $row['max(id_negocio)'] >= 1 ? $row['max(id_negocio)'] : 0;
$id_negocio++;


$sql = "INSERT INTO tb_produto
(id_negocio, descricao, categoria, subcategoria, fabricante, preco, quantidade, estado, tamanho, perc_lucro, dt_modif, comentario, id_master)
VALUES (
$id_negocio, '$descricao', '$categoria', '$subcategoria', '$fabricante', $preco, $quantidade, $estado, '$tamanho', $perc_lucro, curdate(), '$comentario', ".ID_MASTER.");";

if ($conexao->query($sql) === TRUE) {
    $last_id = $conexao->insert_id;

    //registrar log
    include_once "../auditoria/log.php";
            
    $registro = "Incluir produto: $last_id -  Descrição: $descricao - $categoria - $subcategoria - Tam: $tamanho - R$ $preco";
    $coluna = "todos;";
    registrar_log($registro, 'tb_produto', $coluna);

    
    header("Location: lista.php");

  } else {
    echo "Error: " . $sql . "<br>" . $conexao->error;
  }

    $conexao->close();

    ob_end_flush();
?>
    
    
