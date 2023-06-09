<?php 
    include_once "../header.php";
    //

    if ($nivel == 1){

    $id = $_GET['id'];

    $sql = "SELECT * FROM tb_marca WHERE id_marca = $id AND id_master = ".ID_MASTER." ORDER BY 2 ASC";
    $result = $conexao->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $id_marca = $row['id_marca'];
            $descricao = $row['descricao'];
        }
    }
?>


<div class="container">
<br><br>

  
    <h1>Atualizar Marca</h1><br><br>

    <form role="form" action="/pitstopcar/marcas/_atualizar.php" class="templatemo-login-form" method="post" enctype="multipart/form-data">

        <div class="form-group">
            <div class="row">
                
                <div class="col-sm-3">
                    <label for="descricao">Marca</label>
                    <input type="text" class="form-control" id="descricao" name="descricao" value="<?= $descricao?>">
                </div>
                <div>
                    <input style="display: none" type="number" name="id_marca" value="<?= $id_marca ?>">
                </div>

                <div  class="col-sm-3"  >
                    <label for=""> </label><br>
                    <button type="submit" class="btn btn-primary botao_salvar btn-lg" ><i class="far fa-edit"></i>       Atualizar       </button><br><br>
                </div>
            </div>
        </div>
    </form>

   
</div>


<?php 
    }
    include_once "../footer.html";
?>