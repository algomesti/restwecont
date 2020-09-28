<?php

namespace App\DAO;

use App\Models\UserModel;

class UserDAO extends Conection
{
    public function __construct()
    {
        parent::__construct();
    }

    public function view(int $userId): array
    {
        $query = '
            SELECT userId, name, password, email, token, refreshToken, situation, created, updated
                FROM users
                WHERE userId = :userId;
        ';
        $user = $this->pdo->prepare($query);
        $user->bindParam(':userId', $userId, \PDO::PARAM_INT);
        $user->execute();
        return ($user->fetchAll(\PDO::FETCH_ASSOC))[0] ?? [];
    }

    public function list(int $limit = 5, ?int $page): array
    {
        $query = 'SELECT userId, name, password, email, token, refreshToken, situation, created, updated FROM users Limit ' .  $limit;
        if (null !== $page) {
            $offset = ($limit * $page) - $limit;
            $query .= " Offset $offset";
        }
        $user = $this->pdo->prepare($query);
        $user->execute();
        return $user->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function add(userModel $user): array
    {
        $sql = 'INSERT INTO users (name, email, password, situation) VALUES(:name, :email, :password, :situation);';
        $data = [
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'situation' => 'active'
        ];
        $statement = $this->pdo->prepare($sql);
        if (!$statement->execute($data)) {
            throw new \Exception('Error save database');
        }
        return $this->view($this->pdo->lastInsertId());
    }

    public function edit(int $userId, userModel $user): array
    {
        $sql = 'UPDATE users set ';
        $fields = [];
        $values = ['userId' => $userId];
        $arrayUser = $user->toArray();
        foreach ($arrayUser as $key => $value) {
            if (!empty(trim($value))) {
                $fields[] = "$key = :$key";
                $values[$key] = $value;
            }
        }
        if (!empty($values)) {
            $sql_fields = implode(", ", $fields);
            $sql .= $sql_fields . ' WHERE userId = :userId;';
        }
        $statement = $this->pdo->prepare($sql);
        if (!$statement->execute($values)) {
            throw new \Exception('Error save database');
        }
        return $this->view($userId);
    }

    public function remove(int $userId): array
    {
        $sql = 'UPDATE users set situation = :situation where userId = :userId';
        $statement = $this->pdo->prepare($sql);
        $values = [
            'userId' => $userId,
            'situation' => 'removed'
        ];
        if (!$statement->execute($values)) {
            throw new \Exception('Error save database');
        }
        return $this->view($userId);
    }

    public function unRemove(int $userId): array
    {
        $sql = 'UPDATE users set situation = :situation where userId = :userId';
        $statement = $this->pdo->prepare($sql);
        $values = [
            'userId' => $userId,
            'situation' => 'active'
        ];
        if (!$statement->execute($values)) {
            throw new \Exception('Error save database');
        }
        return $this->view($userId);
    }

    public function getUserByEmail(string $email): array
    {
        $query = 'SELECT userId, name, password, email, token, refreshToken, situation, created, updated FROM users WHERE email = :email;';
        $user = $this->pdo->prepare($query);
        $user->bindParam(':email', $email, \PDO::PARAM_STR);
        $user->execute();
        return ($user->fetchAll(\PDO::FETCH_ASSOC))[0] ?? [];
    }


    public function verifyRefreshToken(string $refreshToken): bool
    {
        $statement = $this->pdo->prepare('SELECT userId FROM users WHERE refreshToken = :refreshToken;');
        $statement->bindParam('refreshToken', $refreshToken);
        $statement->execute();
        $tokens = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return count($tokens) === 0 ? false : true;
    }
}
