<?php
use Phalcon\Mvc\Router;


$router = new Router();

$router->add(
    '/',
    [
        'controller' => 'index',
        'action'     => 'index'
    ]
);

$router->add(
    '/login',
    [
        'controller' => 'login',
        'action'     => 'index'
    ]
);

$router->add(
	'/callback',
	[
		'controller' => 'callback',
		'action'     => 'index'
	]
);

$router->add(
    '/profile/{name}',
    [
        'controller' => 'profile',
        'action'     => 'index',
    ]
);

$router->add(
    '/logout',
    [
        'controller' => 'callback',
        'action'     => 'endsession'
    ]

);





