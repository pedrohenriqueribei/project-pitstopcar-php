<?php

include_once "../header.php";
//

//apenas nivel master pode visualizar
if($nivel == 1) { 
?>

<div class="container">
    <br><h1>faturamento</h1><br><br>
   
    <div class="form-group">
        
        <div class="row">
            <div class="col-sm-4">
                
            </div>
            <div class="col-sm-4">
                

                <form role="form" action="ver.php" method="post">
                    
                    <h2 style="text-align:center">Buscar por mês</h2> 
                    <div class="row justify-content-center">
                    
                        <div class="col-sm-4">    
                            <label for="ano">Ano</label>
                            <select name="ano" id="ano" class="form-control custom-select">
                                <?php
                                $sql = "SELECT distinct year(dt_servico) as anos FROM tb_ordem_servico WHERE id_master = ".ID_MASTER;
                                $query = $conexao->query ($sql);
                                while ($array = $query->fetch_assoc()) {
                                    $ano = $array['anos'];
                                    ?>
                                        <option value="<?= $ano ?>"><?= $ano ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-sm-4">
                            <label for="mes">Mês</label>
                            <select name="mes" id="mes" class="form-control custom-select">
                                <?php
                                $sql = "SELECT distinct month(dt_servico) as meses FROM tb_ordem_servico WHERE id_master = " . ID_MASTER;
                                $query = $conexao->query ($sql);
                                while ($array = $query->fetch_assoc()) {
                                    $meses = $array['meses'];
                                    ?>
                                        <option value="<?= $meses ?>">
                                            <?php switch ($meses) {
                                                case 1: echo "Janeiro"; break; case 2: echo "Fevereiro"; break; case 3: echo "Março";    break;   
                                                case 4: echo "Abril"  ; break; case 5: echo "Maio";      break; case 6: echo "Junho";    break;
                                                case 7: echo "Julho"  ; break; case 8: echo "Agosto";    break; case 9: echo "Setembro"; break;
                                                case 10: echo "Outubro";break; case 11: echo "Novembro"; break; case 12: echo "Dezembro"; break;
                                            } ?>
                                        </option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div style="text-align: center;"   >
                        <button type="submit" class="btn btn-primary text-uppercase mb-3 botao_salvar btn-lg" >Buscar</button><br><br>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
                
           
</div>



<?php
}
include_once "../footer.html";
?>