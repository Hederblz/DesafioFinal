<!DOCTYPE html>
<?php include "Head.php"; ?>
<?php
    $v_params = $this->getParams();
    $v_desperdicioProducao = $v_params['v_desperdicioProducao'];
?>

<html lang="en">

<body>
<?php include "Views/menu.php"; ?>

<h1 align="center" >Lista de Desperdicio Produção</h1>

    <div align="center">
        <table width="80%" border="1">
            <tr>
                <th>
                    ID
                </th>
                <th>
                    Nome
                </th>
                <th>
                    Data
                </th>
                <th>
                    Numero
                </th>
                <th>
                    Finalizado
                </th>
               
                <th colspan="3">
                    Ações
                </th>
            </tr>
            <?php
            foreach($v_desperdicioProducao AS $desperdicioProducao)
            {
                ?>
                <tr>
                    <td>
                        <?php echo $desperdicioProducao->getId()?>
                    </td>
                    <td>
                        <?php echo $desperdicioProducao->getNomePessoa()?>
                    </td>
                    <td>
                        <?php echo $desperdicioProducao->getDataSaida()?>
                    </td>
                    <td>
                        <?php echo $desperdicioProducao->getNumeroProducao()?>
                    </td>
                    <td>
                        <?php echo $desperdicioProducao->getFinalizada()?>
                    </td>
                    <td align="center">
                        <a href='ViewController.php?controle=DesperdicioProducao&acao=cadastraDesperdicioProducao&id=<?php echo $desperdicioProducao->getId()?>'>Editar</a>
                    </td>
                    <td align="center">
                        <a href='ViewController.php?controle=DesperdicioProducao&acao=apagarDesperdicioProducao&id=<?php echo $desperdicioProducao->getId()?>'>Apagar</a>
                    </td>
                    <td align="center">
                        <a href='ViewController.php?controle=DesperdicioProducao&acao=imprimirDesperdicioProducao&id=<?php echo $desperdicioProducao->getId()?>'>Imprimir</a>
                    </td>
                </tr>
                <?php } ?>
        </table>
    </div>

</body>

</html>