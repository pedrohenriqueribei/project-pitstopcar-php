<?php 
    include_once "../header.php";


    $id_servico = $_GET['id'];

    $sql = "SELECT v.id_veiculo, placa, v.marca, v.modelo, ano, s.id_negocio,
    s.observacao, forma_pag, parcelado, desconto, taxa_entrega, hr_servico, dt_servico, dt_previsao, tipo, s.status, valor, total_pagar, cliente,
    dt_aprovacao, dt_pagamento, dt_entrega, dt_reaberto, dt_finalizado, dt_manutencao, garantia, parecer_tecnico, km, id_mecanico,
    nome, sobrenome, telefone, cpf, sexo, data_nasc
    FROM tb_ordem_servico s INNER JOIN tb_cliente c ON s.cliente = c.idCliente
    INNER JOIN tb_veiculo v ON s.id_veiculo =  v.id_veiculo
    WHERE id_servico = $id_servico";
    $result = $conexao->query($sql);
    
    if ($result->num_rows == 1) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $id_veiculo = $row['id_veiculo'];
            $placa = $row['placa'];
            $marca = $row['marca'];
            $modelo = $row['modelo'];
            $ano = $row['ano'];
            
            $id_negocio = $row['id_negocio'];
            $observacao = $row['observacao'];
            $parecer_tecnico = $row['parecer_tecnico'];
            $garantia = $row['garantia'];
            $forma_pag = $row['forma_pag'];
            $parcelado = $row['parcelado'];
            $desconto = $row['desconto'];
            $taxa_entrega = $row['taxa_entrega'];
            $hr_servico = $row['hr_servico'];
            $dt_servico = $row['dt_servico'];
            $dt_previsao = $row['dt_previsao'];
            $tipo = $row['tipo'];
            $status = $row['status'];
            $valor = $row['valor'];
            $total_pagar = $row['total_pagar'];
            $idCliente = $row['cliente'];
            $km = $row['km'];
            $mecanico = $row['id_mecanico'];
            
            $dt_aprovacao = $row['dt_aprovacao'];
            $dt_pagamento = $row['dt_pagamento'];
            $dt_entrega = $row['dt_entrega'];
            $dt_reaberto = $row['dt_reaberto'];
            $dt_finalizado = $row['dt_finalizado'];
            $dt_manutencao = $row['dt_manutencao'];

            
            $nome = $row['nome'];
            $sobrenome = $row['sobrenome'];
            $telefone = $row['telefone'];
            $cpf = $row['cpf'];
            $data_nasc = $row['data_nasc'];
            $sexo = $row['sexo'];

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
        }
    } else {
    echo "0 results";
    }
    
?>



