<?php 
    ob_start();
    include_once "../header.php";

    $id = $_GET['id'];

    if($nivel == 1):

        $sql = "SELECT * FROM tb_categoria WHERE id_master = ". ID_MASTER. " AND id_categoria = $id";

        $result = $conexao->query($sql);

        while ($row = $result->fetch_assoc()) {
            $id_categoria = $row['id_categoria'];
            $descricao = $row['descricao'];
            $tabela = $row['tabela'];
        }
?>

<div class="container">




    <br><h1>Cadastrar Categoria</h1>

    <form role="form" action="/pitstopcar/categoria/atualizar.php" method="post">
        <div class="form-group">
            <div class="row">
                <div class="col-4">
                    <label for="descricao">Descrição</label>
                    <input type="text" class="form-control" id="descricao" name="descricao" value="<?= $descricao ?>" required>
                </div>
                
                <div class="col-4">
                    <label for="tabela">Módulo</label>
                    <select class="form-control custom-select" id="tabela" name="tabela" required>
                        <option <?php if($tabela == "Despesa") echo "selected"?> value="Despesa">Despesa</option>
                        <option <?php if($tabela == "Produto") echo "selected"?> value="Produto">Produto</option>
                    </select>
                </div>

                <input style="display: none;" type="text" name="id_categoria" id="id_categoria" value="<?= $id_categoria ?>">
            </div>
        </div>
        <div style="text-align: center;"   >
            <button type="submit" class="btn btn-primary btn-lg" >       Atualizar       </button><br><br>
        </div>
        
    </form>


    
</div>

<?php 
    endif;
    $conexao->close();
    include_once "../footer.html";
    ob_end_flush();
?>