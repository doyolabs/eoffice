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

use EOffice\Packages\Passport\Contracts\AccessTokenManagerInterface;
use EOffice\Packages\Passport\Contracts\RefreshTokenManagerInterface;
use Illuminate\Contracts\Events\Dispatcher;
use Laravel\Passport\Bridge\RefreshToken;
use Laravel\Passport\Events\RefreshTokenCreated;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;

/**
 * @covers \EOffice\Packages\Passport\Bridge\RefreshTokenRepository
 */
class RefreshTokenRepository implements RefreshTokenRepositoryInterface
{
    private RefreshTokenManagerInterface $refreshTokenManager;
    private AccessTokenManagerInterface $accessTokenManager;
    private Dispatcher $dispatcher;

    public function __construct(
        RefreshTokenManagerInterface $refreshTokenManager,
        AccessTokenManagerInterface $accessTokenManager,
        Dispatcher $dispatcher
    ) {
        $this->refreshTokenManager = $refreshTokenManager;
        $this->accessTokenManager  = $accessTokenManager;
        $this->dispatcher          = $dispatcher;
    }

    public function getNewRefreshToken(): RefreshTokenEntityInterface
    {
        return new RefreshToken();
    }

    public function persistNewRefreshToken(RefreshTokenEntityInterface $refreshTokenEntity): void
    {
        $refreshTokenManager = $this->refreshTokenManager;
        if (null !== $refreshTokenManager->find($refreshTokenEntity->getIdentifier())) {
            throw UniqueTokenIdentifierConstraintViolationException::create();
        }

        $accessTokenId = $refreshTokenEntity->getAccessToken()->getIdentifier();
        $accessToken   = $this->accessTokenManager->find($accessTokenId);

        $record = $refreshTokenManager->create(
            $refreshTokenEntity->getIdentifier(),
            $refreshTokenEntity->getExpiryDateTime(),
            $accessToken
        );
        $refreshTokenManager->save($record);

        $event = new RefreshTokenCreated(
            $refreshTokenEntity->getIdentifier(),
            $refreshTokenEntity->getAccessToken()->getIdentifier()
        );

        $this->dispatcher->dispatch($event);
    }

    public function revokeRefreshToken($tokenId): void
    {
        $manager      = $this->refreshTokenManager;
        $refreshToken = $manager->find($tokenId);
        if (null !== $refreshToken) {
            $refreshToken->revoke();
            $manager->save($refreshToken);
        }
    }

    public function isRefreshTokenRevoked($tokenId): bool
    {
        $token = $this->refreshTokenManager->find($tokenId);

        if (null === $token) {
            return true;
        }

        return $token->isRevoked();
    }
}
