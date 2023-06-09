<?php
    include_once "../header.php";
    //
    
    

    $dt_ini = $_POST['inicio'];
    $dt_fim = $_POST['fim'];

    $saldo = 0;
    $cont = 0;

?>

<div class="container">

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
        <a href="/pitstopcar/despesas/form.php" class="col-sm-3 btn btn-primary text-uppercase mb-3 btn-lg botao">Nova Despesa</a>
    </div>

    <br><h1>Despesas entre <?= date('d/m/Y', strtotime($dt_ini)) ?> a <?= date('d/m/Y', strtotime($dt_fim)) ?></h1><br>

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
                
                $sql = "SELECT * FROM tb_despesa WHERE id_master = ".ID_MASTER." AND dt_compra >= '$dt_ini' AND dt_compra <= '$dt_fim'";
                $query = $conexao->query($sql);

                while ($array = $query->fetch_assoc()) {
                    $id_despesa = $array['id_despesa'];
                    $dt_compra = $array['dt_compra'];
                    $descricao = $array['descricao'];
                    $produto  = $array['produto'];
                    $valor   = $array['valor'];
                    // $quantidade  = $array['quantidade'];
                    $total   = $array['total'];
                    $saldo = $saldo + $total;
                    // $cont = $cont + $quantidade;

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
                <?php
                }
                $conexao->close();
                ?>
            </tbody>
        </table>
    </div>

    <h2 class="totais">Total em despesas R$ <?= number_format($saldo,2,',','.') ?></h2>
    <!-- <h2 class="totais">Quantidade de itens comprados <?= ($cont) ?></h2> -->

</div>


<?php 
    include_once "../footer.html";
?>