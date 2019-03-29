<?php
namespace core\mvc;

use core\dao\IDao;
use core\mvc\view\Message;


abstract class Controller
{

    protected $view;
    protected $viewList;
    protected $dao;
    protected $get;
    protected $post;

    public function __construct()
    {
        /**
         * Get the send data and store it in local variables.
         * $_POST and $_GET are server variables used to store
         * temporarily client data.  
         */
        $this->post = $_POST;
        $this->get = $_GET;
    }

    public function run()
    {
        //..gets the value of command variable of post
        $command = strtolower($this->post['command']);
        //..verify the value and invoke the correct method
        switch ($command) {
            case 'salvar':
                $this->insertUpdate();
                break;
            case 'excluir':
                $this->delete();
                break;
            case 'novo':
                $this->showView();
                break;
            default:
                break;
        }
    }

    /**
     * This method must be implement in inherited classes.
     * Its function is return a model object from data view.
     */
    public abstract function getModelFromView();

    /**
     * This method gets the data from view, instantiates a model
     * object and persists it in database.  
     */
    public function insertUpdate()
    {
        try {
            //..if the 'id' post variable is null, then it is an insertion
            if ($this->post['id'] == null)
                $this->dao->insert($this->getModelFromView());
            else //..else, it is an updating
                $this->dao->update($this->getModelFromView());
            (new Message())->show(); //..show a message to user
        } catch (\Exception $ex) {
            (new Message(null, "Erro: {$ex->getMessage()}."))->show();
        }
    }

    /**
     * This method gets the 'id' post variable and invokes the
     * delete method from DAO object. 
     */
    public function delete()
    {
        try {
            //..if the post 'id' variable is not null, then get the variable and invokes the delete method of DAO object.
            if (!is_null($this->post['id'])) {
                $id = (int)$this->post['id'];
                $this->dao->delete($id);
                (new Message())->show(); //..show a message to user
            }
        } catch (\Exception $ex) {
            (new Message(null, "Erro: {$ex->getMessage()}."))->show();
        }
    }

    /**
     * There are two situations to show a view:
     * a) An 'empty' view to user input data to store or update an object
     * b) A 'full' view that shows stored data retrieved from database.
     */
    public function showView()
    {
        //..if the id 'get' variable is not set, then show an empty view.
        if (!isset($this->get['id']))
            $this->view->show();
        else //..else, try to retrieve a stored object, set the model and show the view with data.
            try {
                $id = (int)$this->get['id'];
                $model = $this->dao->findById($id);
                if ($model) {
                    $this->view->setModel($model);
                    $this->view->show();
                } else (new Message(null, "Objeto não encontrado!"))->show();
            } catch (\Exception $ex) {
                (new Message(null, "Erro: {$ex->getMessage()}."))->show();
            }
    }
}
