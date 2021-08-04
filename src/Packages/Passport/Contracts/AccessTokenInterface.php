<?php

namespace EOffice\Packages\Passport\Contracts;


use EOffice\Packages\User\Contracts\UserInterface;

interface AccessTokenInterface
{
    /**
     * @return UserInterface|null
     */
    public function getUser(): ?UserInterface;

    /**
     * @param UserInterface|null $user
     */
    public function setUser(?UserInterface $user): void;

    /**
     * @return ClientInterface|null
     */
    public function getClient(): ?ClientInterface;

    /**
     * @param ClientInterface|null $client
     */
    public function setClient(?ClientInterface $client): void;

    /**
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void;

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

    /**
     * @return string|null
     */
    public function getId(): ?string;

    public function getCreatedAt(): ?\DateTimeInterface;

    public function setCreatedAt(?\DateTimeInterface $createdAt): void;

    public function getUpdatedAt(): ?\DateTimeInterface;

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): void;

    public function revoke(): void;
}
