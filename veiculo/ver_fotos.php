<?php 
    include_once "../header.php";
    //

    $id = $_GET['id'];

    $sql = "SELECT foto1, foto2, foto3, foto4, foto5, foto6, foto7, foto8, foto9, foto10,
                    placa, marca, modelo, ano
    FROM tb_veiculo v 
    WHERE id_veiculo = $id";

    $result = $conexao->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $foto1 = $row['foto1'];
            $foto2 = $row['foto2'];
            $foto3 = $row['foto3'];
            $foto4 = $row['foto4'];
            $foto5 = $row['foto5'];
            $foto6 = $row['foto6'];
            $foto7 = $row['foto7'];
            $foto8 = $row['foto8'];
            $foto9 = $row['foto9'];
            $foto10 = $row['foto10'];
            $placa = $row['placa'];
    
            $marca = $row['marca'];
            $modelo = $row['modelo'];
            $ano = $row['ano'];

        }
    } else {
        echo "0 results";
    }
    
?>

<div class="container">

    <h1><?= $marca.' '.$modelo.' '.$placa ?></h1>
    <h2>Fotos</h2>
    <div class="form-group">

        <div class="row">

            <?php for ($i=1; $i <= 10; $i++) { if(isset(${"foto$i"})){?>
            <div class="col-sm-4">
                <img src="<?= ${"foto$i"}; ?>" class="img-thumbnail" alt="<?= "Veículo -PLACA: ".$placa.$i ?>" >
            </div>
            <?php } } ?>
        </div>
    </div>


    <br><br><br>

    <div class="p-2">
        <a href="<?= $_SERVER['HTTP_REFERER'] ?>" class="btn btn-primary text-uppercase mb-3 btn-lg"> Voltar</a>
    </div>
</div>