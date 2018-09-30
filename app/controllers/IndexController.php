<?php

use Phalcon\Mvc\Controller;
use Phalcon\Http\Response;

class IndexController extends Controller
{
    public function indexAction()
    {
         $this->view->title = 'Homepage';
    }


    public function noaccessAction()
    {
    	$this->view->title = 'Error';
    }

}
