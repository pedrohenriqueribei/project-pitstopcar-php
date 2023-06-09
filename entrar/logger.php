<?php 
ob_start();
    include_once "../header.php";
    //
    

    
    $usuario = mysqli_real_escape_string($conexao, $_POST['usuario']);
    $senha = mysqli_real_escape_string($conexao, $_POST['senha']);
    
    

    if (!isset($_SESSION)) session_start();

    echo $sql = "SELECT * FROM tb_user WHERE id_master = ".ID_MASTER." AND usuario = '$usuario'";
    $result = $conexao->query($sql);

    
    
    if ($result->num_rows > 0) {

        $array = $result->fetch_assoc();
        
        $bd_usuario = $array['usuario'];
        $bd_senha = $array['senha'];
        $bd_id_master = $array['id_master'];

        if ($bd_id_master == ID_MASTER AND $bd_usuario == $usuario AND $bd_senha == $senha) {
            
            $_SESSION['usuario'] = $bd_usuario;
            $_SESSION['logado'] = TRUE;
            $_SESSION['master'] = $bd_id_master;

            //registrar log
            include_once "../auditoria/log.php";
            $registro = "Usuario logado";
            $coluna = "usuario; senha;";
            registrar_log($registro, 'tb_user', $coluna);
            
            
            header("Location: /pitstopcar/index.php");
        }
        else {
            $_SESSION['erro'] = "Usuário ou senha inválidos";
            //header("Location: login.php");
        }
    }

    else {
        if (!isset($_SESSION)) session_start();
        $_SESSION['erro'] = "Usuário ou senha inválidos";
        //header("Location: login.php");
    }

ob_end_flush();
?>