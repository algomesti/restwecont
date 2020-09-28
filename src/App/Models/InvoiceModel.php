<?php

namespace App\Models;

use Firebase\JWT\JWT;

final class InvoiceModel
{
    private $invoiceId;
    private $userId;
    private $status;
    private $expiration;
    private $url;
    private $situation;
    private $created;
    private $updated;

    public function getInvoiceId(): int
    {
        return $this->invoiceId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getExpiration(): string
    {
        return $this->expiration;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getSituation(): string
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

    public function setInvoiceId(int $invoiceId): self
    {
        $this->invoiceId = $invoiceId;
        return $this;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function setExpiration(string $expiration): self
    {
        $this->expiration = $expiration;
        return $this;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;
        return $this;
    }

    public function setSituation(string $situation): self
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
    public function toArray() : array
    {
        return [
            'invoiceId' => $this->invoiceId,
            'userId' => $this->userId,
            'status' => $this->status,
            'expiration' => $this->expiration,
            'url' => $this->url,
            'situation' => $this->situation,
            'created' => $this->created,
            'updated' => $this->updated,
        ];
    }
}
