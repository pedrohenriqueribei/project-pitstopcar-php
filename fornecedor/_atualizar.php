<?php
ob_start();

include_once "../header.php";

$nome_fantasia = $_POST['nome_fantasia'];
$id_fornecedor_pecas = $_POST['id_fornecedor_pecas'];

$sql = "UPDATE tb_fornecedor_pecas SET nome_fantasia = '$nome_fantasia' WHERE id_master = ".ID_MASTER." AND id_fornecedor_pecas = $id_fornecedor_pecas";

if ($conexao->query($sql) === TRUE){
    echo "Record atualizado successfully";

} else {
  echo "Error: " . $sql . "<br>" . $conexao->error;
}


//registrar log
include_once "../auditoria/log.php";
                    
$registro = "Atualizar fornecedor de servico $id_fornecedor_pecas - $nome_fantasia";
$coluna = "nome fantasia";
registrar_log($registro, 'tb_fornecedor_pecas', $coluna);





header("Location: lista.php");

$conexao->close();


include_once "../footer.html";
ob_end_flush();
?>