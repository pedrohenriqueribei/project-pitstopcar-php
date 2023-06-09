<?php
ob_start();

include_once "../header.php";


$nome = $_POST['nome'];
$sobrenome = $_POST['sobrenome'];
$telefone = $_POST['telefone'];
$sexo = $_POST['sexo'];
$data_nasc = $_POST['data_nasc'];
$cpf = $_POST['cpf'];



//buscar id de negócio
$sql = "SELECT max(id_negocio) FROM tb_cliente WHERE id_master = ". ID_MASTER;
$result = $conexao->query($sql);
$row = $result->fetch_assoc();
$id_negocio = $row['max(id_negocio)'] >= 1 ? $row['max(id_negocio)'] : 0;
$id_negocio++;


$sql = "INSERT INTO tb_cliente (id_negocio, nome, sobrenome, telefone, sexo, data_nasc, cpf, id_master) 
    VALUES ($id_negocio, '$nome', '$sobrenome', '$telefone', $sexo, '$data_nasc', '$cpf', ".ID_MASTER.")";

if ($conexao->query($sql) === TRUE) {
    $last_id = $conexao->insert_id;
    
    echo "Cliente cadastrado com sucesso. Last inserted ID is: " . $last_id;

    //registrar log
    include_once "../auditoria/log.php";
                
    $registro = "Incluir cliente: $last_id -  Nome: $nome $sobrenome";
    $coluna = "todos;";
    registrar_log($registro, 'tb_cliente', $coluna);



    if(!empty($_POST['cep']) OR !empty($_POST['logradouro'])) {
        $cep = $_POST['cep'];
        $logradouro = $_POST['logradouro'];
        $complemento = $_POST['complemento'];
        $bairro = $_POST['bairro'];
        $cidade = $_POST['cidade'];
        $uf = $_POST['uf'];
        
        $addr = "INSERT INTO tb_endereco (cep, logradouro, complemento, bairro, cidade, uf, id_cliente, id_master) 
                VALUES ('$cep', '$logradouro','$complemento','$bairro','$cidade','$uf',$last_id,".ID_MASTER.")";
        
        if ($conexao->query($addr) === TRUE) {
            echo "Endereço cadastrado com sucesso.";
    
            
        } else {
            echo "Error: " . $addr . "<br>" . $conexao->error;
        }
    } 

    header("Location: compras.php/?id=".$last_id);

} else {
    echo "Error: " . $sql . "<br>" . $conexao->error;
}
  



$conexao->close();



?>

<div class="container"><br><br>
<p><?= 'Cliente '.$nome;?> cadastrado(a) com sucesso</p>
<br><br>
<div> 
    <a href="form.php" role="button" class="btn btn-primary text-uppercase mb-3 col-6 col-md-4 botao_salvar">Cadastrar Novo Cliente</a>
</div>
<br>
<div>
    <a href="lista.php" role="button" class="btn btn-primary text-uppercase mb-3 col-6 col-md-4 botao_salvar">Listar Clientes</a>
</div>
<br><br><br>

</div>

<?php
    include_once "../footer.html";
    ob_end_flush();
?>