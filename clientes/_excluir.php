<?php
ob_start();    
include_once "../header.php";
//

$id = $_GET['cod'];

$select = "SELECT count(cliente) as cont FROM tb_ordem_servico WHERE cliente = $id AND id_master = ".ID_MASTER;
$qy= $conexao->query($select);
$fetch = $qy->fetch_assoc();
$verif = $fetch['cont'];

if ($verif > 0) {
    echo "Este cliente solicitou $verif serviços(s) e não pode ser excluído.";
}

else {
    echo "Este cliente não fez compras";

    $sql = "SELECT * FROM tb_cliente WHERE idCliente = $id";
    $result = $conexao->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $nome = $row['nome'];
            $sobrenome = $row['sobrenome'];
            $tel = $row['telefone'];
        }
    }

    $sql = "DELETE FROM tb_cliente WHERE idCliente = $id AND id_master = ".ID_MASTER;

    $query = $conexao->query($sql);

    $addr = "DELETE FROM tb_endereco WHERE id_cliente = $id AND id_master = ".ID_MASTER;

    if ($query = $conexao->query($addr)){

        //registrar log
        include_once "../auditoria/log.php";
                
        $registro = "Deletar cliente: $id - Nome: $nome $sobrenome - Telefone: $tel";
        $coluna = "todos;";
        registrar_log($registro, 'tb_cliente', $coluna);

    }

    $conexao->close();

?>

<div class="container">
    <p>Cliente excluído com sucesso</p>

    <br>

    <a  role="button" class="btn btn-primary text-uppercase mb-3 botao_salvar col-6 col-md-4" href="/pitstopcar/clientes/lista.php"><i class="fas fa-arrow-left"></i> Voltar</a>
</div>

<?php

}
ob_end_flush();
?>