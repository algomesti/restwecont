<?php

namespace src;

use Tuupola\Middleware\JwtAuthentication;
use App\DAO\UserDAO;

function jwtAuth(): JwtAuthentication
{
    return new JwtAuthentication([
        'secret' => getenv('JWT_SECRET_KEY'),
        'attribute' => 'jwt'
    ]);
}

function jwtAuthValid($request, $response, $next)
{
    return function ($request, $response, $next) {
        $token = $request->getAttribute('jwt');
        $userDAO = new UserDAO;
        $user = $userDAO->view($token['sub']);
        if (empty($user)) {
            return $response->withStatus(401);
        }
        if ($user['situation'] != 'active') {
            return $response->withStatus(401);
        }

        if (empty($user['token'])) {
            return $response->withStatus(401);
        }
        $response = $next($request, $response);
        return $response;
    };
}
