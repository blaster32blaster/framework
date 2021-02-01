<?php

include_once 'request.php';
include_once 'router.php';
include_once 'controller.php';


$router = new Router(new Request);
$controller = new Controller();

$router->get('/', function() use ($controller) {
    return $controller->get();
});

$router->post('/', function($request) use ($controller)  {
    return $controller->post($request);
});
