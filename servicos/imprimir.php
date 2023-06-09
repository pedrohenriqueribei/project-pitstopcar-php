
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Pit Stop Car - Estética Automotiva - Soluções Automotivas</title>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/pitstopcar/recursos/img/logo.png" type="image/x-icon" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,700' rel='stylesheet' type='text/css'>
    <link href="/pitstopcar/recursos/css/font-awesome.min.css" rel="stylesheet">
    <link href="/pitstopcar/recursos/css/bootstrap.min.css" rel="stylesheet">
    <!--<link href="/pitstopcar/recursos/css/templatemo-style.css" rel="stylesheet">-->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script> -->

    <link rel="stylesheet" href="/pitstopcar/recursos/css/estilo.css">
    
    <script type="text/javascript">setTimeout("window.close();", 1000);</script>

    <?php
        
        define("ID_MASTER", 4686);
        $id_servico = $_GET['id'];

    $sql = "SELECT * FROM tb_ordem_servico WHERE id_servico = $id_servico";
    $result = $conexao->query($sql);
    
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
                       
            $observacao = $row['observacao'];
            $forma_pag = $row['forma_pag'];
            $parcelado = $row['parcelado'];
            $desconto = $row['desconto'];
            $taxa_entrega = $row['taxa_entrega'];
            $total_pagar = $row['total_pagar'];
            $hr_servico = $row['hr_servico'];
            $dt_servico = $row['dt_servico'];
            $dt_previsao = $row['dt_previsao'];
            $tipo = $row['tipo'];
            $status = $row['status'];
            $valor = $row['valor'];
            $total_pagar = $row['total_pagar'];
            $idCliente = $row['cliente'];
            $id_veiculo = $row['id_veiculo'];
            $garantia = $row['garantia'];
            
            
            $dt_aprovacao = $row['dt_aprovacao'];
            $dt_pagamento = $row['dt_pagamento'];
            $dt_entrega = $row['dt_entrega'];
            $dt_reaberto = $row['dt_reaberto'];
            $dt_finalizado = $row['dt_finalizado'];
            $dt_manutencao = $row['dt_manutencao'];

            $slq_cli = "SELECT * FROM tb_cliente WHERE idCliente = $idCliente";
            $query = $conexao->query($slq_cli);
            $row = $query->fetch_assoc();
            $nome_cli = $row['nome'];
            $sobrenome_cli = $row['sobrenome'];
            $telefone_cli = $row['telefone'];

            $sql_addr = "SELECT * FROM tb_endereco WHERE id_cliente = $idCliente";
            $query = $conexao->query($sql_addr);
            $row = $query->fetch_assoc();
            $cep = isset($row['cep']) ? $row['cep'] : "";
            $logradouro = isset($row['logradouro']) ? $row['logradouro'] : "";
            $complemento = isset($row['complemento']) ? $row['complemento'] : "";
            $bairro = isset($row['bairro']) ? $row['bairro'] : ""; 
            $cidade = isset($row['cidade']) ? $row['cidade'] : "";
            $uf = isset($row['uf']) ? $row['uf'] : "";

            $sql_car = "SELECT * FROM tb_veiculo WHERE id_veiculo = $id_veiculo";
            $car = $conexao->query($sql_car);
            $row = $car->fetch_assoc();
            $placa = $row['placa'];
            $marca = $row['marca'];
            $modelo = $row['modelo'];
            $ano = $row['ano'];
        }
    } else {
    echo "0 results";
    }
    
    ?>

