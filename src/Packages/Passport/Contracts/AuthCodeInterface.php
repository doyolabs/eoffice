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

namespace EOffice\Packages\Passport\Contracts;

use Doctrine\ORM\Mapping as ORM;
use EOffice\Packages\User\Contracts\UserInterface;

interface AuthCodeInterface
{
    public function getUser(): UserInterface;

    public function setUser(UserInterface $user): void;

    public function getClient(): ClientInterface;

    public function setClient(ClientInterface $client): void;

    /**
     * @return string|null
     */
    public function getScopes(): ?string;

    /**
     * @param string|null $scopes
     */
    public function setScopes(?string $scopes): void;

    /**
     * @return bool
     */
    public function isRevoked(): bool;

    public function revoke(): void;

    /**
     * @param bool $revoked
     */
    public function setRevoked(bool $revoked): void;

    /**
     * @return \DateTimeInterface|null
     */
    public function getExpiresAt(): ?\DateTimeInterface;

    /**
     * @param \DateTimeInterface|null $expiresAt
     */
    public function setExpiresAt(?\DateTimeInterface $expiresAt): void;
}
