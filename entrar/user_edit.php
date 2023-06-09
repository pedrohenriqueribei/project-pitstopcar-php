<?php

    if (!isset($_SESSION)) session_start();

    include_once "../header.php";
    //
    

    $id = $_GET['id'];

    $sql = "SELECT * FROM tb_user WHERE id_master = ".ID_MASTER." AND id_user = $id";
    $result = $conexao->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        $row = $result->fetch_assoc();
        
        $id_user = $row['id_user'];
        $nome = $row['nome'];
        $usuario = $row['usuario'];
        $senha = $row['senha'];
        $nivel = $row['nivel'];
        
    } else {
        echo "0 results";
    }
?>

<div class="container">
    <br><br>
    
    <h1>Editar Perfil de <?= $nome ?></h1> <br><br>


    <form role="form" action="/pitstopcar/entrar/user_update.php" method="post">
        <div class="form-group">
            <div class="row">
                <div class="col-sm-6">
                    <label for="nome">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" value="<?= $nome ?>" >
                </div>

                
                <div class="col-sm-3">
                    <label for="nome">Nível de acesso</label>
                    <select name="nivel" id="nivel" class="form-control custom-select">
                        <option value="1" <?php if($nivel == 1){echo "selected";} ?> >Master</option>
                        <option value="2" <?php if($nivel == 2){echo "selected";} ?> >Funcionário</option>
                        <option value="3" <?php if($nivel == 3){echo "selected";} ?> >Mecânico</option>
                    </select>
                </div>
                
            </div>

            <div class="row">
                <div class="col-sm-4">
                    <label for="usuario">Nome de Usuário</label>
                    <input type="text" class="form-control" id="usuario" name="usuario" value="<?= $usuario ?>" >
                </div>

                <div class="col-sm-4">
                    <label for="senha">Senha</label>
                    <input type="password" class="form-control" id="senha" name="senha" value="<?= $senha ?>" >
                </div>

                <div class="col-sm-4">
                    <label for="nova_senha">Nova Senha</label>
                    <input type="password" class="form-control" id="nova_senha" name="nova_senha" value="<?= $senha ?>" >
                </div>

                <div>
                    <input style="display: none" type="number" name="id_user" value="<?= $id_user ?>">
                </div>
            </div>
        </div>

        <?php
        
        if(isset($_SESSION['erro_nova_senha'])){
            ?>
            <div class="alert alert-danger" role="alert">
                <h6><?= $_SESSION['erro_nova_senha'] ?></h6>
            </div>  
            <?php
        }
        ?>

        <div style="text-align: center;"   >
            <button type="submit" class="btn btn-primary text-uppercase mb-3 botao_salvar btn-lg col-sm-4" >Salvar</button><br><br>
        </div>
    </form>
        
</div> 

<?php
    $conexao->close();
    include_once "../footer.html";
?>