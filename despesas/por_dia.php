<?php 
    include_once "../header.php";
    //

    $dt = $_POST['dt'];

    $cont = 0;
    $saldo = 0;

?>


<div class="container">
    <br><h1>Despesas do dia <?= date('d/m', strtotime($dt)) ?></h1>
    <br><br>
    
    <div class="row">  
        <div class="col-sm-4"> 
            <h2>Por dia</h2>
            <form action="/pitstopcar/despesas/por_dia.php" role="form" method="post">
                <div class="form-group">
                    <label for="dt">De</label>
                    <input type="date" name="dt" id="dt" class="form-control" value="<?= date('Y-m-d') ?>">
                </div>
                <div  style="text-align: center;"   >
                    <button type="submit" class="btn btn-primary text-uppercase mb-3 botao" >Pesquisar</button><br><br>
                </div>
            </form>
        </div>

        <div class="col-sm-4"> 
            <h2>Por Período</h2>
            <form action="/pitstopcar/despesas/periodo.php" role="form" method="post">
                <div class="form-group">
                    <label for="inicio">De</label>
                    <input type="date" name="inicio" id="inicio" class="form-control" value="<?= date('Y-m-d') ?>">
                    <label for="fim">Até</label>
                    <input type="date" name="fim" id="fim" class="form-control" value="<?= date('Y-m-d') ?>">
                </div>
                <div  style="text-align: center;"   >
                    <button type="submit" class="btn btn-primary text-uppercase mb-3 botao" >Pesquisar</button><br><br>
                </div>
            </form>
        </div>
    </div>

    <div style="text-align: right">
        <a href="/pitstopcar/despesas/form.php" class="btn btn-primary text-uppercase mb-3 botao btn-lg"><i class="fas fa-plus"></i>Nova Despesa</a><br><br>
    </div>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr class="cab">
                    <th scope="col">ID</th>
                    <th scope="col">Data</th>
                    <th scope="col">Descrição</th>
                    <th scope="col">Produto</th>
                    <th scope="col">Valor</th>
                    <!-- <th scope="col">Quantidade</th> -->
                    <th scope="col">Total</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    
                    $sql = "SELECT * FROM tb_despesa WHERE id_master = ".ID_MASTER." AND dt_compra = '$dt'";
                    $select = $conexao->query($sql);
                    
                    while ($array = $select->fetch_assoc()) {
                        $id_despesa = $array['id_despesa'];
                        $dt_compra = $array['dt_compra'];
                        $descricao = $array['descricao'];
                        $produto  = $array['produto'];
                        $valor   = $array['valor'];
                        // $quantidade  = $array['quantidade'];
                        $total   = $array['total'];
                        // $cont = $cont + $quantidade;
                        $saldo = $saldo + $total;
                ?>

                <tr>
                    <td><?= $id_despesa ?></td>
                    <td><?= date('d/m/Y',strtotime($dt_compra)) ?></td>
                    <td><a href="/pitstopcar/despesas/detalhar.php/?id=<?= $id_despesa?>"><?= $descricao ?></a></td>
                    <td><?= $produto ?></td>
                    <td><?= $valor ?></td>
                    <!-- <td><?= $quantidade ?></td> -->
                    <td><?= $total ?></td>
                    <td>
                        <a href="/pitstopcar/despesas/form_editar.php/?id=<?= $id_despesa?>" class="btn btn-primary text-uppercase mb-3 btn-sm botao"><i class="fa fa-edit"></i>Editar</a>
                        <a href="/pitstopcar/despesas/excluir.php/?id=<?= $id_despesa?>" class="btn btn-primary text-uppercase mb-3 btn-sm botao"><i class="far fa-trash-alt"></i>Excluir</a>
                    </td>
                </tr>
                <?php } 
                $conexao->close(); 
                ?>
            </tbody>
        </table>
        <br><br>
    </div>



    <!-- <h3>Itens: <?= $cont ?> </h3> -->
    <h3>Total R$ <?= number_format($saldo,2,',','.') ?></h3>
    <br><br>

</div>


<?php 
    include_once "../footer.html";
?>