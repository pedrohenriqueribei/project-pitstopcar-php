<?php
session_start();

//

$nome = $_POST['nome'];
$usuario = $_POST['usuario'];
$senha = $_POST['senha'];
$nova_senha = $_POST['nova_senha'];
$id_user  = $_POST['id_user'];
$nivel = $_POST['nivel'];

if ($senha != $nova_senha){

    

    $_SESSION['erro_nova_senha'] = "As senhas deve ser iguais";

    header("Location: perfil.php");
}
else {
    $update = "UPDATE tb_user SET nome = '$nome' , usuario = '$usuario', senha = '$nova_senha', nivel = '$nivel' WHERE id_user = $id_user";

    if ($conexao->query($update) === TRUE) {
        echo "Record updated successfully";
        $_SESSION['erro_nova_senha'] = null;

        //registrar log
        include_once "../auditoria/log.php";
        $usuario_autor = $_SESSION['usuario'];
        $registro = "Usuario atualizado - ".$usuario." atualizado por ".$usuario_autor;
        $coluna = "usuario; senha; nivel";
        registrar_log($registro, $usuario_autor, 'tb_user', $coluna);
    } else {
        echo "Error updating record: " . $conexao->error;
    }
    
    $conexao->close();

    

    header("Location: logout.php");
}

?>