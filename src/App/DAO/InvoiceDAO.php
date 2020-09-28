<?php

namespace App\DAO;

use App\Models\InvoiceModel;

class InvoiceDAO extends Conection
{
    protected $jwt;

    public function __construct()
    {
        parent::__construct();
    }

    public function view(int $userId, int $invoiceId): array
    {
        $query = 'SELECT invoiceId, userId, status, expiration, url, situation, created, updated FROM invoices WHERE userId=:userId AND invoiceId = :invoiceId;';
        $invoice = $this->pdo->prepare($query);
        $invoice->bindParam(':invoiceId', $invoiceId, \PDO::PARAM_INT);
        $invoice->bindParam(':userId', $userId, \PDO::PARAM_INT);
        $invoice->execute();
        return ($invoice->fetchAll(\PDO::FETCH_ASSOC))[0] ?? [];
    }

    public function list(int $userId, int $limit = 5, ?int $page): array
    {
        $query = "SELECT invoiceId, userId, status, expiration, situation, url, created, updated FROM invoices WHERE userId = :userId  Limit :limit  Offset :offset";
        $offset = 0;
        if (null !== $page) {
            $offset = ($limit * $page) - $limit;
        }
        $invoice = $this->pdo->prepare($query);
        $invoice->bindParam(':userId', $userId, \PDO::PARAM_INT);
        $invoice->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $invoice->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $invoice->execute();
        return $invoice->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function add(int $userId, invoiceModel $invoice): array
    {
        $sql = 'INSERT INTO invoices (userId, url, expiration) VALUES (:userId, :url, :expiration);';
        $data = [
            'userId' => $userId,
            'url' => $invoice->getUrl(),
            'expiration' => $invoice->getExpiration(),
        ];
        $statement = $this->pdo->prepare($sql);
        if (!$statement->execute($data)) {
            throw new \Exception('Error save database');
        }
        return $this->view($userId, $this->pdo->lastInsertId());
    }

    public function edit(int $userId, int $invoiceId, invoiceModel $invoice): array
    {
        $sql = 'UPDATE invoices set ';
        $fields = [];
        $values = ['invoiceId' => $invoiceId];
        $arrayUser = $invoice->toArray();
        foreach ($arrayUser as $key => $value) {
            if (!empty(trim($value))) {
                $fields[] = "$key = :$key";
                $values[$key] = $value;
            }
        }
        if (!empty($values)) {
            $sql_fields = implode(", ", $fields);
            $sql .= $sql_fields . ' WHERE userId=:userId AND invoiceId = :invoiceId; ';
        }
        $statement = $this->pdo->prepare($sql);

        $values['userId'] = $userId;

        if (!$statement->execute($values)) {
            throw new \Exception('Error save database');
        }
        return $this->view($userId, $invoiceId);
    }

    public function remove(int $userId, int $invoiceId): array
    {
        $sql = 'UPDATE invoices set situation = :situation where userId=:userId AND invoiceId = :invoiceId';
        $statement = $this->pdo->prepare($sql);
        $values = [
            'invoiceId' => $invoiceId,
            'situation' => 'removed',
            'userId' => $userId
        ];
        if (!$statement->execute($values)) {
            throw new \Exception('Error save database');
        }
        return $this->view($userId, $invoiceId);
    }

    public function unRemove(int $userId, int $invoiceId): array
    {
        $sql = 'UPDATE invoices set situation = :situation where userId=:userId AND invoiceId = :invoiceId';
        $statement = $this->pdo->prepare($sql);
        $values = [
            'invoiceId' => $invoiceId,
            'situation' => 'active',
            'userId' => $userId
        ];
        if (!$statement->execute($values)) {
            throw new \Exception('Error save database');
        }
        return $this->view($userId, $invoiceId);
    }
}
