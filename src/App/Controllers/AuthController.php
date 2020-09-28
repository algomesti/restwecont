<?php

namespace App\Controllers;

use App\DAO\UserDAO;
use App\Models\UserModel;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Firebase\JWT\JWT;

final class AuthController extends Controller
{
    public function login(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();
        $email = $data['email'];
        $password = $data['password'];
        $userDAO = new UserDAO();
        $user = $userDAO->getUserByEmail($email);
        if (is_null($user)) {
            return $response->withStatus(401);
        }
        if (!password_verify($password, $user['password'])) {
            return $response->withStatus(401);
        }
        $userModel = new UserModel();
        $userModel
            ->setUserId($user['userId'])
            ->setName($user['name'])
            ->setEmail($user['email'])
            ->setToken()
            ->setRefreshToken()
        ;
        $this->responseArray = $userDAO->edit($user['userId'], $userModel);
        return $this->parseResponse($response);
    }

    public function refreshToken(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();
        $refreshToken = $data['refreshToken'];
        $refreshTokenDecoded = JWT::decode(
            $refreshToken,
            getenv('JWT_SECRET_KEY'),
            ['HS256']
        );
        $userDAO = new UserDAO();
        $refreshTokenExists = $userDAO->verifyRefreshToken($refreshToken);
        if (!$refreshTokenExists) {
            return $response->withStatus(401);
        }
        $userModel = new UserModel();
        $user = $userDAO->getUserByEmail($refreshTokenDecoded->email);
        if (is_null($user)) {
            return $response->withStatus(401);
        }
        $userModel->setUserId($user['userId']);
        $userModel->setEmail($user['email']);
        $userModel->setName($user['name']);
        $userModel->setToken();
        $userModel->setRefreshToken();
        $this->responseArray = $userDAO->edit((int)$this->getJwt($request)['sub'], $userModel);
        return $this->parseResponse($response);
    }
}
