<?php

//  ---GrupoProdutos---
require_once 'GrupoProdutosController.php';
require_once 'Models/GrupoProdutosModel.php';


class ProdutosController extends Banco{
    
    public function loadById($id){
        $sql_query = "SELECT * FROM `produtos` WHERE `produtos`.`codigo_produto` = $id;";
        $ProdutosModel = new ProdutosModel();
        $link = $this->conecta_mysql();

        try {
            $data = mysqli_query($link, $sql_query);
        } catch (mysqli_sql_exception $e) {
            die($e->getMessage());
        }
        $produtos = $data->fetch_object();

        $GrupoProdutosController = new GrupoProdutosController();
        $GrupoProdutosModel = new GrupoProdutosModel();
        $GrupoProdutosModel = $GrupoProdutosController->loadByID($produtos->codTbGrupo);
        //ta dando ERRO

        
        $ProdutosModel->setId($produtos->codigo_produto);
        $ProdutosModel->setCodigoGrupo($GrupoProdutosModel->getId());
        $ProdutosModel->setDescricao($produtos->descricao);
        $ProdutosModel->setUnidade($produtos->unidade);

        return $ProdutosModel;
    }

}