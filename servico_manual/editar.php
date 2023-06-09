<?php 
    include_once "../header.php";
    $id = $_GET['id'];

    $sql = "SELECT * FROM tb_servico_manual WHERE id_servico_manual = $id";
    $result = $conexao->query($sql);
    
    if($result->num_rows == 1){
        $row = $result->fetch_assoc();
        $descricao = $row['descricao'];
        $preco = $row['preco'];
        $ativo = $row['ativo'];
    }
?>

<div class="container">

    <br><h1>Atualizar Serviço de Manutenção</h1>

    <form role="form" action="/pitstopcar/servico_manual/_atualizar.php" method="post">
        <div class="form-group">
            <div class="row">
                <div class="col-sm-4">
                    <label for="descricao">Descrição</label>
                    <input type="text" name="descricao" id="descricao" class="form-control" value="<?= $descricao?>">
                </div>

                <div class="col-sm-2">
                    <label for="preco">Preço</label><br>
                    <input type="text" class="form-control" id="preco" name="preco" min="1" value="<?= $preco?>">
                </div>

                <div class="col-sm-2">
                    <label for="ativo">Ativo</label><br>
                    <input type="text" class="form-control" id="ativo" name="ativo" value="<?= $ativo ? "Ativo" : "Inativo" ?>" disabled>
                </div>

                <input type="number" name="id_servico_manual" id="id_servico_manual" value="<?= $id?>" style="display: none">

            </div>
        </div>
        <div style="text-align: center;"   >
            <button type="submit" class="btn btn-primary text-uppercase mb-3 botao_salvar btn-lg col-sm-4" >       Atualizar       </button><br><br>
        </div>
        
    </form>
      
</div>



<?php include_once "../footer.html";