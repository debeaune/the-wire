<?php

require_once __DIR__ . '/src/classes/Router.php';
require_once __DIR__ . '/src/controllers/ArticleController.php';
require_once __DIR__ . '/src/controllers/CommentController.php';
require_once __DIR__ . '/src/controllers/MessageController.php';

$router = new Router();

// Routes GET
$router->get('/', function() {
    $controller = new ArticleController();
    $controller->index();
});

$router->get('/article/{id}', function($id) {
    $controller = new ArticleController();
    $controller->show((int) $id);
});

$router->get('/salon', function() {
    $controller = new MessageController();
    $controller->index();
});

// Routes POST
$router->post('/comments/store', function() {
    $controller = new CommentController();
    $controller->store();
});

$router->post('/messages/store', function() {
    $controller = new MessageController();
    $controller->store();
});

// Dispatch
$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
$router->dispatch($method, $uri);