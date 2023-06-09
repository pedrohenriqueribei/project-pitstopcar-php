<?php 
    include_once "../header.php";
    //
?>

<?php if($nivel == 1): ?>            
<div class="container">
    <br><h1>Despesas</h1>
    <br><br>

    <div class="row">   
        <div class="col-sm-4">
            <form action="por_dia.php" role="form" method="post">
                <div class="form-group">
                    <input type="date" name="dt" id="dt" class="form-control" value="<?= date('Y-m-d') ?>">           
                </div>

                <div  style="text-align: center;">
                    <button type="submit" class="btn btn-primary botao">Pesquisar</button>
                </div>
            </form>
        </div>
    

        <div class="col-sm-4">
            <form action="periodo.php" role="form" method="post">
                <div class="form-group">
                    <label for="inicio">De</label>
                    <input type="date" name="inicio" id="inicio" class="form-control" value="<?= date('Y-m-d') ?>">
                    <label for="fim">Até</label>
                    <input type="date" name="fim" id="fim" class="form-control" value="<?= date('Y-m-d') ?>">
                </div>
                <div  style="text-align: center;"   >
                    <button type="submit" class="btn btn-primary botao" >Pesquisar</button><br><br>
                </div>    
            </form>
        </div>

        <div class="col-sm-4">
            <div style="text-align: right">
                <a href="form.php" class="btn btn-primary botao btn-lg"><i class="fas fa-plus"></i>Nova Despesa</a><br><br>
            </div>

            <div style="text-align: right">
                <a href="/pitstopcar/categoria/ver.php/?tabela=despesa" class="btn btn-primary botao btn-lg"><i class="fas fa-plus"></i>Ver Categorias</a><br><br>
            </div>

            <div style="text-align: right">
                <a href="/pitstopcar/categoria/form.php/?tabela=despesa" class="btn btn-primary botao btn-lg"><i class="fas fa-plus"></i>Cadastrar Categoria</a><br><br>
            </div>
        </div>
    </div>


    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="cab">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Data</th>
                    <th scope="col">Descrição</th>
                    
                    <th scope="col">Valor</th>
                    <th scope="col">Categoria</th>
                    <th scope="col">Total</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    
                    $sql = "SELECT * FROM tb_despesa WHERE id_master = ".ID_MASTER." ORDER BY dt_compra DESC, descricao ASC";
                    $result = $conexao->query($sql);

                    while ($row = $result->fetch_assoc()) {
                        $id_despesa = $row['id_despesa'];
                        $dt_compra = $row['dt_compra'];
                        $descricao = $row['descricao'];
                        $produto  = $row['produto'];
                        $valor   = $row['valor'];
                        $categoria  = $row['categoria'];
                        $total   = $row['total'];
                        
                        $cat = "SELECT descricao FROM tb_categoria WHERE id_master = ".ID_MASTER." AND id_categoria = $categoria";
                        $qy = $conexao->query($cat);
                        $ay = $qy->fetch_assoc();
                        $cat_desc = $ay['descricao'];
                ?>

                <tr>
                    <td><?= $id_despesa ?></td>
                    <td><?= date('d/m/Y',strtotime($dt_compra)) ?></td>
                    <td><a href="/pitstopcar/despesas/detalhar.php/?id=<?= $id_despesa?>"><?= $descricao ?></a></td>
                    
                    <td><?= number_format($valor,2,',','.') ?></td>
                    <td><?= $cat_desc ?></td>
                    <td><?= number_format($total,2,',','.') ?></td>
                    <td>
                        <a href="/pitstopcar/despesas/editar.php/?id=<?= $id_despesa?>" class="btn btn-primary btn-sm botao"><i class="fa fa-edit"></i> Editar</a>
                        <a href="/pitstopcar/despesas/excluir.php/?id=<?= $id_despesa?>" class="btn btn-primary btn-sm botao"><i class="far fa-trash-alt"></i> Excluir</a>
                    </td>
                </tr>
                <?php } $conexao->close();?>
            </tbody>
        </table>
        <br><br>
    </div>

  
    
</div>
<?php endif ?>

<?php 
    include_once "../footer.html";
?>

