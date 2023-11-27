<?php

require_once 'Models/DesperdicioProducaoModel.php';

class DesperdicioProducaoController extends Banco{

    public function loadById($id){
        $sql_query = "SELECT * FROM `desperdicio_producao` WHERE `desperdicio_producao`.`codigo_producao` = $id;";
        $DesperdicioProducaoModel = new DesperdicioProducaoModel();
        $link = $this->conecta_mysql();

        try {
            $data = mysqli_query($link, $sql_query);
        } catch (mysqli_sql_exception $e) {
            die($e->getMessage());
        }

        $desperdicioProducao = $data->fetch_object();
        $DesperdicioProducaoModel->setId($desperdicioProducao->codigo_producao);
        $DesperdicioProducaoModel->setNomePessoa($desperdicioProducao->nomePessoa);
        $DesperdicioProducaoModel->setDataSaida($desperdicioProducao->dataSaida);
        $DesperdicioProducaoModel->setNumeroProducao($desperdicioProducao->numeroProducao);
        $DesperdicioProducaoModel->setFinalizada($desperdicioProducao->finalizada);

        return $DesperdicioProducaoModel;
    }

    public function listarDesperdicioProducaoAction(){
        $sql_query = "SELECT * FROM `desperdicio_producao` ORDER BY `desperdicio_producao`.`codigo_producao` ASC;";
        $link = $this->conecta_mysql();

        try {
            $data = mysqli_query($link, $sql_query);
        } catch (mysqli_sql_exception $e) {
            die($e->getMessage());
        }

        $v_desperdicioProducao = array();
        while ($desperdicioProducao_data = $data->fetch_object()) {
            $DesperdicioProducaoModel = new DesperdicioProducaoModel();
            $DesperdicioProducaoModel->setId($desperdicioProducao_data->codigo_producao);
            $DesperdicioProducaoModel->setNomePessoa($desperdicioProducao_data->nomePessoa);
            $DesperdicioProducaoModel->setDataSaida($desperdicioProducao_data->dataSaida);
            $DesperdicioProducaoModel->setNumeroProducao($desperdicioProducao_data->numeroProducao);
            $DesperdicioProducaoModel->setFinalizada($desperdicioProducao_data->finalizada);
            array_push($v_desperdicioProducao, $DesperdicioProducaoModel);
        }

        $View = new View('views/listarDesperdicioProducao.php');
        $View->setParams(array('v_desperdicioProducao' => $v_desperdicioProducao));
        $View->showContents();
    }

    public function save($DesperdicioProducaoModel){
        $nomePessoa = $DesperdicioProducaoModel->getNomePessoa();
        $dataSaida = $DesperdicioProducaoModel->getDataSaida();
        $numeroProducao = $DesperdicioProducaoModel->getNumeroProducao();
        $finalizada = $DesperdicioProducaoModel->getFinalizada();
        $id = $DesperdicioProducaoModel->getId();
        $link = $this->conecta_mysql();

        if (is_null($id))
            $sql_query = "INSERT INTO `desperdicio_producao`
                        (
                            `nomePessoa`,
                            `dataSaida`,
                            `numeroProducao`,
                            `finalizada`
                        )
                        VALUES
                        (
                            '$nomePessoa',
                            '$dataSaida',
                            '$numeroProducao',
                            '$finalizada'
                        );";
        else
            $sql_query = "UPDATE
                            `desperdicio_producao`
                        SET
                            `nomePessoa` = '$nomePessoa',
                            `dataSaida` = '$dataSaida',
                            `numeroProducao` = '$numeroProducao',
                            `finalizada` = '$finalizada'
                        WHERE
                        `codigo_producao` = $id";
        try {
            mysqli_query($link, $sql_query);
            return true;
        } catch (mysqli_sql_exception $e) {
            die($e->getMessage());
        }
    }

    public function cadastraDesperdicioProducaoAction(){
        $DesperdicioProducaoModel = new DesperdicioProducaoModel();

        if (isset($_REQUEST['id'])) {
            if ($_REQUEST['id'])
                $DesperdicioProducaoModel = $this->loadById($_REQUEST['id']);
        }

        if (count($_POST) > 0) {
            $DesperdicioProducaoModel->setNomePessoa($_POST['nomePessoa']);
            $DesperdicioProducaoModel->setDataSaida($_POST['dataSaida']);
            $DesperdicioProducaoModel->setNumeroProducao($_POST['numeroProducao']);
            $DesperdicioProducaoModel->setFinalizada($_POST['finalizada']);

            if ($this->save($DesperdicioProducaoModel)) {
                Application::redirect('ViewController.php?controle=DesperdicioProduto&acao=cadastraDesperdicioProduto');
                //CadastraDesperdicioProduto
            }
        }
        
        $View = new View('views/cadastraDesperdicioProducao.php');
        $View->setParams(array('DesperdicioProducaoModel' => $DesperdicioProducaoModel));
        $View->showContents();

    }

    public function apagarDesperdicioProducaoAction(){
        if ($_GET['id']) {
            $DesperdicioProducaoModel = new DesperdicioProducaoModel();
            $DesperdicioProducaoModel = $this->loadById($_GET['id']);
            $id = $DesperdicioProducaoModel->getId();
            $link = $this->conecta_mysql();
            if (!is_null($id)) {
                $sql_query = "DELETE FROM `desperdicio_producao` WHERE `desperdicio_producao`.`codigo_producao`=$id";
                try {
                    mysqli_query($link, $sql_query);
                } catch (mysqli_sql_exception $e) {
                    die($e->getMessage());
                }
            }
            Application::redirect('ViewController.php?controle=DesperdicioProducao&acao=listarDesperdicioProducao');
        }
    }

    public function imprimirDesperdicioProducaoAction(){
        $DesperdicioProducaoModel = new DesperdicioProducaoModel();

        if (isset($_REQUEST['id'])) {
            if ($_REQUEST['id'])
                $DesperdicioProducaoModel = $this->loadById($_REQUEST['id']);
        }

        $teste = print($DesperdicioProducaoModel->getId());

        return $teste;
    }
}