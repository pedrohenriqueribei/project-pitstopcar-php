<?php
ob_start();
    include_once "../header.php";
    //
    

    $id = $_GET['id'];

    $sql = "SELECT * FROM tb_cliente WHERE id_master = ".ID_MASTER." AND idCliente = $id";
    
    $result = $conexao->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $idCliente = $row['idCliente'];
            $nome = $row['nome'];
            $sobrenome = $row['sobrenome'];
            $telefone = $row['telefone'];
            $sexo = $row['sexo'];
            $data_nasc = $row['data_nasc'];
            $cpf = $row['cpf'];
        }
    } else {
        echo "0 results";
    }
    

    $addr = "SELECT * FROM tb_endereco WHERE id_master = ".ID_MASTER." AND id_cliente = $id";
    
    $result_add = $conexao->query($addr);

    if ($result_add->num_rows > 0) {
        // output data of each row
        while($row = $result_add->fetch_assoc()) {
            $cep = $row['cep'];
            $logradouro = $row['logradouro'];
            $complemento = $row['complemento'];
            $bairro = $row['bairro'];
            $cidade = $row['cidade'];
            $uf = $row['uf'];
            
        }
    } 
    
    $saldo = 0;
    $cont = 0;
?>

<div class="container">
    <br><h1>Compras de <?= $nome." ".$sobrenome?></h1>
    <br><br>

    <div class="form-group">
        <div class="row">   
            <div class="col-sm-4"> 
                <h2>Pesquisar</h2>
                <form action="/pitstopcar/clientes/pesquisa.php" role="form" method="post">
                    <label for="busca">Por nome</label>
                    <input type="text" name="busca" id="busca" class="form-control">
                    <br>
                    <div  style="text-align: center;"   >
                        <button type="submit" class="btn btn-primary text-uppercase mb-3 botao" >Pesquisar</button><br><br>
                    </div>
                </form>
            </div>

            <div class="col-sm-4"> 
                <h2>Pesquisar</h2>
                <form action="/pitstopcar/clientes/pesquisa_telefone.php" role="form" method="post">
                    <label for="telefone">Por telefone</label>
                    <input type="text" name="telefone" id="telefone" class="form-control" value="61 ">
                    <br>
                    <div  style="text-align: center;"   >
                        <button type="submit" class="btn btn-primary text-uppercase mb-3 botao" >Pesquisar</button><br><br>
                    </div>
                </form>
            </div>
        </div>
    </div>
       
    <br>
    
    <div style="text-align: right">
        <a href="/pitstopcar/servicos/os_clienteloc.php/?id=<?= $idCliente ?>" class="btn btn-primary text-uppercase mb-3 botao btn-lg"><i class="fas fa-plus"></i>Abrir OS</a><br><br>
    </div>
    

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
            
        <?php if($result_add->num_rows > 0): ?>
        <div class="row">
            <div class="col-sm-4">
                <label for="cep">CEP</label>
                <input name="cep" type="text" class="form-control" id="cep" value="<?= $cep ?>" size="10" maxlength="8" readonly />
            </div>

            <div class="col-sm-8">
                <label for="logradouro">Logradouro</label>
                <input name="logradouro" type="text" class="form-control" id="logradouro" value="<?= $logradouro ?>" size="200" readonly />
            </div>

            <div class="col-sm-12">
                <label for="complemento">Complemento</label>
                <input name="complemento" type="text" class="form-control" id="complemento" value="<?= $complemento ?>" size="200" readonly />
            </div>

            <div class="col-sm-6">
                <label for="bairro">Bairro</label>
                <input name="bairro" type="text" class="form-control" id="bairro" size="40" value="<?= $bairro ?>" readonly />
            </div>

            <div class="col-sm-4 col-xs-8">
                <label for="cidade">Cidade</label>
                <input name="cidade" type="text" class="form-control" id="cidade" size="40" value="<?= $cidade ?>" readonly />
            </div>
            <div class="col-sm-2 col-xs-4">
                <label for="uf">UF</label>
                <input name="uf" type="text" class="form-control" id="uf" size="2" value="<?= $uf ?>" readonly />
            </div>
        </div>
        <?php endif; ?>

        <div>
            <input style="display: none" type="number" name="idCliente" value="<?= $idCliente ?>">
        </div>
        <br>
        <div style="text-align: center">
            <a href="/pitstopcar/clientes/form_editar.php/?id=<?= $idCliente ?>" class="btn btn-primary text-uppercase mb-3 botao btn-lg">
            <i class="fas fa-plus"></i>Atualizar</a><br><br>
        </div>

    </div>
    
    <div style="text-align: right">
        <a href="/pitstopcar/servicos/os_clienteloc.php/?id=<?= $idCliente ?>" class="btn btn-primary text-uppercase mb-3 botao btn-lg"><i class="fas fa-plus"></i>Abrir OS</a><br><br>
    </div>

    

    
    <h2>Ordens de Serviços</h2>
    <br>
    <div class="table-responsive">

        <table class="table table-hover">
            <thead>
                <tr class="cab">
                    <th scope="col">ID</th>
                    <th scope="col">Data</th>
                    <th scope="col">Placa</th>
                    <th scope="col">Status</th>
                    <th scope="col">Total</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>

            <tbody>
            <?php
                    
            $sql = "SELECT s.id_negocio, id_servico, placa, dt_servico, dt_previsao, tipo, s.status, valor, total_pagar FROM tb_ordem_servico s, tb_veiculo v 
                    WHERE s.id_veiculo = v.id_veiculo AND s.id_master = ".ID_MASTER." AND cliente = $id ORDER BY dt_servico DESC";
                
            $results = $conexao->query($sql);

            if ($results->num_rows > 0) {
                // output data of each row
                
                while($row = $results->fetch_assoc()) {
                    $id_servico = $row['id_servico'];
                    $id_negocio = $row['id_negocio'];
                    $placa = $row['placa'];
                    $dt_servico = $row['dt_servico'];
                    $dt_previsao = $row['dt_previsao'];
                    $tipo = $row['tipo'];
                    $status = $row['status'];
                    $valor = $row['valor'];
                    $total_pagar = $row['total_pagar'];
                    $cont++;
                    $saldo = $saldo + $total_pagar;
                    ?>
                    <tr>
                        <td><?= $id_negocio ?></td>
                        <td><?= date('d/m/Y', strtotime($dt_servico)) ?></td>
                        <td><?= $placa ?></td>
                        
                        <td><?php switch ($status){
                            case 1: echo "Aberto"; break;   case 2: echo "Aprovado"; break;   case 3: echo "Em Manutenção"; break;   
                            case 4: echo "Aguardando Pagamento"; break;   case 5: echo "Entregue"; break;   case 6: echo "Garantia"; break;   
                            case 7: echo "Reaberto"; break;   case 8: echo "Finalizado"; break;   
                            case -1: echo "Não aprovado"; break;    case -2: echo "Insucesso"; break;
                        } ?></td>
                        <td><?= number_format($total_pagar,2,',','.') ?></td>
                        <td>
                            <a href="/pitstopcar/servicos/abrir.php/?id=<?= $id_servico?>" class="btn btn-primary text-uppercase mb-3 btn-sm">Abrir</a>
                        </td>
                    </tr>
                    <?php
                }
              } else {
                echo "0 resultados";
              }
              $conexao->close();
            
            
            ?>   

            </tbody>
        </table>
    </div>
    

    <br><br><br>

    <?php if($nivel == 1){ ?>
    <div class="row">
        <div class="col-sm-4">
            <h2>Quantidade de Serviços</h2>
            <h5 class="valores"><?= $cont ?></h5>
        </div><br>

        <div class="col sm 4">
            <h2>Total de Serviços</h2>
            <h5 class="valores">R$ <?= number_format($saldo,2,',','.') ?></h5>
        </div><br>

        <div class="col-sm-4">
            
        </div><br>
    </div>
    <?php } ?>
    <div class="row">
        <div class="col-sm-4">
        
            
        </div><br>

        <div class="col-sm-4">
        
        </div><br>
    </div>

    <div style="text-align: right">
        <a href="/pitstopcar/clientes/lista.php" class="btn btn-primary text-uppercase mb-3 botao btn-lg"><i class="fas fa-arrow-left"></i> Voltar</a><br><br>
    </div>
    
</div>

<?php
    include_once "../footer.html";
    ob_end_flush();
?>