<?php

include_once "../header.php";    
//


$id = $_GET['id'];

$sql = "SELECT * FROM tb_produto WHERE idProduto = $id";
$result = $conexao->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $descricao = $row['descricao'];
        $categoria = $row['categoria'];
        $subcategoria = $row['subcategoria'];
        $tamanho = $row['tamanho'];
        $preco = $row['preco'];
    }
}

//registrar log
include_once "../auditoria/log.php";
            
$registro = "Deletar produto: $id -  Descrição: $descricao - $categoria - $subcategoria - Tam: $tamanho - R$ $preco";
$coluna = "todos;";
registrar_log($registro, 'tb_produto', $coluna);

$sql = "UPDATE tb_produto SET estado = 0 WHERE idProduto = $id AND id_master = ".ID_MASTER;

$query = $conexao->query($sql);

header("Location: /pitstopcar/produtos/lista.php");


$conexao->close();

    include_once "../footer.html";       
?>