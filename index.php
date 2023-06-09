<?php 
  include_once "header.php";
?>

<br><br>

<div class="container">
    
    <div class="form-group">
        <div class="row">

            <div class="col-sm-4 col-xs-6" >
                <div class="panel panel-default templatemo-content-widget white-bg no-padding templatemo-overflow-hidden">
                <div class="panel-heading templatemo-position-relative"><h2 class="text-uppercase">Produtos Acabando</h2></div>
                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr class="cab">
                                <th scope="col">Produto</th>
                                <th scope="col">Quantidade</th>
                            </tr>
                        </thead>
                        <tbody>
        
                        <?php
                        $sql = "SELECT * FROM tb_produto WHERE id_master = ".ID_MASTER." AND quantidade <= 10 ORDER BY quantidade DESC, descricao ASC";
                        $result = $conexao->query($sql);


                        if ($result->num_rows > 0) {
                            
                            while($row = $result->fetch_assoc()) {
                                
                                $descricao = $row['descricao'];
                                $quantidade = $row['quantidade'];
                                ?>

                                <tr>  
                                    <td><?= $descricao?></td>
                                    <td><?= $quantidade?></td>
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

            <div class="col-sm-4 col-xs-12" >
                <div class="panel panel-default templatemo-content-widget white-bg no-padding templatemo-overflow-hidden">
                    <div class="panel-heading templatemo-position-relative"><h2 class="text-uppercase">OS em Atraso</h2></div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr class="cab">
                                    <th scope="col">Data</th>
                                    <th scope="col">Placa</th>
                                    <th scope="col">Marca/Modelo</th>
                                    <th scope="col">Dias</th>
                                </tr>
                            </thead>
                            <tbody>
            
                                <?php
                                $sql = "SELECT id_servico, dt_servico, placa, marca, modelo, curdate() - dt_previsao as dias FROM tb_ordem_servico s INNER JOIN tb_veiculo v ON v.id_veiculo = s.id_veiculo
                                        WHERE s.id_master = ".ID_MASTER." AND dt_previsao < curdate() AND s.status < 8;";
                                $result = $conexao->query($sql);


                                if ($result->num_rows > 0) {
                                    
                                    while($row = $result->fetch_assoc()) {
                                        $id_servico = $row['id_servico'];
                                        $dt_servico = $row['dt_servico'];
                                        $placa = $row['placa'];
                                        $marca = $row['marca'];
                                        $modelo = $row['modelo'];
                                        $dias = $row['dias'];
                                        ?>

                                        <tr>  
                                            <td><?= date("d/m", strtotime($dt_servico)) ?></td>
                                            <td><a href="servicos/abrir.php/?id=<?= $id_servico?>"><?= $placa ?></a></td>
                                            <td><?= $modelo ?></td>
                                            <td><?= $dias?></td>
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


            <div class="col-sm-4 col-xs-6">
                <a href="/pitstopcar/marcas/lista.php" class="btn btn-primary text-uppercase btn-lg btn-block col-12 mb-2">Marcas</a>
                <a href="/pitstopcar/mecanico/lista.php" class="btn btn-primary text-uppercase btn-lg btn-block col-12 mb-2">Mecânicos</a>
                <a href="/pitstopcar/categoria/ver.php" class="btn btn-primary text-uppercase btn-lg btn-block col-12 mb-2">Categoria</a>
                <a href="/pitstopcar/servico_manual/lista.php" class="btn btn-primary text-uppercase btn-lg btn-block col-12 mb-2">Serviços Manuais</a>
                <a href="/pitstopcar/fornecedor/lista.php" class="btn btn-primary text-uppercase btn-lg btn-block col-12 mb-2">Fornecedores</a>
            </div>
            <div class="col-sm-4 col-xs-6" >
                <div class="panel panel-default templatemo-content-widget white-bg no-padding templatemo-overflow-hidden">
                <div class="panel-heading templatemo-position-relative"><h2 class="text-uppercase">TOP Mecânicos</h2></div>
                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr class="cab">
                                    <th scope="col">Nome</th>
                                    <th scope="col">Quantidade</th>
                                </tr>
                            </thead>
                            <tbody>
            
                            <?php
                            $sql = "SELECT id_mecanico, nome, COUNT(*) FROM tb_ordem_servico s INNER JOIN tb_user u ON id_user = id_mecanico WHERE s.id_master = ".ID_MASTER." GROUP BY id_mecanico ORDER BY 2 DESC;";
                            $result = $conexao->query($sql);


                            if ($result->num_rows > 0) {
                                
                                while($row = $result->fetch_assoc()) {
                                    $id_mecanico = $row['id_mecanico'];
                                    $nome = $row['nome'];
                                    $quantidade = $row['COUNT(*)'];
                                    ?>

                                    <tr>  
                                        <td><a href="mecanico/servicosde.php/?id=<?= $id_mecanico?>"><?= $nome?></a></td>
                                        <td><?= $quantidade?></td>
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

            <div class="col-sm-4 col-xs-6">

                <div class="panel panel-default templatemo-content-widget white-bg no-padding templatemo-overflow-hidden">
                    <div class="panel-heading templatemo-position-relative"><h2 class="text-uppercase">Prestações em Atraso</h2></div>
                        <div class="table-responsive">
                            <table class="table table-hover table-sm">
                                <thead>
                                    <tr class="cab">
                                        <th scope="col">Origem</th>
                                        <th scope="col">Data</th>
                                        <th scope="col">Valor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                $sql = "SELECT id_pedido_externo, nome_fantasia, dt_venc, vl_prest FROM tb_cprestacao c, tb_pedido_externo p, tb_fornecedor_pecas f WHERE p.id_fornecedor = f.id_fornecedor_pecas AND p.id_master = ". ID_MASTER." AND curdate() > dt_venc AND id_pedido = id_pedido_externo  AND pago = FALSE;";
                                $result = $conexao->query($sql);
                                if($result->num_rows > 0){
                                    while($row = $result->fetch_assoc()){
                                        $id_pedido_externo = $row['id_pedido_externo'];
                                        $nome_fantasia = $row['nome_fantasia'];
                                        $dt_venc = $row['dt_venc'];
                                        $vl_prest = $row['vl_prest'];
                                        ?>
                                        <tr>
                                            <td><a href="pedido/abrir.php/?id=<?= $id_pedido_externo?>"><?= $nome_fantasia?></a></td>
                                            <td><?= date('d/m/Y', strtotime($dt_venc))?></td>
                                            <td><?= number_format($vl_prest,2,",",".")?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                                </tbody>
                        </table>
                    </div>
                </div>
        
            </div>
        </div>
    </div>
       
</div>


<?php 
    $conexao->close();
    include_once "footer.html";
?>