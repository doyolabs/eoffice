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

use EOffice\Packages\Passport\Contracts\AccessTokenInterface;
use EOffice\Packages\Passport\Contracts\AccessTokenManagerInterface;
use EOffice\Packages\Passport\Contracts\ClientManagerInterface;
use EOffice\Packages\Passport\Contracts\ScopeConverterInterface;
use EOffice\Packages\Passport\Exception\PassportException;
use EOffice\Packages\User\Contracts\UserManagerInterface;
use EOffice\Packages\User\Exception\UserException;
use Laravel\Passport\Bridge\AccessToken;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;

class AccessTokenRepository implements AccessTokenRepositoryInterface
{
    private AccessTokenManagerInterface $accessTokenManager;
    private ClientManagerInterface $clientManager;
    private ScopeConverterInterface $scopeConverter;
    private UserManagerInterface $userManager;

    public function __construct(
        AccessTokenManagerInterface $accessTokenManager,
        ClientManagerInterface $clientManager,
        ScopeConverterInterface $scopeConverter,
        UserManagerInterface $userManager
    ) {
        $this->accessTokenManager = $accessTokenManager;
        $this->clientManager      = $clientManager;
        $this->scopeConverter     = $scopeConverter;
        $this->userManager        = $userManager;
    }

    /**
     * @param ClientEntityInterface        $clientEntity
     * @param array|ScopeEntityInterface[] $scopes
     * @param mixed              $userIdentifier
     * @psalm-param array<array-key, ScopeEntityInterface> $scopes
     *
     * @return AccessTokenEntityInterface
     */
    public function getNewToken(ClientEntityInterface $clientEntity, $scopes, $userIdentifier = null): AccessTokenEntityInterface
    {
        return new AccessToken((string) $userIdentifier, $scopes, $clientEntity);
    }

    public function persistNewAccessToken(AccessTokenEntityInterface $accessTokenEntity): void
    {
        $accessTokenManager = $this->accessTokenManager;

        if (null !== $accessTokenManager->find($accessTokenEntity->getIdentifier())) {
            throw UniqueTokenIdentifierConstraintViolationException::create();
        }

        $accessToken = $this->buildAccessToken($accessTokenEntity);
        $accessTokenManager->save($accessToken);
    }

    public function revokeAccessToken($tokenId): void
    {
        $accessTokenManager = $this->accessTokenManager;
        $accessToken        = $accessTokenManager->find($tokenId);

        if (null !== $accessToken) {
            $accessToken->revoke();
            $accessTokenManager->save($accessToken);
        }
    }

    public function isAccessTokenRevoked($tokenId): bool
    {
        $accessToken = $this->accessTokenManager->find($tokenId);

        if (null === $accessToken) {
            return true;
        }

        return $accessToken->isRevoked();
    }

    /**
     * @param AccessTokenEntityInterface $accessTokenEntity
     *
     * @throws PassportException
     * @throws UserException
     *
     * @return AccessTokenInterface
     */
    private function buildAccessToken(AccessTokenEntityInterface $accessTokenEntity): AccessTokenInterface
    {
        $client = $this->clientManager->find($clientId = $accessTokenEntity->getClient()->getIdentifier());
        $user   = $this->userManager->find($userId = $accessTokenEntity->getUserIdentifier());

        if (null === $client) {
            throw PassportException::clientNotFound($clientId);
        }
        if (null === $user) {
            throw UserException::userNotFound($userId);
        }

        return $this->accessTokenManager->create(
            $accessTokenEntity->getIdentifier(),
            $accessTokenEntity->getExpiryDateTime(),
            $client,
            $user,
            $this->scopeConverter->toDomainArray($accessTokenEntity->getScopes())
        );
    }
}
