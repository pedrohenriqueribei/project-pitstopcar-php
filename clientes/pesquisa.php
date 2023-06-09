<?php 
    include_once "../header.php";
    //

    if(isset($_POST['busca'])){
        $busca = $_POST['busca']; 
    } elseif (isset($_GET['busca'])){
        $busca = $_GET['busca'];
    }
?>

<div class="container">
    
    <div class="form-group">

        <div class="row">   

            <div class="col-sm-4"> 
                <h2>Pesquisar</h2>
                <form action="/pitstopcar/clientes/pesquisa.php" role="form" method="post">
                    <label for="busca">Por nome</label>
                    <input type="text" name="busca" id="busca" class="form-control">
                    
                    <div  style="text-align: center;"   >
                        <button type="submit" class="btn btn-primary text-uppercase mb-3 botao" >Pesquisar</button><br><br>
                    </div>
                </form>
            </div>

            <div class="col-sm-4"> 
                <h2>Pesquisar</h2>
                <form action="/pitstopcar/clientes/pesquisa_telefone.php" role="form" method="post">
                    <label for="telefone">Por telefone</label>
                    <input type="text" name="telefone" id="telefone" class="form-control" value="61 ">
                    <br>
                    <div  style="text-align: center;"   >
                        <button type="submit" class="btn btn-primary text-uppercase mb-3 botao" >Pesquisar</button><br><br>
                    </div>
                </form>
            </div>
        </div>
    </div>

   

    <br><h1>Pesquisa: <?= $busca?></h1>

   
    <div style="text-align: right">
        <a href="/pitstopcar/clientes/form.php" class="btn btn-primary text-uppercase mb-3 botao btn-lg"><i class="fas fa-plus"></i>Novo Cliente</a><br><br>
    </div>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr class="cab">
                    <th scope="col">ID</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Sobrenome</th>
                    <th scope="col">Telefone</th>
                    <th scope="col">Sexo</th>
                    <!--<th scope="col">Data de Nasc</th>-->
                    <th scope="col">Ações</th>
                    
                </tr>
            </thead>
            <tbody>
                
            <?php
                
                $sql = "SELECT * FROM tb_cliente where id_master = ".ID_MASTER." AND (
                    nome LIKE '%$busca%' OR 
                    sobrenome LIKE '%$busca%'OR 
                    telefone LIKE '%$busca%')" ;
                
                $result = $conexao->query($sql);

                if ($result->num_rows > 0) {
                // output data of each row
                    while($row = $result->fetch_assoc()) {
                        $idCliente = $row['idCliente'];
                        $nome = $row['nome'];
                        $sobrenome = $row['sobrenome'];
                        $telefone = $row['telefone'];
                        $sexo = $row['sexo'];
                        $data_nasc = $row['data_nasc'];
                    

                
                    
                        ?>
                        <tr>  
                            <td><?= $idCliente ?></td>
                            <td><a href="compras.php/?id=<?= $idCliente ?>" title="Ver Compras"><?= $nome ?></a></td>
                            <td><?= $sobrenome ?></td>
                            <td><?= $telefone ?></td>
                            <td><?= $sexo == 1 ? "Feminino" : "Masculino" ?></td>
                            <!--<td><?php //echo date('d/m/Y', strtotime($data_nasc)) ?></td>-->
                        
                            <td>
                                <a href="/pitstopcar/servicos/os_clienteloc.php/?id=<?= $idCliente ?>" class="btn btn-primary text-uppercase mb-3 botao btn-lg"><i class="fas fa-clipboard-list"></i> Abrir OS</a>
                                <a href="form_editar.php/?id=<?= $idCliente?>" class="btn btn-primary text-uppercase mb-3 btn-sm botao"><i class="far fa-edit"></i> Editar</a>
                                <a href="excluir.php/?cod=<?= $idCliente?>" class="btn btn-primary text-uppercase mb-3 btn-sm botao"><i class="far fa-trash-alt"></i> Excluir</a>
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
    </div></div>
</div>




<?php 
    include_once "../footer.html";
?>