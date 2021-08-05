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

namespace EOffice\Packages\Passport\Bridge;

use EOffice\Packages\Passport\Contracts\AuthCodeInterface;
use EOffice\Packages\Passport\Contracts\AuthCodeManagerInterface;
use EOffice\Packages\Passport\Contracts\ClientManagerInterface;
use EOffice\Packages\Passport\Contracts\ScopeConverterInterface;
use EOffice\Packages\Passport\Exception\PassportException;
use EOffice\Packages\User\Contracts\UserManagerInterface;
use EOffice\Packages\User\Exception\UserException;
use Laravel\Passport\Bridge\AuthCode;
use League\OAuth2\Server\Entities\AuthCodeEntityInterface;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface;

class AuthCodeRepository implements AuthCodeRepositoryInterface
{
    private AuthCodeManagerInterface $authCodeManager;
    private ClientManagerInterface $clientManager;
    private ScopeConverterInterface $scopeConverter;
    private UserManagerInterface $userManager;

    public function __construct(
        AuthCodeManagerInterface $authCodeManager,
        ClientManagerInterface $clientManager,
        ScopeConverterInterface $scopeConverter,
        UserManagerInterface $userManager
    ) {
        $this->authCodeManager = $authCodeManager;
        $this->clientManager   = $clientManager;
        $this->scopeConverter  = $scopeConverter;
        $this->userManager     = $userManager;
    }

    public function getNewAuthCode(): AuthCodeEntityInterface
    {
        return new AuthCode();
    }

    /**
     * @psalm-suppress MissingReturnType
     */
    public function persistNewAuthCode(AuthCodeEntityInterface $authCodeEntity): void
    {
        if (null !== $this->authCodeManager->find($authCodeEntity->getIdentifier())) {
            throw UniqueTokenIdentifierConstraintViolationException::create();
        }

        $authCode = $this->buildAuthCode($authCodeEntity);
        $this->authCodeManager->save($authCode);
    }

    public function revokeAuthCode($codeId): void
    {
        $authCodeManager = $this->authCodeManager;
        $authCode        = $authCodeManager->find($codeId);

        if (null !== $authCode) {
            $authCode->revoke();
            $authCodeManager->save($authCode);
        }
    }

    public function isAuthCodeRevoked($codeId): bool
    {
        $authCodeManager = $this->authCodeManager;
        $authCode        = $authCodeManager->find($codeId);

        if (null === $authCode) {
            return true;
        }

        return $authCode->isRevoked();
    }

    /**
     * @param AuthCodeEntityInterface $authCode
     *
     * @throws PassportException on invalid client id
     * @throws UserException     on invalid user id
     *
     * @return AuthCodeInterface
     */
    private function buildAuthCode(AuthCodeEntityInterface $authCode): AuthCodeInterface
    {
        $client = $this->clientManager->find($authCode->getClient()->getIdentifier());
        $user   = $this->userManager->find($authCode->getUserIdentifier());

        if (null === $user) {
            throw UserException::userNotFound($authCode->getUserIdentifier());
        }

        if (null === $client) {
            throw PassportException::clientNotFound($authCode->getClient()->getIdentifier());
        }

        return $this->authCodeManager->create(
            $authCode->getIdentifier(),
            $authCode->getExpiryDateTime(),
            $client,
            $user,
            $this->scopeConverter->toDomainArray($authCode->getScopes())
        );
    }
}
