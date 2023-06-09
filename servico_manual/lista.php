<?php 
    include_once "../header.php";
    //
?>
            
<div class="container">
    <br><h1>Todos Serviços Manuais</h1>

    <div style="text-align: right">         
        <a href="/pitstopcar/servico_manual/novo.php" class="btn btn-primary text-uppercase mb-3 botao btn-lg"><i class="fas fa-plus"></i>Novo Serviço Manual</a><br><br>
    </div>


    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Descrição</th>
                    <th scope="col">Preço</th>
                    <th scope="col">Status</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    
                    $sql = "SELECT * FROM tb_servico_manual WHERE id_master = ".ID_MASTER."  ORDER BY descricao ASC";
                    $select = $conexao->query($sql);

                    if ($select->num_rows > 0) {

                        while ($row = $select->fetch_assoc()) {
                            $id_servico_manual = $row['id_servico_manual'];
                            $descricao = $row['descricao'];
                            $preco  = $row['preco'];
                            $ativo  = $row['ativo'];
                            ?>

                            <tr>
                                <td><?= $id_servico_manual ?></td>
                                <td><?= $descricao ?></td>
                                <td><?= number_format($preco,2,',','.') ?></td>
                                <td><?= $ativo ? "Ativo" : "Inativo"?></td>
                                <td>
                                    <a href="editar.php/?id=<?= $id_servico_manual?>" class="btn btn-primary text-uppercase mb-3 btn-sm botao"><i class="far fa-edit"></i> Editar</a>
                                    <?php if($ativo == 1): ?>
                                    <a href="_desativar.php/?id=<?= $id_servico_manual?>" class="btn btn-primary text-uppercase mb-3 btn-sm botao"><i class="far fa-trash-alt"></i> Desativar</a>
                                    <?php else: ?>
                                        <a href="_ativar.php/?id=<?= $id_servico_manual?>" class="btn btn-primary text-uppercase mb-3 btn-sm botao"><i class="fas fa-upload"></i> Ativar</a>
                                    <?php endif ?>
                                </td>
                            </tr>
                        <?php } 
                    } else {
                        ?> <h6>Não há produtos cadastrados</h6> <?php
                    }
                ?>
            </tbody>
        </table>
        <br><br>
    </div>

    </div>


<?php 
    include_once "../footer.html";
?>