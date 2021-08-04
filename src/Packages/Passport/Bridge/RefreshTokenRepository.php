<?php

namespace EOffice\Packages\Passport\Bridge;

use EOffice\Packages\Passport\Contracts\AccessTokenManagerInterface;
use EOffice\Packages\Passport\Contracts\RefreshTokenManagerInterface;
use Illuminate\Contracts\Events\Dispatcher;
use Laravel\Passport\Bridge\RefreshToken;
use Laravel\Passport\Events\RefreshTokenCreated;
use Laravel\Passport\Passport;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;

class RefreshTokenRepository implements RefreshTokenRepositoryInterface
{

    private RefreshTokenManagerInterface $refreshTokenManager;
    private AccessTokenManagerInterface $accessTokenManager;
    private Dispatcher $dispatcher;

    public function __construct(
        RefreshTokenManagerInterface $refreshTokenManager,
        AccessTokenManagerInterface $accessTokenManager,
        Dispatcher $dispatcher
    )
    {
        $this->refreshTokenManager = $refreshTokenManager;
        $this->accessTokenManager = $accessTokenManager;
        $this->dispatcher = $dispatcher;
    }

    public function getNewRefreshToken(): RefreshTokenEntityInterface
    {
        return new RefreshToken();
    }

    public function persistNewRefreshToken(RefreshTokenEntityInterface $refreshTokenEntity): void
    {
        /*
        if(!is_null($refreshTokenManager->find($refreshTokenEntity->getIdentifier()))){
            throw UniqueTokenIdentifierConstraintViolationException::create();
        }
        */
        $this->refreshTokenManager->createFromEntity($refreshTokenEntity);
        $this->dispatcher->dispatch(new RefreshTokenCreated($refreshTokenEntity->getIdentifier(), $refreshTokenEntity->getAccessToken()->getIdentifier()));
    }

    public function revokeRefreshToken($tokenId)
    {
        $manager = $this->refreshTokenManager;
        $refreshToken = $manager->find($tokenId);
        if(!is_null($refreshToken)){
            $refreshToken->revoke();
            $manager->save($refreshToken);
        }
    }

    public function isRefreshTokenRevoked($tokenId)
    {
        // TODO: Implement isRefreshTokenRevoked() method.
    }
}
