<?php 
    include_once "../header.php";
    //
?>
            
<div class="container">

    <?php if($nivel == 1): ?>
    <br><h1>Cadastrar Despesa</h1>

   

    <form role="form" action="cadastrar.php" method="post">
        <div class="form-group">
            <div class="row">
                <div class="col-sm-6">
                    <label for="descricao">Descrição</label>
                    <input type="text" class="form-control" id="descricao" name="descricao"  required>
                </div>
              
                <div class="col-sm-6"> 
                    <label for="categoria">Valor</label>
                    <input type="text" class="form-control" id="valor" name="valor">
                </div>

                <div class="col-6 col-md-4">
                    <label for="categoria">Categoria</label>
                    <select class="form-control" id="categoria" name="categoria" >
                        <?php
                        echo $sql = "SELECT * FROM tb_categoria WHERE id_master = ". ID_MASTER. " AND tabela = 'despesa'";
                        $result = $conexao->query($sql);

                        while ($row = $result->fetch_assoc()) {
                            $id_categoria = $row['id_categoria'];
                            $desc_categoria = $row['descricao'];
                            ?>
                            <option value="<?= $id_categoria ?>"><?= $desc_categoria ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

                <div class="col-6 col-md-4">
                    <label for="dt_compra">Data</label>
                    <input type="date" class="form-control" id="dt_compra" name="dt_compra" value="<?= date('Y-m-d') ?>">
                </div>

                <div class="col-sm-12">
                    <label for="comentario">Comentário</label>
                    <textarea class="form-control" name="comentario" id="comentario" cols="30" rows="5"></textarea>
                </div>

               
            </div>
        </div>
        <div style="text-align: center;"   >
            <button type="submit" class="btn btn-primary botao_salvar btn-lg" >       Cadastrar       </button><br><br>
        </div>
        
      </form>

      </div></div>

      <?php endif ?>
</div>




<?php
include_once "../footer.html";
?>