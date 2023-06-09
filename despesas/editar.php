<?php 
    include_once "../header.php";
    //

    $id = $_GET['id'];

    $sql = "SELECT * FROM tb_despesa WHERE id_despesa = $id AND id_master = ".ID_MASTER;
    $query = $conexao->query($sql);
    $array = $query->fetch_assoc();
    
    $id_despesa = $array['id_despesa'];
    $descricao = $array['descricao'];
    $produto = $array['produto'];
    $dt_compra = $array['dt_compra'];
    $produto = $array['produto'];
    $valor = $array['valor'];
    $categoria = $array['categoria'];
    $total = $array['total'];
    $comentario = $array['comentario'];

    //$conexao->close();
?>
            
<div class="container">


    <br><h1>Atualizar Despesa</h1>

    <?php if($nivel == 1): ?>

   

    <form role="form" action="/pitstopcar/despesas/atualizar.php" method="post">
        <div class="form-group">
            <div class="row">
                <div class="col-sm-6">
                    <label for="descricao">Descrição</label>
                    <input type="text" class="form-control" id="descricao" name="descricao" value="<?= $descricao ?>" required>
                </div>
              
                <div class="col-sm-6"> 
                    <label for="valor">Valor</label>
                    <input type="text" class="form-control" id="valor" name="valor" value="<?= $valor ?>">
                </div>

                <div class="col-6 col-md-4">
                    <label for="categoria">Categoria</label>
                    <select class="form-control custom-select" id="categoria" name="categoria" >
                        <?php
                        echo $sql = "SELECT * FROM tb_categoria WHERE id_master = ". ID_MASTER. " AND tabela = 'despesa'";
                        $result = $conexao->query($sql);

                        while ($row = $result->fetch_assoc()) {
                            $id_categoria = $row['id_categoria'];
                            $desc_categoria = $row['descricao'];
                            ?>
                            <option value="<?= $id_categoria ?>" <?php if($categoria == $id_categoria){echo "selected";} ?>><?= $desc_categoria ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

                <div class="col-6 col-md-4">
                    <label for="dt_compra">Data</label>
                    <input type="date" class="form-control" id="dt_compra" name="dt_compra" value="<?= $dt_compra ?>">
                </div>

                <div class="col-sm-12">
                    <label for="comentario">Comentário</label>
                    <textarea class="form-control" name="comentario" id="comentario" cols="3"><?= $comentario?></textarea>
                </div>
                
                <div>
                    <input style="display: none" type="text" name="id_despesa" id="id_despesa" value="<?= $id_despesa ?>">
                </div>
               
            </div>
        </div>
        <div style="text-align: center;"   >
            <button type="submit" class="btn btn-primary botao_salvar btn-lg" >       Atualizar       </button><br><br>
        </div>
        
      </form>

      </div></div>

      <?php endif ?>
</div>




<?php
include_once "../footer.html";
?>