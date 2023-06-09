<?php 
    include_once "../header.php";
    //

    $id_veiculo = $_GET['id'];

    $sql = "SELECT * FROM tb_veiculo WHERE id_veiculo = $id_veiculo";
    $result = $conexao->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $placa = $row['placa'];
        $marca = $row['marca'];
        $modelo = $row['modelo'];
        $ano = $row['ano'];
    
    } else {
        echo "0 results";
    }

?>

<div class="container">

    <br><h1>Veículo <?= $modelo." ".$placa?></h1><br><br>   

    
    <div class="form-group">

        <h2>Dados do Veículo</h2><br><br>
        <div class="row">

            <div class="col-sm-3">
                <label for="placa">Placa</label>
                <input type="text" class="form-control" id="placa" name="placa" maxlength="8" value="<?= $placa?>" disabled>
            </div>

            <div class="col-sm-3"> 
                <label for="modelo">Modelo</label>
                <input type="text" class="form-control" id="modelo" name="modelo" value="<?= $modelo?>" disabled>
            </div>

            <div class="col-6 col-md-3">
                <label for="marca">Marca</label>
                <input type="text" class="form-control" id="marca" name="marca" value="<?= $marca?>" disabled>
            </div>

            <div class="col-6 col-md-3"> 
                <label for="ano">Ano Fabricação</label>
                <input type="text" class="form-control" id="ano" name="ano" value="<?= $ano?>" disabled>
            </div>
        </div>
    </div>

  
    
    <div class="d-inline-flex justify-content-center">

        <a href="/pitstopcar/veiculo/editar.php/?id=<?= $id_veiculo ?>" class="btn btn-primary text-uppercase mb-3">Editar</a>
    
        <a href="/pitstopcar/veiculo/ver_fotos.php/?id=<?= $id_veiculo ?>" class="btn btn-primary text-uppercase mb-3"> Ver Fotos</a>
        
    </div>

    <br><br><br>
                
    <h2>Serviços Relacionados ao Veículo</h2>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr class="cab">
                    <th scope="col">ID</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Telefone</th>
               
                    <th scope="col">Data</th>
                    <th scope="col">Previsão</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Status</th>
                    <th scope="col">Total a pagar</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                <?php
                    $sql = "SELECT s.id_servico, s.dt_servico, s.dt_previsao, s.tipo, s.status, s.valor, s.total_pagar, 
                        c.nome, c.sobrenome, c.telefone
                        FROM tb_ordem_servico s 
                        INNER JOIN tb_cliente c ON c.idCliente = s.cliente
                        INNER JOIN tb_veiculo v ON s.id_veiculo = v.id_veiculo
                        WHERE s.id_master = ".ID_MASTER." AND s.id_veiculo = $id_veiculo
                        ORDER BY s.dt_servico DESC";

                    $result = $conexao->query($sql);

                    if ($result->num_rows > 0) {
                        // output data of each row
                        while($row = $result->fetch_assoc()) {
                            $id_servico = $row['id_servico'];
                            
                            $dt_servico = $row['dt_servico'];
                            $dt_previsao = $row['dt_previsao'];
                            $tipo = $row['tipo'];
                            $status = $row['status'];
                            $valor = $row['valor'];
                            $total_pagar = $row['total_pagar'];
                            $nome = $row['nome'];
                            $sobrenome = $row['sobrenome'];
                            $telefone = $row['telefone'];

                            ?>
                            <tr>
                                <td><?= $id_servico ?></td>
                                <td><?= $nome." ".$sobrenome ?></td>
                                <td><?= $telefone ?></td>
                                
                                <td><?= date('d/m/Y', strtotime($dt_servico)) ?></td>
                                <td><?= date('d/m/Y', strtotime($dt_previsao)) ?></td>
                                <td><?= $tipo ?></td>
                                <td><?php switch ($status){
                                    case 1: echo "Aberto"; break;   case 2: echo "Aprovado"; break;   case 3: echo "Em Manutenção"; break;   
                                    case 4: echo "Aguardando Pagamento"; break;   case 5: echo "Entregue"; break;   case 6: echo "Garantia"; break;   
                                    case 7: echo "Reaberto"; break;   case 8: echo "Finalizado"; break;   
                                    case -1: echo "Não aprovado"; break;    case -2: echo "Insucesso"; break;
                                } ?></td>
                                <td>R$ <?= number_format($total_pagar,2,',','.') ?></td>
                                <td>
                                    <a href="/pitstopcar/servicos/abrir.php/?id=<?= $id_servico?>" class="btn btn-primary text-uppercase mb-3 btn-sm">Abrir OS</a>
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
</div>



<?php
    include_once "../footer.html";
?>