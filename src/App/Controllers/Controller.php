<?php

namespace App\Controllers;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

class Controller
{
    protected $errors;
    protected $responseArray;

    public function __construct(Container $container)
    {
        $this->errors = [];
        $this->responseArray = [];
    }

    public function parseResponse(Response $response) : Response
    {
        if (!empty($this->errors)) {
            $response = $response->withJson([
                'errors' => $this->errors,
            ]);
            return $response->withStatus(400);
        }

        if (empty($this->responseArray)) {
            return $response->withStatus(401);
        }

        return $response
            ->withJson([
                'message' => 'success',
                'data' => $this->responseArray
            ])
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200)
        ;
    }

    protected function getJwt(Request $request) :array
    {
        return $request->getAttribute('jwt');
    }
}
