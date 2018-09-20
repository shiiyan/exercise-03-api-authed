<?php

use Phalcon\Mvc\Controller;
use Phalcon\Http\Response;

require __DIR__.'/../config/auth.php';

class LoginController extends Controller
{
    public function indexAction()
    {
         $this->view->clientID = CLIENT_ID;
    }

}
