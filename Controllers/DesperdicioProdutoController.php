<?php

require_once 'Models/DesperdicioProdutoModel.php';
require_once 'Models/DesperdicioProducaoModel.php';
require_once 'DesperdicioProducaoController.php';
require_once 'Models/ProdutosModel.php';
require_once 'ProdutosController.php';

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

        $DesperdicioProducaoController = new DesperdicioProducaoController();
        $DesperdicioProducaoModel = new DesperdicioProducaoModel();
        $DesperdicioProducaoModel = $DesperdicioProducaoController->loadByID($desperdicioProduto->codTbProducao);

        $ProdutosController = new ProdutosController();
        $ProdutosModel = new ProdutosModel();
        $ProdutosModel = $ProdutosController->loadByID($desperdicioProduto->codigo_produto);

        
        $DesperdicioProdutoModel->setId($desperdicioProduto->sequencia);
        $DesperdicioProdutoModel->setCodigoProducao($DesperdicioProducaoModel->getId());
        $DesperdicioProdutoModel->setCodigoProduto($ProdutosModel->getId());
        $DesperdicioProdutoModel->setQtdeSaida($desperdicioProduto->qtde_saida);

        return $DesperdicioProdutoModel;
    }

    public function save($DesperdicioProdutoModel){
        $link = $this->conecta_mysql();
        $id = $DesperdicioProdutoModel->getId();
        $codProducao = $DesperdicioProdutoModel->getCodigoProducao();
        $codProduto = $DesperdicioProdutoModel->getCodigoProduto();
        $qtdeSaida = $DesperdicioProdutoModel->getQtdeSaida();
        $link = $this->conecta_mysql();

        if (is_null($id))
            $sql_query = "INSERT INTO `desperdicio_producao_produto`
                        (
                            `codTbProducao`,
                            `codTbProduto`,
                            `qtde_saida`
                        )
                        VALUES
                        (
                            '$codProducao',
                            '$codProduto',
                            '$qtdeSaida'
                        );";
        else
            $sql_query = "UPDATE
                            `desperdicio_producao_produto`
                        SET
                            `codTbProducao` = '$codProducao',
                            `codTbProduto` = '$codProduto',
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
        $DesperdicioProducaoController = new DesperdicioProducaoController();
        $ProdutosController = new ProdutosController();
        $DesperdicioProducaoModel = new DesperdicioProducaoModel();
        $ProdutosModel = new ProdutosModel();
        $v_DesperdicioProducao = array();
        $v_Produtos = array();
        $link = $this->conecta_mysql();

        if (isset($_REQUEST['id'])) {
            if ($_REQUEST['id'])
                $DesperdicioProdutoModel = $this->loadById($_REQUEST['id']);
                $DesperdicioProducaoModel = $DesperdicioProducaoController->loadById($DesperdicioProdutoModel->getCodigoProducao());
                $ProdutosModel = $ProdutosController->loadById($DesperdicioProdutoModel->getId());
        }

        if (count($_POST) > 0) {
            $DesperdicioProdutoModel->setCodigoProducao($_POST['codigoProducao']);
            $DesperdicioProdutoModel->setCodigoProduto($_POST['codigoProduto']);
            $DesperdicioProdutoModel->setQtdeSaida($_POST['qtdeSaida']);

            if ($this->save($DesperdicioProdutoModel)) {
                Application::redirect('ViewController.php?controle=DesperdicioProduto&acao=CadastraDesperdicioProduto');
            }
        }

        $sql_query = "SELECT * FROM `desperdicio_producao` ORDER BY `desperdicio_producao`.`nome_pessoa` ASC;";

        try {
            $data = mysqli_query($link, $sql_query);
        } catch (mysqli_sql_exception $e) {
            die($e->getMessage());
        }

        while($desperdicioProducao = $data->fetch_object()){
            $DesperdicioProducaoModel = new DesperdicioProducaoModel();
            $DesperdicioProducaoModel->setId($desperdicioProducao->id);
            $DesperdicioProducaoModel->setNomePessoa($desperdicioProducao->nome_pessoa);
            array_push($v_DesperdicioProducao, $DesperdicioProducaoModel);
        }

        $sql_query = "SELECT * FROM `produtos` ORDER BY `produtos`.`descricao` ASC;";

        try {
            $data = mysqli_query($link, $sql_query);
        } catch (mysqli_sql_exception $e) {
            die($e->getMessage());
        }

        while($produto = $data->fetch_object()){
            $ProdutosModel = new ProdutosModel();
            $ProdutosModel->setId($produto->codigo_produto);
            $ProdutosModel->setDescricao($produto->descricao);
            array_push($v_Produtos, $ProdutosModel);
        }

        $View = new View('views/cadastraDesperdicioProduto.php');
        $View->setParams(array(
            'DesperdicioProdutoModel' => $DesperdicioProdutoModel,
            'v_DesperdicioProducao' => $v_DesperdicioProducao,
            'DesperdicioProducao'=> $DesperdicioProducaoModel,
            //
            'v_Produtos' => $v_Produtos,
            'Produtos'=> $ProdutosModel
        ));
        $View->showContents();

    }

    public function novoDesperdicioProdutoAction(){
        $sql_query = "SELECT * FROM `desperdicio_producao` ORDER BY `desperdicio_producao`.`nome_pessoa` ASC;";
        $link = $this->conecta_mysql();

        try {
            $data = mysqli_query($link, $sql_query);
        } catch (mysqli_sql_exception $e) {
            die($e->getMessage());
        }

        $v_DesperdicioProducao = array();
        while ($desperdicioProducao = $data->fetch_object()) {
            $DesperdicioProducaoModel = new DesperdicioProducaoModel();
            $DesperdicioProducaoModel->setId($desperdicioProducao->id);
            $DesperdicioProducaoModel->setNomePessoa($desperdicioProducao->nome_pessoa);
            array_push($v_DesperdicioProducao, $DesperdicioProducaoModel);
        }

        $sql_query = "SELECT * FROM `produtos` ORDER BY `produtos`.`descricao` ASC;";
        $link = $this->conecta_mysql();

        try {
            $data = mysqli_query($link, $sql_query);
        } catch (mysqli_sql_exception $e) {
            die($e->getMessage());
        }

        $v_Produtos = array();
        while ($produtos = $data->fetch_object()) {
            $ProdutosModel = new ProdutosModel();
            $ProdutosModel->setId($produtos->codigo_produto);
            $ProdutosModel->setDescricao($produtos->descricao);
            array_push($v_Produtos, $ProdutosModel);
        }

        $DesperdicioProdutoModel = new DesperdicioProdutoModel();

        $View = new View('views/cadastraDesperdicioProduto.php');
        $View->setParams(array(
            'desperdicioProduto' => $DesperdicioProdutoModel, 
            'v_DesperdicioProducao' => $v_DesperdicioProducao,
            'v_Produtos' => $v_Produtos
        ));
        $View->showContents();
    }
}