<?php

//


$id = $_GET['id'];

$sql = "SELECT * FROM tb_despesa WHERE id_despesa = $id";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $descricao = $row['descricao'];
        $dt_compra = $row['dt_compra'];
        $valor = $row['valor'];
        $quantidade = $row['quantidade'];
        $total = $row['total'];
    }
} else {
    echo "0 results";
}



$sql = "DELETE FROM tb_despesa WHERE id_despesa = $id";

if ($conexao->query($sql) === TRUE) {
    
    echo "Record deleted successfully";
    
    //registrar log
    include_once "../auditoria/log.php";
                
    $registro = "Deletar despesa: $id -  Descricao: $descricao - Data: $dt_compra - Valor R$ $valor - Quantidade: $quantidade = Total: R$ $total";
    $coluna = "descricao; dt_compra; valor; quantidade; total;";
    registrar_log($registro, 'tb_despesa', $coluna);

} else {
    echo "Error deleting record: " . $conexao->error;
}


$conexao->close();

header("Location: /pitstopcar/despesas/lista.php");
?>