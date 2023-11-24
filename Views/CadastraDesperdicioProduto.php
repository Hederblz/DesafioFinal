<!DOCTYPE html>
<?php include "Head.php"; ?>
<?php
    $v_params = $this->getParams();
    $DesperdicioProdutoModel = $v_params['DesperdicioProdutoModel'];
    if ($DesperdicioProdutoModel->getId() != null) {
        $codProducao = $v_params["DesperdicioProducao"];
        $codProduto = $v_params["Produtos"];
    }
    $v_DesperdicioProducao = $v_params["v_DesperdicioProducao"];
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
                        Producao
                    </th>
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
                        <select name="DesperdicioProducao">
                            <?php
                            if ($DesperdicioProdutoModel->getId() !== null) {
                            ?>
                                <option value="<?php echo $codProducao->getId() ?>"> <?php echo $codProducao->getNomePessoa(); ?></option>
                            <?php
                            }
                            ?>

                            <?php
                            foreach ($v_DesperdicioProducao as $DesperdicioProducao) {
                                if ($DesperdicioProducao->getId() !== $DesperdicioProdutoModel->getNomePessoa()) {
                            ?>
                                    <option value="<?php echo $DesperdicioProducao->getId() ?>"><?php echo $DesperdicioProducao->getNomePessoa(); ?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                    </td>
                    <td>
                        <select name="codigoProduto">
                            <?php
                            if ($DesperdicioProdutoModel->getId() !== null) {
                            ?>
                                <option value="<?php echo $codProduto->getId() ?>"> <?php echo $codProduto->getDescricao(); ?></option>
                            <?php
                            }
                            ?>

                            <?php
                            foreach ($v_Produtos as $Produtos) {
                                if ($Produtos->getId() !== $DesperdicioProdutoModel->getDescricao()) {
                            ?>
                                    <option value="<?php echo $Produtos->getId() ?>"><?php echo $Produtos->getDescricao(); ?></option>
                            <?php
                                }
                            }
                            ?>
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

    </body>

</html>