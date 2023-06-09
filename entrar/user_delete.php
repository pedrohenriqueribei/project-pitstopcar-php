<?php

ob_start();
include_once "../header.php";
//

$id = $_GET['id'];

$sql = "SELECT * FROM tb_user WHERE id_user = $id";

$result = $conexao->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $usuario_del = $row['usuario'];
        $nome_del = $row['nome'];
        $nivel_del = $row['nivel'];
    }
}

$sql = "DELETE FROM tb_user WHERE id_user = $id";

if ($result = $conexao->query($sql) === TRUE) {
    echo "Record deleted successfully";

    //registrar log
    include_once "../auditoria/log.php";
    
    $registro = "Usuario deletado: $usuario_del - nome: $nome_del - nivel: $nivel_del";
    $coluna = "usuario;";
    registrar_log($registro, 'tb_user', $coluna);

    header("Location: /pitstopcar/entrar/perfil.php");
    exit;
} else {
    echo "Error deleting record: " . $conexao->error;
}
  
$conexao->close();
ob_end_flush();
?>