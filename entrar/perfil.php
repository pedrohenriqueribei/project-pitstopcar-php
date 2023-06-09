<?php
    
    ob_start();
    include_once "../header.php";
    //


    
    $_SESSION['usuario'];
    $user = $_SESSION['usuario'];

    $sql = "SELECT * FROM tb_user WHERE id_master = ".ID_MASTER." AND usuario = '$user'";

    $query = $conexao->query($sql);
    $array = $query->fetch_assoc();
    
    $nome = $array['nome'];
    $usuario = $array['usuario'];
    $senha = $array['senha'];
    $master = $array['id_master'];
    $id_user = $array['id_user'];
    $nivel = $array['nivel'];
?>

<div class="container">

    <?php
    if(isset($_SESSION['erro'])){
        ?>
        <div class="alert alert-danger" role="alert">
            <h6><?= $_SESSION['erro'] ?></h6>
        </div>  
        <?php
    }
    ?>
    <br><br>
    
    <h1>Perfil de <?= $nome ?></h1> <br><br>

    <form role="form" action="/pitstopcar/entrar/atualizar.php" method="post">
        <div class="form-group">
            <div class="row">
                <div class="col-sm-6">
                    <label for="nome">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" maxlength="45" value="<?= $nome ?>" >
                </div>

                <?php if($nivel == 1){ ?>
                <div class="col-sm-3">
                    <label for="nome">Nível de acesso</label>
                    <select name="nivel" id="nivel" class="form-control custom-select">
                        <option value="1" <?php if($nivel == 1){echo "selected";} ?> >Master</option>
                        <option value="2" <?php if($nivel == 2){echo "selected";} ?> >Funcionário</option>
                        <option value="3" <?php if($nivel == 3){echo "selected";} ?> >Mecânico</option>
                    </select>
                </div>
                <?php 
                    }
                    
                ?>
            </div>

            <div class="row">
                <div class="col-sm-4">
                    <label for="usuario">Nome de Usuário</label>
                    <input type="text" class="form-control" id="usuario" name="usuario" maxlength="45" style="text-transform: lowercase" value="<?= $usuario ?>" >
                </div>

                <div class="col-sm-4">
                    <label for="senha">Senha</label>
                    <input type="password" class="form-control" id="senha" name="senha" maxlength="45" value="<?= $senha ?>" >
                </div>

                <div class="col-sm-4">
                    <label for="nova_senha">Nova Senha</label>
                    <input type="password" class="form-control" id="nova_senha" name="nova_senha" maxlength="45" value="<?= $senha ?>" >
                </div>

                <div>
                    <input style="display: none" type="number" name="id_user" value="<?= $id_user ?>">
                </div>
            </div>
        </div>

        <?php
        //if (!isset($_SESSION)) session_start();
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

    <?php if($nivel == 1){ ?>

   

    <div style="text-align: right">
        <a href="/pitstopcar/entrar/novo.php" class="btn btn-primary text-uppercase mb-3 botao btn-lg"><i class="fas fa-plus"></i>Novo Funcionário</a><br><br>
    </div>

    

    

                    
    <h2>Lista de Funcionários</h2>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr class="cab">
                    <th>Nome</th>
                    <th>Usuário</th>
                    <th>Nível de Acesso</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
            
            <?php

            $sql = "SELECT * FROM tb_user WHERE id_master = ". ID_MASTER;
            
            $results = $conexao->query($sql);
            
            if ($results->num_rows > 0) {
                // output data of each row
                while($row = $results->fetch_assoc()) {
                    $nome_func = $row['nome'];
                    $usuario_func = $row['usuario'];
                    $nivel_func = $row['nivel'];
                    $id_func = $row['id_user'];
                    ?>
                    <tr>
                        <td><?= $nome_func ?></td>
                        <td><?= $usuario_func ?></td>
                        <td><?php 
                            if ($nivel_func == 1) {
                                echo "Master";
                            }  elseif ($nivel_func == 2) {
                                echo "Funcionário";
                            } elseif ($nivel_func == 3){
                                echo "Mecânico";
                            }
                        ?></td>
                        <td style="text-align:center">
                            <a href="user_edit.php/?id=<?= $id_func?>" class="btn btn-primary text-uppercase mb-3 btn-sm botao"> Editar</a>
                            <?php if ($usuario != $usuario_func){?><a href="user_delete.php/?id=<?= $id_func?>" class="btn btn-primary text-uppercase mb-3 btn-sm botao"><i class="far fa-trash-alt"></i> Excluir</a>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php
                }
            } else {
            echo "0 results";
            }
            $conexao->close();
            ?>
            </tbody>   
        </table>
    </div>
        
    <?php } ?>
</div>


<?php
    if(isset($_SESSION['erro'])) unset($_SESSION['erro']);
    include_once "../footer.html";
    ob_end_flush();
?>