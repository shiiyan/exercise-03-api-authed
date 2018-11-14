<?php

use Phalcon\Acl;
use Phalcon\Acl\Role;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Resource;
use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Mvc\Dispatcher;

class SecurityPlugin extends Plugin
{
	public function getAcl()
	{
		$acl = new AclList();

		$acl->setDefaultAction(
			Acl::DENY
		);

		$roles = [
			'users'  => new Role('Users'),
			'guests' => new Role('Guests')
		];

		foreach ($roles as $role) {
			$acl->addRole($role);
		}

		$privateResources = [
			'profile' => ['index']
		];

		foreach ($privateResources as $resourceName => $actions) {
			$acl->addResource(
				new Resource($resourceName),
				$actions
			);
		}

		$publicResources = [
			'index'    => ['index', 'noaccess'],
			'login'    => ['index'],
			'callback' => ['index', 'register'],
			'api'	   => ['getall', 'getbyname', 'getbyid', 'add', 'updatebyid', 'deletebyid'],
		];

		foreach ($publicResources as $resourceName => $actions) {
			$acl->addResource(
				new Resource($resourceName),
				$actions
			);
		}

		foreach ($roles as $role) {
			foreach ($publicResources as $resource => $actions) {
				$acl->allow(
					$role->getName(),
					$resource,
					'*'
				);
			}
		}

		foreach ($privateResources as $resource => $actions) {
			foreach ($actions as $action) {
				$acl->allow(
					'Users',
					$resource,
					$action
				);
			}
		}

		return $acl;
	}


	public function beforeExecuteRoute (Event $event, Dispatcher $dispatcher) 
	{
		$auth = $this->session->get('auth');

		if(!$auth){
			$role = 'Guests';
		} else {
			$role = 'Users';
		}

		$controller = $dispatcher->getControllerName();
		$action 	= $dispatcher->getActionName();

		// var_dump($controller);
		// var_dump($action);

		$acl = $this->getAcl();

		$allowed = $acl->isAllowed($role, $controller, $action);

		
		if (!$allowed) {

			/*
			$this->flash->error(
				"You don't have access to this module"
			);
			*/

			$dispatcher->forward(
				[
					'controller' => 'index',
					'action'	 => 'noaccess'
				]
			);

			return false;
		}
		
	}

}

