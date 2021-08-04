<?php

namespace EOffice\Packages\Passport\Contracts;


use Doctrine\ORM\Mapping as ORM;
use EOffice\Packages\User\Contracts\UserInterface;

/**
 * @ORM\Entity
 */
interface ClientInterface
{
    /**
     * @return UserInterface
     */
    public function getUser(): UserInterface;

    /**
     * @param UserInterface $user
     */
    public function setUser(UserInterface $user): void;

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
    public function getSecret(): ?string;

    /**
     * @param string|null $secret
     */
    public function setSecret(?string $secret): void;

    /**
     * @return string|null
     */
    public function getProvider(): ?string;

    /**
     * @param string|null $provider
     */
    public function setProvider(?string $provider): void;

    /**
     * @return string|null
     */
    public function getRedirect(): ?string;

    /**
     * @param string|null $redirect
     */
    public function setRedirect(?string $redirect): void;

    /**
     * @return bool
     */
    public function isPersonalAccessClient(): bool;

    /**
     * @param bool $personalAccessClient
     */
    public function setPersonalAccessClient(bool $personalAccessClient): void;

    /**
     * @return bool
     */
    public function isPasswordClient(): bool;

    /**
     * @param bool $passwordClient
     */
    public function setPasswordClient(bool $passwordClient): void;

    /**
     * @return bool
     */
    public function isRevoked(): bool;

    /**
     * @param bool $revoked
     */
    public function setRevoked(bool $revoked): void;

    public function getGrants(): array;

    public function firstParty(): bool;

    public function confidential(): bool;
}
