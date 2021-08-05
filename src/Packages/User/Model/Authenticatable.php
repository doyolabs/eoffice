<?php

/*
 * This file is part of the EOffice project.
 *
 * (c) Anthonius Munthi <https://itstoni.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace EOffice\Packages\User\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @psalm-suppress PossiblyNullPropertyAssignmentValue
 */
trait Authenticatable
{
    /**
     * @ORM\Column(name="remember_token", type="string", nullable=true)
     */
    protected ?string $rememberToken = null;

    public function getAuthIdentifierName(): string
    {
        return 'id';
    }

    public function getAuthIdentifier(): ?string
    {
        return $this->getId();
    }

    /**
     * @return string|null
     * @psalm-suppress ImplementedReturnTypeMismatch
     */
    public function getAuthPassword(): ?string
    {
        return $this->getPassword();
    }

    /**
     * @return string
     */
    public function getRememberToken()
    {
        return $this->rememberToken;
    }

    /**
     * @param string $token
     */
    public function setRememberToken($token): void
    {
        $this->rememberToken = $token;
    }

    public function getRememberTokenName(): string
    {
        return 'rememberToken';
    }
}
