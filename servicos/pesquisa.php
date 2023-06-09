<?php 
    include_once "../header.php";
    //

    $numero = $_POST['numero'];
?>




<div class="container">

    <?php
    require_once "menu-servicos.php";
    require_once "form-pesquisa.php";
    ?>


<h1> Ordem de Serviço - Nº <?= $numero ?></h1><br><br>

<div style="text-align: right">
    <a href="/pitstopcar/servicos/os_loccliente.php" class="btn btn-primary text-uppercase mb-3 botao btn-lg"><i class="fas fa-plus"></i>Nova Ordem de Serviço</a><br><br>
</div>

<div class="templatemo-content-container">
            
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr class="cab">
                    <th scope="col">ID</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Telefone</th>
                    <th scope="col">Placa</th>
                    <th scope="col">Data</th>
                    <th scope="col">Previsão</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Status</th>
                    <th scope="col">Valor</th>
                    <th scope="col">AÇÕES</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                <?php
                    $sql = "SELECT s.id_servico, s.dt_servico, s.dt_previsao, s.tipo, s.status, s.valor, c.nome, c.telefone, placa
                        FROM tb_ordem_servico s 
                        INNER JOIN tb_cliente c ON c.idCliente = s.cliente
                        INNER JOIN tb_veiculo v ON s.id_veiculo = v.id_veiculo
                        WHERE s.id_master = ".ID_MASTER."
                        AND s.id_servico = $numero";

                    $result = $conexao->query($sql);

                    if ($result->num_rows > 0) {
                        // output data of each row
                        while($row = $result->fetch_assoc()) {
                            $id_servico = $row['id_servico'];
                            $placa = $row['placa'];
                            $dt_servico = $row['dt_servico'];
                            $dt_previsao = $row['dt_previsao'];
                            $tipo = $row['tipo'];
                            $status = $row['status'];
                            $valor = $row['valor'];
                            $nome = $row['nome'];
                            $telefone = $row['telefone'];

                            ?>
                            <tr>
                                <td><?= $id_servico ?></td>
                                <td><?= $nome ?></td>
                                <td><?= $telefone ?></td>
                                <td><?= $placa ?></td>
                                <td><?= date('d/m/Y', strtotime($dt_servico)) ?></td>
                                <td><?= date('d/m/Y', strtotime($dt_previsao)) ?></td>
                                <td><?= $tipo ?></td>
                                <td><?php switch ($status){
                                    case 1: echo "Aberto"; break;   case 2: echo "Aprovado"; break;   case 3: echo "Em Manutenção"; break;   
                                    case 4: echo "Aguardando Pagamento"; break;   case 5: echo "Entregue"; break;   case 6: echo "Garantia"; break;   
                                    case 7: echo "Reaberto"; break;   case 8: echo "Finalizado"; break;   
                                } ?></td>
                                <td><?= number_format($valor,2,',','.') ?></td>
                                <td>
                                
                                    <a href="abrir.php/?id=<?= $id_servico?>" class="btn btn-primary btn-sm">Abrir</a>
                            
                                    
                                </td>
                            </tr>
                            <?php
                        }
                      } else {
                        echo "0 resultados";
                      }
                      $conexao->close();
                ?>
            </tbody>
        </table>
    </div>
    
</div>





<?php 
    include_once "../footer.html";
?>