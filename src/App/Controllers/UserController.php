<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\DAO\UserDAO;
use App\Models\UserModel;
use Slim\Container;

final class UserController extends Controller
{
    private $userDAO;

    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->userDAO = new UserDAO();
    }
    public function view(Request $request, Response $response, array $args): Response
    {
        $this->responseArray = $this->userDAO->view($args['userId'] ?? null);
        return $this->parseResponse($response);
    }

    public function list(Request $request, Response $response, array $args): Response
    {
        $data = $request->getQueryParams();
        $limit = $data['limit'] ?? 5;
        $page = $data['page'] ?? null;
        $this->responseArray = $this->userDAO->list($limit, $page);
        return $this->parseResponse($response);
    }

    public function add(Request $request, Response $response, array $args): Response
    {
        try {
            $required = ['name','email','password'];
            $data = $request->getParsedBody();

            foreach ($required as $field) {
                if (!isset($data[$field]) || trim($data[$field]) === '') {
                    $this->errors[] = "Field $field is required and can not to be empty";
                }
            }
            if (!empty($this->errors)) {
                return $this->parseResponse($response);
            }
            $userDAO = new UserDAO();
            $user = new UserModel();
            $user
                ->setName($data['name'] ?? null)
                ->setEmail($data['email'] ?? null)
                ->setPassword($data['password'] ?? null)
            ;
            $this->responseArray = $userDAO->add($user);
        } catch (\Exception $e) {
            $this->errors[] = $e->getMessage();
        }
        return $this->parseResponse($response);
    }

    public function edit(Request $request, Response $response, array $args): Response
    {
        try {
            $data = $request->getParsedBody();
            if (!empty($this->errors)) {
                return $this->parseResponse($response);
            }
            $userDAO = new UserDAO();
            $user = new UserModel();
            $user
                ->setName($data['name'] ?? '')
                ->setEmail($data['email'] ?? '')
                ->setPassword($data['password'] ?? '')
            ;
            $this->responseArray = $userDAO->edit((int) $args['userId'], $user);
        } catch (\Exception $e) {
            $this->errors[] = $e->getMessage();
        }
        return $this->parseResponse($response);
    }

    public function remove(Request $request, Response $response, array $args): Response
    {
        try {
            $userId = $args['userId'] ?? null;
            $userDAO = new UserDAO();
            $this->responseArray = $userDAO->remove($userId);
        } catch (\Exception $e) {
            $this->errors[] = $e->getMessage();
        }
        return $this->parseResponse($response);
    }

    public function unRemove(Request $request, Response $response, array $args): Response
    {
        try {
            $userId = $args['userId'] ?? null;
            $userDAO = new UserDAO();
            $this->responseArray = $userDAO->unRemove($userId);
        } catch (\Exception $e) {
            $this->errors[] = $e->getMessage();
        }
        return $this->parseResponse($response);
    }
}
