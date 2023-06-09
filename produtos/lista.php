<?php 
    include_once "../header.php";
    //
?>
            
<div class="container">
    <br><h1>Todos Produtos</h1>

    <div style="text-align: right">         
        <a href="/pitstopcar/categoria/form.php/?tabela=produto" class="btn btn-primary text-uppercase mb-3 botao btn-lg"><i class="fas fa-plus"></i>Cadastrar Categoria de Produto</a>
        <a href="/pitstopcar/produtos/novo.php" class="btn btn-primary text-uppercase mb-3 botao btn-lg"><i class="fas fa-plus"></i>Novo Produto</a><br><br>
    </div>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Descrição</th>
                    <th scope="col">Categoria</th>
                    <th scope="col">Subcategoria</th>
                    <th scope="col">Fabricante</th>
                    <th scope="col" class="text-center">Quantidade</th>
                    <th scope="col">Volume</th>
                    <th scope="col">Preço</th>
                    <th scope="col" class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    
                    $sql = "SELECT * FROM tb_produto WHERE id_master = ".ID_MASTER." AND estado = 1 AND quantidade > 0 ORDER BY descricao, subcategoria, categoria ASC";
                    $select = $conexao->query($sql);

                    if ($result->num_rows > 0) {

                        while ($array = mysqli_fetch_array($select)) {
                            $idProduto = $array['idProduto'];
                            $descricao = $array['descricao'];
                            $categoria  = $array['categoria'];
                            $subcategoria  = $array['subcategoria'];
                            $fabricante  = $array['fabricante'];
                            $vl_compra   = $array['vl_compra'];
                            $preco  = $array['preco'];
                            $quantidade  = $array['quantidade'];
                            $estado   = $array['estado'];
                            $tamanho   = $array['tamanho'];
                            $dt_modif  = $array['dt_modif'];
                            $comentario = $array['comentario'];
                    ?>

                    <tr>
                        <td><?= $idProduto ?></td>
                        <td><?= $descricao ?></td>
                        <td><?= $categoria ?></td>
                        <td><?= $subcategoria ?></td>
                        <td><?= $fabricante ?></td>
                        <td class="text-center"><?= $quantidade ?></td>
                        <td><?= $tamanho ?></td>
                        <td><?= number_format($preco,2,',','.') ?></td>
                        <td>
                            <a href="editar.php/?id=<?= $idProduto?>" class="btn btn-primary text-uppercase mb-3 btn-sm botao"><i class="far fa-edit"></i> Editar</a>
                            <a href="_excluir.php/?id=<?= $idProduto?>" class="btn btn-primary text-uppercase mb-3 btn-sm botao"><i class="far fa-trash-alt"></i> Desativar</a>
                        </td>
                    </tr>
                <?php } 
            } else {
                ?> <h6>Não há produtos cadastrados</h6> <?php
            }
            ?>
            </tbody>
        </table>
        <br><br>
    </div>
       


    <br><br>

    <h3>Produtos Inativos</h3>
    
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Descrição</th>
                    <th scope="col">Categoria</th>
                    <th scope="col">Subcategoria</th>
                    <th scope="col">Fabricante</th>
                    <th scope="col">Quantidade</th>
                    <th scope="col">Volume</th>
                    <th scope="col">Preço</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    
                    $sql = "SELECT * FROM tb_produto WHERE id_master = ".ID_MASTER." AND (estado = 0 OR quantidade = 0) ORDER BY descricao, subcategoria, categoria ASC";
                    $select = $conexao->query($sql);

                    if ($result->num_rows > 0) {

                        while ($array = mysqli_fetch_array($select)) {
                            $idProduto = $array['idProduto'];
                            $id_negocio = $array['id_negocio'];
                            $descricao = $array['descricao'];
                            $categoria  = $array['categoria'];
                            $subcategoria  = $array['subcategoria'];
                            $fabricante  = $array['fabricante'];
                            $vl_compra   = $array['vl_compra'];
                            $preco  = $array['preco'];
                            $quantidade  = $array['quantidade'];
                            $estado   = $array['estado'];
                            $tamanho   = $array['tamanho'];
                            $dt_modif  = $array['dt_modif'];
                            $comentario = $array['comentario'];
                    ?>

                    <tr>
                        <td><?= $id_negocio ?></td>
                        <td><?= $descricao ?></td>
                        <td><?= $categoria ?></td>
                        <td><?= $subcategoria ?></td>
                        <td><?= $fabricante ?></td>
                        <td><?= $quantidade ?></td>
                        <td><?= $tamanho ?></td>
                        <td><?= number_format($preco,2,',','.') ?></td>
                        <td>
                            <a href="editar.php/?id=<?= $idProduto?>" class="btn btn-primary text-uppercase mb-3 btn-sm botao"><i class="far fa-edit"></i> Editar</a>
                        </td>
                    </tr>
                <?php } 
            } else {
                ?> <h6>Não há produtos cadastrados</h6> <?php
            }
            ?>
            </tbody>
        </table>
        <br><br>
    </div>
      
</div>


<?php 
    include_once "../footer.html";
?>

