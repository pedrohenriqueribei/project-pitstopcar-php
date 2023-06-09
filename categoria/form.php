<?php 
ob_start();
    include_once "../header.php";
    
    if(isset($_GET['tabela'])){
        $tabela = $_GET['tabela'];
    }
?>
            
<div class="container">

    <?php if($nivel == 1): ?>

   

    <br><h1>Cadastrar Categoria</h1>

    <form role="form" action="/pitstopcar/categoria/salvar.php" method="post">
        <div class="form-group">
            <div class="row">
                <div class="col-4">
                    <label for="descricao">Descrição</label>
                    <input type="text" class="form-control" id="descricao" name="descricao"  required>
                </div>
                
                <div class="col-4">
                    <label for="tabela">Módulo</label>
                    <select class="form-control custom-select" id="tabela" name="tabela" required>
                        <option value="Despesa" <?php if(isset($tabela)){ echo $tabela == "despesa" ? "selected" : "";} ?> >Despesa</option>
                        <option value="Produto"<?php if(isset($tabela)){ echo $tabela == "produto" ? "selected" : "";}?> >Produto</option>
                        <option value="Servico">Serviços</option>
                    </select>
                
                </div>
            </div>
        </div>
        <div style="text-align: center;"   >
            <button type="submit" class="btn btn-primary btn-lg" >       Cadastrar       </button><br><br>
        </div>
        
      </form>

      </div>
      </div>
      
      <?php endif ?>
</div>




<?php
include_once "../footer.html";
ob_end_flush();
?>