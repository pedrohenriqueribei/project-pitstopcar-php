<?php
ob_start();

include_once "../header.php";




$id = $_POST['idCliente'];
$p_nome = $_POST['nome'];
$p_sobrenome = $_POST['sobrenome'];
$p_telefone = $_POST['telefone'];
$p_sexo = $_POST['sexo'];
$p_data_nasc = $_POST['data_nasc'];
$cpf = $_POST['cpf'];



echo $sql = 
"UPDATE tb_cliente 
SET 
nome = '$p_nome',
sobrenome = '$p_sobrenome',    
telefone = '$p_telefone',
sexo = $p_sexo,
data_nasc = '$p_data_nasc',
cpf = '$cpf'
WHERE idCliente = $id AND id_master = ".ID_MASTER;

if ($conexao->query($sql) === TRUE) {
    echo "Record updated successfully";


    //registrar log
    include_once "../auditoria/log.php";
            
    $registro = "Atualizar cliente: $id -  Nome: $p_nome $p_sobrenome - Telefone: $p_telefone";
    $coluna = "todos;";
    registrar_log($registro, 'tb_cliente', $coluna);

    
    
    $addr = "SELECT * FROM tb_endereco WHERE id_cliente = $id";
    
    $result_add = $conexao->query($addr);
    
    
    if(!empty($_POST['cep']) OR !empty($_POST['logradouro']) AND !empty($_POST['bairro'])) {
    
        $cep = $_POST['cep'];
        $logradouro = $_POST['logradouro'];
        $complemento = $_POST['complemento'];
        $bairro = $_POST['bairro'];
        $cidade = $_POST['cidade'];
        $uf = $_POST['uf'];
    
        if ($result_add->num_rows == 1) {
            echo "Atualizar endereço";
            
            $update = "UPDATE tb_endereco SET 
            cep = '$cep', 
            logradouro = '$logradouro', 
            complemento = '$complemento', 
            bairro = '$bairro', 
            cidade = '$cidade', 
            uf = '$uf'
            WHERE id_cliente = $id ";
    
            if ($conexao->query($update) === TRUE) {
                echo "Record updated successfully";
                
                //registrar log
                include_once "../auditoria/log.php";
                        
                $registro = "Atualizar Endereço: $id -  Nome: $p_nome $p_sobrenome - CEP: $cep";
                $coluna = "CEP";
                registrar_log($registro, 'tb_endereco', $coluna);
    
            } else {
                echo "Error updating record: " . $conexao->error;
            }
            
    
    
            
            
        } else if ($result_add->num_rows == 0) {
            echo "0 results";
            $addr = "INSERT INTO tb_endereco (cep, logradouro, complemento, bairro, cidade, uf, id_cliente, id_master) 
            VALUES ('$cep', '$logradouro','$complemento','$bairro','$cidade','$uf', $id,".ID_MASTER.")";
    
            if ($conexao->query($addr) === TRUE) {
                echo "Endereço incluído com sucesso";
    
                //registrar log
                include_once "../auditoria/log.php";
                        
                $registro = "Incluir de endereço cliente: $id -  Nome: $p_nome $p_sobrenome - CEP: $cep";
                $coluna = "Endereço;";
                registrar_log($registro, 'tb_endereco', $coluna);
            
            } else {
                echo "Error: " . $sql . "<br>" . $conexao->error;
            }
    
            
    
        }

        header("Location: /pitstopcar/clientes/lista.php");
    
    } elseif ((!empty($_POST['logradouro']) AND empty($_POST['bairro'])) OR (!empty($_POST['cep']) AND empty($_POST['logradouro']) AND empty($_POST['bairro']))){
        $_SESSION['erro_endereco'] = "Endereço invalido";
        header("Location: form_editar.php/?id=".$id);
    }
} else {
echo "Error updating record: " . $conexao->error;
}







?>

<div class="container">
<p>Cliente atualizado(a) com sucesso</p>

<div> 
    <a href="form.php" role="button" class="btn btn-primary text-uppercase mb-3 botao_salvar col-6 col-md-4">Cadastrar Novo Cliente</a>
</div>
<br>
<div>
    <a href="lista.php" role="button" class="btn btn-primary text-uppercase mb-3 botao_salvar col-6 col-md-4"><i class="fas fa-arrow-left"></i> Voltar</a>
</div>
    

</div>


<?php $conexao->close(); ob_end_flush(); ?>