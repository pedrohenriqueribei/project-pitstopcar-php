<?php
include_once "../header.php";

$id = $_GET['id'];

$sql = "SELECT * FROM tb_produto WHERE idProduto = $id AND id_master = ".ID_MASTER;

$select = $conexao->query($sql);

$array = $select->fetch_assoc();

if ($select->num_rows > 0) {

    $idProduto = $array['idProduto'];
    $descricao = $array['descricao'];
    $categoria = $array['categoria'];
    $subcategoria = $array['subcategoria'];
    $fabricante = $array['fabricante'];
    $preco = $array['preco'];
    $quantidade = $array['quantidade'];
    $estado = $array['estado'];
    $tamanho = $array['tamanho'];
    $perc_lucro = $array['perc_lucro'];
    $dt_modif = $array['dt_modif'];
    $comentario = $array['comentario'];

    ?>

    <div class="container">


        <br><h1>Atualizar Produto</h1>
        <form role="form" action="/pitstopcar/produtos/_atualizar.php" method="post">
            <div class="form-group">
                <div class="row">
                
                    <div class="col-sm-4">
                        <label for="descricao">Descrição</label>
                        <input type="text" name="descricao" id="descricao" class="form-control" value="<?= $descricao?>">
                    </div>
                
                    <div class="col-sm-3"> 
                        <label for="categoria">Categoria</label>
                        <select class="form-control" id="categoria" name="categoria">
                            <option selected disabled>Selecione uma categoria</option>
                            <?php 
                            $sql = "SELECT * FROM tb_categoria WHERE id_master = ".ID_MASTER." AND tabela = 'produto'";
                            $result = $conexao->query($sql);
                            if($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    $id_categoria = $row['id_categoria'];
                                    $desc_cat = $row['descricao'];
                                    ?>
                                    <option value="<?= $desc_cat?>" <?php if($desc_cat == $categoria) echo "selected" ?>><?= $desc_cat?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-sm-3 col-md-4">
                        <label for="subcategoria">Subcategoria</label>
                        <input type="text" class="form-control" name="subcategoria" id="subcategoria" value="<?= $subcategoria?>">
                    </div>

                    <div class="col-sm-3 col-md-4">
                        <label for="fabricante">Fabricante</label>
                        <input type="text" class="form-control" name="fabricante" id="fabricante" value="<?= $fabricante?>">
                    </div>

                    <div class="col-sm-6 col-md-4">
                        <label for="estado">Status</label><br>
                        <select class="form-control" id="estado" name="estado" required>
                            <option <?php if($estado == 1) echo "selected"?> value="1">Ativo</option>
                            <option <?php if($estado == 0) echo "selected"?> value="0">Inativo</option>
                        </select>
                    </div>

                    <div class="col-sm-3">
                        <label for="quantidade">Quantidade</label><br>
                        <input type="number" class="form-control" id="quantidade" name="quantidade" min="0" value="<?= $quantidade?>" readonly>
                    </div>

                    <div class="col-sm-2">
                        <label for="preco">Preço</label><br>
                        <input type="text" class="form-control" id="preco" name="preco" min="1"  value="<?= $preco?>" >
                    </div>

                    <div class="col-sm-2">
                        <label for="tamanho">Volume</label><br>
                        <input type="text" class="form-control" id="tamanho" name="tamanho"  value="<?= $tamanho?>">
                    </div>

                    <div class="col-sm-3">
                        <label for="perc_lucro">Percentual de Lucro (%)</label><br>
                        <input type="text" class="form-control" id="perc_lucro" name="perc_lucro" value="<?= $perc_lucro?>">
                    </div>

                    <div class="col-sm-12">
                        <label for="comentario">Comentário</label>
                        <textarea class="form-control" name="comentario" id="comentario" cols="3"><?= $comentario?></textarea>
                    </div>
                    
                    <input style="display:none" type="number" name="idProduto" id="idProduto" value="<?= $idProduto?>">
                </div>
            </div>
            <div class="text-center w-100"   >
                <button type="submit" class="btn btn-primary text-uppercase mb-3 botao_salvar btn-lg" >       Atualizar       </button><br><br>
            </div>
            
        </form>

        

        <div style="text-align: center;">
            <a href="/pitstopcar/produtos/lista.php" role="button" class="btn btn-primary text-uppercase mb-3 botao_salvar col-6 col-md-2">Voltar</a>
            <br><br>
        </div>
    </div>

    <?php

} else {
    echo "Produto nao localizado!!";
}

    $conexao->close();

    include_once "../footer.html";
?>