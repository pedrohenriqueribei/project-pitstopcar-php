<?php if (!isset($_SESSION)) session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Pit Stop Car - Estética Automotiva</title>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="/pitstopcar/recursos/img/logo.jpg" type="image/x-icon" />
    
    <!-- <link href='/pitstopcar/recursos/css/bootstrap.min.css' rel='stylesheet' type='text/css'> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

    <link href="/pitstopcar/recursos/css/fontawesome.css" rel="stylesheet" type='text/css'>

    <link href="/pitstopcar/recursos/css/estilo.css" rel="stylesheet">
</head>
<body id="reportsPage">

<?php
    include "DB/Sql.php";
    define("ID_MASTER", 4686);

    date_default_timezone_set('America/Sao_Paulo');
    
    
    if (!isset($_SESSION['usuario']) || $_SESSION['logado'] != TRUE || ($_SESSION['master'] != ID_MASTER AND $_SESSION['master'] != 4687 )){
        header("Location: /pitstopcar/entrar/logout.php");
    } 

    $sql = "SELECT nivel FROM tb_user WHERE usuario = '".$_SESSION['usuario']."' AND id_master = ".ID_MASTER;
    $result = $conexao->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $nivel = $row['nivel'];
        }
    }
?>




<nav class="navbar navbar-expand-lg navbar-light bg-light" style="padding:10px; background-color: black">
    <div class="container-fluid">
        <a class="navbar-brand" href="/dfmultimarcas/index.php" target="_blank"><img src="/pitstopcar/recursos/img/logo.jpg" height="70" alt="Pit Stop Car"></a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="padding:10px">
            
                <li class="nav-item">
                    <a href="/pitstopcar/index.php" class="nav-link active">
                    <div style="text-align:center"><i class="fas fa-laptop-house fa-2x"></i><br> Home</div></a>
                </li>
                <li class="nav-item">
                    <a href="/pitstopcar/servicos/dodia.php" class="nav-link">
                    <div style="text-align:center"><i class="far fa-newspaper fa-2x"></i><br>Ordens de Serviços</div></a>
                </li>
                <li class="nav-item">
                    <a href="/pitstopcar/veiculo/lista.php" class="nav-link">
                    <div style="text-align:center"><i class="fa fa-car fa-2x" aria-hidden="true"></i><br>Veículos</div></a>
                </li>
                <li class="nav-item">
                    <a href="/pitstopcar/clientes/lista.php" class="nav-link">
                    <div style="text-align:center"><i class="fa fa-users fa-fw fa-2x"></i><br>Clientes</div></a>
                </li>
                <li class="nav-item">
                    <a href="/pitstopcar/despesas/lista.php" class="nav-link">
                    <div style="text-align:center"><i class="fa fa-credit-card fa-2x" aria-hidden="true"></i><br>Despesas</div></a>
                </li>
                <?php if($nivel == 1) { ?>
                <li class="nav-item">
                    <a href="/pitstopcar/faturamento/form.php" class="nav-link">
                    <div style="text-align:center"><i class="fas fa-file-invoice-dollar fa-2x"></i><br>Faturamento</div></a>
                </li>
                <?php } ?>
                <li class="nav-item">
                    <a href="/pitstopcar/produtos/lista.php" class="nav-link">
                    <div style="text-align:center"><i class="fa fa-cogs fa-2x" aria-hidden="true"></i><br> Produtos & Peças</div></a>
                </li>
                <li class="nav-item">
                    <a href="/pitstopcar/pedido/lista.php" class="nav-link">
                    <div style="text-align:center"><i class="fa fa-list-alt fa-2x" aria-hidden="true"></i><br> Pedidos</div></a>
                </li>
                <li class="nav-item">
                    <a href="/pitstopcar/entrar/perfil.php" class="nav-link">
                    <div style="text-align:center"><i class="fas fa-user fa-2x" aria-hidden="true"></i> <br>           
                    <?php $sql = "SELECT nome FROM tb_user WHERE id_master = ".ID_MASTER." AND usuario = '".$_SESSION['usuario']."'";
                    $query = $conexao->query($sql);
                    $array = $query->fetch_assoc();
                    echo $array['nome'];
                    ?>
                    </div></a>
                </li>
            </ul>
            <ul class="nav justify-content-end" >
                <li class="nav-item" >
                    <a href="/pitstopcar/entrar/logout.php" class="nav-link" style="color: gray">
                    <div style="text-align:center"><i class="fas fa-sign-out-alt fa-2x"></i><br> Sign Out</div></a>
                </li>
            </ul> 
        </div> 
    </div>
</nav>
   