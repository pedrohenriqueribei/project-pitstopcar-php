
<?php 
    include_once "../header.php";
?>
            
<div class="container">
    <div class="mt-2" style="text-align: right">   
        <a href="/pitstopcar/produtos/novo.php" class="btn btn-primary text-uppercase botao btn-lg"><i class="fas fa-plus"></i>Novo Produto</a>  
        <a href="../fornecedor/novo.php" class="btn btn-primary btn-lg">Cadastrar Fornecedor</a>     
        <a href="/pitstopcar/pedido/lista.php" class="btn btn-primary text-uppercase botao btn-lg">Voltar</a><br><br>
    </div>
    <br>
    <h1>Cadastrar Pedido Externo de Peças/Produtos</h1><br>


    <form role="form" action="/pitstopcar/pedido/_cadastrar.php" method="post">
        <div class="form-group">
            <div class="row">
                <div class="col-sm-2">
                    <label for="codigo_externo">Código Externo</label>
                    <input type="number" name="codigo_externo" id="codigo_externo" class="form-control" min="0" value="0">
                </div>

                <div class="col-sm-3">
                    <label for="fornecedor">Fornecedor</label>
                    <select name="fornecedor" id="fornecedor" class="form-control" required>
                        <option disabled selected>Selecione um fornecedor</option>
                        <?php
                        $sql = "SELECT * FROM tb_fornecedor_pecas WHERE id_master = ". ID_MASTER;
                        $results = $conexao->query($sql);
                        if($results->num_rows > 0){
                            while($row = $results->fetch_assoc()){
                                $id_forn = $row['id_fornecedor_pecas'];
                                $nome_fantasia = $row['nome_fantasia'];
                                ?>
                                <option value="<?= $id_forn?>"><?= $nome_fantasia?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="col-sm-3">
                    <label for="dt_pedido">Data do Pedido</label>
                    <input type="date" name="dt_pedido" id="dt_pedido" class="form-control" value="<?= date('Y-m-d')?>" required>
                </div>

                <div class="col-sm-3">
                    <label for="dt_entrega">Data da Entrega</label>
                    <input type="date" name="dt_entrega" id="dt_entrega" class="form-control" value="<?= date('Y-m-d')?>" required>
                </div>
            </div>
        </div>

        <div style="text-align: center;"   >
            <button type="submit" class="btn btn-primary text-uppercase btn-lg" >       Gerar Pedido Externo      </button><br><br>
        </div>
        
    </form>
        
</div>

<?php include_once "../footer.html"; ?>