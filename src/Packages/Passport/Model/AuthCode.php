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

namespace EOffice\Packages\Passport\Model;

use Doctrine\ORM\Mapping as ORM;
use EOffice\Packages\User\Contracts\UserInterface;
use EOffice\Packages\Passport\Contracts\AuthCodeInterface;
use EOffice\Packages\Passport\Contracts\ClientInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="oauth_auth_codes")
 */
class AuthCode implements AuthCodeInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="string")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected ?string $id = null;

    /**
     * @ORM\ManyToOne(targetEntity="EOffice\Packages\User\Contracts\UserInterface")
     */
    protected UserInterface $user;

    /**
     * @ORM\ManyToOne(targetEntity="EOffice\Packages\Passport\Contracts\ClientInterface")
     */
    protected ClientInterface $client;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected ?string $scopes = null;

    /**
     * @ORM\Column(type="boolean")
     */
    protected bool $revoked = false;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected ?\DateTimeInterface $expiresAt = null;

    /**
     * @param UserInterface   $user
     * @param ClientInterface $client
     */
    public function __construct(UserInterface $user, ClientInterface $client)
    {
        $this->user   = $user;
        $this->client = $client;
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    public function getUser(): UserInterface
    {
        return $this->user;
    }

    public function setUser(UserInterface $user): void
    {
        $this->user = $user;
    }

    public function getClient(): ClientInterface
    {
        return $this->client;
    }

    public function setClient(ClientInterface $client): void
    {
        $this->client = $client;
    }

    /**
     * @return string|null
     */
    public function getScopes(): ?string
    {
        return $this->scopes;
    }

    /**
     * @param string|null $scopes
     */
    public function setScopes(?string $scopes): void
    {
        $this->scopes = $scopes;
    }

    /**
     * @return bool
     */
    public function isRevoked(): bool
    {
        return $this->revoked;
    }

    public function revoke(): void
    {
        $this->revoked = true;
    }

    /**
     * @param bool $revoked
     */
    public function setRevoked(bool $revoked): void
    {
        $this->revoked = $revoked;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getExpiresAt(): ?\DateTimeInterface
    {
        return $this->expiresAt;
    }

    /**
     * @param \DateTimeInterface|null $expiresAt
     */
    public function setExpiresAt(?\DateTimeInterface $expiresAt): void
    {
        $this->expiresAt = $expiresAt;
    }
}
