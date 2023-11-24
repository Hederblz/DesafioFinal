<?php


class DesperdicioProdutoModel{

    private $id;
    private $codProducao;
    private $codProduto;
    private $qtde_saida;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setCodigoProducao($codProducao)
    {
        $this->codProducao = $codProducao;
    }

    public function getCodigoProducao()
    {
        return $this->codProducao;
    }

    public function setCodigoProduto($codProduto)
    {
        $this->codProduto = $codProduto;
    }

    public function getCodigoProduto()
    {
        return $this->codProduto;
    }

    public function setQtdeSaida($qtde_saida)
    {
        $this->qtde_saida = $qtde_saida;
    }

    public function getQtdeSaida()
    {
        return $this->qtde_saida;
    }
}