<?php 
    include_once "../header.php";
    //
?>


<div class="container">
    
    <br><br>


                
    <h1>Veículos Cadastrados</h1> <br><br>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr class="cab">
                    <th scope="col">ID</th>
                    <th scope="col">Placa</th>
                    <th scope="col">Modelo</th>
                    <th scope="col">Marca</th>
                    <th scope="col">Ano</th>
                    <th scope="col">Ação</th>
                </tr>
            </thead>
            <tbody>
                
                <?php
                    
                    $sql = "SELECT * FROM tb_veiculo 
                            WHERE id_master = ".ID_MASTER." ORDER BY 1 ASC";
                    
                    $results = $conexao->query($sql);

                    if ($results->num_rows > 0) {
                        // output data of each row
                        while($array = $results->fetch_assoc()) {
                            $id_veiculo = $array['id_veiculo'];
                            $id_negocio = $array['id_negocio'];
                            
                            
                            $placa = $array['placa'];
                            $modelo = $array['modelo'];
                            $marca = $array['marca'];
                            $ano = $array['ano'];
                            $status = $array['status'];

                
                        
                            ?>
                            <tr>  
                                <td><?= $id_negocio ?></td>
                                <td><a href="/pitstopcar/veiculo/abrir.php/?id=<?php  echo $id_veiculo?>" class="btn btn-primary text-uppercase mb-3" ><i class="fas fa-clipboard-list"></i> <?= $placa ?></a></td>
                                <td><?= $modelo ?></td>
                                <td><?= $marca ?></td>
                                <td><?= $ano  ?></td>
                                <td>
                                <a href="/pitstopcar/veiculo/abrir.php/?id=<?php  echo $id_veiculo?>" class="btn btn-primary text-uppercase mb-3" ><i class="fas fa-clipboard-list"></i> Abrir</a>
                                </td>
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