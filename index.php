<?php

use app\model\ClientModel;
use app\view\client\ClientView;
use app\dao\ClientDao;
use app\controller\ClientCtr;

require_once('autoload.php');



if(!$_POST)
    (new ClientView())->show();
else
    (new ClientCtr())->run();


