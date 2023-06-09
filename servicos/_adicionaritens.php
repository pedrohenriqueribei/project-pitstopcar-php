<?php
ob_start();

include_once "../header.php";

if(isset($_POST['id_servico'])){
    $id_servico = $_POST['id_servico'];
    $item = $_POST['item'];
    $quantidade = $_POST['quantidade'];
} elseif(isset($_GET['id'])){
    $id_servico = $_GET['id_serv'];
    $quantidade = $_GET['qtd'];
    $produto = $_GET['id'];
} elseif (isset($_GET['srv_mnl'])){
    $id_servico = $_GET['id_serv'];
    $quantidade = $_GET['qtd'];
    $srv_mnl = $_GET['srv_mnl'];
}




//verificar se a OS está com status finalizado
$sql = "SELECT * FROM tb_ordem_servico WHERE id_servico = $id_servico AND status < 8";
$result = $conexao->query($sql);

if($result->num_rows > 0){

    //VERIFICAR SE HÁ PRODUTO
    if(isset($_POST['item'])){
        $sql = "SELECT * FROM tb_produto 
                WHERE id_master = ". ID_MASTER." AND (descricao LIKE '%$item%' OR categoria LIKE '%$item%' OR subcategoria LIKE '%$item%')
                AND estado = 1";
        $svc = "SELECT * FROM tb_servico_manual WHERE id_master = ". ID_MASTER." AND ativo = 1 AND descricao LIKE '%$item%'; ";
        $produtos = $conexao->query($sql);
        $servicos = $conexao->query($svc);
    } elseif(isset($_GET['id'])){
        $sql = "SELECT * FROM tb_produto WHERE idProduto = ".$_GET['id'];
        $produtos = $conexao->query($sql);
        
    } elseif (isset($_GET['srv_mnl'])){
        $svc = "SELECT * FROM tb_servico_manual WHERE id_servico_manual = $srv_mnl";
        $servicos = $conexao->query($svc);
    }
    

    echo $produtos->num_rows." produto(s)" ;
    echo "<br>";
    echo $servicos->num_rows." serviço(s)";

    if($produtos->num_rows > 1 OR $servicos->num_rows > 1 OR ($produtos->num_rows == 1 AND $servicos->num_rows == 1)) {
        ?>
        <div class="container">
            
            <div class="table-responsive">
                <table class="table table-hover table-sm">
                    <thead>
                        <tr>
                            <th scope="col">Produto</th>
                            <th scope="col">Preço</th>
                            <th scope="col">Quantidade</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php
                    if($produtos->num_rows >= 1):
                        while($row = $produtos->fetch_assoc()){
                            $idProduto = $row['idProduto'];
                            $desc_prod = $row['descricao'];
                            $quant = $row['quantidade'];
                            $preco = $row['preco'];
                            ?>
                            <tr>
                                <td><?= $desc_prod?></td>
                                <td><?= number_format($preco,2,",",".")?></td>
                                <td><?= $quant?></td>
                                <td><a href="/pitstopcar/servicos/_adicionaritens.php/?id=<?=$idProduto?>&id_serv=<?=$id_servico?>&qtd=<?=$quantidade?>" class="btn btn-primary">Selecionar</a></td>
                            </tr>
                            <?php
                        }
                    endif;
                    if($servicos->num_rows >= 1):
                        while($row = $servicos->fetch_assoc()){
                            $id_servico_manual = $row['id_servico_manual'];
                            $desc_serv = $row['descricao'];
                            $preco_serv = $row['preco'];
                            ?>
                            <tr>
                                <td><?= $desc_serv?></td>
                                <td><?= number_format($preco_serv,2,",",".")?></td>
                                <td></td>
                                <td><a href="/pitstopcar/servicos/_adicionaritens.php/?srv_mnl=<?=$id_servico_manual?>&id_serv=<?=$id_servico?>&qtd=<?=$quantidade?>" class="btn btn-primary">Selecionar</a></td>
                            </tr>
                            <?php
                        }
                    endif;
                    ?>
                    </tbody>
                </table>
            </div>
                
            <a href="<?= $_SERVER['HTTP_REFERER'] ?>" class="btn btn-primary">Voltar</a>
        </div>
    <?php
    
    }
    //localizou apenas 1 produto -> insere
    elseif($produtos->num_rows == 1){
        echo "inserindo produto";
        $row = $produtos->fetch_assoc();
        $idProduto = $row['idProduto'];
        $desc_prod = $row['descricao'];
        $preco = $row['preco'];
        $estoque = $row['quantidade'];
        $valor = $preco * $quantidade;

        if($estoque >= $quantidade){
            echo $insert = "INSERT INTO tb_itens_os (id_servico, id_produto, descricao, quantidade, preco, valor, status, id_master) 
                VALUES ($id_servico, $idProduto, '$desc_prod', $quantidade, $preco, $valor, 1, ". ID_MASTER .")";
            if($conexao->query($insert) === TRUE){
                $last_id = $conexao->insert_id;
                echo "Item $last_id incluído com sucesso!!";

                //registrar log
                include_once "../auditoria/log.php";

                $registro = "Incluir item $last_id OS $id_servico Produto $idProduto - Quantidade $quantidade - Preco R$ $preco - Valor R$ $valor";
                $coluna = "id_servico, id_produto, descricao, quantidade, preco, valor, id_master";
                registrar_log($registro, 'tb_itens_os', $coluna);


                //ATUALIZAR TOTAL
                $sql_os = "SELECT valor, total_pagar FROM tb_ordem_servico WHERE id_servico = $id_servico";
                $produtos = $conexao->query($sql_os);

                $row = $produtos->fetch_assoc();
                $valor_os = $row['valor'];
                $total_pagar_os = $row['total_pagar'];

                //calculos
                $valor_atlz = $valor + $valor_os;
                $total_atlz = $valor + $total_pagar_os;

                $update_os = "UPDATE tb_ordem_servico SET valor = $valor_atlz, total_pagar = $total_atlz WHERE id_servico = $id_servico";
                if ($conexao->query($update_os) === TRUE) {
                    echo "Valores atualizados da OS";
                } else {
                    echo "Error updating record: " . $conexao->error;
                }

                //ATUALIZAR ESTOQUE
                $quant_atual = $estoque - $quantidade;
                $atualiza_estoque = "UPDATE tb_produto SET quantidade = $quant_atual WHERE idProduto = $idProduto";
                $conexao->query($atualiza_estoque);


                header ("Location: /pitstopcar/servicos/abrir.php/?id=$id_servico#item");
            }else {
                echo "Erro ao inserir item: " . $conexao->error;
            }
        } else {
            $_SESSION['erro'] = "Quantidade em estoque insuficiente. Estoque de $desc_prod: ".$estoque." unidades.";
            header ("Location: /pitstopcar/servicos/abrir.php/?id=$id_servico");
        }
    
    //Não encontrou produto/peça

    //localizou apenas 1 serviço manual -> insere serviço manual no item
    } elseif($servicos->num_rows == 1) {
        echo "inserindo serviço";
        $row = $servicos->fetch_assoc();
        $id_servico_manual = $row['id_servico_manual'];
        $desc_serv = $row['descricao'];
        $preco = $row['preco'];
        $valor = $preco * $quantidade;

        $insert = "INSERT INTO tb_itens_os (id_servico, id_servico_manual, descricao, quantidade, preco, valor, status, id_master) 
            VALUES ($id_servico, $id_servico_manual, '$desc_serv', $quantidade, $preco, $valor, 1, ". ID_MASTER .")";
        if($conexao->query($insert) === TRUE){
            $last_id = $conexao->insert_id;

            //registrar log
            include_once "../auditoria/log.php";

            $registro = "Incluir item $last_id OS $id_servico Servico $id_servico_manual - Preco R$ $preco ";
            $coluna = "id_servico, id_servico_manual, descricao, quantidade, preco, valor, id_master";
            registrar_log($registro, 'tb_itens_os', $coluna);


            //ATUALIZAR TOTAL
            $sql_os = "SELECT valor, total_pagar FROM tb_ordem_servico WHERE id_servico = $id_servico";
            $result_os = $conexao->query($sql_os);

            $row = $result_os->fetch_assoc();
            $valor_os = $row['valor'];
            $total_pagar_os = $row['total_pagar'];

            //calculos
            $valor_atlz = $valor + $valor_os;
            $total_atlz = $valor + $total_pagar_os;

            $update_os = "UPDATE tb_ordem_servico SET valor = $valor_atlz, total_pagar = $total_atlz WHERE id_servico = $id_servico";
            if ($conexao->query($update_os) === TRUE) {
                echo "Valores atualizados da OS";
            } else {
                echo "Error updating record: " . $conexao->error;
            }



            header ("Location: /pitstopcar/servicos/abrir.php/?id=$id_servico#item");
            
        }else {
            echo "Erro ao inserir item: " . $conexao->error;
        }
    }
    //quando não encontra nem produto nem serviço manual
    else {
        $_SESSION['erro'] = "Produto/Peça não encontrada";
        header ("Location: /pitstopcar/servicos/abrir.php/?id=$id_servico");
    }

    


    //se OS estiver com status finalizado não adiciona

} else {
    
    $_SESSION['erro'] = "Não foi possível adicionar novos itens na OS Nº $id_servico, pois se encontra com o status Finalizado.";
        
}

include_once "../footer.html";
ob_end_flush();
?>