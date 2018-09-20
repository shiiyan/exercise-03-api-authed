<?php

use Phalcon\Mvc\Controller;
use Phalcon\Http\Response;

class ProfileController extends Controller
{
    public function indexAction()
    {
         $user = Users::findFirst([
			[
				'conditions' => 'id = ?1',
				'bind' => [1 => $this->session->get('auth')['id']],
			]

		 ]);

         $name = $this->dispatcher->getParam('name');
         if ($user->name !== $name) {
         	return $this->response->setStatusCode(404, 'Not Found');
         }
         
         $this->view->user = $user;
    }


}
