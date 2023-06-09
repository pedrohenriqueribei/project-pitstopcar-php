<?php

include_once "../header.php";

$sql = "SELECT * FROM tb_fornecedor_pecas WHERE id_master = ".ID_MASTER. " ORDER BY nome_fantasia ASC";
$result = $conexao->query($sql);
$quant = $result->num_rows;
?>

<div class="container">
    <div class="d-flex justify-content-between">
        <a href="<?php echo $_SERVER['HTTP_REFERER'] ?>" class="btn btn-primary text-uppercase "> Voltar</a>
    

        <?php if($nivel <= 2): ?>
        <a href="novo.php" class="btn btn-primary btn-lg">Cadastrar Fornecedor</a>
        <?php endif; ?>
    </div>
    
    <br><br>
    <h1>Fornecedores de Peças </h1>


    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr class="cab">
                    <th scope="col">ID</th>
                    <th scope="col">Nome</th>
                    <th scope="col"></th>
                    
                </tr>
            </thead>
            <tbody>
                
                <?php
                    
                    

                    if ($result->num_rows > 0) {
                        // output data of each row
                        while($row = $result->fetch_assoc()) {
                            $id_fornecedor = $row['id_fornecedor_pecas'];                            
                            $nome_fantasia = $row['nome_fantasia'];             
                        
                            ?>

                            <tr>  
                                <?php if($nivel <= 2): ?>
                                <td><?= $id_fornecedor ?></td>                                
                                <td><!--<a href="abrir.php/?id=<?= $id_fornecedor?>">--><?= $nome_fantasia ?><!--</a>--></td>
                                <td><a href="atualizar.php/?id=<?=$id_fornecedor?>">Atualizar</a></td>
                                <?php endif; ?>
                            </tr>
                    <?php 
                    }
                } else {
                    echo "0 results";
                }
                
                $conexao->close();

                ?>
                    
            </tbody>
        </table>
        <br><br>
    </div>
    

</div>



<?php
include_once "../footer.html";
?>