<?php
ob_start();

include_once "../header.php";
//

$id_veiculo = $_POST['id_veiculo'];
$placa = $_POST['placa'];
$modelo = $_POST['modelo'];
$marca = $_POST['marca'];
$ano = $_POST['ano'];




echo $sql = "UPDATE tb_veiculo SET 
        placa = '$placa',
        modelo = '$modelo',
        marca = '$marca',
        ano = $ano
        
        WHERE id_veiculo = $id_veiculo";
if ($conexao->query($sql) === TRUE) {
    echo "Record updated successfully";

    //carregar fotos

    for ($i=1; $i <= 10; $i++) { 
        
        //carregamento de arquivo foto JPG
        $pastaUpload = dirname(__DIR__) . '/recursos/img/';
    
        if ($_FILES && $_FILES["foto$i"] && $_FILES["foto$i"]['error'] == 0) {
            $tmp = $_FILES["foto$i"]['tmp_name'];
            $tipo = exif_imagetype($tmp);
            $nome = $placa."_$i";
    
            if ($tipo === 2 || $tipo === 3) {
                $tipo === 2 ? $ext = '.jpg' : $ext = '.png';
                $pastaFinal = $pastaUpload . $nome . $ext;
                
                if (move_uploaded_file($tmp, $pastaFinal)) {
                    echo 'Sucesso';
                } else {
                    echo 'Erro';
                }
            }
            $localNomeIMG = "/pitstopcar/recursos/img/$nome$ext";
    
            $foto = "UPDATE tb_veiculo SET 
            foto$i = '$localNomeIMG'
            WHERE id_veiculo = $id_veiculo";
    
            if ($conexao->query($foto) === TRUE) {
                echo "<br> Foto $i carregada";
            } else {
                echo "Erro ao carregar foto: " . $conexao->error;
            }
        }
            
    }
} else {
    echo "Error updating record: " . $conexao->error;
}

header("Location: lista.php");








$conexao->close();


include_once "../footer.html";
ob_end_flush();
?>