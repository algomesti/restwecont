<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\DAO\InvoiceDAO;
use App\Models\InvoiceModel;
use Slim\Container;

final class InvoiceController extends Controller
{
    private $invoiceDAO;
    private $jwt;



    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->invoiceDAO = new InvoiceDAO();
    }


    public function view(Request $request, Response $response, array $args): Response
    {
        $this->jwt = $request->getAttribute('jwt');
        $this->responseArray = $this->invoiceDAO->view($this->getJwt($request)['sub'], $args['invoiceId'] ?? null);
        return $this->parseResponse($response);
    }

    public function list(Request $request, Response $response, array $args): Response
    {
        $data = $request->getQueryParams();
        $limit = $data['limit'] ?? 5;
        $page = $data['page'] ?? null;
        $this->responseArray = $this->invoiceDAO->list($this->getJwt($request)['sub'], $limit, $page);
        return $this->parseResponse($response);
    }

    public function add(Request $request, Response $response, array $args): Response
    {
        try {
            $required = ['userId','expiration','url'];
            $data = $request->getParsedBody();
            foreach ($required as $field) {
                if (!isset($data[$field]) || trim($data[$field]) === '') {
                    $this->errors[] = "Field $field is required and can not to be empty";
                }
            }
            if (!empty($this->errors)) {
                return $this->parseResponse($response);
            }
            $invoiceDAO = new InvoiceDAO();
            $invoice = new InvoiceModel();
            $invoice
                ->setUserId((int)$this->getJwt($request)['sub'])
                ->setExpiration($data['expiration'] ?? null)
                ->setUrl($data['url'] ?? null)
            ;
            $this->responseArray = $invoiceDAO->add((int)$this->getJwt($request)['sub'], $invoice);
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
            $invoiceDAO = new InvoiceDAO();
            $invoice = new InvoiceModel();
            $invoice
                ->setExpiration($data['expiration'] ?? '')
                ->setStatus($data['status'] ?? '')
                ->setUrl($data['url'] ?? '')
            ;
            $this->responseArray = $invoiceDAO->edit((int)$this->getJwt($request)['sub'], (int) $args['invoiceId'], $invoice);
        } catch (\Exception $e) {
            $this->errors[] = $e->getMessage();
        }
        return $this->parseResponse($response);
    }

    public function remove(Request $request, Response $response, array $args): Response
    {
        try {
            $invoiceId = $args['invoiceId'] ?? null;

            $invoiceDAO = new InvoiceDAO();
            $this->responseArray = $invoiceDAO->remove((int)$this->getJwt($request)['sub'], $invoiceId);
        } catch (\Exception $e) {
            $this->errors[] = $e->getMessage();
        }
        return $this->parseResponse($response);
    }

    public function unRemove(Request $request, Response $response, array $args): Response
    {
        try {
            $invoiceId = $args['invoiceId'] ?? null;
            $invoiceDAO = new InvoiceDAO();
            $this->responseArray = $invoiceDAO->unRemove((int)$this->getJwt($request)['sub'], $invoiceId);
        } catch (\Exception $e) {
            $this->errors[] = $e->getMessage();
        }
        return $this->parseResponse($response);
    }
}
