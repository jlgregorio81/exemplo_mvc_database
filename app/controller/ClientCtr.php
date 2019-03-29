<?php
namespace app\controller;

use app\model\ClientModel;
use app\view\client\ClientView;
use core\mvc\Controller;
use app\dao\ClientDao;


final class ClientCtr extends Controller
{

    public function __construct()
    {
        parent::__construct();        
        $this->dao = new ClientDao();
        $this->view = new ClientView();
    }

    public function getModelFromView()
    {
        if (isset($this->post) && !empty($this->post)) {
            $id = (int)$this->post['id'];
            $name = ltrim($this->post['name']);
            $name = rtrim($name);
            $birth = $this->post['birthDate'];
            $gender = substr($this->post['gender'], 0, 1);            
            return new ClientModel($id, $name, $birth, $gender);
        }
    }
   
 
}




