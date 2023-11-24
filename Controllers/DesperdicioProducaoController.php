<?php

require_once 'Models/DesperdicioProducaoModel.php';

class DesperdicioProducaoController extends Banco{

    public function loadById($id){
        $sql_query = "SELECT * FROM `desperdicio_producao` WHERE `desperdicio_producao`.`id` = $id;";
        $DesperdicioProducaoModel = new DesperdicioProducaoModel();
        $link = $this->conecta_mysql();

        try {
            $data = mysqli_query($link, $sql_query);
        } catch (mysqli_sql_exception $e) {
            die($e->getMessage());
        }

        $desperdicioProducao = $data->fetch_object();
        $DesperdicioProducaoModel->setId($desperdicioProducao->id);
        $DesperdicioProducaoModel->setNomePessoa($desperdicioProducao->nome_pessoa);
        $DesperdicioProducaoModel->setDataSaida($desperdicioProducao->data_saida);
        $DesperdicioProducaoModel->setNumeroProducao($desperdicioProducao->numero_producao);
        $DesperdicioProducaoModel->setFinalizada($desperdicioProducao->finalizada);

        return $DesperdicioProducaoModel;
    }

    public function listarDesperdicioProducaoAction(){
        $sql_query = "SELECT * FROM `desperdicio_producao` ORDER BY `desperdicio_producao`.`id` ASC;";
        $link = $this->conecta_mysql();

        try {
            $data = mysqli_query($link, $sql_query);
        } catch (mysqli_sql_exception $e) {
            die($e->getMessage());
        }

        $v_desperdicioProducao = array();
        while ($desperdicioProducao_data = $data->fetch_object()) {
            $DesperdicioProducaoModel = new DesperdicioProducaoModel();
            $DesperdicioProducaoModel->setId($desperdicioProducao_data->id);
            $DesperdicioProducaoModel->setNomePessoa($desperdicioProducao_data->nome_pessoa);
            $DesperdicioProducaoModel->setDataSaida($desperdicioProducao_data->data_saida);
            $DesperdicioProducaoModel->setNumeroProducao($desperdicioProducao_data->numero_producao);
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
                            `nome_pessoa`,
                            `data_saida`,
                            `numero_producao`,
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
                            `nome_pessoa` = '$nomePessoa',
                            `data_saida` = '$dataSaida',
                            `numero_producao` = '$numeroProducao',
                            `finalizada` = '$finalizada'
                        WHERE
                        `id` = $id";
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
            $DesperdicioProducaoModel->setFinalizada($$_POST['finalizada']);

            if ($this->save($DesperdicioProducaoModel)) {
                Application::redirect('ViewController.php?controle=DesperdicioProduto&acao=CadastraDesperdicioProduto');
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
                $sql_query = "DELETE FROM `desperdicio_producao` WHERE `desperdicio_producao`.`id` = $id";
                try {
                    mysqli_query($link, $sql_query);
                } catch (mysqli_sql_exception $e) {
                    die($e->getMessage());
                }
            }
            Application::redirect('ViewController.php?controle=DesperdicioProducao&acao=listarDesperdicioProducao');
        }
    }
}