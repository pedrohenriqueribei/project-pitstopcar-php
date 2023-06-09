<?php

include_once "../header.php";

$id = $_GET['id'];

$sql = "SELECT * FROM tb_cliente WHERE id_master = ".ID_MASTER." AND idCliente = $id";
$result = $conexao->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    $row = $result->fetch_assoc();
    
    $idCliente = $row['idCliente'];
    $nome = $row['nome'];
    $sobrenome = $row['sobrenome'];
    $telefone = $row['telefone'];
    $sexo = $row['sexo'];
    $data_nasc = $row['data_nasc'];
    $cpf = $row['cpf'];
} else {
    echo "0 results";
}



$addr = "SELECT * FROM tb_endereco WHERE id_master = ".ID_MASTER." AND id_cliente = $id";
$result_add = $conexao->query($addr);

if ($result_add->num_rows > 0) {

    $endr = $result_add->fetch_assoc();

    $cep = $endr['cep'];
    $logradouro = $endr['logradouro'];
    $complemento = $endr['complemento'];
    $bairro = $endr['bairro'];
    $cidade = $endr['cidade'];
    $uf = $endr['uf'];

} else {
    echo "0 results";
}
?>

<div class="container">

<?php if(isset($_SESSION['erro_endereco'])):
?>
    <div class="alert alert-danger" role="alert">
        <?= $_SESSION['erro_endereco'] ?>
    </div>
<?php endif; ?>


<br><h1>Editar Cliente</h1>

    <div class="row tm-content-row">
        <div class="col-12 tm-block-col">
            <div class="tm-bg-primary-dark tm-block tm-block-h-auto">

                <form role="form" action="/pitstopcar/clientes/_atualizar.php" method="post">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="nome">Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome" value="<?= $nome ?>" required>
                            </div>
                        
                            <div class="col-sm-4"> 
                                <label for="sobrenome">Sobrenome</label>
                                <input type="text" class="form-control" id="sobrenome" name="sobrenome" value="<?= $sobrenome ?>" required>
                            </div>

                            <div class="col-sm-4 col-xs-6"> 
                                <label for="cpf">CPF</label>
                                <input type="text" class="form-control" id="cpf" name="cpf" value="<?= $cpf ?>" >
                            </div>

                            <div class="col-6 col-md-4 col-xs-6">
                                <label for="telefone">Telefone</label>
                                <input type="tel" class="form-control" id="telefone" name="telefone" value="<?= $telefone ?>" required>
                            </div>

                            <div class="col-6 col-md-4 col-xs-6">
                                <label for="sexo">Sexo</label><br>
                                <select class="form-control custom-select" id="sexo" name="sexo" required>
                                    <option value="1" <?php if($sexo == 1) echo "selected"?>>Feminino</option>
                                    <option value="2" <?php if($sexo == 2) echo "selected"?>>Masculino</option>
                                </select>
                            </div>
                        
                            <div class="col-6 col-md-4 col-xs-6">
                                <label for="data_nasc">Data de Nascimento</label><br>
                                <input type="date" class="form-control" id="data_nasc" name="data_nasc" value="<?= $data_nasc ?>">
                            </div>

                            
                            
                            <div class="col-sm-4">
                                <label for="cep">CEP</label>
                                <input name="cep" type="text" class="form-control" id="cep" value="<?= isset($cep) ? $cep : '' ?>" size="10" maxlength="10" />
                            </div>

                            <div class="col-sm-8">
                                <label for="logradouro">Logradouro</label>
                                <input name="logradouro" type="text" class="form-control" id="logradouro" value="<?= isset($logradouro) ? $logradouro : '' ?>" size="200" />
                            </div>

                            <div class="col-sm-12">
                                <label for="complemento">Complemento</label>
                                <input name="complemento" type="text" class="form-control" id="complemento" value="<?= isset($complemento) ? $complemento : '' ?>" size="200" />
                            </div>

                            <div class="col-sm-6">
                                <label for="bairro">Bairro</label>
                                <input name="bairro" type="text" class="form-control" id="bairro" size="40" value="<?= isset($bairro) ? $bairro : '' ?>" />
                            </div>

                            <div class="col-sm-4 col-xs-8">
                                <label for="cidade">Cidade</label>
                                <input name="cidade" type="text" class="form-control" id="cidade" size="40" value="<?= isset($cidade) ? $cidade : '' ?>" />
                            </div>
                            <div class="col-sm-2  col-xs-4">
                                <label for="uf">UF</label>
                                <input name="uf" type="text" class="form-control" id="uf" size="2" value="<?= isset($uf) ? $uf : '' ?>" />
                            </div>
                            



                            <div>
                                <input style="display: none" type="number" name="idCliente" value="<?= $idCliente ?>">
                            </div>
                        </div>
                    </div>
                    <div style="text-align: center;"   >
                        <button type="submit" class="btn btn-primary text-uppercase mb-3 botao_salvar btn-lg col-sm-4" >Atualizar</button><br><br>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>

</div>

<?php
$conexao->close();
if(isset($_SESSION['erro_endereco'])) unset($_SESSION['erro_endereco']);
include_once "../footer.html";
?>