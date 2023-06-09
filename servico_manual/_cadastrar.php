<?php
ob_start();
include_once "../header.php";

$descricao = $_POST['descricao'];
$preco = $_POST['preco'];


//substituir a virgula do preço
$preco = str_replace('.','', $preco);
$preco = str_replace(',','.', $preco);

$sql = "INSERT INTO tb_servico_manual (id_master, descricao, preco, ativo) VALUES (". ID_MASTER .", '$descricao', '$preco', 1)";

if ($conexao->query($sql) === TRUE) {
    $last_id = $conexao->insert_id;

    //registrar log
    include_once "../auditoria/log.php";
            
    $registro = "Incluir serviço manual: $last_id -  Descrição: $descricao - R$ $preco";
    $coluna = "descricao e preco;";
    registrar_log($registro, 'tb_servico_manual', $coluna);

    
    header("Location: lista.php");

} else {
    echo "Error: " . $sql . "<br>" . $conexao->error;
}

$conexao->close();
ob_end_flush();
?>