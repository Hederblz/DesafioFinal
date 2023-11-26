<!DOCTYPE html>
<?php include "Head.php"; ?>
<?php
    $v_params = $this->getParams();
    $DesperdicioProdutoModel = $v_params['DesperdicioProdutoModel'];
    $n_params = $this->getNparams();
    $v_desperdicioProduto = $n_params['v_desperdicioProduto'];
 //   if ($DesperdicioProdutoModel->getId() != null) {
    //    $codProducao = $v_params["DesperdicioProducao"];
    //    $codProduto = $v_params["Produtos"];
   // }
   // $v_DesperdicioProducao = $v_params["v_DesperdicioProducao"];
    //$v_Produtos = $v_params["v_Produtos"];
?>

<html lang="en">

<body>
<?php include "Views/menu.php"; ?>

    <h1 align="center">Cadastra Desperdicio de Produtos</h1>
    <div align="center">
        <form method='POST'>
            <table width="300" border="1">
                
                <tr>
                    <th>    
                        Produto
                    </th>
                    <th>
                        Quantidade de Saida
                    </th>

                    <th colspan="2">
                        Ações
                    </th>
                </tr>
                <tr>
                    <td>
                        <select id="produtos" name="produto">
                        <option value="1">Produto A</option>
                        <option value="2">Produto B</option>
                        </select>   
                    </td> 
                    <td>
                        <input type='text' name='qtdeSaida' value='<?php echo $DesperdicioProdutoModel->getQtdeSaida(); ?>'>
                    </td> 
                    <td align="center">
                        <a href='index.php'>Cancelar</a>
                    </td>
                    <td align="center">
                        <input type='hidden' name='controle' value='DesperdicioProduto'>
                        <input type='hidden' name='acao' value='cadastraDesperdicioProduto'>
                        <input type='hidden' name='id' value='<?php echo $DesperdicioProdutoModel->getId(); ?>'>
                        <button type='submit'>Salvar</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
   <!-- Lista  Lista  Lista  Lista  Lista  Lista  Lista  Lista  Lista  Lista  Lista  Lista  Lista  Lista  Lista  Lista  Lista  Lista  Lista  Lista  Lista  Lista -->
    <br>
    <h1 align="center">Lista de Produtos</h1>
    <div align="center">
    <table width="80%" border="1">
            <tr>
                <th>
                    Produto
                </th>
                <th>
                    Quantidade de Saida
                </th>
                <th colspan="3">
                    Ações
                </th>
            </tr>
            <?php
            foreach($v_desperdicioProduto AS $desperdicioProduto)
            {
                ?>
            <tr>
                <td>
                    <?php echo $desperdicioProduto->getCodigoProduto()?>
                </td>
                <td>
                    <?php echo $desperdicioProduto->getQtdeSaida()?>
                </td>
                <td align="center">
                    <a href='#'>Editar</a>
                </td>
                <td align="center">
                    <a href='ViewController.php?controle=DesperdicioProduto&acao=apagarDesperdicioProduto&id=<?php echo $desperdicioProduto->getId()?>'>Apagar</a>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
    <br>
    <div align="center" ><button><a href="#" class="sem-linha">Finalizar</a></button></div>

    </body>

</html>