<div class="container">
    <?php
    require_once "menu-servicos.php";
    //require_once "form-pesquisa.php";

    if(isset($_SESSION['erro'])){
        ?>
        <br><br>
        <div class="alert alert-danger" role="alert">
            <?= $_SESSION['erro'] ?>
        </div>
        <?php
    }
    ?>
    <br>
    
    <h1 class="text-center text-uppercase">Ordem de serviço nº <?= $id_negocio ?></h1><br>

    <form action="/pitstopcar/servicos/_atualizar.php" role="form" method="post">
      
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

            <br><br>

            <div class="row">
                <div class="col-sm-2">
                    <label for="dt_pedido">Data da Solicitação</label>
                    <input type="date" class="form-control" id="dt_servico" name="dt_servico" value="<?= $dt_servico ?>" disabled>
                </div>
                

                <div class="col-sm-3">
                    <label for="tipo">Tipo</label>
                    <select name="tipo" id="tipo" class="form-control custom-select">
                        <option <?php if($tipo == "Manutenção") echo "selected" ?> value="Manutenção">Manutenção</option>
                        <option <?php if($tipo == "Venda") echo "selected" ?> value="Venda">Venda</option>
                        <option <?php if($tipo == "Serviço") echo "selected" ?> value="Serviço">Serviço</option>
                        <option <?php if($tipo == "Orçamento") echo "selected" ?> value="Orçamento">Orçamento</option>
                    </select>
                </div>


                <div class="col-sm-3">
                    <label for="dt_previsao">Previsão para</label>
                    <input type="date" class="form-control" id="dt_previsao" name="dt_previsao" value="<?= $dt_previsao ?>">
                </div>

                

                <div class="col-sm-2">
                    <label for="hr_servico">Hora do Pedido</label>
                    <input type="text" name="hr_servico" id="hr_servico" class="form-control" value="<?= $hr_servico ?>" disabled>    
                </div>

                <div class="col-sm-2">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control custom-select" disabled>
                        <option value="1" <?php if($status==1) echo "selected"?>>Aberto</option>
                        <option value="2" <?php if($status==2) echo "selected"?>>Aprovado</option>
                        <option value="3" <?php if($status==3) echo "selected"?>>Manutenção Finalizada com sucesso</option>
                        <option value="4" <?php if($status==4) echo "selected"?>>Aguardando Pagamento</option>
                        <option value="5" <?php if($status==5) echo "selected"?>>Entregue</option>
                        
                        <option value="7" <?php if($status==7) echo "selected"?>>Reaberto</option>
                        <option value="8" <?php if($status==8) echo "selected"?>>Finalizado</option>
                        <option value="-1" <?php if($status==-1) echo "selected"?>>Não Aprovado</option>
                        <option value="-2" <?php if($status==-2) echo "selected"?>>Manutenção Finalizada com insucesso</option>
                    </select>
                </div>

                <?php 
                if($status >= 3){ ?>
                <div class="col-sm-2">
                    <label for="dt_manutencao">Data Manutenção</label>
                    <input type="date" name="dt_manutencao" id="dt_manutencao" class="form-control" value="<?= $dt_manutencao ?>" disabled>    
                </div>
                <?php } ?>
            </div> 
        </div> 

        <br><br>
        <h2>Dados do veículo</h2>
        <div class="form-group">
            <div class="row">
                <div class="col-sm-3">
                    <label for="placa">Placa</label>
                    <input type="text" class="form-control" id="placa" name="placa" maxlength="8" value="<?= $placa?>" disabled>
                </div>       
                
                <div class="col-sm-3">
                    <label for="modelo">Modelo</label>
                    <input type="text" name="modelo" id="modelo" class="form-control" value="<?= $modelo ?>" disabled>
                </div>
                
                <div class="col-6 col-md-3">
                    <label for="marca">Marca</label>
                    <input type="text" class="form-control" id="marca" name="marca" value="<?= $marca?>" disabled>
                </div>

                <div class="col-6 col-md-3"> 
                    <label for="ano">Ano Fabricação</label>
                    <input type="text" class="form-control" id="ano" name="ano" value="<?= $ano?>" disabled>
                </div>
                
                <br>
                <div class="col-sm-12">
                    <label for="observacao">Observação</label>
                    <input type="text" name="observacao" id="observacao" class="form-control" rows="3"  value="<?= $observacao ?>" />
                </div>

                <div class="col-sm-12">
                    <label for="parecer_tecnico">Parecer Técnico</label>
                    <input type="text" name="parecer_tecnico" id="parecer_tecnico" class="form-control" rows="3"  value="<?= $parecer_tecnico ?>" />
                </div>

                <div class="col-sm-3">
                    <label for="km">Quilometragem</label>
                    <input type="number" name="km" id="km" class="form-control" min="0"  value="<?= $km ?>" required/>
                </div>

                <div class="col-sm-3">
                    <label for="mecanico">Mecânico</label>
                    <select class="form-control" id="mecanico" name="mecanico" <?php if($nivel > 1) echo "readonly"?>>
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
                                <option value="<?= $id_user?>" <?php if($id_user == $mecanico) echo "selected" ?>><?= $nome ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>

                <?php if($status >= 2): ?>
                <div class="col-sm-3 mt-3">
                    <label for="garantia">Garantia de </label>
                    <select name="garantia" id="garantia" class="form-control custom-select" <?php if($status >= 2){ echo "required";} ?>>
                        <option value="0"  <?php if($garantia == 0) echo "selected"?>>Sem Garantia</option>
                        <option value="30" <?php if($garantia == 30) echo "selected"?> >30 dias</option>
                        <option value="60" <?php if($garantia == 60) echo "selected"?> >60 dias</option>
                        <option value="90" <?php if($garantia == 90) echo "selected"?> >90 dias</option>
                    </select>  
                </div>
                <?php endif; ?>

                <?php if($status >= 3): ?>
                <div class="col-sm-3">
                    <label for="ate">Garantia até</label>
                    <input type="date" name="ate" id="ate" class="form-control"  value="<?= date('Y-m-d', strtotime('+'.$garantia.' days', strtotime($dt_manutencao))) ?>" disabled>
                </div>
                <?php endif ?>
            </div>
            <div style="margin-top: 10px">
                <a href="/pitstopcar/servicos/ver_fotos.php/?id=<?= $id_servico ?>" class="btn btn-primary text-uppercase mb-3"><i class="far fa-images"></i> Ver Fotos</a>
            </div>
        </div>
    
        <br><br>
        <div class="form-group">

            <h2>Forma de Pagamento</h2>
            <div class="row">
                
    
                <div class="col-sm-3 " style="text-align:center">
                    <label for="forma_pag">Forma de Pagemento</label>
                    <select name="forma_pag" id="forma_pag" class="form-control custom-select" required>
                        <option value="1" <?php if($forma_pag == 1) echo "selected"?> >Dinheiro</option>
                        <option value="2" <?php if($forma_pag == 2) echo "selected"?> >Débito</option>
                        <option value="3" <?php if($forma_pag == 3) echo "selected"?> >Crédito</option>
                    </select>
                </div>

                <div class="col-sm-3" style="text-align:center">
                    <label for="parcelado">Parcelado</label>
                    <select id="parcelado" name="parcelado" class="form-control custom-select">
                        <option value="1" <?php if($parcelado == 1) echo "selected"?> >À vista</option>
                        <option value="2" <?php if($parcelado == 2) echo "selected"?> >2</option>
                        <option value="3" <?php if($parcelado == 3) echo "selected"?> >3</option>
                        <option value="4" <?php if($parcelado == 4) echo "selected"?> >4</option>
                        <option value="5" <?php if($parcelado == 5) echo "selected"?> >5</option>
                        <option value="6" <?php if($parcelado == 6) echo "selected"?> >6</option>
                        <option value="7" <?php if($parcelado == 7) echo "selected"?> >7</option>
                        <option value="8" <?php if($parcelado == 8) echo "selected"?> >8</option>
                        <option value="9" <?php if($parcelado == 9) echo "selected"?> >9</option>
                        <option value="10" <?php if($parcelado == 10) echo "selected"?> >10</option>
                        <option value="11" <?php if($parcelado == 11) echo "selected"?> >11</option>
                        <option value="12" <?php if($parcelado == 12) echo "selected"?> >12</option>
                    </select>
                </div>

                <div class="col-sm-3 ">
                    <label for="taxa_entrega">Taxa de Frete R$</label>
                    <input type="text" name="taxa_entrega" id="taxa_entrega" class="form-control" min="0" value="<?= number_format($taxa_entrega,2,',','.') ?>">
                </div>

                <div class="col-sm-3 ">
                    <label for="desconto">Desconto R$</label>
                    <input type="text" name="desconto" id="desconto" class="form-control" value="<?= number_format($desconto,2,',','.') ?>">
                </div>
            </div>
        </div>   
           

        <br><br><br>
        <div class="d-flex justify-content-between">
            
            <div class="col-sm-4">
                <a href="/pitstopcar/servicos/imprimir.php/?id=<?= $id_servico?>" class="btn btn-primary text-uppercase mb-3 btn-lg btn-block" target="_blank">
                    <i class="fa fa-print" aria-hidden="true"></i>
                    Imprimir 
                </a>
            </div>

            <div class="col-sm-4"><br><br><br><br>
                <button type="submit" class="btn btn-primary text-uppercase mb-3 btn-lg btn-block">
                <i class="fa fa-retweet" aria-hidden="true"></i> Atualizar 
                </button>
            </div>

            <div class="col-sm-4">
                <div style="text-align:center; border-radius: 15px; border: 5px solid #717171">
                    <label for="total_pagar"><h2>Total a Pagar </h2></label>
                    <h2 class="total" style="text-align:center ;font-size:45pt"><b><?= "R$ ". number_format($total_pagar,2,',','.') ?></b></h2>
                </div>
            </div>

        </div>

        <br><br>
        
        <input style="display: none" type="number" name="id_servico" value="<?= $id_servico ?>">
        
    </form>


    
    <h2>Itens da OS</h2><br><br>

    <form action="/pitstopcar/servicos/_adicionaritens.php" role="form" method="post">

        <div class="form-group">
            <div class="row">
                <div class="col-sm-6">
                    <label for="item">Item</label>
                    <input type="text" name="item" id="item" class="form-control" required>
                </div>

                <div class="col-sm-2">
                    <label for="quantidade">Quantidade</label>
                    <select name="quantidade" id="quantidade" class="form-control custom-select" value="1" min="1" required>
                        <?php for ($i=1; $i <= 10 ; $i++) { ?>
                            <option value="<?= $i ?>"><?= $i ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="col-sm-3" style="text-align: center;"  ><br>
                    <button type="submit" class="btn btn-primary botao_salvar btn-lg" >
                        
                        <div class="align-middle">
                            Adicionar item
                        </div> 
                    </button>
                </div>

                <div>
                    <input style="display: none" type="number" name="id_servico" value="<?= $id_servico ?>">
                </div>
            </div>
        </div>

    </form>
            
    <br><br>


    <div class="table-responsive">
        <table class="table table-hover table-sm">
            <thead>
                <tr class="cab">
                    <th scope="col">ID</th>
                    <th scope="col">Item</th>
                    <th class="text-center" scope="col">Quantidade</th>
                    <th scope="col">Preço</th>
                    <th scope="col">Valor</th>
                    <th>Excluir</th>
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
                        $id_itens_os = $row['id_itens_os'];
                        $item = $row['descricao'];
                        $quantidade = $row['quantidade'];
                        $preco = $row['preco']; 
                        $valor = $row['valor']; 
                        $total += $valor;
                        $key++;
                        ?>
                        <tr>
                            <td><?= $key ?></td>
                            <td><?= $item ?></td>
                            <td class="text-center"><?= $quantidade ?></td>
                            <td><?= number_format($preco,2,',','.') ?></td>
                            <td><?= number_format($valor,2,',','.') ?></td>
                            <td>
                                <a href="/pitstopcar/servicos/_excluiritem.php?id=<?= $id_itens_os ?>&id_servico=<?= $id_servico ?>"  title="Excluir" style="color: #fab81f">
                                <i class="far fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "0 results";
                }
                
            ?>
            </tbody>
            <tfoot>
                <tr class="cab">
                    <th  colspan="6" style="text-align: right;"><h4><strong> Total R$ <?= number_format($total,2,',','.') ?></strong></h4></th>
                </tr>            
            </tfoot>
        </table>
            
    </div>
            

    <br>
    <br>
    <br>
    
    <br><br><br><br>
    <?php
    switch ($status) {
        case 1:
            {
                ?>
                <div class="d-inline-flex justify-content-center">
                    <!--<div class="col-4">-->
                        <a href="/pitstopcar/servicos/_aprovar.php/?id=<?= $id_servico?>" class="btn btn-success btn-lg">Aprovar</a>
                    <!--</div>-->
                    <!--<div class="col-4">-->
                        <a href="/pitstopcar/servicos/_reprovar.php/?id=<?= $id_servico?>" class="btn btn-danger btn-lg">Reprovar</a>
                    <!--</div>-->
                </div>
                <?php
            }
            break;
        
        case 2:
            {
                ?>
                <a href="/pitstopcar/servicos/_concluir_manutencao.php/?id=<?= $id_servico?>" class="btn btn-success text-uppercase mb-3 btn-lg">Concluir Manutenção</a>
                <?php
            }
            break;
        case 3:
            {
                ?>
                <a href="/pitstopcar/servicos/_conf_pagamento.php/?id=<?= $id_servico?>" class="btn btn-success text-uppercase mb-3 btn-lg">Confirmar Pagamento</a>
                <?php
            }
            break;
        
        case 4:
            {
                ?>
                <a href="/pitstopcar/servicos/_entregar_equipamento.php/?id=<?= $id_servico?>" class="btn btn-success text-uppercase mb-3 btn-lg">Finalizar OS</a>
                <?php
            }
        break;

        case 7:
            {
                ?>
                <a href="/pitstopcar/servicos/_entregar_equipamento.php/?id=<?= $id_servico?>" class="btn btn-success text-uppercase mb-3 btn-lg">Finalizar OS</a>
                <?php
            }

        
    }
    if ($status == 8 AND date('Y-m-d', strtotime('+'.$garantia.' days', strtotime($dt_servico))) >= date('Y-m-d')) {
        
        ?>
        <a href="/pitstopcar/servicos/_reabrir.php/?id=<?= $id_servico?>" class="btn btn-success text-uppercase mb-3 btn-lg">Reabrir OS</a>
        <?php  
    }
    ?>
    
    <br><br>
    <div class="row">
        <?php if($status >= 2 OR $status == -1){ ?>
        <div class="col-sm-2">
            <h6><?php if($status >= 2){ echo "Data de Aprovação";} elseif($status == -1) { echo "Não Aprovado em";  } ?></h6>
            <input type="text" class="form-control" value="<?= date('d/m/Y', strtotime($dt_aprovacao)) ?>" disabled>
        </div>
        <?php } ?>

        <?php if($status >= 3){ ?>
        <div class="col-sm-2">
            <h6>Data de Manutenção</h6>
            <input type="text" class="form-control" value="<?= date('d/m/Y', strtotime($dt_manutencao)) ?>" disabled>
        </div>
        <?php } ?>

        <?php if($status >= 4){ ?>
        <div class="col-sm-2">
            <h6>Data de Pagamento</h6>
            <input type="text" class="form-control" value="<?= date('d/m/Y', strtotime($dt_pagamento)) ?>" disabled>
        </div>
        <?php } ?>

        <?php if($status >= 5){ ?>
        <div class="col-sm-2">
            <h6>Data da Entrega</h6>
            <input type="text" class="form-control" value="<?= date('d/m/Y', strtotime($dt_entrega)) ?>" disabled>
        </div>
        <?php } ?>

        <?php if($status >= 5){ ?>
        <div class="col-sm-2">
            <h6>Data da Finalização</h6>
            <input type="text" class="form-control" value="<?= date('d/m/Y', strtotime($dt_finalizado)) ?>" disabled>
        </div>
        <?php } ?>

        <?php if($status >= 7){ ?>
        <div class="col-sm-2">
            <h6>Data de Reabertura</h6>
            <input type="text" class="form-control" value="<?= date('d/m/Y', strtotime($dt_reaberto)) ?>" disabled>
        </div>
        <?php } ?>
    </div>


</div>



<?php 
    $conexao->close();
    unset($_SESSION['erro']);
    include_once "../footer.html";
?>