<?php

class View
{
    private $contents;
    private $view;
    private $v_params;

    function __construct($view = null, $v_params = null)
    {
        if ($view != null)
            $this->setView($view);
        $this->v_params = $v_params;
    }


    public function setView($view)
    {
        if (file_exists($view))
            $this->view = $view;
        else {
            $menssagem = "Arquivo da View '$view' não existe";
            Application::redirect("ErroPage.php?menssagem=" . $menssagem);
            die();
        }
    }

    public function getView()
    {
        return $this->view;
    }

    public function setParams(array $v_params)
    {
        $this->v_params = $v_params;
    }

    public function getParams()
    {
        return $this->v_params;
    }

    public function getContents()
    {
        ob_start();
        if (isset($this->view))
            require_once $this->view;
        $this->contents = ob_get_contents();
        ob_end_clean();
        return $this->contents;
    }

    public function showContents()
    {
        echo $this->getContents();
        exit;
    }
}