</head>
<body>
    <div class="container"><br>
        
        <div class="row" style="border: 3px solid #DCDCDC; border-radius: 15px;">
            
            <!-- <div class="col-12"> -->
            <div class="d-flex justify-content-center">
                <table>
                    <tr>
                    <td style="width: 200px"></td>
                    <td><img src="/pitstopcar/recursos/img/logo.jpg" alt="logo" width="80px"></td>
                    <td>
                        
                            <h1 style="color: black; text-align: center; font-size: 8pt;"> Pit Stop Car - Centro de Estética Automotivo</h1>
                            <h4 style="color: black; text-align: center; font-weight: bolder;font-size: 7pt">
                            <i class="fa fa-phone" aria-hidden="true"></i>
                            (61) 98209-4686
                            </h4>
                            <h6 style="text-align: center;font-size: 5pt">Qn 308 Conjunto 04 Lote 6 - Samambaia Sul, Brasília - DF, 72306-404</h6>  
                        
                    </td>
                    </tr>
                </table>
                
                
                <!-- </div> -->
            </div>
        </div>
                    
        <h3 style="color: black; font-size: 10pt; text-align: center; font-weight: bolder">Ordem de Serviço Nº <?= $id_servico ?></h3>

        <div class="row" style="border: 3px solid #DCDCDC; padding: 8px; border-radius: 15px; font-size: 6pt; margin-bottom: 4px;">
            
            <table>
                <tr>
                    <td style="width: 200px">
                        <p><strong>Cliente</strong>
                        <br><?= $nome_cli." ".$sobrenome_cli ?></p>
                    </td>

                    <td style="width: 150px">
                        <p><strong>Telefone</strong>
                        <br><?= $telefone_cli ?></p>
                    </td>

                    <td style="width: 200px" colspan="2">
                        <p><strong>Endereço</strong>
                        <br><?= $logradouro ?></p>
                    </td>
                
                    <td style="width: 200px">
                        <p><strong>Complemento</strong>
                        <br><?= $complemento ?></p>
                    </td>

                    <td style="width: 150px">
                        <p><strong>Bairro</strong>
                        <br><?= $bairro ?></p>
                    </td>

                    <td style="width: 150px">
                        <p><strong>CEP</strong>
                        <br><?= $cep ?></p>
                    </td>

                    <td style="width: 150px">
                        <p><strong>Cidade/UF</strong>
                        <br><?= $cidade."/".$uf  ?>   </p>
                    </td>
                </tr>

                <tr>
                    <td style="width: 200px">
                        <p><strong>Placa</strong>
                        <br><?= $placa ?></p>
                    </td>

                    <td style="width: 200px">
                        <p><strong>Marca</strong>
                        <br><?= $marca ?></p>
                    </td>

                    <td style="width: 200px">
                        <p><strong>Modelo</strong>
                        <br><?= $modelo ?></p>
                    </td>

                    <td style="width: 200px">
                        <p><strong>Ano</strong>
                        <br><?= $ano ?></p>
                    </td>
                </tr>
            </table>
                         
        </div>

        
        
        <div class="row" style="border: 3px solid #DCDCDC; border-radius: 15px; padding: 8px; font-size: 6pt; margin-bottom: 4px;">
            <table>
                <tr>
                    <td colspan=3>Observação: <?= $observacao?></td>
                </tr>
                
                <tr>
                    <td style="width: 120px">
                        <label><b>Data da Solicitação</b></label><br>
                        <?= date("d/m/Y", strtotime($dt_servico)); ?>
                    </td>

                    <td style="width: 120px">
                        <label><b>Data de Previsão</b></label><br>
                        <?= date("d/m/Y", strtotime($dt_previsao)); ?>
                    </td>

                    <td style="width: 120px">
                        <label><b>Data de Aprovação</b></label><br>
                        <?= date("d/m/Y", strtotime($dt_aprovacao)); ?>
                    </td>
                    <td style="width: 120px">
                        <label for="status">Status</label><br>
                        <?php if($status==1) echo "Aberto"; elseif($status==2) echo "Aprovado"; elseif($status==3) echo "Manutenção Finalizada com sucesso"; elseif($status==4) echo "Aguardando Pagamento"; elseif($status==5) echo "Entregue"; elseif($status==7) echo "Reaberto"; elseif($status==8) echo "Finalizado"; elseif($status==-1) echo "Não Aprovado"; elseif($status==-2) echo "Manutenção Finalizada com insucesso"; ?>               
                    </td>

                    <?php if($status >= 3): ?>
                        <td style="width: 120px">
                            <label for="dt_manutencao">Data Manutenção</label><br>
                            <?= date("d/m/Y", strtotime($dt_manutencao)) ?>
                        </td>
                        <td style="width: 120px">
                            <label for="ate">Garantia até</label><br>
                            <?= date("d/m/Y", strtotime('+'.$garantia.' days', strtotime($dt_manutencao))) ?>
                        </td>
                    <?php endif ?>
                </tr>
            </table>
        </div>

        

        <div class="row" style="border: 2px solid #DCDCDC; padding-top: 8px; padding-bottom: -10px; border-radius: 15px; font-size: 6pt; margin-bottom: 4px;">
            <h4 style="font-size: 8pt">Itens da OS</h4>
            <table class="" width="95%">
                <thead>
                    <tr class="">
                        <th >ID</th>
                        <th scope="col">Item</th>
                        <th scope="col">Quantidade</th>
                        <th scope="col">Preço</th>
                        <th scope="col">Valor</th>
                        
                    </tr>
                </thead>
                <tbody>
                <?php
                    $total = 0;
                    $key = 0;
                    
                    $sql = "SELECT * FROM tb_itens_os WHERE id_servico = $id_servico AND status > 0 AND id_master = ". ID_MASTER;
                    $result = $conexao->query($sql);

                    if ($result->num_rows > 0) {
                        // output data of each row
                        while($row = $result->fetch_assoc()) {
                            $id_item = $row['id_itens_os'];
                            $item = $row['descricao'];
                            $quantidade = $row['quantidade'];
                            $preco = $row['preco']; 
                            $valor = $row['valor']; 
                            $total += $valor;
                            $key++;
                            ?>
                            <tr style="height: 1em; text-align: center">
                                <td><?= $key ?></td>
                                <td><?= $item ?></td>
                                <td><?= $quantidade ?></td>
                                <td><?= number_format($preco,2,',','.') ?></td>
                                <td><?= number_format($valor,2,',','.') ?></td>
                                
                            </tr>
                            <?php
                        }
                    } else {
                        echo "0 results";
                    }
                    
                ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th  colspan="6" style="text-align: right;"><h4 style="font-size: 6pt"><strong> Total R$ <?= number_format($total,2,',','.') ?></strong></h4></th>
                    </tr>            
                </tfoot>
            </table>
        </div>

        
        <div class="row d-flex align-items-end flex-column" style="margin-bottom: 4px;">
            <div class="col-5" style="border: 3px solid #DCDCDC; padding: 8px; border-radius: 15px;font-size: 6pt">
                <h5 style="color: black; text-align:right;font-size: 6pt">Desconto R$ <?= number_format($desconto ,2,',','.') ?></h5>
                <h5 style="color: black; text-align:right;font-size: 6pt">Taxa Entrega R$ <?= number_format($taxa_entrega ,2,',','.') ?></h5>
                <h4 class="text-uppercase" style="color: black; text-align:right;font-size: 8pt"><strong> total a pagar r$ <?= number_format($total_pagar,2,',','.') ?> </strong></h4>
            </div>
        </div>
        

        <div class="row" style="border: 3px solid #DCDCDC; padding: 8px; border-radius: 15px; font-size: 6pt; margin-bottom: 4px;">
            <div class="col-12">
                <h5 class="text-uppercase" style="color: black; text-align:center;font-size: 6pt"><strong>acordo entre as partes</strong></h5>
                <p class="lead" style="font-size: 5pt">
                    <ol>
                        <li>
                        Esta Ordem de Servico tem a garantia de <?= $garantia ?> dias, contados da data de aprovação em <?= date("d/m/Y", strtotime($dt_aprovacao))?>, válidos apenas
                        para os defeitos constados por esta Ordem de Serviço e abrange todas as peças substituídas.
                        </li>
                        <li>
                        
                        </li>
                        <li>
                        Declaro para fins de direito que estou de acordo com os itens acima mencionados.
                        </li>
                    </ol>
                </p>
            </div>
        </div> 

        <br><br>

        <div class="row" style="font-size: 6pt">
            <table>
                <tr>
                    <td style="width:200px"></td>
                    <td>
                        ______________________
                    </td>

                    <td style="width:200px"></td>

                    <td>
                        ______________________
                    </td>
                </tr>

                <tr>
                    <td style="width:200px"></td>
                    <td>
                        <p class="text-center">Assinatura do Cliente</p>
                    </td>

                    <td style="width:400px"></td>

                    <td>
                        <p class="text-center">Pit Stop Car - Estética Automotiva</p>
                    </td>
                </tr>
            </table>
        </div>

       

        
        <script type="text/javascript">
            window.print();
        </script>

        <script type="text/javascript">
            window.onload = function() {
                window.print();
            }
        </script>

        <script type="text/javascript" src="/pitstopcar/recursos/js/jquery-3.5.1.min.js"></script>
        <script type="text/javascript" src="/pitstopcar/recursos/js/popper.min.js" ></script>
        <script type="text/javascript" src="/pitstopcar/recursos/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="/pitstopcar/recursos/js/jquery.mask.min.js"></script>
        <script type="text/javascript" src="/pitstopcar/recursos/js/bootstrap-notify.min.js"></script>
        <script type="text/javascript" src="/pitstopcar/recursos/js/cep.js"></script>
        <script type="text/javascript" src="/pitstopcar/recursos/js/main.js"></script>
        <script type="text/javascript" src="/pitstopcar/recursos/js/jquery-1.11.2.min.js"></script>      <!-- jQuery -->
        <script type="text/javascript" src="/pitstopcar/recursos/js/jquery-migrate-1.2.1.min.js"></script> <!--  jQuery Migrate Plugin -->
        <script type="text/javascript" src="https://www.google.com/jsapi"></script> <!-- Google Chart -->
       
    </div>
    <br>
</body>
<footer>
    <?php
    $conexao->close();
    ?>
</footer>