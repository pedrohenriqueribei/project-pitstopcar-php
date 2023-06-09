<?php


function registrar_log ($registro, $tabela, $coluna) {
    if(!isset($_SESSION)) session_start();
    

    $usuario = $_SESSION['usuario'];
    $id_master = $_SESSION['master'];

    include "../DB/Sql.php";

    $ip = get_client_ip();
    $sql = "INSERT INTO tb_log (registro, usuario, tabela, coluna, dt_log, ip, id_master) 
            VALUES ('$registro', '$usuario', '$tabela', '$coluna', now(), '$ip', $id_master)";

    if ($conexao->query($sql) === TRUE) {
        echo "New record created successfully";
    }
    else {
        echo "Error: " . $sql . "<br>" . $conexao->error;
    }
    $conexao->close();
}





    function get_client_ip() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }



?>