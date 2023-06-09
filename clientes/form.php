
<?php 
    include_once "../header.php";

    if(isset($_GET['telefone'])){
        $telefone = $_GET['telefone'];
    }
    else {
        $telefone = "61 ";
    }
?>
            
<div class="container">

    <br><h1 class="tm-block-title">Cadastrar Cliente</h1>
    
   

    <div class="row tm-content-row">
        <div class="col-12 tm-block-col">
            <div class="tm-bg-primary-dark tm-block tm-block-h-auto">

                <form role="form" action="/pitstopcar/clientes/_cadastrar.php" method="post">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="nome">Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite o nome" required>
                            </div>
                        
                            <div class="col-sm-4"> 
                                <label for="sobrenome">Sobrenome</label>
                                <input type="text" class="form-control" id="sobrenome" name="sobrenome" placeholder="Digite o sobrenome" required>
                            </div>

                            <div class="col-xs-6 col-sm-4"> 
                                <label for="cpf">CPF</label>
                                <input type="text" class="form-control" id="cpf" name="cpf" placeholder="000.000.000-00" >
                            </div>

                            <div class="col-xs-6 col-sm-4">
                                <label for="telefone">Telefone</label>
                                <input type="tel" class="form-control" id="telefone" name="telefone" placeholder="Digite o telefone" value="<?= $telefone ?> " required>
                            </div>

                            <div class="col-xs-6 col-sm-4">
                                <label for="sexo">Sexo</label><br>
                                <select class="form-control custom-select" id="sexo" name="sexo">
                                    <option  value="1">Feminino</option>
                                    <option selected value="2">Masculino</option>
                                </select>
                            </div>
                        
                            <div class="col-xs-6 col-sm-4">
                                <label for="data_nasc">Data de Nascimento</label><br>
                                <input type="date" class="form-control" id="data_nasc" name="data_nasc">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <label for="cep">CEP</label>
                                <input name="cep" type="text" class="form-control" id="cep" value="" size="10" maxlength="10" />
                            </div>

                            <div class="col-sm-8">
                                <label for="logradouro">Logradouro</label>
                                <input name="logradouro" type="text" class="form-control" id="logradouro" value="" size="200" />
                            </div>

                            <div class="col-sm-6">
                                <label for="complemento">Complemento</label>
                                <input name="complemento" type="text" class="form-control" id="complemento" value="" size="200" />
                            </div>

                            <div class="col-sm-3 col-xs-5">
                                <label for="bairro">Bairro</label>
                                <input name="bairro" type="text" class="form-control" id="bairro" size="40" />
                            </div>

                            <div class="col-sm-2 col-xs-5">
                                <label for="cidade">Cidade</label>
                                <input name="cidade" type="text" class="form-control" id="cidade" size="40" />
                            </div>
                            <div class="col-sm-1 col-xs-2">
                                <label for="uf">UF</label>
                                <input name="uf" type="text" class="form-control" id="uf" size="2" />
                            </div>
                        </div>
                    </div>

                    <input type="text" name="origem" id="origem" style="display: none" value="<?= $origem ?>">
                    <div style="text-align: center;"   >
                        <button type="submit" class="btn btn-primary text-uppercase mb-3 botao_salvar btn-lg col-sm-4" >       Salvar       </button><br><br>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
    </div></div>
</div>

<?php
include_once "../footer.html";
?>