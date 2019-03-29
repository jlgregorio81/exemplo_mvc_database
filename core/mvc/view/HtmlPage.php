<?php
namespace core\mvc\view;

abstract class HtmlPage{
    protected $model;
    protected $htmlFile;

    public function __construct($model = null)
    {
        $this->model = $model;
    }

    public function renderHeader(){
        require_once('core\mvc\view\header.phtml');
    }

    public function renderFooter(){
        require_once('core\mvc\view\footer.phtml');
    }

    public function show(){
        $this->renderHeader();
        require_once($this->htmlFile);
        $this->renderFooter();
    }


    /**
     * Get the value of model
     */ 
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set the value of model
     *
     * @return  self
     */ 
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }
}