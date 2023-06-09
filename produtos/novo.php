
<?php 
    include_once "../header.php";
?>
            
<div class="container">
    <div class="mt-2" style="text-align: right">  
        <a href="../categoria/form.php/?tabela=produto" class="btn btn-primary text-uppercase botao btn-lg"><i class="fas fa-plus"></i>Nova Categoria</a>
        <a href="../fornecedor/novo.php" class="btn btn-primary btn-lg">Cadastrar Fornecedor</a>       
        <a href="../pedido/novo.php" class="btn btn-primary text-uppercase botao btn-lg"><i class="fas fa-plus"></i>Novo Pedido</a><br><br>
    </div>

    <br><h1>Cadastrar Produto</h1>


    <form role="form" action="/pitstopcar/produtos/_cadastrar.php" method="post">
        <div class="form-group">
            <div class="row">
                <div class="col-sm-4">
                    <label for="descricao">Descrição</label>
                    <input type="text" name="descricao" id="descricao" class="form-control">
                </div>
            
                <div class="col-sm-3"> 
                    <label for="categoria">Categoria</label>
                    <select class="form-control" id="categoria" name="categoria">
                        <option selected disabled>Selecione uma categoria</option>
                        <?php 
                        $sql = "SELECT * FROM tb_categoria WHERE id_master = ".ID_MASTER." AND tabela = 'produto' ORDER BY descricao ASC";
                        $result = $conexao->query($sql);
                        if($result->num_rows > 0){
                            while($row = $result->fetch_assoc()){
                                $id_categoria = $row['id_categoria'];
                                $descricao = $row['descricao'];
                                ?>
                                <option value="<?= $descricao?>"><?= $descricao?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="col-sm-3 col-md-4">
                    <label for="subcategoria">Subcategoria</label>
                    <input type="text" class="form-control" name="subcategoria" id="subcategoria">
                </div>

                <div class="col-sm-3 col-md-4">
                    <label for="fabricante">Fabricante</label>
                    <input type="text" class="form-control" name="fabricante" id="fabricante">
                </div>

                <div class="col-sm-3 col-md-3">
                    <label for="estado">Status</label><br>
                    <select class="form-control" id="estado" name="estado" required>
                        <option selected value="1">Ativo</option>
                        <option value="0">Inativo</option>
                    </select>
                </div>

                <div class="col-sm-2">
                    <label for="quantidade">Quantidade</label><br>
                    <input type="number" class="form-control" id="quantidade" name="quantidade" min="1" value="0" readonly>
                </div>

                <div class="col-sm-2">
                    <label for="preco">Preço</label><br>
                    <input type="text" class="form-control" id="preco" name="preco" min="0" value="0" readonly>
                </div>

                <div class="col-sm-2">
                    <label for="tamanho">Volume</label><br>
                    <input type="text" class="form-control" id="tamanho" name="tamanho" value="Unidade">
                </div>

                <div class="col-sm-3">
                    <label for="perc_lucro">Percentual de Lucro (%)</label><br>
                    <input type="text" class="form-control" id="perc_lucro" name="perc_lucro" value="0">
                </div>

                <div class="col-sm-12">
                    <label for="comentario">Comentário</label>
                    <textarea class="form-control" name="comentario" id="comentario" cols="30" rows="5"></textarea>
                </div>

                
            </div>
        </div>
        <div style="text-align: center;"   >
            <button type="submit" class="btn btn-primary text-uppercase btn-lg" >       Cadastrar       </button><br><br>
        </div>
        
    </form>
       
</div>

<?php include_once "../footer.html"; ?>