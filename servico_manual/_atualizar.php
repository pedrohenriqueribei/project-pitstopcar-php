<?php

include_once "../header.php";

$id_servico_manual = $_POST['id_servico_manual'];
$descricao = $_POST['descricao'];
$preco = $_POST['preco'];


//substituir a virgula do preço
$preco = str_replace('.','', $preco);
$preco = str_replace(',','.', $preco);

$sql = "UPDATE tb_servico_manual SET descricao = '$descricao', preco = '$preco' WHERE id_servico_manual = $id_servico_manual";

if ($conexao->query($sql) === TRUE) {
    $last_id = $conexao->insert_id;

    //registrar log
    include_once "../auditoria/log.php";
            
    $registro = "Atualizar serviço manual: $id_servico_manual -  Descrição: $descricao - R$ $preco";
    $coluna = "descricao e preco;";
    registrar_log($registro, 'tb_servico_manual', $coluna);

    
    header("Location: lista.php");

} else {
    echo "Error: " . $sql . "<br>" . $conexao->error;
}

$conexao->close();

?>