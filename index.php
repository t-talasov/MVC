<?php

session_start();

define('UPLOAD_DIR', __DIR__. '/uploads');


require 'vendor/autoload.php';

if (! isset($_SESSION['auth']) && $_SERVER['REQUEST_URI'] !== '/login') {
    header('Location: /login');
    return;
}

$dispatcher = FastRoute\simpleDispatcher(function($r) {
    $r->addRoute('GET', '/', function(){
        $controller = new App\Controller\Main();
        $controller->run();
    });
    
    $r->addRoute(['GET', 'POST'], '/login', function(){
        $controller = new App\Controller\Login();
        $controller->run();
    });

    $r->addRoute(['GET', 'POST'], '/users', function(){
        $controller = new App\Controller\Users();
        $controller->run();
    });

    $r->addRoute(['GET', 'POST'], '/users/add', function(){
        $controller = new App\Controller\Users();
        $controller->runAdd();
    });

    $r->addRoute(['GET', 'POST'], '/users/edit', function(){
        $controller = new App\Controller\Users();
        $controller->runEdit();
    });


    $r->addRoute(['GET', 'POST'], '/tasks', function(){
        
        $controller = new App\Controller\Tasks();
        $controller->run();
    });
    $r->addRoute(['GET', 'POST'], '/tasks/add', function(){
        $controller = new App\Controller\Tasks();
        $controller->runAdd();
    });
    $r->addRoute(['GET', 'POST'], '/tasks/update', function(){
        $controller = new App\Controller\Tasks();
        $controller->runUpdate();
    });
    $r->addRoute(['GET', 'POST'], '/tasks/delete', function(){
        $controller = new App\Controller\Tasks();
        $controller->runDelete();
    });
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        echo 'Роут не создан';
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        echo 'Роут есть, а метода нет (GET или POST)';
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        $handler($vars);
        break;
}