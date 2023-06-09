<?php 
    ob_start();
    include_once "../header.php";

  
    $id_servico = $_GET['id_servico'];

    $id = $_GET['id'];

    //verificar se a OS está com status finalizado
    $sql = "SELECT * FROM tb_ordem_servico WHERE id_servico = $id_servico AND status < 8";
    $result = $conexao->query($sql);

    if($result->num_rows > 0) {

        $sql = "SELECT valor, total_pagar FROM tb_ordem_servico WHERE id_servico = $id_servico";
        $result = $conexao->query($sql);

        $row = $result->fetch_assoc();
        $valor = $row['valor'];
        $total_pagar = $row['total_pagar'];

        $sql = "SELECT valor, id_produto, quantidade FROM tb_itens_os WHERE id_itens_os = $id";
        $result = $conexao->query($sql);
        $row = $result->fetch_assoc();
        $valor_item = $row['valor'];
        $id_produto = $row['id_produto'];
        $quantidade = $row['quantidade'];
        
        $valor_atlz = $valor - $valor_item;
        $total_atlz = $total_pagar - $valor_item;
        
        $sql = "UPDATE tb_itens_os SET status = -1 WHERE id_itens_os = $id";
        if($conexao->query($sql)){
            echo "Item removido da OS";
        }
        
        
        $sql = "UPDATE tb_ordem_servico SET valor = $valor_atlz, total_pagar = $total_atlz WHERE id_servico = $id_servico";
        if($conexao->query($sql)){
            echo "Valor e total a pagar corrigido da OS";
        }

        //atualizar estoque se for produto
        if($id_produto > 0){
            $estoque = "SELECT quantidade FROM tb_produto WHERE idProduto = $id_produto";
            $estoque = $conexao->query($estoque);
            $estoque = $estoque->fetch_assoc();
            $estoque = $estoque['quantidade'];
            $estoque = $quantidade + $estoque;
            $estoque = "UPDATE tb_produto SET quantidade = $estoque WHERE idProduto = $id_produto";
            if($conexao->query($estoque)){
                echo "Estoque atualizado";
            }
        }
    } else {
        $_SESSION['erro'] = "Não foi possível remover novos itens na OS Nº $id_servico, pois se encontra com o status Finalizado.";
    }
        
    header ("Location: /pitstopcar/servicos/abrir.php/?id=$id_servico#item");


    include_once "../footer.html";

    ob_end_flush();
?>