<?php

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

    public function revoke();
}
