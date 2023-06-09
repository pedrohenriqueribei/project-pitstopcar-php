<?php 
    include_once "../header.php";
    //

    $id = $_GET['id'];

    $sql = "SELECT foto1, foto2, foto3, foto4, foto5
    FROM tb_ordem_servico
    WHERE id_servico = $id";

    $result = $conexao->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $foto1 = $row['foto1'];
            $foto2 = $row['foto2'];
            $foto3 = $row['foto3'];
            $foto4 = $row['foto4'];
            $foto5 = $row['foto5'];
        }
    } else {
        echo "0 results";
    }
    
?>

<div class="container">

    

    <h1>Fotos</h1>
    
    <div class="form-group">

        <div class="row">

            <?php for ($i=1; $i <= 5; $i++) { if(isset(${"foto$i"})){?>
            <div class="col-sm-4">
                <img src="<?= ${"foto$i"}; ?>" class="img-thumbnail" alt="<?= "Veículo -PLACA: ".$placa.$i ?>" >
            </div>
            <?php } } ?>
        </div>
    </div>

           
    <br><br><br>

    <div class="p-2">
        <a href="<?= $_SERVER['HTTP_REFERER'] ?>" class="btn btn-primary text-uppercase mb-3 btn-lg"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Voltar</a>
    </div>
</div>

<?php include_once "../footer.html" ?>