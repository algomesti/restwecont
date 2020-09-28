<?php

namespace src;

use App\DAO\LojasDAO;
use Dotenv\Dotenv;

$dotenv = new Dotenv(__DIR__);
$dotenv->load();
$dotenv->required([
    'APPLICATION_ENV',
    'DISPLAY_ERRORS_DETAILS',
    'LOG_PATH',
    'LOG_LEVEL',
    'REDIS_HOST',
    'REDIS_PORT',
    'REDIS_TTL',
    'DB_HOST',
    'DB_PORT',
    'DB_USER',
    'DB_PASS',
    'DB_USER',
    'DB_PASS',
    'DB_DBAS',
])->notEmpty();

function slimConfiguration(): \Slim\Container
{
    $configuration = [
        'settings' => [
            'displayErrorDetails' => (bool) getenv('DISPLAY_ERRORS_DETAILS'),
        ],
    ];
    $container = new \Slim\Container($configuration);
    return $container;
}
