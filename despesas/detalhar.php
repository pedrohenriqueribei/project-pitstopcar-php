<?php 
    include_once "../header.php";
    //

    $id = $_GET['id'];

    $sql = "SELECT * FROM tb_despesa WHERE id_despesa = $id AND id_master = ".ID_MASTER;
    $result = $conexao->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($array = $result->fetch_assoc()) {
            $id_despesa = $array['id_despesa'];
            $descricao = $array['descricao'];
            $produto = $array['produto'];
            $dt_compra = $array['dt_compra'];
            $produto = $array['produto'];
            $valor = $array['valor'];
            
            $total = $array['total'];
            $comentario = $array['comentario'];
            
        }
    } else {
    echo "0 results";
    }
    $conexao->close();
?>
            
<div class="container">


    <br><h1>Detalhes da Despesa</h1>

    <form role="form" action="atualizar.php" method="post">
        <div class="form-group">
            <div class="row">
                <div class="col-sm-6">
                    <label for="descricao">Descrição</label>
                    <input type="text" class="form-control" id="descricao" name="descricao" value="<?= $descricao ?>" required disabled>
                </div>
              
                <div class="col-sm-6"> 
                    <label for="valor">Valor</label>
                    <input type="text" class="form-control" id="valor" name="valor" value="<?= $valor ?>" disabled>
                </div>

                

                <div class="col-12">
                    <label for="comentario">Comentário</label>
                    <textarea class="form-control" name="comentario" id="comentario" cols="3" readonly><?= $comentario?></textarea>
                </div>
                
                <div>
                    <input style="display: none" type="text" name="id_despesa" value="<?= $id_despesa ?>">
                </div>
               
            </div>
        </div>
        
    </form>

    <div style="text-align:right">
        <a href="/pitstopcar/despesas/lista.php" class="btn btn-primary text-uppercase mb-3 btn-lg botao">Voltar</a>
        <a href="/pitstopcar/despesas/editar.php/?id=<?= $id_despesa?>" class="btn btn-primary text-uppercase mb-3 btn-lg botao"><i class="fa fa-edit"></i>Editar</a>
        <a href="/pitstopcar/despesas/excluir.php/?id=<?= $id_despesa?>" class="btn btn-danger btn-lg botao"><i class="far fa-trash-alt"></i> Excluir</a>
    </div>
</div>




<?php
include_once "../footer.html";
?>