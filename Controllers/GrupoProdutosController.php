<?php

class GrupoProdutosController extends Banco{
    
    public function loadById($id){
        $sql_query = "SELECT * FROM `grupo_produtos` WHERE `grupo_produtos`.`codigo_grupo` = $id;";
        $GrupoProdutosModel = new GrupoProdutosModel();
        $link = $this->conecta_mysql();

        try {
            $data = mysqli_query($link, $sql_query);
        } catch (mysqli_sql_exception $e) {
            die($e->getMessage());
        }
        $grupo = $data->fetch_object();
        
        $GrupoProdutosModel->setId($grupo->codigo_grupo);
        $GrupoProdutosModel->setDescricao($grupo->descricao);

        return $GrupoProdutosModel;
    }

}