<?php

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Router;
use Phalcon\Mvc\Application;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Url as UrlProvider;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Session\Adapter\Files as Session;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Db\Adapter\Pdo\Mysql as PdoMysql;

// Define some absolute path constants to aid in locating resources
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

// Register an autoloader
$loader = new Loader();

$loader->registerDirs(
    [
        APP_PATH . '/controllers/',
        APP_PATH . '/models/',
        APP_PATH . '/plugins/',
    ]
);

$loader->register();

// Create a DI
$di = new FactoryDefault();

// Setup the view component
$di->set(
    'view',
    function () {
        $view = new View();
        $view->setViewsDir(APP_PATH.'/views/');
        $view->registerEngines([
            '.volt' => function ($view) {
                $volt = new VoltEngine($view, $this);
                $volt->setOptions([
                    'compiledPath' => BASE_PATH . '/cache/volt/',
                ]);
                $compiler = $volt->getCompiler();
                $compiler->addFunction('e', 'htmlentities');
                return $volt;
            }
        ]);

        return $view;
    }
);

$di->set(
    'url',
    function () {
        $url = new UrlProvider();
        $url->setBaseUri('/exercise-03-api-authed');
        return $url;
    }
);

$di->set(
    'router',
    function () {
        require APP_PATH.'/config/routes.php';
        return $router;
    }

);

$di->set(
    'session',
    function () {
        $session = new Session();
        $session->start();
        return $session;
    }
);

$di->set(
    'dispatcher',
    function () {
        $eventsManager = new EventsManager();
        $eventsManager->attach(
            'dispatch:beforeExecuteRoute',
            new SecurityPlugin()
        );

        $dispatcher = new Dispatcher();
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    }
);

$di->set(
    'db',
    function () {
        require APP_PATH.'/config/config.php';
        return $Pdo;
    
    }
);


$application = new Application($di);

try {
    // Handle the request
    $response = $application->handle();

    $response->send();
} catch (\Exception $e) {
    echo 'Exception: ', $e->getMessage();
}