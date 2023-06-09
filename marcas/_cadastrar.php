<?php
ob_start();

include_once "../header.php";
//

$descricao = $_POST['descricao'];

$marca_sql = "SELECT * FROM tb_marca WHERE id_master = ". ID_MASTER." AND descricao LIKE '%$descricao%'";
$result_sql  = $conexao->query($marca_sql);

if ($result_sql->num_rows == 0) {
    // NÃO PODE CADASTRAR UMA MARCA JÁ EXISTENTE


    //buscar id de negócio
    $sql = "SELECT max(id_negocio) FROM tb_marca WHERE id_master = ". ID_MASTER;
    $result = $conexao->query($sql);
    $row = $result->fetch_assoc();
    $id_negocio = $row['max(id_negocio)'] >= 1 ? $row['max(id_negocio)'] : 0;
    $id_negocio++;

    $sql = "INSERT INTO tb_marca (id_negocio, descricao, id_master) VALUES ($id_negocio, '$descricao', ".ID_MASTER.")";
    
    if ($conexao->query($sql) === TRUE) {
        echo "Marca adicionada com sucesso";
        $last_id = $conexao->insert_id;
    
        //registrar log
        include_once "../auditoria/log.php";
                    
        $registro = "INCLUIR MARCA: $last_id - Descrição: $descricao";
        $coluna = "DESCRICAO";
        registrar_log($registro, 'tb_marca', $coluna);
    } else {
        echo "Error: " . $sql . "<br>" . $conexao->error;
    }

}

  
$conexao->close();

header("Location: lista.php");


include_once "../footer.html";
ob_end_flush();
?>