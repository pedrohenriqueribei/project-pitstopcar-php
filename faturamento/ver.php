<?php

include_once "../header.php";
//

if($nivel == 1) {

    $ano = $_POST['ano'];
    $mes = $_POST['mes'];

?>

<div class="container">

    <br>
    <h1>Faturamento  
    <?php switch ($mes) {
        case 1: echo "Janeiro/$ano"; break; case 2: echo "Fevereiro/$ano"; break; case 3: echo "Março/$ano";     break;   
        case 4: echo "Abril/$ano"  ; break; case 5: echo "Maio/$ano";      break; case 6: echo "Junho/$ano";     break;
        case 7: echo "Julho/$ano"  ; break; case 8: echo "Agosto/$ano";    break; case 9: echo "Setembro/$ano";  break;
        case 10: echo "Outubro/$ano";break; case 11: echo "Novembro/$ano"; break; case 12: echo "Dezembro/$ano"; break;
    } ?></h1><br>

    
    <?php
        $total = 0;
        $tx = 0;
        $desc = 0;
        $sql = "SELECT sum(valor), sum(taxa_entrega), sum(desconto) FROM tb_ordem_servico 
        WHERE id_master = ". ID_MASTER ." AND YEAR(dt_servico) = $ano AND MONTH(dt_servico) = $mes
        AND status >= 4 group by YEAR(dt_servico), month(dt_servico)";
        $result = $conexao->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            $array = $result->fetch_assoc();
            
            $total = $array['sum(valor)'];
            $tx = $array['sum(taxa_entrega)'];
            $desc = $array['sum(desconto)'];
        } else {
        echo "0 results";
        }


        $sql = "SELECT sum(total) FROM tb_despesa WHERE id_master = ". ID_MASTER ." AND YEAR(dt_compra) = $ano AND MONTH(dt_compra) = $mes";                              
        $result = $conexao->query($sql);

        if ($result->num_rows > 0) {
        // output data of each row
            while($row = $result->fetch_assoc()) {
                $despesas = $row['sum(total)'];
            }

            
        } else {
        echo "0 results";
        }

        $sql = "SELECT sum(vl_prest) as pedidos FROM tb_cprestacao WHERE id_master =  ". ID_MASTER ." AND YEAR(dt_pag) = $ano AND MONTH(dt_pag) = $mes";
        $result = $conexao->query($sql);
        $row = $result->fetch_assoc();
        $total_pedidos = $row['pedidos'];

        $lucro = $total - $despesas - $desc + $tx - $total_pedidos;
    ?>
                                
    <div class="row">
        <!-- Total faturado em serviços prestados -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total em Serviços (Mensal)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">R$ <?= number_format($total,2,',','.') ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-car fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total faturado em despesas -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total em Despesas (Mensal)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">R$ <?= number_format($despesas,2,',','.') ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-credit-card fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Total faturado em entregas -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total em Fretes (Mensal)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">R$ <?= number_format($tx,2,',','.') ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-truck fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total faturado em descontos -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total em Descontos (Mensal)</div>
                                <?php if ($desc == 0) $porcem = 0; else  $porcem = $desc*100/($total+$desc)  ?>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">R$ <?= number_format($desc,2,',','.')." (".number_format($porcem,2,',','.')."%)" ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-hand-holding-usd fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        

        <!-- Total em lucros -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Lucro (Mensal)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <p <?= $lucro < 0 ? "style=background-color:red;color:white" : "" ?>>R$ <?= number_format($lucro,2,',','.') ?></p>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="far fa-money-bill-alt fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total faturado em pedidos externos -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total em Pedidos (Mensal)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">R$ <?= number_format($total_pedidos,2,',','.') ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-cart-plus fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br><br>

    <div class="form-group">
        <div class="row">
            <div class="col-sm-6">
                <h2>Marcas</h2>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr class="cab">
                                <th>Nome</th>
                                <th>Total R$</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        <?php
                            $sql = "SELECT v.marca, sum(total_pagar) FROM tb_ordem_servico s INNER JOIN tb_veiculo v ON v.id_veiculo = s.id_veiculo
                                WHERE s.id_master =". ID_MASTER ." AND YEAR(dt_servico) = $ano AND MONTH(dt_servico) = $mes
                                AND s.status >= 4 GROUP BY v.marca ORDER BY 2 DESC";
                            $result = $conexao->query($sql);

                            if ($result->num_rows > 0) {
                                // output data of each row
                                while ($row = $result->fetch_assoc()){
                                    $marca = $row['marca'];
                                    $total = $row['sum(total_pagar)'];
                                    ?>
                                    <tr>
                                        <td><?= $marca ?></td>
                                        <td><?= number_format($total,2,',','.') ?></td>
                                    </tr>
                                    <?php
                                }

                            } else {
                            echo "0 results";
                            }
                            
                        ?>
                            
                    </table>
                </div>
            </div>
        
            <div class="col-sm-6">
                <h2>Modelos</h2>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr class="cab">
                                <th>Nome</th>
                                <th>Total R$</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        <?php
                            $sql = "SELECT v.modelo, sum(total_pagar) FROM tb_ordem_servico s INNER JOIN tb_veiculo v ON v.id_veiculo = s.id_veiculo
                                WHERE s.id_master =". ID_MASTER ." AND YEAR(dt_servico) = $ano AND MONTH(dt_servico) = $mes
                                AND s.status >= 4 GROUP BY v.marca ORDER BY 2 DESC";
                            $result = $conexao->query($sql);

                            if ($result->num_rows > 0) {
                                // output data of each row
                                while ($row = $result->fetch_assoc()){
                                    $modelo = $row['modelo'];
                                    $total = $row['sum(total_pagar)'];
                                    ?>
                                    <tr>
                                        <td><?= $modelo ?></td>
                                        <td><?= number_format($total,2,',','.') ?></td>
                                    </tr>
                                    <?php
                                }

                            } else {
                            echo "0 results";
                            }
                            
                        ?>
                        </tbody>   
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="form-group">
        <div class="row">
            <div class="col-sm-6">
                <h2>Serviços</h2>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr class="cab">
                                <th>#</th>
                                <th>Data</th>
                                <th>Carro</th>
                                <th>Mecânico</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        <?php
                            $sql = "SELECT id_servico, placa, dt_servico, nome , total_pagar
                            FROM tb_ordem_servico s INNER JOIN tb_veiculo v ON v.id_veiculo = s.id_veiculo INNER JOIN tb_user u ON id_mecanico = id_user
                            WHERE s.id_master = ". ID_MASTER ." AND YEAR(dt_servico) = $ano AND MONTH(dt_servico) = $mes
                            AND s.status >= 4";
                            $result = $conexao->query($sql);

                            if ($result->num_rows > 0) {
                                // output data of each row
                                while ($row = $result->fetch_assoc()){
                                    $id_servico = $row['id_servico'];
                                    $placa = $row['placa'];
                                    $dt_servico = $row['dt_servico'];
                                    $mecanico = $row['nome'];
                                    $total_pagar = $row['total_pagar'];
                                    ?>
                                    <tr>
                                        <td><?= $id_servico?></td>
                                        <td><?= date('d/m/Y', strtotime($dt_servico)) ?></td>
                                        <td><?= $placa ?></td>
                                        <td><?= $mecanico ?></td>
                                        <td><?= number_format($total_pagar,2,",",".") ?></td>
                                    </tr>
                                    <?php
                                }

                            } else {
                            echo "0 results";
                            }
                            
                        ?>
                        </tbody>   
                    </table>
                </div>
            </div>

            <div class="col-sm-6">
                <h2>Prestações de Pedidos</h2>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr class="cab">
                                <th>#</th>
                                <th>DIA</th>
                                <th>Origem</th>
                                <th>Valor</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        <?php
                            $sql = "SELECT id_pedido_externo, dt_venc, nome_fantasia, vl_prest, pago, id_cprestacao
                            FROM tb_cprestacao c, tb_pedido_externo p, tb_fornecedor_pecas f 
                            WHERE p.id_fornecedor = f.id_fornecedor_pecas AND p.id_master = ". ID_MASTER ." AND id_pedido = id_pedido_externo  AND year(dt_venc) = $ano AND month(dt_venc) = $mes ORDER BY dt_venc ASC";
                            $result = $conexao->query($sql);

                            if ($result->num_rows > 0) {
                                // output data of each row
                                while ($row = $result->fetch_assoc()){
                                    $id_pedido_externo = $row['id_pedido_externo'];
                                    $id_cprestacao = $row['id_cprestacao'];
                                    $dt_venc = $row['dt_venc'];
                                    $nome_fantasia = $row['nome_fantasia'];
                                    $vl_prest = $row['vl_prest'];
                                    $pago = $row['pago'];
                                    ?>
                                    <tr>
                                        
                                        <td><?= date('d', strtotime($dt_venc)) ?></td>
                                        <td><?= $nome_fantasia ?></td>
                                        <td><?= number_format($vl_prest,2,",",".") ?></td>
                                        <td><?php if($pago){echo "Pago";} else { ?><a href="/pitstopcar/pedido/abrir.php/?id=<?= $id_pedido_externo?>">Pagar</a><?php } ?></td>
                                    </tr>
                                    <?php
                                }

                            } else {
                            echo "0 results";
                            }
                            
                        ?>
                        </tbody>   
                    </table>
                </div>
            </div>
        </div>
    </div>
        
       
    </div>
    <br><br>

    
</div>

<?php
}
$conexao->close();
include_once "../footer.html";
?>