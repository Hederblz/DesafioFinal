<?php


class ProdutosModel{

    private $id;
    private $codigo_grupo;
    private $descricao;
    private $unidade;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setCodigoGrupo($codigo_grupo)
    {
        $this->codigo_grupo = $codigo_grupo;
    }

    public function getCodigoGrupo()
    {
        return $this->codigo_grupo;
    }

    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function setUnidade($unidade)
    {
        $this->unidade = $unidade;
    }

    public function getUnidade()
    {
        return $this->unidade;
    }

}