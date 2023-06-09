<?php

include_once "../header.php";

$id_fornecedor = $_GET['id'];

$sql = "SELECT * FROM tb_fornecedor_pecas
        WHERE id_fornecedor_pecas = $id_fornecedor";
$result = $conexao->query($sql);

if($result->num_rows == 1):
    while ($row = $result->fetch_assoc()):
        $nome_fantasia = $row['nome_fantasia'];
        

    endwhile;
    ?>

    <div class="container">
        <div class="p-2">
            <a href="<?php echo $_SERVER['HTTP_REFERER'] ?>" class="btn btn-primary text-uppercase mb-3"><i class="fas fa-arrow-left"></i> Voltar</a>
        </div>
        <br>
        <h1>Fornecedor de Peças</h1>
        <br>
        <h2><?= $nome_fantasia?></h2><br>

        <h3>Peças</h3><br>


        <br><br>

        <div class="table-responsive">
            <table class="table table-hover table-sm">
                <thead>
                    <tr class="cab">
                        
                        <th scope="col">Descrição</th>
                        <th scope="col">Item</th>
                        <th scope="col">Preço</th>
                        <th scope="col">Quantidade</th>
                        <th scope="col">Valor</th>
                        <th scope="col">Status</th>
                        
                    </tr>
                </thead>
                <tbody>
                    
                    <?php    
                        $select = "SELECT * FROM tb_pecas_item p 
                        INNER JOIN tb_manutencao m ON m.id_manutencao = p.id_manutencao
                        WHERE id_fornecedor = $id_fornecedor";
                        $results = $conexao->query($select);

                        
                        if ($results->num_rows > 0){

                            while ($row = $results->fetch_assoc()) {
                                $id_manutencao = $row['id_manutencao'];
                                $descricao = $row['descricao'];
                                $preco  = $row['preco'];
                                $quantidade  = $row['quantidade'];
                                $valor = $row['valor'];
                                $status = $row['status_pecas_item'];
                                $item = $row['item'];
                                ?>
                                <tr>  
                                    <td><a href="/dfmultimarcas/manutencao/abrir.php/?id=<?= $id_manutencao ?>"><?= $descricao ?></a></td>
                                    <td><?= $item ?></td>
                                    <td><?= number_format($preco, 2,',','.') ?></td>
                                    <td><?= $quantidade?></td>
                                    <td><?= number_format($valor, 2,',','.') ?></td>
                                    <td><?= $status ?></td>
                                    
                                </tr>
                                <?php 
                            }
                        }   
                    
                    

                    ?>
                        
                </tbody>
            </table>
            <br><br>
        </div>
    </div>
    
<?php
endif;
include_once "../footer.html";
?>