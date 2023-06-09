<?php
include_once "../header.php";
//
?>

<div class="container">
    <br><h1>Novo Funcionário</h1><br><br>


    <form role="form" action="/pitstopcar/entrar/user_salvar.php" method="post">
        <div class="form-group">
            <div class="row">
                <div class="col-sm-6">
                    <label for="nome">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite o nome do funcionário" required>
                </div>
            
                <div class="col-sm-6"> 
                    <label for="usuario">Usuário</label>
                    <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Digite o usuario" style="text-transform: lowercase" required>
                </div>

                <div class="col-6 col-md-4">
                    <label for="senha">Senha padrão (12345)</label>
                    <input type="password" class="form-control" id="senha" name="senha" placeholder="" value="12345" required>
                </div>

                <div class="col-6 col-md-4">
                    <label for="nivel">Nível de Acesso</label><br>
                    <select class="form-control custom-select" id="nivel" name="nivel">
                        <option value="1">Master</option>
                        <option selected value="2">Funcionário</option>
                        <option  value="3">Mecânico</option>
                    </select>
                </div>
            
                
            </div>

        </div>
        <div style="text-align: center;"   >
            <button type="submit" class="btn btn-primary text-uppercase mb-3 botao_salvar btn-lg col-sm-4" >       Salvar       </button><br><br>
        </div>
        
    </form>
       
</div>

<?php 
include_once "../footer.html";
?>