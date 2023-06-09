<?php
include_once "../header.php";
?>

<div class="container">
    <br>
    <h1>Lista de Mecânicos</h1><br><br>


    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr class="cab">
                    <th scope="col">ID</th>
                    <th scope="col">Nome</th>
                    
                    
                </tr>
            </thead>
            <tbody>
                
                <?php
                    
                    $sql = "SELECT * FROM tb_user where id_master = ".ID_MASTER." AND nivel = 3 ORDER BY nome ASC";
                    
                    $results = $conexao->query($sql);

                    if ($results->num_rows > 0) {
                        // output data of each row
                        while($array = $results->fetch_assoc()) {
                            $id_user = $array['id_user'];
                            $nome = $array['nome'];
                            $user = $array['usuario'];

                
                        
                            ?>
                            <tr>  
                                <td><?= $id_user ?></td>
                                <td><?php if($user == $_SESSION['usuario'] OR $nivel <= 2){ ?><a href="servicosde.php/?id=<?= $id_user?>"><?= $nome ?></a><?php } else { echo $nome;} ?></td>
                                
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
    </div>
        
</div>


<?php include_once "../footer.html" ?>