<?php 
    include_once "../header.php";
    //

    $id_veiculo = $_GET['id'];

    $sql = "SELECT * FROM tb_veiculo WHERE id_veiculo = $id_veiculo";
    $result = $conexao->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $placa = $row['placa'];
        $marca = $row['marca'];
        $modelo = $row['modelo'];
        $ano = $row['ano'];
    
    } else {
        echo "0 results";
    }

?>

<div class="container">



    <br><h1>Veículo <?= $modelo." ".$placa?></h1><br><br>   

    <form role="form" action="/pitstopcar/veiculo/_atualizar.php" method="post" enctype="multipart/form-data">
        <div class="form-group">

            <h2>Atualizar Dados do Veículo</h2><br><br>
            <div class="row">

                <div class="col-sm-3">
                    <label for="placa">Placa</label>
                    <input type="text" class="form-control" id="placa" name="placa" maxlength="8" value="<?= $placa?>" >
                </div>

                <div class="col-sm-3"> 
                    <label for="modelo">Modelo</label>
                    <input type="text" class="form-control" id="modelo" name="modelo" value="<?= $modelo?>" >
                </div>

                <div class="col-6 col-md-3">
                    <label for="marca">Marca</label>
                    <select class="form-control" id="marca" name="marca" required>
                        <?php
                        $sql = "SELECT * FROM tb_marca WHERE id_master = ".ID_MASTER."
                                ORDER BY descricao ASC";
                        $result = $conexao->query($sql);

                        while ($row = $result->fetch_assoc()) {
                            $id_categoria = $row['id_marca'];
                            $desc_marca = $row['descricao'];
                            ?>
                            <option value="<?= $desc_marca ?>" <?php if($marca == $desc_marca) echo "selected" ?>><?= $desc_marca ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

                <div class="col-6 col-md-3"> 
                    <label for="ano">Ano Fabricação</label>
                    <select class="form-control" id="ano" name="ano">
                        <?php
                        
                        for ($i=2021; $i > 1980; $i--) { 
                            ?>
                            <option value="<?= $i?>" <?php if ($ano == $i) echo "selected" ?>><?= $i?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>

            <BR></BR>

            <div class="row pt-5">
        
                <div class="col-6 col-md-3">
                    <label for="foto1">Foto 1 <?= isset($foto1) ? "<smal style='color: red'>(Carregada)</smal>" : "<smal style='color: blue'>(Sem foto)</smal>" ?></label>
                    <input type="file" name="foto1" class="form-control form-control-file" accept="image/*" capture>
                </div>

                <div class="col-6 col-md-3">
                    <label for="foto2">Foto 2 <?= isset($foto2) ? "<smal style='color: red'>(Carregada)</smal>" : "<smal style='color: blue'>(Sem foto)</smal>" ?></label>
                    <input type="file" name="foto2" class="form-control form-control-file" accept="image/*" capture>
                </div>

                <div class="col-6 col-md-3">
                    <label for="foto3">Foto 3 <?= isset($foto3) ? "<smal style='color: red'>(Carregada)</smal>" : "<smal style='color: blue'>(Sem foto)</smal>" ?></label>
                    <input type="file" name="foto3" class="form-control form-control-file" accept="image/*" capture>
                </div>

                <div class="col-6 col-md-3">
                    <label for="foto4">Foto 4 <?= isset($foto4) ? "<smal style='color: red'>(Carregada)</smal>" : "<smal style='color: blue'>(Sem foto)</smal>" ?></label>
                    <input type="file" name="foto4" class="form-control form-control-file" accept="image/*" capture>
                </div>

                <div class="col-6 col-md-3">
                    <label for="foto5">Foto 5 <?= isset($foto5) ? "<smal style='color: red'>(Carregada)</smal>" : "<smal style='color: blue'>(Sem foto)</smal>" ?></label>
                    <input type="file" name="foto5" class="form-control form-control-file" accept="image/*" capture>
                </div>
            </div>
        </div>

        <input style="display:none" type="number" name="id_veiculo" id="id_veiculo" value="<?= $id_veiculo ?>">

        <div  class="mx-auto" style="width: 200px;" >
            <button type="submit" class="btn btn-primary botao_salvar btn-lg" >       Atualizar       </button><br><br>
        </div>

    </form>

</div>



<?php
    include_once "../footer.html";
?>