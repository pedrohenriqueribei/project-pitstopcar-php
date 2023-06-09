<?php 
    include_once "../header.php";
    //

    if(isset($_POST['search'])){
        
        $search = $_POST['search'];
        $_SESSION['search'] = $search;
    
    } else {
        $search = $_SESSION['search'];
    }

?>


<div class="container">
    <br><br>
    <h1>Pesquisa de Veículo: <?= $search ?></h1> <br><br>

    <br><br>

    <h3>Veículos</h3>


    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr class="cab">
                    <th scope="col">ID</th>
                    <th scope="col">Placa</th>
                    <th scope="col">Modelo</th>
                    <th scope="col">Marca</th>
                    <th scope="col">Ano</th>
                </tr>
            </thead>
            <tbody>
                
                <?php
                    
                    $sql = "SELECT * FROM tb_veiculo 
                            WHERE id_master = ".ID_MASTER." AND (placa like '%$search%' OR modelo like '%$search%' OR 
                            ano like '%$search%' OR marca like '%$search%' ) ORDER BY 1 ASC";
                    
                    $results = $conexao->query($sql);

                    if ($results->num_rows > 0) {
                        // output data of each row
                        while($row = $results->fetch_assoc()) {
                            $id_veiculo = $row['id_veiculo'];
                            
                            $placa = $row['placa'];
                            $modelo = $row['modelo'];
                            $marca = $row['marca'];
                            $ano = $row['ano'];
                        

                
                        
                            ?>
                            <tr>  
                                <td><?= $id_veiculo ?></td>
                                <td><a href="/pitstopcar/veiculo/abrir.php/?id=<?php  echo $id_veiculo?>" class="btn btn-primary text-uppercase mb-3" ><i class="fas fa-clipboard-list"></i> <?= $placa ?></a></td>
                                <td><?= $modelo ?></td>
                                <td><?= $marca ?></td>
                                <td><?= $ano  ?></td>
                            </tr>
                    <?php 
                    }
                } else {
                    echo "0 results";
                }
                
                

                ?>
                    
            </tbody>
        </table>
        <br><br>
    </div>
        
    <br><br>       
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
                        WHERE s.id_master = ".ID_MASTER." AND (v.placa like '%$search%' OR v.modelo like '%$search%' OR 
                        v.ano like '%$search%' OR v.marca like '%$search%' )
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
                                    <a href="../servicos/abrir.php/?id=<?= $id_servico?>" class="btn btn-primary text-uppercase mb-3 btn-sm">Abrir</a>
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