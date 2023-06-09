<?php 
    include_once "../header.php";
    //

    

    if($nivel == 1):
?>

         
<div class="container">

    <div class="mt-2" style="text-align: right">
        <a href="/pitstopcar/categoria/form.php/?tabela=despesa" class="btn btn-primary botao btn-lg"><i class="fas fa-plus"></i>Cadastrar Categoria</a><br><br>
    </div>


    <br><h1>Categorias</h1>
    <br><br>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr class="cab">
                    <th scope="col">ID</th>
                    <th scope="col">Descrição</th>             
                    <th scope="col">Módulo</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    if(isset($_GET['tabela'])){
                        $tabela = $_GET['tabela'];
                        $sql = "SELECT * FROM tb_categoria WHERE id_master = ".ID_MASTER." AND tabela = '$tabela' ORDER BY descricao ASC";
                    }
                    else {
                        $sql = "SELECT * FROM tb_categoria WHERE id_master = ".ID_MASTER."  ORDER BY descricao ASC";
                    }
                    $result = $conexao->query($sql);

                    while ($row = $result->fetch_assoc()) {
                        $id_categoria = $row['id_categoria'];
                        $id_negocio = $row['id_negocio'];
                        $descricao = $row['descricao'];
                        $tabela = $row['tabela'];
                ?>

                <tr>
                    <td><?= $id_negocio ?></td>
                    <td><?= $descricao ?></td> 
                    <td><?= strtoupper($tabela) ?></td>
                    <td>
                        <a href="/pitstopcar/categoria/editar.php/?id=<?= $id_categoria?>" class="btn btn-primary btn-sm botao"><i class="fas fa-edit"></i>Editar</a>
                        <a href="/pitstopcar/categoria/excluir.php/?id=<?= $id_categoria?>" class="btn btn-primary btn-sm botao"><i class="far fa-trash-alt"></i>Excluir</a>
                    </td>
                </tr>
                <?php } $conexao->close();?>
            </tbody>
        </table>
        <br><br>
    </div>


    
</div>


<?php 
    endif;
    include_once "../footer.html";
?>