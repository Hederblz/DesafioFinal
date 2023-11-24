<?php

require_once 'Models/DesperdicioProdutoModel.php';

class DesperdicioProdutoController extends Banco{
    
    public function loadById($id){
        $sql_query = "SELECT * FROM `desperdicio_producao_produto` WHERE `desperdicio_producao_produto`.`sequencia` = $id;";
        $DesperdicioProdutoModel = new DesperdicioProdutoModel();
        $link = $this->conecta_mysql();

        try {
            $data = mysqli_query($link, $sql_query);
        } catch (mysqli_sql_exception $e) {
            die($e->getMessage());
        }

        $desperdicioProduto = $data->fetch_object();
        $DesperdicioProdutoModel->setSequencia($desperdicioProduto->sequencia);
        $DesperdicioProdutoModel->setId($desperdicioProduto->id);
        $DesperdicioProdutoModel->setCodigoProduto($desperdicioProduto->codigo_produto);
        $DesperdicioProdutoModel->setQtdeSaida($desperdicioProduto->qtde_saida);

        return $DesperdicioProdutoModel;
    }

    public function save($DesperdicioProdutoModel){
        $idProducao = $DesperdicioProdutoModel->getId();
        $codigoProduto = $DesperdicioProdutoModel->getCodigoProduto();
        $qtdeSaida = $DesperdicioProdutoModel->getQtdeSaida();
        $id = $DesperdicioProdutoModel->getSequencia();
        $link = $this->conecta_mysql();

        if (is_null($id))
            $sql_query = "INSERT INTO `desperdicio_producao_produto`
                        (
                            `id`,
                            `codigo_produto`,
                            `qtde_saida`
                        )
                        VALUES
                        (
                            '$idProducao',
                            '$codigoProduto',
                            '$qtdeSaida'
                        );";
        else
            $sql_query = "UPDATE
                            `desperdicio_producao_produto`
                        SET
                            `id` = '$idProducao',
                            `codigo_produto` = '$codigoProduto',
                            `qtde_saida` = '$qtdeSaida'
                        WHERE
                        `sequencia` = $id";
        try {
            mysqli_query($link, $sql_query);
            return true;
        } catch (mysqli_sql_exception $e) {
            die($e->getMessage());
        }
    }

    public function cadastraDesperdicioProdutoAction(){
        $DesperdicioProdutoModel = new DesperdicioProdutoModel();

        if (isset($_REQUEST['id'])) {
            if ($_REQUEST['id'])
                $DesperdicioProducaoModel = $this->loadById($_REQUEST['id']);
        }

        if (count($_POST) > 0) {
            $DesperdicioProdutoModel->setId($_POST['id']);
            $DesperdicioProdutoModel->setCodigoProduto($_POST['codigoProduto']);
            $DesperdicioProdutoModel->setQtdeSaida($_POST['qtdeSaida']);

            if ($this->save($DesperdicioProducaoModel)) {
                Application::redirect('ViewController.php?controle=DesperdicioProduto&acao=CadastraDesperdicioProduto');
            }
        }

        $View = new View('views/cadastraDesperdicioProduto.php');
        $View->setParams(array('DesperdicioProdutoModel' => $DesperdicioProdutoModel));
        $View->showContents();

    }
}