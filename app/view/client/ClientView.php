<?php
namespace app\view\client;

use core\mvc\view\HtmlPage;
use app\model\ClientModel;

final class ClientView extends HtmlPage{

    public function __construct(ClientModel $model = null)
    {
        $this->model = is_null($model) ? new ClientModel() : $model;
        $this->htmlFile = 'app/view/client/client_view.phtml';
    }

    

}