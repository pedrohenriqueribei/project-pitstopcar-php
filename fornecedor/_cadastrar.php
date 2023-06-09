<?php
ob_start();

include_once "../header.php";

$nome_fantasia = $_POST['nome_fantasia'];


//buscar id de negócio
$sql = "SELECT max(id_negocio) FROM tb_fornecedor_pecas WHERE id_master = ". ID_MASTER;
$result = $conexao->query($sql);
$row = $result->fetch_assoc();
$id_negocio = $row['max(id_negocio)'] >= 1 ? $row['max(id_negocio)'] : 0;
$id_negocio++;

$sql = "INSERT INTO tb_fornecedor_pecas (id_negocio, nome_fantasia, id_master) VALUES ($id_negocio, '$nome_fantasia', ".ID_MASTER.");";

if ($conexao->query($sql) === TRUE){
    echo "New record created successfully";
    $last_id = $conexao->insert_id;
} else {
  echo "Error: " . $sql . "<br>" . $conexao->error;
}


//registrar log
include_once "../auditoria/log.php";
                    
$registro = "Incluir fornecedor de servico $last_id - $nome_fantasia";
$coluna = "nome fantasia";
registrar_log($registro, 'tb_fornecedor_pecas', $coluna);





header("Location: lista.php");

$conexao->close();


include_once "../footer.html";
ob_end_flush();
?>