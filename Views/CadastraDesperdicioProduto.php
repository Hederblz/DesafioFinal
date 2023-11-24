<!DOCTYPE html>
<?php include "Head.php"; ?>
<?php
    $v_params = $this->getParams();
    $DesperdicioProducaoModel = $v_params['DesperdicioProducaoModel'];
?>

<html lang="en">

<body>
<?php include "Views/menu.php"; ?>

    <h1 align="center">Cadastra Desperdicio de Producao</h1>
    <div align="center">
        <form method='POST'>
            <table width="300" border="1">
                
                <tr>
                    <th>
                        teste
                    </th>
                    <th>
                        teste
                    </th>
                    <th>
                        teste
                    </th>

                    <th colspan="2">
                        Ações
                    </th>
                </tr>
                <tr>
                    <td>
                        <input type='text' name='nomePessoa' value='<?php echo $DesperdicioProducaoModel->getNomePessoa(); ?>'>
                    </td>
                    <td>
                        <input type='date' name='dataSaida' value='<?php echo $DesperdicioProducaoModel->getDataSaida(); ?>'>
                    </td>
                    <td>
                        <input type='text' name='numeroProducao' value='<?php echo $DesperdicioProducaoModel->getNumeroProducao(); ?>'>
                    </td>

                    <td align="center">
                        <a href='index.php'>Cancelar</a>
                    </td>
                    <td align="center">
                        <input type='hidden' name='controle' value='DesperdicioProducao'>
                        <input type='hidden' name='acao' value='cadastraDesperdicioProducao'>
                        <input type='hidden' name='id' value='<?php echo $DesperdicioProducaoModel->getId(); ?>'>
                        <button type='submit'>Salvar</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>

    </body>

</html>