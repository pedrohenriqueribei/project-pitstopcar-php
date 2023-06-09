<?php
ob_start();
include_once "../header.php";

$idCliente = $_POST['idCliente'];
$id_veiculo = $_POST['id_veiculo'];
$km = $_POST['km'];
$tipo = $_POST['tipo'];
$status = 1;
$dt_previsao = $_POST['dt_previsao'];
$observacao = $_POST['observacao'];
$mecanico = $_POST['mecanico'];

//buscar id de negócio
$sql = "SELECT max(id_negocio) FROM tb_ordem_servico WHERE id_master = ". ID_MASTER;
$result = $conexao->query($sql);
$row = $result->fetch_assoc();
$id_negocio = $row['max(id_negocio)'] >= 1 ? $row['max(id_negocio)'] : 0;
$id_negocio++;


$insert = "INSERT INTO tb_ordem_servico (id_negocio, cliente, id_veiculo, id_master, dt_servico, hr_servico, tipo, status, dt_previsao, observacao, km, id_mecanico) 
            VALUES ($id_negocio, $idCliente, $id_veiculo,". ID_MASTER .", curdate(), curtime(), '$tipo', $status, '$dt_previsao', '$observacao', $km, $mecanico)";

if ($conexao->query($insert) === TRUE) {
    $last_id = $conexao->insert_id;
    echo "Ordem de serviço aberto com sucesso. Last inserted ID is: " . $last_id;
    
    
    //carregar fotos
    for ($i=1; $i <= 5; $i++) { 
                        
        //carregamento de arquivo foto JPG
        $pastaUpload = dirname(__DIR__) . '/recursos/img/';

        if ($_FILES && $_FILES["foto$i"] && $_FILES["foto$i"]['error'] == 0) {
            $tmp = $_FILES["foto$i"]['tmp_name'];
            $tipo = exif_imagetype($tmp);
            $nome = "OS_".$last_id."_veiculo_".$id_veiculo."_$i";

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

            $foto = "UPDATE tb_ordem_servico SET 
            foto$i = '$localNomeIMG'
            WHERE id_servico = $last_id";

            if ($conexao->query($foto) === TRUE) {
                echo "<br> Foto $i carregada";
            } else {
                echo "Erro ao carregar foto: " . $conexao->error;
            }
        }  
    }


    //registrar log
    include_once "../auditoria/log.php";
                        
    $registro = "Incluir servico ID $last_id - Data ".date('d/m/Y')." - Veiculo $id_veiculo - Mecanico $mecanico";
    $coluna = "ID - cliente - data";
    registrar_log($registro, 'tb_ordem_servico', $coluna);



    header("Location: abrir.php/?id=".$last_id);
}

$conexao->close();
ob_end_flush();
?>