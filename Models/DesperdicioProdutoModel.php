<?php


class DesperdicioProdutoModel{

    private $sequencia;
    private $id;
    private $codigo_produto;
    private $qtde_saida;

    public function setSequencia($sequencia)
    {
        $this->sequencia = $sequencia;
    }

    public function getSequencia()
    {
        return $this->sequencia;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setCodigoProduto($codigo_produto)
    {
        $this->codigo_produto = $codigo_produto;
    }

    public function getCodigoProduto()
    {
        return $this->codigo_produto;
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