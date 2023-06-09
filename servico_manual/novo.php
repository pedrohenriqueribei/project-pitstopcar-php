<?php 
    include_once "../header.php";
?>

<div class="container">

    <br><h1>Cadastrar Serviço de Manutenção</h1>


    <form role="form" action="_cadastrar.php" method="post">
        <div class="form-group">
            <div class="row">
                <div class="col-sm-4">
                    <label for="descricao">Descrição</label>
                    <input type="text" name="descricao" id="descricao" class="form-control">
                </div>

                <div class="col-sm-2">
                    <label for="preco">Preço</label><br>
                    <input type="text" class="form-control" id="preco" name="preco" min="1">
                </div>

            </div>
        </div>
        <div style="text-align: center;"   >
            <button type="submit" class="btn btn-primary text-uppercase mb-3 botao_salvar btn-lg col-sm-4" >       Cadastrar       </button><br><br>
        </div>
        
    </form>
     
</div>



<?php include_once "../footer.html";