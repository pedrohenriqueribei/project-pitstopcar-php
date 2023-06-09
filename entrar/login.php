<?php session_start(); ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Pit Stop Car - Estética Automotiva - Soluções Automotivas</title>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="/pitstopcar/recursos/img/logo.jpg" type="image/x-icon" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700">
    <link rel="stylesheet" href="/pitstopcar/recursos/css/fontawesome.css">
    <link rel="stylesheet" href="/pitstopcar/recursos/css/bootstrap.min.css">
    <link rel="stylesheet" href="/pitstopcar/recursos/css/estilo.css">
    <!-- <link rel="stylesheet" href="/pitstopcar/recursos/css/templatemo-style.css"> -->
    <!-- <link href="/pitstopcar/recursos/css/font-awesome.min.css" rel="stylesheet"> -->
    <script src="/pitstopcar/recursos/js/jquery-3.5.1.min.js"></script>
    <script src="/pitstopcar/recursos/js/popper.min.js" ></script>
    <script src="/pitstopcar/recursos/js/bootstrap.js"></script>
    <script type="text/javascript" src="/pitstopcar/recursos/js/fontawesome.js"></script>
    <script src="/pitstopcar/recursos/js/jquery.mask.min.js"></script>
    <script src="/pitstopcar/recursos/js/bootstrap-notify.min.js"></script>
    <script type="text/javascript" src="/pitstopcar/recursos/js/cep.js"></script>
    <script type="text/javascript" src="/pitstopcar/recursos/js/main.js"></script>

    <meta name="viewport" content="initial-scale=1.0, user-scalable=no"/>
</head>

<body class="light-gray-bg">



<div class="container templatemo-content-widget templatemo-login-widget white-bg" style="width:300px; margin-top: 100px; border-radius: 15px; border: 2px solid #f3f3f3" >

    
    

    
    
    <form role="form" action="logger.php" method="post" class="templatemo-login-form">
        
        <div class="form-group">
            <div class="tm-bg-primary-dark tm-block tm-block-h-auto">
                <div class="row">
                    <div class="col-12 text-center">
                    <h2 class="tm-block-title mb-4">Bem-vindo ao Sistema de Gerenciamento de Serviços</h2>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-user fa-fw"></i></div>
                    <input type="text" name="usuario" id="usuario" class="form-control" autocomplete="off" maxlength="45" required>
                </div>
            </div>
            
            <div class="form-group">
	        	<div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-key fa-fw"></i></div>
                    <input type="password" name="senha" id="senha" class="form-control" autocomplete="off" maxlength="45" required>
                </div>
            </div>
        </div>

        <div style="text-align: center;"   >
            <button type="submit" class="btn btn-primary btn-lg w-5" >Entrar</button><br><br>
        </div>

        <?php
        
        if(isset($_SESSION['erro'])){
            ?>
            <div class="alert alert-danger" role="alert">
                <h6><?= $_SESSION['erro'] ?></h6>
            </div>  
            <?php
        }
        ?>
    </form>
</div>

<?php
include_once "../footer.html";
?>