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
use EOffice\Packages\Passport\Contracts\UserManagerInterface;
use Laravel\Passport\Bridge\AccessToken;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
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

    public function getNewToken(ClientEntityInterface $clientEntity, array $scopes, $userIdentifier = null)
    {
        return new AccessToken($userIdentifier, $scopes, $clientEntity);
    }

    public function persistNewAccessToken(AccessTokenEntityInterface $accessTokenEntity)
    {
        $accessTokenManager = $this->accessTokenManager;

        if (null !== $accessTokenManager->findById($accessTokenEntity->getIdentifier())) {
            throw UniqueTokenIdentifierConstraintViolationException::create();
        }

        $accessToken = $this->buildAccessToken($accessTokenEntity);
        $accessTokenManager->save($accessToken);
    }

    public function revokeAccessToken($tokenId)
    {
        $accessTokenManager = $this->accessTokenManager;
        $accessToken        = $accessTokenManager->findById($tokenId);

        if (null !== $accessToken) {
            $accessToken->revoke();
            $accessTokenManager->save($accessToken);
        }
    }

    public function isAccessTokenRevoked($tokenId): bool
    {
        $accessToken = $this->accessTokenManager->findById($tokenId);

        if (null === $accessToken) {
            return true;
        }

        return $accessToken->isRevoked();
    }

    private function buildAccessToken(AccessTokenEntityInterface $accessTokenEntity): AccessTokenInterface
    {
        $client = $this->clientManager->findById($accessTokenEntity->getClient()->getIdentifier());
        $user   = $this->userManager->findById($accessTokenEntity->getUserIdentifier());

        return $this->accessTokenManager->create(
            $accessTokenEntity->getIdentifier(),
            $accessTokenEntity->getExpiryDateTime(),
            $client,
            $user,
            $this->scopeConverter->toDomainArray($accessTokenEntity->getScopes())
        );
    }
}
