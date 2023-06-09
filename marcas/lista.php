<?php 
    include_once "../header.php";
    //
    
    if ($nivel == 1){
?>


<div class="container">

    <br><br>
    <h1>Marcas de Automóveis</h1><br><br>

    <div class="row tm-content-row">
        <div class="col-12 tm-block-col">
            <div class="tm-bg-primary-dark tm-block tm-block-h-auto">

                <form role="form" action="_cadastrar.php" class="templatemo-login-form" method="post" enctype="multipart/form-data">

                    <div class="form-group">
                        <div class="row">
                            
                            <div class="col-sm-3">
                                <label for="descricao">Marca</label>
                                <input type="text" class="form-control" id="descricao" name="descricao" required>
                            </div>

                            <div  class="col-sm-3"  >
                                <label for=""> </label><br>
                                <button type="submit" class="btn btn-primary botao_salvar btn-lg" >       Cadastrar       </button><br><br>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <BR></BR>

    <div class="table-responsive">
        <table class="table table-sm table-hover" style="width: 60%;height: 20%;">
            <thead>
                <tr class="cab">
                    <th scope="col">ID</th>
                    <th scope="col">Marca</th>
                    <th scope="col">Ação</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            $sql = 'SELECT * FROM tb_marca WHERE id_master = '.ID_MASTER.' ORDER BY 3 ASC';
            $result = $conexao->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    $id_marca = $row['id_marca'];
                    $id_negocio = $row['id_negocio'];
                    $descricao = $row['descricao'];
                    ?>
                    <tr >
                        <td><?= $id_negocio ?></td>
                        <td><?= $descricao ?></td>
                        <td>
                            <a href="editar.php/?id=<?= $id_marca?>" class="btn btn-primary text-uppercase mb-3"><i class="far fa-edit"></i> Editar</a>
                            <a href="_excluir.php/?id=<?= $id_marca?>&descricao=<?= $descricao?>" class="btn btn-primary text-uppercase mb-3"><i class="far fa-trash-alt"></i> Excluir</a>
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
    }
    include_once "../footer.html";
?>