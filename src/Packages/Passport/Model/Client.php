<?php

namespace EOffice\Packages\Passport\Model;

use Doctrine\ORM\Mapping as ORM;
use EOffice\Components\Resource\Contracts\TimestampableInterface;
use EOffice\Components\Resource\Model\TimestampableTrait;
use EOffice\Packages\Passport\Contracts\ClientInterface;
use EOffice\Packages\User\Contracts\UserInterface;
use League\OAuth2\Server\Grant\GrantTypeInterface;

/**
 * @ORM\Entity
 */
class Client implements TimestampableInterface, ClientInterface
{
    use TimestampableTrait;

    /**
     * @ORM\Column(type="string")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected ?string $id;

    /**
     * @ORM\ManyToOne(targetEntity="EOffice\Packages\User\Contracts\UserInterface")
     */
    protected UserInterface $user;

    /**
     * @ORM\Column(name="name", type="string")
     */
    protected ?string $name = null;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected ?string $secret = null;

    /**
     * @ORM\Column(nullable=true)
     */
    protected ?string $provider = null;

    /**
     * @ORM\Column(type="text")
     */
    protected ?string $redirect;

    /**
     * @ORM\Column(type="boolean")
     */
    protected bool $personalAccessClient;

    /**
     * @ORM\Column(type="boolean")
     */
    protected bool $passwordClient;

    /**
     * @ORM\Column(type="boolean")
     */
    protected bool $revoked;

    /**
     * @var array|GrantTypeInterface
     */
    protected array $grants;

    /**
     * @return array|GrantTypeInterface
     */
    public function getGrants(): array
    {
        return $this->grants;
    }

    public function firstParty(): bool
    {
        return $this->isPersonalAccessClient() || $this->isPasswordClient();
    }

    public function confidential(): bool
    {
        return !empty($this->secret);
    }


    /**
     * @return UserInterface
     */
    public function getUser(): UserInterface
    {
        return $this->user;
    }

    /**
     * @param UserInterface $user
     */
    public function setUser(UserInterface $user): void
    {
        $this->user = $user;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getSecret(): ?string
    {
        return $this->secret;
    }

    /**
     * @param string|null $secret
     */
    public function setSecret(?string $secret): void
    {
        $this->secret = $secret;
    }

    /**
     * @return string|null
     */
    public function getProvider(): ?string
    {
        return $this->provider;
    }

    /**
     * @param string|null $provider
     */
    public function setProvider(?string $provider): void
    {
        $this->provider = $provider;
    }

    /**
     * @return string|null
     */
    public function getRedirect(): ?string
    {
        return $this->redirect;
    }

    /**
     * @param string|null $redirect
     */
    public function setRedirect(?string $redirect): void
    {
        $this->redirect = $redirect;
    }

    /**
     * @return bool
     */
    public function isPersonalAccessClient(): bool
    {
        return $this->personalAccessClient;
    }

    /**
     * @param bool $personalAccessClient
     */
    public function setPersonalAccessClient(bool $personalAccessClient): void
    {
        $this->personalAccessClient = $personalAccessClient;
    }

    /**
     * @return bool
     */
    public function isPasswordClient(): bool
    {
        return $this->passwordClient;
    }

    /**
     * @param bool $passwordClient
     */
    public function setPasswordClient(bool $passwordClient): void
    {
        $this->passwordClient = $passwordClient;
    }

    /**
     * @return bool
     */
    public function isRevoked(): bool
    {
        return $this->revoked;
    }

    /**
     * @param bool $revoked
     */
    public function setRevoked(bool $revoked): void
    {
        $this->revoked = $revoked;
    }
}
