<?php 
    ob_start();
    include_once "../header.php";
    //

    $id_servico = $_POST['id_servico'];
    //$dt_servico = $_POST['dt_servico'];
    //$hr_servico = date('H:i:s');
    //$status = $_POST['status'];
    $tipo = $_POST['tipo'];
    $dt_previsao = $_POST['dt_previsao'];
    
    $forma_pag = $_POST['forma_pag'];
    $parcelado = $_POST['parcelado'];
    $taxa_entrega = $_POST['taxa_entrega'];
    $desconto = $_POST['desconto'];
    $garantia = isset($_POST['garantia']) ? $_POST['garantia'] : 0;
    $observacao = $_POST['observacao'];
    $parecer_tecnico = $_POST['parecer_tecnico'];
    $km = $_POST['km'];
    $mecanico = $_POST['mecanico'];
    
    
    $desconto = $desconto == "" ? 0 : $desconto;
    $taxa_entrega = $taxa_entrega == "" ? 0 : $taxa_entrega;
    $desconto = str_replace(',','.', $desconto);
    $taxa_entrega = str_replace(',','.', $taxa_entrega);


    //VERIFICAR O STATUS ATUAL DA OS
    $stt = "SELECT status FROM tb_ordem_servico WHERE id_servico = $id_servico";
    $stt = $conexao->query($stt);
    $stt = $stt->fetch_assoc();
    $status_atual = $stt['status'];

    if($status_atual != 8){
    
        //ATUALIZAR TOTAL
        $sql_os = "SELECT valor, total_pagar, desconto FROM tb_ordem_servico WHERE id_servico = $id_servico";
        $result = $conexao->query($sql_os);

        $row = $result->fetch_assoc();
        $desconto_os = $row['desconto'];
        $valor_os = $row['valor'];
        $total_pagar_os = $row['total_pagar'];

        $desc_max = $valor_os * 0.1;
        if($desconto > $desc_max){
            $desconto = $desconto_os;
            $_SESSION['erro'] = "Desconto NÃO aplicado. Desconto máximo até R$ ". number_format($desc_max, 2,',','.');
        }
        

        
        
        $total_pagar = $valor_os - $desconto + $taxa_entrega;
        

        echo $atualizar = "UPDATE tb_ordem_servico SET 
            tipo = '$tipo',  
            garantia = $garantia,
            dt_previsao = '$dt_previsao', 
            forma_pag = $forma_pag, 
            parcelado = $parcelado, 
            taxa_entrega = $taxa_entrega, 
            desconto = $desconto, 
            parecer_tecnico = '$parecer_tecnico',
            observacao = '$observacao',
            km = $km,
            id_mecanico = $mecanico,
            total_pagar = $total_pagar
            WHERE id_servico = $id_servico";
        
        if ($conexao->query($atualizar) === TRUE) {
            echo "Record updated successfully";



            //registrar log
            include_once "../auditoria/log.php";
                        
            $registro = "Atualizar servico: ID: $id_servico - Valor: $valor_os - Pagar: $total_pagar  ";
            $coluna = "todos;";
            registrar_log($registro, 'tb_ordem_servico', $coluna);


            

        } else {
        echo "Error updating record: " . $conexao->error;
        }
    
    } else {
        $_SESSION['erro'] = "NÃO É POSSÍVEL ALTERAR ORDEM DE SERVIÇO COM STATUS FINALIZADA.";
    } 


    header("Location: /pitstopcar/servicos/abrir.php?id=". $id_servico);
    
    $conexao->close();

    

    ob_end_flush();
?>