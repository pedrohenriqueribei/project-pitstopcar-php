<?php

ob_start();

include_once "../header.php";
//


$nome = $_POST['nome'];
$usuario = $_POST['usuario'];
$senha = $_POST['senha'];
$nivel = $_POST['nivel'];

$usuario = str_replace(" ","",$usuario);
$usuario = strtolower($usuario);

$sql = "SELECT usuario FROM tb_user WHERE id_master = ".ID_MASTER." AND usuario LIKE '$usuario'";
$result = $conexao->query($sql);

if($result->num_rows == 0):

    $sql = "INSERT INTO tb_user (nome, usuario, senha, nivel, id_master) 
        VALUES ('$nome', '$usuario', '$senha', $nivel, ".ID_MASTER.")";

    if ($conexao->query($sql) === TRUE) {
        $last_id = $conexao->insert_id;
        echo "New record created successfully. Last inserted ID is: " . $last_id;

        //registrar log
        include_once "../auditoria/log.php";
        
        $registro = "Usuario criado: $usuario - Nome: $nome - Nível: $nivel";
        $coluna = "usuario;";
        registrar_log($registro, 'tb_user', $coluna);

        header("Location: perfil.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conexao->error;
    }
else :
    $_SESSION['erro'] = "Nome de usuário: $usuario já existe!";
    header("Location: perfil.php");
endif;

$conexao->close();

ob_end_flush();
?>