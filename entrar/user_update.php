<?php
    
    ob_start();
    include_once "../header.php";
    //

    $nome = $_POST['nome'];
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];
    $nova_senha = $_POST['nova_senha'];
    $id_user = $_POST['id_user'];
    $nivel = $_POST['nivel'];

    if ($senha != $nova_senha) {
        $_SESSION['erro_nova_senha'] = "As senhas devem ser iguais.";
        header("Location: perfil.php");
        exit;
    }
    else {
        $update = "UPDATE tb_user SET nome = '$nome' , usuario = '$usuario', senha = '$nova_senha', nivel = '$nivel' WHERE id_user = $id_user";

        if ($conexao->query($update) === TRUE) {
            echo "Record updated successfully";
            unset($_SESSION['erro_nova_senha']);

            //registrar log
            include_once "../auditoria/log.php";
            
            $registro = "Usuario atualizado: $usuario -  Nome: $nome - Nível: $nivel";
            $coluna = "usuario;";
            registrar_log($registro, 'tb_user', $coluna);
        } else {
            echo "Error updating record: " . $conexao->error;
        }
          
        $conexao->close();

        header("Location: perfil.php");
        exit;
    }

    ob_end_flush();
?>