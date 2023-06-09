<?php 
    include_once "../header.php";
    
?>

<div class="container">
    <br><br>
    <h1>Nova Ordem de Serviço</h1><br><br>

    <div style="text-align: right">
        <a href="/pitstopcar/clientes/form.php" class="btn btn-primary btn-lg">Cadastrar Novo Cliente</a>
    </div>
    <br><br>


    <h2>Localizar Cliente</h2><br>

    <form action="/pitstopcar/servicos/os_clienteloc.php" role="form" method="post" >
        <div class="form-group">
           
            <div class="row">
                <div class="col-sm-4">
                    <label for="nome">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" readonly>
                </div>
            
                <div class="col-sm-4"> 
                    <label for="sobrenome">Sobrenome</label>
                    <input type="text" class="form-control" id="sobrenome" name="sobrenome" readonly>
                </div>

                <div class="col-sm-4 col-xs-6"> 
                    <label for="cpf">CPF</label>
                    <input type="text" class="form-control" id="cpf" name="cpf" readonly>
                </div>

                <div class="col-6 col-md-4 col-xs-6">
                    <label for="telefone">Telefone</label>
                    <input type="text" class="form-control" id="telefone" name="telefone" value="61">
                </div>

                <div class="col-6 col-md-4 col-xs-6">
                    <label for="sexo">Sexo</label><br>
                    <input type="text" class="form-control" id="sexo" name="sexo" readonly>
                </div>
            
                <div class="col-md-4 col-xs-6">
                    <label for="data_nasc">Data de Nascimento</label><br>
                    <input type="date" class="form-control" id="data_nasc" name="data_nasc" readonly>
                </div>
            </div>
        
    
            <div class="row">
                <div class="col-sm-12">
                    <label for="cep">Endereço</label>
                    <input name="text" type="text" class="form-control" id="cep" size="10" maxlength="8" readonly />
                </div>
            </div>

            <div style="text-align: center;"  ><br>
                <button type="submit" class="btn btn-primary btn-lg">Localizar Cliente</button>
            </div>
        </div>
            


    </form>
</div>


<?php 
    include_once "../footer.html";
?>