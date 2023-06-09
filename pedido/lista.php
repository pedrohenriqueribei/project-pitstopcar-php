<?php 
    include_once "../header.php";
?>


<div class="container">
    <div class="mt-2" style="text-align: right">  
        <a href="/pitstopcar/produtos/novo.php" class="btn btn-primary text-uppercase botao btn-lg"><i class="fas fa-plus"></i>Novo Produto</a>
        <a href="../fornecedor/novo.php" class="btn btn-primary btn-lg">Cadastrar Fornecedor</a>       
        <a href="/pitstopcar/pedido/novo.php" class="btn btn-primary text-uppercase botao btn-lg"><i class="fas fa-plus"></i>Novo Pedido</a><br><br>
    </div>

    <br>
    <h1>Todos Pedidos Externos</h1>
    <h2>Pedidos de Reposição de estoque</h2>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Data Pedido</th>
                    <th scope="col">Fornecedor</th>
                    <th scope="col">Data Entrega</th>
                    <th scope="col">Status</th>
                    <th scope="col" class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    
                $sql = "SELECT * FROM tb_pedido_externo WHERE id_master = ".ID_MASTER." AND status != 'Cancelado'  ORDER BY dt_pedido ASC";
                $select = $conexao->query($sql);

                if ($select->num_rows > 0) {

                    while ($row = $select->fetch_assoc()) {
                        $id_pedido_externo = $row['id_pedido_externo'];
                        $id_negocio = $row['id_negocio'];
                        $dt_pedido = $row['dt_pedido'];
                        $dt_entrega  = $row['dt_entrega'];
                        $id_fornecedor  = $row['id_fornecedor'];
                        $status  = $row['status'];
                        $forn = "SELECT nome_fantasia FROM tb_fornecedor_pecas WHERE id_fornecedor_pecas = $id_fornecedor";
                        $result=$conexao->query($forn);
                        $forn = $result->fetch_assoc();
                        $nome_fantasia = $forn['nome_fantasia'];
                        ?>

                        <tr>
                            <td><a href="abrir.php/?id=<?= $id_pedido_externo?>"><?= $id_negocio ?></a></td>
                            <td><?= date('d/m/Y', strtotime($dt_pedido)) ?></td>
                            <td><?= !empty($nome_fantasia) ? $nome_fantasia : "" ?></td>
                            <td><?= date('d/m/Y', strtotime($dt_entrega)) ?></td>
                            <td><?= $status ?></td>
                            <td class="text-center">
                                <a href="abrir.php/?id=<?= $id_pedido_externo?>" class="btn btn-primary text-uppercase mb-3 btn-sm botao">Abrir</a>
                                <a href="_cancelar.php/?id=<?= $id_pedido_externo?>" class="btn btn-primary text-uppercase mb-3 btn-sm botao"><i class="fa fa-ban" aria-hidden="true"></i> Cancelar</a>
                            </td>
                        </tr>
                    <?php } 
                } else {
                    ?> <h6>Não há pedidos cadastrados</h6> <?php
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