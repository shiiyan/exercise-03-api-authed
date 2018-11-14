<?php
use Phalcon\Mvc\Router;


$router = new Router(false);

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

// api routes

$router->addGet(
    '/api/products',
    'api::getall'
);

$router->addGet(
    '/api/products/search/{name}',
    'api::getbyname'
);

$router->addGet(
    '/api/products/search/{id:[0-9]+}',
    'api::getbyid'
);

$router->addPost(
    '/api/products',
    'api::add'
);

$router->addPut(
    '/api/products/{id:[0-9]+}',
    'api::updatebyid'
);

$router->addDelete(
    '/api/products/{id:[0-9]+}',
    'api::deletebyid'
);




