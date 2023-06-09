<?php

include_once "../header.php";

$id_fornecedor = $_GET['id'];

$sql = "SELECT * FROM tb_fornecedor_pecas WHERE id_master = ".ID_MASTER. " AND id_fornecedor_pecas = $id_fornecedor";
$result = $conexao->query($sql);
$row = $result->fetch_assoc();
$nome_fantasia = $row['nome_fantasia'];
?>

<div class="container">
    <div class="p-2">
        <a href="<?php echo $_SERVER['HTTP_REFERER'] ?>" class="btn btn-primary text-uppercase mb-3"> Voltar</a>
    </div>
    <br>
    <h1>Atualizar Fornecedor de Peças</h1><br><br>

    <form role="form" action="/dfmultimarcas/fornecedor/_atualizar.php"  method="post" >
        <div class="form-group">

        
            <div class="row d-flex justify-content-center">

                <div class="col-sm-5">
                    <label for="nome_fantasia">Nome Fantasia</label>
                    <input type="text" class="form-control" id="nome_fantasia" name="nome_fantasia" maxlength="45" value="<?= $nome_fantasia ?>" required>
                </div>

                <input type="number" name="id_fornecedor_pecas" id="id_fornecedor_pecas" value="<?= $id_fornecedor?>" style="display:none">


            </div>
        </div>
        
        <div class="row d-flex justify-content-center">
            <div  class="m-3" style="width: 200px; text-align: center" >
                <button type="submit" class="btn btn-primary botao_salvar btn-lg " >       Atualizar       </button><br><br>
            </div>
        </div>
    </form> 
      
</div>


<?php
include_once "../footer.html";
?>