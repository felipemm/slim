<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Firebase\JWT\JWT;
use \App\Model\User;
// Routes

$app->get('/', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});

$app->get('/books',         '\App\Controller\BooksController:index');
$app->get('/books/get/all', '\App\Controller\BooksController:getAll');
$app->get('/books/get/{id}','\App\Controller\BooksController:get');
$app->post('/books/add',    '\App\Controller\BooksController:add');
$app->put('/books/{id}',    '\App\Controller\BooksController:change');
$app->delete('/books/{id}', '\App\Controller\BooksController:remove');


$app->post('/invoice/upload',    '\App\Controller\InvoiceController:uploadFile');

// $app->get('/auth','\App\Controller\UsersController:authenticate');
$app->get('/auth','\App\Controller\SessionsController:authenticate');
$app->get('/logout/{username}','\App\Controller\UsersController:killSession');




$app->get('/users/get/{id}','\App\Controller\UsersController:get');
$app->post('/users/genkeys','\App\Controller\UsersController:genKeys');
$app->post('/users/newpasswd','\App\Controller\UsersController:updateUserPassword');


$app->get('/orders',         '\App\Controller\OrderController:index');
$app->get('/orders/get/all', '\App\Controller\OrderController:getAll');
$app->get('/orders/get/{id}','\App\Controller\OrderController:get');
$app->post('/orders/new',    '\App\Controller\OrderController:add');
$app->put('/orders/{id}',    '\App\Controller\OrderController:change');
$app->delete('/orders/{id}', '\App\Controller\OrderController:remove');
