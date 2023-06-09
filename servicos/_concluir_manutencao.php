<?php 
    ob_start();

    include_once "../header.php";

    $id = $_GET['id'];

    //buscar prazo de garantia
    $sql = "SELECT garantia, dt_servico FROM tb_ordem_servico WHERE id_servico = $id";
    $result = $conexao->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $garantia = $row['garantia'];
        $dt_servico = $row['dt_servico'];

        if($garantia > 0){

            $prazo = date($dt_servico, strtotime('+'.$garantia.' days'));
            
            
            $sql = "UPDATE tb_ordem_servico SET status = 3, dt_manutencao = curdate() WHERE id_servico = $id";
            
            
            if ($conexao->query($sql) === TRUE) {
                echo "Record updated successfully";

                //registrar log
                include_once "../auditoria/log.php";
                            
                $registro = "Manutencao Concluida servico: ID: $id";
                $coluna = "status";
                registrar_log($registro, 'tb_ordem_servico', $coluna);

            } else {
                echo "Error updating record: " . $conexao->error;
            }
            
            $conexao->close();
        
            header("Location: /pitstopcar/servicos/3_aguardando_pag.php");
        } else {
            include_once "../header.php";
            ?>
            <div class="container">
                <div class="alert alert-warning" role="alert">
                    Para concluir a manutenção é necessário definir prazo de garantia.</p>
                </div>

                <a href="/pitstopcar/servicos/abrir.php/?id=<?= $id?>" class="btn btn-primary text-uppercase mb-3 btn-lg    botao">Voltar</a>
                
            </div>
            <?php
        }

    } else {
        echo "0 results";
    }
    $conexao->close();

    ob_end_flush();
?>