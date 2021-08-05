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

interface RefreshTokenInterface
{
    /**
     * @return AccessTokenInterface|null
     */
    public function getAccessToken(): ?AccessTokenInterface;

    /**
     * @param AccessTokenInterface|null $accessToken
     */
    public function setAccessToken(?AccessTokenInterface $accessToken): void;

    /**
     * @return bool
     */
    public function isRevoked(): bool;

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

    public function revoke(): void;
}
