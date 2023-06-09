<?php
include_once "../header.php";

if(isset($_POST['placa'])){
    $placa = $_POST['placa'];
    $idCliente = $_POST['idCliente'];
} elseif (isset($_GET['placa'])){
    $placa = $_GET['placa'];
    $idCliente = $_GET['idCliente'];
}

$sql = "SELECT * FROM tb_cliente WHERE id_master = ". ID_MASTER." AND idCliente = $idCliente";
$result = $conexao->query($sql);

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
} else {
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
          
    </div>

    <a href="/pitstopcar/servicos/os_clienteloc.php/?id=<?= $idCliente?>" class="btn btn-primary btn-lg">
        <i class="fas fa-arrow-left"></i>
        Voltar
    </a>
    <br><br>

    <h2>Veículo</h2><br>

    <?php
    $sql = "SELECT * FROM tb_veiculo WHERE id_master = ". ID_MASTER." AND placa LIKE '%$placa%'";
    $result = $conexao->query($sql);

    if($result->num_rows == 1):
        $row = $result->fetch_assoc();
        $id_veiculo = $row['id_veiculo'];
        $placa = $row['placa'];
        $marca = $row['marca'];
        $modelo = $row['modelo'];
        $ano = $row['ano'];
    ?>
    
    <div class="form-group">

        <div class="row">
            <div class="col-sm-3">
                <label for="placa">Placa</label>
                <input type="text" class="form-control" id="placa" name="placa" value="<?= $placa?>" readonly>
            </div>

            <div class="col-sm-3">
                <label for="marca">Marca</label>
                <input type="text" name="marca" id="marca" class="form-control" value="<?= $marca?>"  readonly>
            </div>

            <div class="col-sm-3">
                <label for="modelo">Modelo</label>
                <input type="text" name="modelo" id="modelo" class="form-control" value="<?= $modelo?>"  readonly>
            </div>
            
            <div class="col-6 col-md-3"> 
                <label for="ano">Ano Fabricação</label>
                <input type="text" name="ano" id="ano" class="form-control" value="<?= $ano?>"  readonly>
            </div>
        </div>

    </div>
    
    <br>
    <h3>Informações Adicionais</h3>
    <form action="/pitstopcar/servicos/os_solicitar.php" role="form" method="post" enctype="multipart/form-data">
        <div class="form-group">
            
            <div class="row">
            
                <div class="col-sm-3">
                    <label for="km">KM</label>
                    <input type="number" name="km" id="km" class="form-control" min="0" required>
                </div>

                <div class="col-sm-3">
                    <label for="tipo">Tipo</label>
                    <select name="tipo" id="tipo" class="form-control custom-select">
                        <option value="Manutenção">Manutenção</option>
                        <option value="Venda">Venda</option>
                        <option selected value="Serviço">Serviço</option>
                        <option value="Orçamento">Orçamento</option>
                    </select>
                </div>

                <div class="col-sm-3">
                    <label for="dt_previsao">Previsão para</label>
                    <input type="date" class="form-control" id="dt_previsao" name="dt_previsao" value="<?= $dt = date('Y-m-d') ?>">
                </div>

                <div class="col-sm-3">
                    <label for="mecanico">Mecânico</label>
                    <select class="form-control" id="mecanico" name="mecanico" required>
                        <option disabled selected>Selecione um mecânico</option>
                        <?php 
                        $sql = "SELECT * FROM tb_user WHERE id_master = ".ID_MASTER." AND nivel = 3";
                        $result = $conexao->query($sql);
                        if($result->num_rows > 0){
                            while($row = $result->fetch_assoc()){
                                $id_user = $row['id_user'];
                                $usuario = $row['usuario'];
                                $nome = $row['nome'];
                                ?>
                                <option value="<?= $id_user?>"><?= $nome ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>
            
                <div class="col-sm-12">
                    <label for="observacao">Observação</label>
                    <textarea name="observacao" id="observacao" class="form-control" rows="3" ></textarea>
                </div>
            </div>
            <br><br>
            <div class="row mt-5">
                <div class="col-6 col-md-3">
                    <label for="foto1">Foto 1</label>
                    <input type="file" name="foto1" class="form-control form-control-file" accept="image/*" capture>
                </div>

                <div class="col-6 col-md-3">
                    <label for="foto2">Foto 2</label>
                    <input type="file" name="foto2" class="form-control form-control-file" accept="image/*" capture>
                </div>

                <div class="col-6 col-md-3">
                    <label for="foto3">Foto 3 </label>
                    <input type="file" name="foto3" class="form-control form-control-file" accept="image/*" capture>
                </div>

                <div class="col-6 col-md-3">
                    <label for="foto4">Foto 4 </label>
                    <input type="file" name="foto4" class="form-control form-control-file" accept="image/*" capture>
                </div>

                <div class="col-6 col-md-3">
                    <label for="foto5">Foto 5 </label>
                    <input type="file" name="foto5" class="form-control form-control-file" accept="image/*" capture>
                </div>
            </div>

            
            <input type="number" name="idCliente" id="idCliente" value="<?= $idCliente?>" style="display: none">
            <input type="number" name="id_veiculo" id="id_veiculo" value="<?= $id_veiculo?>" style="display: none">

            <br><br>

            <div style="text-align: center; margin-top: 10px" >
                <button type="submit" class="btn-block btn btn-primary btn-lg">Solicitar OS</button>
            </div>
        </div>
           
    </form>

    <?php 
    elseif ($result->num_rows > 1):
    ?>

                
    <h4>Selecione um veículo</h4>
    <div class="table-responsive">
        <table class="table table-hover table-sm">
            <thead>
                <tr class="cab">
                    <th scope="col">Placa</th>
                    <th scope="col">Marca</th>
                    <th scope="col">Modelo</th>
                    <th scope="col"></th>
                </tr>
            </thead>

            <tbody><?php
            while ($row = $result->fetch_assoc()):
                $placa = $row['placa'];
                $marca = $row['marca'];
                $modelo = $row['modelo'];
                ?>
                <tr>
                    <td><?= $placa?></td>
                    <td><?= $marca?></td>
                    <td><?= $modelo?></td>
                    <td><a href="/pitstopcar/servicos/os_locveiculo.php/?placa=<?= $placa?>&idCliente=<?= $idCliente?>#placa">Selecionar</a></td>
                </tr>
            <?php endwhile ?>
            </tbody>
        </table>
    </div>
       
    <?php 
    elseif ($result->num_rows == 0):
    ?>
    <div class="alert alert-warning" role="alert">
        Veículo não encontrado na base!
    </div><br><br>

    <h3>Cadastrar Veiculo</h3>
    <form action="/pitstopcar/servicos/os_cadveiculo.php" role="form" method="post" >
        <div class="form-group">
            <div class="row">
                <div class="col-sm-3">
                    <label for="placa">Placa</label>
                    <input type="text" class="form-control" id="placa" name="placa" value="<?= $placa ?>">
                </div>

                <div class="col-sm-3">
                    <label for="marca">Marca</label>
                    <select class="form-control" id="marca" name="marca" required>
                        <?php
                        $sql = "SELECT * FROM tb_marca WHERE id_master = ".ID_MASTER." ORDER BY descricao ASC";
                        $result = $conexao->query($sql);

                        while ($row = $result->fetch_assoc()) {
                            $id_categoria = $row['id_marca'];
                            $desc_categoria = $row['descricao'];
                            ?>
                            <option value="<?= $desc_categoria ?>"><?= $desc_categoria ?></option>
                            <?php
                        }
                        ?>  
                    </select>
                </div>

                <div class="col-sm-3">
                    <label for="modelo">Modelo</label>
                    <input type="text" name="modelo" id="modelo" class="form-control" >
                </div>
                
                <div class="col-6 col-md-3"> 
                    <label for="ano">Ano Fabricação</label>
                    <select class="form-control" id="ano" name="ano">
                        <?php
                        
                        for ($i=2021; $i > 1980; $i--) { 
                            ?>
                            <option value="<?= $i?>"><?= $i?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="row">
                <div style="text-align: center; margin-top: 10px" >
                    <button type="submit" class="btn btn-primary btn-lg">Cadastrar</button>
                </div>
            </div>
                
        </div>
        <input type="number" name="idCliente" id="idCliente" value="<?= $idCliente?>" style="display: none">

    </form>
    <?php
    endif; ?>
</div>


<?php
$conexao->close();
include_once "../footer.html";
?>