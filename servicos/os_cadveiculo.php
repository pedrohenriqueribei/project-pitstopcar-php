<?php
ob_start();
include_once "../header.php";

$placa = $_POST['placa'];
$idCliente = $_POST['idCliente'];
$marca = $_POST['marca'];
$modelo = $_POST['modelo'];
$ano = $_POST['ano'];

//buscar id de negócio
$sql = "SELECT max(id_negocio) FROM tb_veiculo WHERE id_master = ". ID_MASTER;
$result = $conexao->query($sql);
$row = $result->fetch_assoc();
$id_negocio = $row['max(id_negocio)'] >= 1 ? $row['max(id_negocio)'] : 0;
$id_negocio++;


$insert = "INSERT INTO tb_veiculo (id_negocio, id_master, placa, marca, modelo, ano) 
           VALUES ($id_negocio, ".ID_MASTER.", '$placa', '$marca', '$modelo', $ano)";

if($conexao->query($insert) === TRUE){
    $last_id_veiculo = $conexao->insert_id;
    echo "Veiculo cadastrado com sucesso";


    //registrar log
    include_once "../auditoria/log.php";
                
    $registro = "Incluir Veiculo ID $last_id_veiculo - Placa $placa - Marca $marca - Modelo $modelo - ANO $ano";
    $coluna = "ID / placa / marca / modelo / ano";
    registrar_log($registro, 'tb_veiculo', $coluna);


    header("Location: os_locveiculo.php/?placa=".$placa."&idCliente=".$idCliente);
}

ob_end_flush();
?>