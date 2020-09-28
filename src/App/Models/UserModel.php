<?php

namespace App\Models;

use Firebase\JWT\JWT;

final class UserModel
{
    private $userId;
    private $name;
    private $email;
    private $password;
    private $token;
    private $refreshToken;
    private $situation;
    private $created;
    private $updated;

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }

    public function getsituation(): string
    {
        return $this->situation;
    }

    public function getCreated(): string
    {
        return $this->created;
    }

    public function getUpdated(): string
    {
        return $this->updated;
    }


    public function setUserId(int $userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function setPassword(string $password): self
    {
        $this->password = password_hash($password, PASSWORD_ARGON2I);
        return $this;
    }

    public function setToken(): self
    {
        $expiredAt = (new \DateTime())->modify('+5 days');
        $tokenPayload = [
            'sub' => $this->getUserId(),
            'name' => $this->getName(),
            'email' => $this->getEmail(),
            'exp' => $expiredAt->getTimestamp()
        ];
        $this->token = JWT::encode($tokenPayload, getenv('JWT_SECRET_KEY'));
        return $this;
    }

    public function setRefreshToken(): self
    {
        $refreshTokenPayload = [
            'email' => $this->getEmail(),
            'ramdom' => uniqid()
        ];
        $this->refreshToken = JWT::encode($refreshTokenPayload, getenv('JWT_SECRET_KEY'));
        return $this;
    }

    public function setsituation(string $situation): self
    {
        $this->situation = $situation;
        return $this;
    }

    public function setCreated($created): self
    {
        $this->created = $created;
        return $this;
    }

    public function setUpdated($updated): self
    {
        $this->updated = $updated;
        return $this;
    }

    public function ToArray() : array
    {
        return [
            'userId' => $this->userId,
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'token' => $this->token,
            'refreshToken' => $this->refreshToken,
            'situation' => $this->situation,
            'created' => $this->created,
            'updated' => $this->updated,
        ];
    }
}
