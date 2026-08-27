<?php
session_start();

require_once __DIR__ . '/src/classes/Router.php';
require_once __DIR__ . '/src/controllers/ArticleController.php';
require_once __DIR__ . '/src/controllers/CommentController.php';
require_once __DIR__ . '/src/controllers/MessageController.php';

$router = new Router();

$articleController = new ArticleController();
$commentController = new CommentController();
$messageController = new MessageController();

// Routes GET
$router->get('/', function() use ($articleController) {
    $articleController->index();
});

$router->get('/article/{id}', function($id) use ($articleController) {
    $articleController->show((int) $id);
});

$router->get('/salon', function() use ($messageController) {
    $messageController->index();
});

$router->get('/salon/stream', function() {    // ← ici
    require_once __DIR__ . '/src/api/ChatStream.php';
});

// Routes POST
$router->post('/article/store', function() use ($articleController) {
    $articleController->store();
});

$router->post('/comments/store', function() use ($commentController) {
    $commentController->store();
});

$router->post('/messages/store', function() use ($messageController) {
    $messageController->store();
});

// Dispatch
$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
$router->dispatch($method, $uri);