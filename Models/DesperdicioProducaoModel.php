<?php


class DesperdicioProducaoModel{

    private $id;
    private $nome_pessoa;
    private $data_saida;
    private $numero_producao;
    private $finalizada;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setNomePessoa($nome_pessoa)
    {
        $this->nome_pessoa = $nome_pessoa;
    }

    public function getNomePessoa()
    {
        return $this->nome_pessoa;
    }

    public function setDataSaida($data_saida)
    {
        $this->data_saida = $data_saida;
    }

    public function getDataSaida()
    {
        return $this->data_saida;
    }

    public function setNumeroProducao($numero_producao)
    {
        $this->numero_producao = $numero_producao;
    }

    public function getNumeroProducao()
    {
        return $this->numero_producao;
    }

    public function setFinalizada($finalizada)
    {
        $this->finalizada = $finalizada;
    }

    public function getFinalizada()
    {
        return $this->finalizada;
    }
}