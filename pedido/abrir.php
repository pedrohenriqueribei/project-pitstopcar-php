<?php 
    include_once "../header.php";

    $id = $_GET['id'];
    $sql = "SELECT * FROM tb_pedido_externo WHERE id_master = ".ID_MASTER." AND id_pedido_externo = $id";
    $result = $conexao->query($sql);

    $row = $result->fetch_assoc();
    $codigo_externo = $row['codigo_externo'];
    $fornecedor = $row['id_fornecedor'];
    $dt_pedido = $row['dt_pedido'];
    $dt_entrega = $row['dt_entrega'];
    $status = $row['status'];
    $total = $row['total'];
    $total_pago = $row['total_pago'];
    $desconto = $row['desconto'];
    $taxa_entrega = $row['taxa_entrega'];
    $forma_pag = $row['forma_pag'];
    $parcelado = $row['parcelado'];
?>

<div class="container">
    <div class="mt-2" style="text-align: right"> 
        <a href="/pitstopcar/produtos/novo.php" class="btn btn-primary text-uppercase botao btn-lg"><i class="fas fa-plus"></i>Novo Produto</a>        
        <a href="/pitstopcar/pedido/lista.php" class="btn btn-primary text-uppercase botao btn-lg">Voltar</a><br><br>
    </div>
    <br>
    <?php
    if(isset($_SESSION['erro'])){
        ?>
        <br><br>
        <div class="alert alert-danger" role="alert">
            <?= $_SESSION['erro'] ?>
        </div>
        <?php
    }
    ?>
    <h1>Cadastrar Pedido Externo de Peças/Produtos</h1><br>


    <form role="form" action="/pitstopcar/pedido/_atualizar.php" method="post">
        <div class="form-group">
            <div class="row">
                <div class="col-sm-2">
                    <label for="codigo_externo">Código Externo</label>
                    <input type="number" name="codigo_externo" id="codigo_externo" class="form-control" min="0" value="<?= $codigo_externo?>">
                </div>

                <div class="col-sm-3">
                    <label for="fornecedor">Fornecedor</label>
                    <select name="fornecedor" id="fornecedor" class="form-control">
                        <option disabled selected>Selecione um fornecedor</option>
                        <?php
                        $sql = "SELECT * FROM tb_fornecedor_pecas WHERE id_master = ". ID_MASTER;
                        $results = $conexao->query($sql);
                        if($results->num_rows > 0){
                            while($row = $results->fetch_assoc()){
                                $id_forn = $row['id_fornecedor_pecas'];
                                $nome_fantasia = $row['nome_fantasia'];
                                ?>
                                <option value="<?= $id_forn?>" <?php if($id_forn == $fornecedor) echo "selected" ?>><?= $nome_fantasia?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="col-sm-2">
                    <label for="dt_pedido">Data do Pedido</label>
                    <input type="date" name="dt_pedido" id="dt_pedido" class="form-control" value="<?= $dt_pedido?>" required>
                </div>

                <div class="col-sm-2">
                    <label for="dt_entrega">Data da Entrega</label>
                    <input type="date" name="dt_entrega" id="dt_entrega" class="form-control" value="<?= $dt_entrega?>" required>
                </div>

                <div class="col-sm-3">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="Aberto" <?php if($status == "Aberto") echo "selected" ?>>Aberto</option>
                        <option value="Em Transporte" <?php if($status == "Em Transporte") echo "selected" ?>>Em Transporte</option>
                        <option value="Recebido" <?php if($status == "Recebido") echo "selected" ?>>Recebido</option>
                        <option value="Cancelado" <?php if($status == "Cancelado") echo "selected" ?>>Cancelado</option>
                    </select>
                </div>
            </div>
        </div>
        <input type="number" name="id_pedido_externo" id="id_pedido_externo" value="<?= $id?>" style="display: none">

        <div style="text-align: center;"   >
            <button type="submit" class="btn btn-primary text-uppercase btn-lg" >       Atualizar Pedido       </button><br><br>
        </div>
        
    </form>

    <br><br>
    <form role="form" action="/pitstopcar/pedido/_adicionaritem.php" method="post">
        <div class="form-group">
            <div class="row">
                <div class="col-sm-4">
                    <label for="produto">Produto</label>
                    <select name="produto" id="produto" class="form-control" required>
                        <option disabled selected value="">Selecione o Produto/Peça</option>
                        <?php 
                        
                        //listar apenas produtos ativos == 1
                        $sql = "SELECT idProduto, descricao, categoria, preco 
                                FROM tb_produto 
                                WHERE id_master = ".ID_MASTER." AND estado = 1
                                ORDER BY descricao, categoria ASC";
                        $result = $conexao->query($sql);
                        
                        while($row = $result->fetch_assoc()){
                            $idProduto = $row['idProduto'];
                            $descricao = $row['descricao'];
                            $cat = $row['categoria'];
                            $preco = $row['preco'];
                        ?>
                        <option value="<?php echo $idProduto ?>"><?= $descricao." - ".$cat ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="col-sm-2">
                    <label for="quantidade">Quantidade</label>
                    <input type="number" name="quantidade" id="quantidade" class="form-control" value="1" min="1" required>
                </div>

                <div class="col-sm-2">
                    <label for="preco">Preço</label>
                    <input type="text" name="preco" id="preco" class="form-control" value="0" required>
                </div>

                <div class="col-sm-3" style="text-align: center;"  ><br>
                    <button type="submit" class="btn btn-primary botao_salvar btn-lg" >
                        Adicionar item
                    </button>
                </div>
            </div>
        </div>
        <input type="number" name="id_pedido_externo" id="id_pedido_externo" value="<?= $id?>" style="display: none">
    </form>

    <br><br>

    <h2>Itens do Pedido</h2>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Item</th>
                    <th scope="col">Quantidade</th>
                    <th scope="col">Preço</th>
                    <th scope="col">Valor</th>
                    <th>Excluir</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            $key = 1;
            $total = 0;
            $sql = "SELECT * FROM tb_itenspedido WHERE id_master = ".ID_MASTER." AND id_pedido = $id AND status > 0";
            $results_i = $conexao->query($sql);
            if($results_i->num_rows > 0){
                while($row = $results_i->fetch_assoc()){
                    $id_item = $row['id_item'];
                    $descricao = $row['descricao'];
                    $quantidade = $row['quantidade'];
                    $preco = $row['preco'];
                    $valor = $row['valor'];
                    $total += $valor;
                    ?>
                    <tr>
                        <td><?= $key++?></td>
                        <td><?= $descricao?></td>
                        <td><?= $quantidade?></td>
                        <td><?= number_format($preco,2,',','.')?></td>
                        <td><?= number_format($valor,2,',','.')?></td>
                        <td><a href="/pitstopcar/pedido/_excluiritem.php/?id_item=<?=$id_item?>&id_pedido=<?=$id?>"><i class="far fa-trash-alt"></i></a></td>
                    </tr>
                    <?php
                }
            }
            ?>
            </tbody>
        </table>
        <h2 class="totais">Total R$ <?= number_format($total,2,',','.') ?></h2>    
    </div>
    <br>
    <br>
    <br>

    <form role="form" action="/pitstopcar/pedido/_atualizar.php" method="post">
        <div class="form-group">
            <div class="row">
                <div class="col-sm-3 text-center">
                    <label for="forma_pag">Forma de Pagamento</label>
                    <select name="forma_pag" id="forma_pag" class="form-control" required>
                        <option disabled>Selecione uma forma de pagamento</option>
                        <option value="1" <?php if($forma_pag == 1) echo "selected" ?>>Dinheiro</option>
                        <option value="2" <?php if($forma_pag == 2) echo "selected" ?>>Débito</option>
                        <option value="3" <?php if($forma_pag == 3) echo "selected" ?>>Crédito</option>
                        <option value="4" <?php if($forma_pag == 4) echo "selected" ?>>Transferência Bancária</option>
                        <option value="5" <?php if($forma_pag == 5) echo "selected" ?>>Boleto</option>
                    </select>
                </div>
                <div class="col-sm-3 ">
                    <label for="taxa_entrega">Taxa de Entrega</label>
                    <input type="text" name="taxa_entrega" id="taxa_entrega" class="form-control" value="<?= $taxa_entrega?>">
                </div>
                <div class="col-sm-3 ">
                    <label for="desconto">Desconto R$</label>
                    <input type="text" name="desconto" id="desconto" class="form-control" value="<?= $desconto?>">
                </div>
                <div class="col-sm-3">
                    <label for="parcelado">Nº de Parcelas</label>
                    <input type="number" name="parcelado" id="parcelado" class="form-control" min='1' value="<?= $parcelado?>" <?php if($parcelado > 1) echo "readonly" ?> required>
                </div>
            </div>

            <br><br>

            <div class="d-flex justify-content-end">
                <h2 class="text-center total">Total Pago</h2>
                <h2 class="text-center total">R$ <?= number_format($total_pago,2,",",".") ?></h2>
            </div>

        </div>  
        <input type="number" name="id_pedido_externo" id="id_pedido_externo" value="<?= $id?>" style="display: none">
        <div style="text-align: center;"   >
            <button type="submit" class="btn btn-primary text-uppercase btn-lg" >       Atualizar Pedido       </button><br><br>
        </div>
    </form>              

    <br><br><br><br>
    <h2>Controle de Prestações</h2>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Data</th>
                    <th scope="col">Valor</th>
                    <th scope="col">Pago</th>
                    <th scope="col">Pago em</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php 
            $key = 1;
            $total = 0;
            $sql = "SELECT * FROM tb_cprestacao WHERE id_pedido = $id AND id_master = ". ID_MASTER;
            $results_i = $conexao->query($sql);
            if($results_i->num_rows > 0){
                while($row = $results_i->fetch_assoc()){
                    $id_cprestacao = $row['id_cprestacao'];
                    $sequencia = $row['sequencia'];
                    $dt_venc = $row['dt_venc'];
                    $vl_prest = $row['vl_prest'];
                    $pago = $row['pago'];
                    $dt_pag = $row['dt_pag']
                    ?>
                    <tr>
                        <td><?= $sequencia?></td>
                        <td><?= date("d/m/Y", strtotime($dt_venc))?></td>
                        <td><?= number_format($vl_prest,2,',','.')?></td>
                        <td><?= $pago == TRUE ? "SIM" : "Não"?></td>
                        <td><?= $pago == TRUE ? date("d/m/Y", strtotime($dt_pag)) : "" ?></td>
                        <td><?php if(!$pago){ ?><a href="/pitstopcar/pedido/_reg_pagamento.php/?id=<?= $id_cprestacao?>">Registrar Pagamento</a><?php }?> </td>
                    </tr>
                    <?php
                }
            }
            ?>
            </tbody>
        </table>
        <!-- <h2 class="totais">Total R$ <?= number_format($total,2,',','.') ?></h2>     -->
    </div>
       
</div>


<?php 
    if(isset($_SESSION['erro'])):
        unset($_SESSION['erro']);
    endif;
    include_once "../footer.html";
?>