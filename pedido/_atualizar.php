<?php
ob_start();
include_once "../header.php";

//atualização 1
if(isset($_POST['codigo_externo'])):
    $id_pedido_externo = $_POST['id_pedido_externo'];
    $codigo_externo = $_POST['codigo_externo'];
    $fornecedor = $_POST['fornecedor'];
    $dt_pedido = $_POST['dt_pedido'];
    $dt_entrega = $_POST['dt_entrega'];
    $status = $_POST['status'];

    $sql = "SELECT status FROM tb_pedido_externo WHERE id_pedido_externo = $id_pedido_externo";
    $result = $conexao->query($sql);
    $row = $result->fetch_assoc();
    $status_atual = $row['status'];

    if($status_atual != "Recebido"):

    $sql = "UPDATE tb_pedido_externo SET 
    id_pedido_externo = $id_pedido_externo,
    codigo_externo = $codigo_externo,
    id_fornecedor = $fornecedor,
    dt_pedido = '$dt_pedido',
    dt_entrega = '$dt_entrega',
    status = '$status'
    WHERE id_pedido_externo = $id_pedido_externo";


    if ($conexao->query($sql) === TRUE) {
        echo "Record updated successfully";



        //registrar log
        include_once "../auditoria/log.php";
                
        $registro = "Atualizar pedido externo: $id_pedido_externo - Fornecedor $fornecedor - data $dt_pedido - entrega $dt_entrega";
        $coluna = "codigo_externo, id_fornecedor, dt_pedido, dt_entrega, status, id_master";
        registrar_log($registro, 'tb_pedido_externo', $coluna);


        //quando o pedido é recebido
        if($status == "Recebido"){
            $rec = "SELECT * FROM tb_itenspedido WHERE id_master = ". ID_MASTER." AND id_pedido = $id_pedido_externo AND status > 0";
            $results = $conexao->query($rec);
            while ($row = $results->fetch_assoc()){
                $id_produto = $row['id_produto'];
                $quantidade = $row['quantidade'];
                $preco = $row['preco'];
                
                $pdt = "SELECT * FROM tb_produto WHERE id_master = ". ID_MASTER." AND idProduto = $id_produto";
                $result_pdt = $conexao->query($pdt);
                $row = $result_pdt->fetch_assoc();
                $estoque = $row['quantidade'];
                $perc = $row['perc_lucro'];

                $estoque += $quantidade;
                $preco = $preco + ($preco * $perc / 100);
                
                $pdt = "UPDATE tb_produto SET quantidade = $estoque, preco = $preco WHERE idProduto = $id_produto";
                $conexao->query($pdt);
            }

        }
    } else {
        echo "Error updating record: " . $conexao->error;
    }
    else:
        $_SESSION['erro'] = "Não é possível alterar status do pedido.";
    endif;

//atualização 2
elseif(isset($_POST['forma_pag'])) :
    $id_pedido_externo = $_POST['id_pedido_externo'];
    $forma_pag = $_POST['forma_pag'];
    $desconto = $_POST['desconto'] == NULL ? 0 : $_POST['desconto'];
    $taxa_entrega = $_POST['taxa_entrega'] == NULL ? 0 : $_POST['taxa_entrega'];
    $parcelado = $_POST['parcelado'];

    $sql = "SELECT total, dt_pedido FROM tb_pedido_externo WHERE id_pedido_externo = $id_pedido_externo";
    $result = $conexao->query($sql);
    
    $row = $result->fetch_assoc();
    $total = $row['total'];
    $dt_pedido = $row['dt_pedido'];

    //substituir a virgula do preço
    $desconto = str_replace('.','', $desconto);
    $desconto = str_replace(',','.', $desconto);
    $taxa_entrega = str_replace('.','', $taxa_entrega);
    $taxa_entrega = str_replace(',','.', $taxa_entrega);
    
    $total_pag = $total + $taxa_entrega - $desconto;


    $sql = "UPDATE tb_pedido_externo SET 
    forma_pag = $forma_pag,
    desconto = $desconto,
    taxa_entrega = $taxa_entrega,
    total_pago = $total_pag,
    parcelado = $parcelado
    WHERE id_pedido_externo = $id_pedido_externo";
    
    if ($conexao->query($sql) === TRUE) {
        echo "Record updated successfully";



        //registrar log
        include_once "../auditoria/log.php";
                
        $registro = "Atualizar pedido externo: $id_pedido_externo - Forma de Pagamento $forma_pag - Desconto $desconto - Taxa de Entrega $taxa_entrega - TOTAL A PAGAR $total_pag";
        $coluna = "forma de pagamento, desconto, taxa de entrega, total a pagar";
        registrar_log($registro, 'tb_pedido_externo', $coluna);


        //controle de prestações
        $sql = "SELECT * FROM tb_cprestacao WHERE id_pedido = $id_pedido_externo";
        $result = $conexao->query($sql);

        if($result->num_rows == 0){
            echo "<br><br><br>";
            echo $parcela = $total_pag / $parcelado;

            $dt_venc = $dt_pedido;
            for ($i=1; $i <= $parcelado ; $i++){

                echo $prazo = "INSERT INTO tb_cprestacao (id_pedido, sequencia, dt_venc, vl_prest, pago, id_master) 
                        VALUES ($id_pedido_externo, $i, '$dt_venc', $parcela, FALSE, ".ID_MASTER.")";
                if($conexao->query($prazo) === TRUE){
                    //echo "Novo registro criado com sucesso";
                    $dt_venc = date('Y-m-d', strtotime('+'.$i.' months', strtotime($dt_venc)));
                } else {
                    echo "Error: ".$prazo."<br>".$conexao->error;
                }
                echo "<br>";
            }
        }
    } else {
        echo "Error updating record: " . $conexao->error;
    }
endif;
$conexao->close();

header("Location: abrir.php/?id=".$id_pedido_externo);

ob_end_flush();
?>