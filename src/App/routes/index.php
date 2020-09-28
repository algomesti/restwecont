<?php

use function src\slimConfiguration;
use function src\jwtAuth;
use App\Controllers\AuthController;
use App\Controllers\UserController;
use App\Controllers\InvoiceController;

$app = new \Slim\App(slimConfiguration());

$app->get('/', function () {
    die('system up');
});

$app->post('/login', AuthController::class . ':login');
$app->post('/refreshToken', AuthController::class . ':refreshToken')->add(jwtAuth());

$app->group('/user', function () use ($app) {
    $app->get('/', UserController::class . ':list');
    $app->get('/{userId:[0-9]+}', UserController::class . ':view');
    $app->post('/', UserController::class . ':add');
    $app->put('/{userId:[0-9]+}', UserController::class . ':edit');
    $app->delete('/{userId:[0-9]+}', UserController::class . ':remove');
    $app->put('/{userId:[0-9]+}/reactive', UserController::class . ':unRemove');
})->add(jwtAuth());

$app->group('/invoice', function () use ($app) {
    $app->get('/', InvoiceController::class . ':list');
    $app->get('/{invoiceId:[0-9]+}', InvoiceController::class . ':view');
    $app->post('/', InvoiceController::class . ':add');
    $app->put('/{invoiceId:[0-9]+}', InvoiceController::class . ':edit');
    $app->delete('/{invoiceId:[0-9]+}', InvoiceController::class . ':remove');
    $app->put('/{invoiceId:[0-9]+}/reactive', InvoiceController::class . ':unRemove');
})->add(jwtAuth());

$app->run();
