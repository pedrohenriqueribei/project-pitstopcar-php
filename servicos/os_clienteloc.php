<?php
include_once "../header.php";

if(isset($_POST['telefone'])){
    $telefone = $_POST['telefone'];
    $sql = "SELECT * FROM tb_cliente WHERE id_master = ". ID_MASTER." AND telefone LIKE '%$telefone%'";
} elseif ($_GET['id']){
    $id = $_GET['id'];
    $sql = "SELECT * FROM tb_cliente WHERE id_master = ". ID_MASTER." AND idCliente = $id";
}


$result = $conexao->query($sql);

if($result->num_rows == 1){
    $row = $result->fetch_assoc();
    
    $idCliente = $row['idCliente'];
    $nome = $row['nome'];
    $sobrenome = $row['sobrenome'];
    $telefone = $row['telefone'];
    $sexo = $row['sexo'];
    $data_nasc = $row['data_nasc'];
    $cpf = $row['cpf'];

    $addr = "SELECT * FROM tb_endereco WHERE id_master = ". ID_MASTER." AND id_cliente = $idCliente";
    $result_addr = $conexao->query($addr);
    if($result_addr->num_rows == 1){
    $endr = $result_addr->fetch_assoc();
    $logradouro = $endr['logradouro'];
    $complemento = $endr['complemento'];
    $bairro = $endr['bairro'];
    $cidade = $endr['cidade'];
    $uf = $endr['uf'];
    $endereco = "$logradouro $complemento $bairro $cidade-$uf";
    }else{
        $endereco = "";
    }
    ?>
    <div class="container">
        <br><br>
        <h1>Nova Ordem de Serviço</h1><br><br>

        <div class="form-group">

            <div class="row">
                <div class="col-sm-4">
                    <label for="nome">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" value="<?= $nome ?>" readonly>
                </div>
            
                <div class="col-sm-4"> 
                    <label for="sobrenome">Sobrenome</label>
                    <input type="text" class="form-control" id="sobrenome" name="sobrenome" value="<?= $sobrenome ?>" readonly>
                </div>

                <div class="col-sm-4 col-xs-6"> 
                    <label for="cpf">CPF</label>
                    <input type="text" class="form-control" id="cpf" name="cpf" value="<?= $cpf ?>" readonly>
                </div>

                <div class="col-6 col-md-4 col-xs-6">
                    <label for="telefone">Telefone</label>
                    <input type="text" class="form-control" id="telefone" name="telefone" value="<?= $telefone ?>" readonly>
                </div>

                <div class="col-6 col-md-4 col-xs-6">
                    <label for="sexo">Sexo</label><br>
                    <input type="text" class="form-control" id="sexo" name="sexo" value="<?= $sexo == 1 ? "Feminino":"Masculino" ?>" readonly>
                </div>
            
                <div class="col-md-4 col-xs-6">
                    <label for="data_nasc">Data de Nascimento</label><br>
                    <input type="date" class="form-control" id="data_nasc" name="data_nasc" value="<?= $data_nasc ?>" readonly>
                </div>
                
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <label for="endereco">Endereço</label>
                    <input name="endereco" type="text" class="form-control" id="endereco" value="<?= $endereco ?>" readonly />
                </div>
            </div>

            
            <div style="text-align: center; margin-top: 10px" >      
                <a href="/pitstopcar/clientes/form_editar.php/?id=<?= $id?>" class="btn btn-primary btn-lg mt-2">Atualizar Dados do Cliente</a>
            </div>
                        
                
        </div>

        <a href="/pitstopcar/servicos/os_loccliente.php" class="btn btn-primary btn-lg">
            <i class="fas fa-arrow-left"></i>
            Voltar
        </a>
        <br><br>

        <h2>Localizar Carro</h2><br>

        <form action="/pitstopcar/servicos/os_locveiculo.php#placa" role="form" method="post" >
            <div class="form-group">

                <div class="row">
                    <div class="col-sm-3">
                        <label for="placa">Placa</label>
                        <input type="text" class="form-control" id="placa" name="placa" >
                    </div>

                    <div class="col-sm-3">
                        <label for="marca">Marca</label>
                        <input type="text" name="marca" id="marca" class="form-control" readonly>
                    </div>

                    <div class="col-sm-3">
                        <label for="modelo">Modelo</label>
                        <input type="text" name="modelo" id="modelo" class="form-control" readonly>
                    </div>
                    
                    <div class="col-6 col-md-3"> 
                        <label for="ano">Ano Fabricação</label>
                        <input type="text" name="ano" id="ano" class="form-control" readonly>
                    </div>
                </div>

                <div class="row">
                    <div style="text-align: center; margin-top: 10px" >
                        <button type="submit" class="btn btn-primary btn-lg">Localizar</button>
                        <a href="/pitstopcar/servicos/os_locveiculo.php/?placa=JcXeO091&idCliente=<?= $idCliente?>" class="btn btn-primary btn-lg">Cadastrar Veículo</a>
                    </div>
                </div>
                   
            </div>
            <input type="number" name="idCliente" id="idClient" value="<?= $idCliente?>" style="display: none">

        </form>
    </div>
    <?php

} elseif($result->num_rows > 1){
    header("Location: /pitstopcar/clientes/pesquisa.php/?busca=".$telefone);
} else {
    ?>
    <div class="container">
        <br>
        <div class="alert alert-warning" role="alert">
            Cliente não localizado!
        </div>
        <br><br>
        <div> 
            <a href="../clientes/form.php/?telefone=<?= $telefone?>" role="button" class="btn btn-primary text-uppercase mb-3 col-6 col-md-4 botao_salvar">Cadastrar Novo Cliente</a>
        </div>
        <br>
        <div>
            <a href="../clientes/lista.php" role="button" class="btn btn-primary text-uppercase mb-3 col-6 col-md-4 botao_salvar">Listar Clientes</a>
        </div>
        <br><br><br>
    </div>
    <?php
}



include_once "../footer.html";

?>