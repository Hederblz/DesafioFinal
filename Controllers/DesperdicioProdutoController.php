<?php

require_once 'Models/DesperdicioProdutoModel.php';
//  ---Producao---
require_once 'Models/DesperdicioProducaoModel.php';
require_once 'DesperdicioProducaoController.php';
//  ---Produtos---
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
        $ProdutosModel = $ProdutosController->loadByID($desperdicioProduto->codTbProduto);   
        // Ta dando ERRO!!!
        
        $DesperdicioProdutoModel->setId($desperdicioProduto->sequencia);
        $DesperdicioProdutoModel->setCodigoProducao($DesperdicioProducaoModel->getId());
        $DesperdicioProdutoModel->setCodigoProduto($ProdutosModel->getId());
        $DesperdicioProdutoModel->setQtdeSaida($desperdicioProduto->qtdeSaida);

        return $DesperdicioProdutoModel;
    }

    public function save($DesperdicioProdutoModel){
        $link = $this->conecta_mysql();
        $id = $DesperdicioProdutoModel->getId();
        //$codProducao = $DesperdicioProdutoModel->getCodigoProducao();
        $codProducao = 1;
        //$codProduto = $DesperdicioProdutoModel->getCodigoProduto();
        $codProduto = 2;
        $qtdeSaida = $DesperdicioProdutoModel->getQtdeSaida();
        $link = $this->conecta_mysql();

        if (is_null($id))
            $sql_query = "INSERT INTO `desperdicio_producao_produto`
                        (
                            `codTbProducao`,
                            `codTbProduto`,
                            `qtdeSaida`
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
                            `qtdeSaida` = '$qtdeSaida'
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

        $sql_query = "SELECT * FROM `desperdicio_producao` ORDER BY `desperdicio_producao`.`nomePessoa` ASC;";

        try {
            $data = mysqli_query($link, $sql_query);
        } catch (mysqli_sql_exception $e) {
            die($e->getMessage());
        }

        while($desperdicioProducao = $data->fetch_object()){
            $DesperdicioProducaoModel = new DesperdicioProducaoModel();
            $DesperdicioProducaoModel->setId($desperdicioProducao->codigo_producao);
            $DesperdicioProducaoModel->setNomePessoa($desperdicioProducao->nomePessoa);
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

        $sql_query = "SELECT * FROM `desperdicio_producao_produto` ORDER BY `desperdicio_producao_produto`.`sequencia` ASC;";

        //$sql_queryTwo = "SELECT dp.codigo_producao,dp.nomePessoa,dp.dataSaida,dp.numeroProducao,dpp.qtdeSaida,pr.descricao AS produto FROM desperdicio_producao dp JOIN desperdicio_producao_produto dpp ON dp.codigo_producao = dpp.codTbProducao JOIN produtos pr ON dpp.codTbProduto = pr.codigo_produto;";
        //$link = $this->conecta_mysql();
        try {
            $data = mysqli_query($link, $sql_query);
        } catch (mysqli_sql_exception $e) {
            die($e->getMessage());
        }

        $v_desperdicioProduto = array();
        while ($desperdicioProduto_data = $data->fetch_object()) {
            $DesperdicioProdutoModelTwo = new DesperdicioProdutoModel();
            $DesperdicioProdutoModelTwo->setId($desperdicioProduto_data->sequencia);
            $DesperdicioProdutoModelTwo->setCodigoProducao($desperdicioProduto_data->codTbProducao);
            $DesperdicioProdutoModelTwo->setCodigoProduto($desperdicioProduto_data->codTbProduto);
            $DesperdicioProdutoModelTwo->setQtdeSaida($desperdicioProduto_data->qtdeSaida);
            array_push($v_desperdicioProduto, $DesperdicioProdutoModelTwo);
        }   

        $View = new View('views/cadastraDesperdicioProduto.php');
        $View->setNparams(array('v_desperdicioProduto' => $v_desperdicioProduto));
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
        $sql_query = "SELECT * FROM `desperdicio_producao` ORDER BY `desperdicio_producao`.`nomePessoa` ASC;";
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

    public function listarDesperdicioProdutoAction(){
        $sql_query = "SELECT * FROM `desperdicio_producao_produto` ORDER BY `desperdicio_producao_produto`.`sequencia` ASC;";

        //$sql_queryTwo = "SELECT dp.codigo_producao,dp.nomePessoa,dp.dataSaida,dp.numeroProducao,dpp.qtdeSaida,pr.descricao AS produto FROM desperdicio_producao dp JOIN desperdicio_producao_produto dpp ON dp.codigo_producao = dpp.codTbProducao JOIN produtos pr ON dpp.codTbProduto = pr.codigo_produto;";
        $link = $this->conecta_mysql();
        try {
            $data = mysqli_query($link, $sql_query);
        } catch (mysqli_sql_exception $e) {
            die($e->getMessage());
        }

        $v_desperdicioProduto = array();
        while ($desperdicioProduto_data = $data->fetch_object()) {
            $DesperdicioProdutoModel = new DesperdicioProdutoModel();
            $DesperdicioProdutoModel->setId($desperdicioProduto_data->sequencia);
            $DesperdicioProdutoModel->setCodigoProducao($desperdicioProduto_data->codTbProducao);
            $DesperdicioProdutoModel->setCodigoProduto($desperdicioProduto_data->codTbProduto);
            $DesperdicioProdutoModel->setQtdeSaida($desperdicioProduto_data->qtdeSaida);
            array_push($v_desperdicioProduto, $DesperdicioProdutoModel);
        }   

        $View = new View('views/listarDesperdicioProduto.php');
        $View->setNparams(array('v_desperdicioProduto' => $v_desperdicioProduto));
        $View->showContents();
    }

    public function apagarDesperdicioProdutoAction(){
        if ($_GET['id']) {
            $DesperdicioProdutoModel = new DesperdicioProdutoModel();
            $DesperdicioProdutoModel = $this->loadById($_GET['id']);
            $id = $DesperdicioProdutoModel->getId();
            $link = $this->conecta_mysql();
            if (!is_null($id)) {
                $sql_query = "DELETE FROM `desperdicio_producao_produto` WHERE `desperdicio_producao_produto`.`sequencia`=$id";
                try {
                    mysqli_query($link, $sql_query);
                } catch (mysqli_sql_exception $e) {
                    die($e->getMessage());
                }
            }
            Application::redirect('ViewController.php?controle=DesperdicioProduto&acao=cadastraDesperdicioProduto');
        }
    }
}