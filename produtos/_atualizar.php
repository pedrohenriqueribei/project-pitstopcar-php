<?php
ob_start();

include_once "../header.php";

$id = $_POST['idProduto']; 
$descricao = $_POST['descricao'];
$categoria = $_POST['categoria'];
$subcategoria = $_POST['subcategoria'];
$fabricante = $_POST['fabricante'];
$perc_lucro = $_POST['perc_lucro'];
$preco = $_POST['preco'];
$quantidade = $_POST['quantidade'];
$estado = $_POST['estado'];
$tamanho = $_POST['tamanho'];
$comentario = $_POST['comentario'];

//substituir a virgula do preço
$preco = str_replace('.','', $preco);
$preco = str_replace(',','.', $preco);
$perc_lucro = str_replace('.','', $perc_lucro);
$perc_lucro = str_replace(',','.', $perc_lucro);



$sql = 
"UPDATE tb_produto 
SET 
descricao = '$descricao',
categoria = '$categoria',
subcategoria = '$subcategoria',
fabricante = '$fabricante',
perc_lucro = $perc_lucro,
preco = $preco,
quantidade = $quantidade,
estado = $estado,
tamanho = '$tamanho',
comentario = '$comentario',
dt_modif = curdate()
WHERE idProduto = $id AND id_master = ".ID_MASTER;

$query = $conexao->query($sql);

//registrar log
include_once "../auditoria/log.php";
            
$registro = "Atualizar produto: $id -  Descrição: $descricao - $categoria - $subcategoria - Tam: $tamanho - R$ $preco";
$coluna = "todos;";
registrar_log($registro, 'tb_produto', $coluna);

$conexao->close();

header("Location: lista.php");

ob_end_flush();
?>
