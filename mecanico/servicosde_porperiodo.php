<?php
include_once "../header.php";

$mecanico = $_POST['mecanico'];
$inicio = $_POST['inicio'];
$fim = $_POST['fim'];

$sql = "SELECT nome FROM tb_user WHERE id_user = $mecanico";
$result = $conexao->query($sql);
$row = $result->fetch_assoc();
$nome = $row['nome'];


?>

<div class="container">

    <div class="row">
        <div class="card col-sm-6">
            <div class="card-body">
                
                <form action="/pitstopcar/mecanico/servicode_porperiodo.php" role="form" method="post">
                    <div class="form-group">
                        <select class="form-control" id="mecanico" name="mecanico" required>
                            <?php
                            $sql = "SELECT * FROM tb_user WHERE id_master = ".ID_MASTER." AND nivel = 3";
                            $results = $conexao->query($sql);
                            if($results->num_rows > 0){
                                while($row = $results->fetch_assoc()){
                                    ?><option value="<?= $row['id_user']?>" <?php if($row['id_user'] == $mecanico) echo "selected"; elseif($nivel > 2) echo "disabled"; ?>><?=$row['nome'] ?></option><?php
                                }
                            }
                            ?>
                        </select>
                        <br>
                        <label for="inicio">De</label>
                        <input type="date" name="inicio" id="inicio" class="form-control" value="<?= date('Y-m-d') ?>">
                        <label for="fim">Até</label>
                        <input type="date" name="fim" id="fim" class="form-control" value="<?= date('Y-m-d') ?>">
                    </div>
                    <div  style="text-align: center;"   >
                        <button type="submit" class="btn btn-primary botao" >Pesquisar</button><br><br>
                    </div>
                </form>
                    
            </div>
        </div>      
    </div>

    <br><h1><?= $nome?></h1>
    <h6>Mecânico</h6>

    
    <div class="table-responsive">
        <table class="table table-hover table-sm">
            <thead>
                <tr class="cab">
                    <th scope="col">ID</th>
                    <th scope="col">Data</th>
                    <th scope="col">Placa</th>
                    
                    <th scope="col">Total OS</th>
                    <th scope="col">Mão de Obra</th>
                    
                </tr>
            </thead>
            <tbody>
            <?php
            $sql = "SELECT * FROM tb_ordem_servico s 
            INNER JOIN tb_veiculo v ON v.id_veiculo = s.id_veiculo 
            WHERE id_mecanico = $mecanico AND dt_servico >= '$inicio' AND dt_servico <= '$fim'";
            $result = $conexao->query($sql);

            $soldo = 0;
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $id_servico = $row['id_servico'];
                    $id_negocio = $row['id_negocio'];
                    $dt_servico = $row['dt_servico'];
                    $total = $row['total_pagar'];
                    $placa = $row['placa'];
                    $maodeobra = "SELECT sum(valor) FROM tb_itens_os WHERE id_servico = $id_servico AND !isnull(id_servico_manual)";
                    $maodeobra = $conexao->query($maodeobra);
                    $row = $maodeobra->fetch_assoc();
                    $maodeobra = $row['sum(valor)'];
                    $soldo+= $maodeobra;
                    ?>
                    <tr>
                        <td><?= $id_negocio?></td>
                        <td><?= date("d/m/Y", strtotime($dt_servico))?></td>
                        <td><?= $placa?></td>
                        <td><?= number_format($total, 2, ",",".") ?></td>
                        <td><?= number_format($maodeobra, 2, ",",".") ?></td>
                    </tr>
                    <?php
                }
            }
            ?>
            </tbody>
            <tfoot>
            
                <tr class="cab">
                    <th  colspan="5" style="text-align: right;"><h4 class="total"><strong> Total em Mão de Obra R$ <?= number_format($soldo,2,',','.') ?></strong></h4></th>
                </tr>            
            
            </tfoot>
        </table>
            
    </div>
</div>

<?php




$conexao->close();
include_once "../footer.html";
?>


