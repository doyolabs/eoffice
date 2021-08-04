<?php

namespace EOffice\Packages\User\Model;

use Doctrine\ORM\Mapping as ORM;

trait Authenticatable
{
    /**
     * @ORM\Column(name="remember_token", type="string", nullable=true)
     */
    protected string $rememberToken;

    public function getAuthIdentifierName(): string
    {
        return 'id';
    }

    public function getAuthIdentifier(): ?string
    {
        return $this->getId();
    }

    public function getAuthPassword(): string
    {
        return $this->getPassword();
    }

    public function getRememberToken(): ?string
    {
        return $this->rememberToken;
    }

    public function setRememberToken($value): void
    {
        $this->rememberToken = $value;
    }

    public function getRememberTokenName()
    {
        return "rememberToken";
    }
}
