<?php

include_once "../header.php";

?>

<div class="container">
    <div class="p-2">
        <a href="<?php echo $_SERVER['HTTP_REFERER'] ?>" class="btn btn-primary text-uppercase mb-3"> Voltar</a>
    </div>
    <br>
    <h1>Cadastrar Fornecedor de Peças</h1><br><br>

  
    <form role="form" action="_cadastrar.php"  method="post" >
        <div class="form-group">

        
            <div class="row d-flex justify-content-center">

                <div class="col-sm-5">
                    <label for="nome_fantasia">Nome Fantasia</label>
                    <input type="text" class="form-control" id="nome_fantasia" name="nome_fantasia" maxlength="45" required>
                </div>

                


            </div>
        </div>
        
        <div class="row d-flex justify-content-center">
        <div  class="m-3" style="width: 200px; text-align: center" >
            <button type="submit" class="btn btn-primary botao_salvar btn-lg " >       Cadastrar       </button><br><br>
        </div>
        </div>
    </form>     
       
</div>


<?php
include_once "../footer.html";
?>