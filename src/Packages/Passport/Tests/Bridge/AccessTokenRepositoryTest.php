<?php

namespace EOffice\Packages\Passport\Tests\Bridge;

use EOffice\Packages\Passport\Bridge\AccessTokenRepository;
use EOffice\Packages\Passport\Contracts\AccessTokenInterface;
use EOffice\Packages\Passport\Contracts\AccessTokenManagerInterface;
use EOffice\Packages\Passport\Contracts\ClientInterface;
use EOffice\Packages\Passport\Contracts\ClientManagerInterface;
use EOffice\Packages\Passport\Contracts\ScopeConverterInterface;
use EOffice\Packages\Passport\Contracts\UserManagerInterface;
use EOffice\Packages\User\Contracts\UserInterface;
use Laravel\Passport\Bridge\AccessToken;
use Laravel\Passport\Bridge\Client;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use PHPUnit\Framework\TestCase;

class AccessTokenRepositoryTest extends TestCase
{
    /**
     * @var AccessTokenManagerInterface|mixed|\PHPUnit\Framework\MockObject\MockObject
     */
    private $accessTokenManager;
    /**
     * @var ClientManagerInterface|mixed|\PHPUnit\Framework\MockObject\MockObject
     */
    private $clientManager;
    /**
     * @var ScopeConverterInterface|mixed|\PHPUnit\Framework\MockObject\MockObject
     */
    private $scopeConverter;
    /**
     * @var UserManagerInterface|mixed|\PHPUnit\Framework\MockObject\MockObject
     */
    private $userManager;

    private AccessTokenRepository $repository;
    private AccessToken $accessTokenEntity;

    public function setUp(): void
    {
        $this->accessTokenManager = $this->createMock(AccessTokenManagerInterface::class);
        $this->clientManager = $this->createMock(ClientManagerInterface::class);
        $this->scopeConverter = $this->createMock(ScopeConverterInterface::class);
        $this->userManager = $this->createMock(UserManagerInterface::class);
        $this->repository = new AccessTokenRepository(
            $this->accessTokenManager,
            $this->clientManager,
            $this->scopeConverter,
            $this->userManager
        );

        $clientEntity = new Client('client_id', 'name','redirect');
        $accessTokenEntity = $this->repository->getNewToken($clientEntity, [], 'user_id');
        $accessTokenEntity->setIdentifier('identifier');
        $accessTokenEntity->setExpiryDateTime(new \DateTimeImmutable('now'));
        $this->accessTokenEntity = $accessTokenEntity;
    }

    public function testItShouldPersistNewToken()
    {
        $accessTokenManager = $this->accessTokenManager;
        $clientManager = $this->clientManager;
        $userManager = $this->userManager;
        $scopeConverter = $this->scopeConverter;
        $repository = $this->repository;
        $entity = $this->accessTokenEntity;
        $accessToken = $this->createMock(AccessTokenInterface::class);
        $client = $this->createMock(ClientInterface::class);
        $user = $this->createMock(UserInterface::class);
        $scopes = ['scopes'];

        $accessTokenManager->expects($this->once())
            ->method('findById')
            ->with('identifier')
            ->willReturn(null);
        $clientManager->expects($this->once())
            ->method('findById')
            ->with('client_id')
            ->willReturn($client);
        $userManager->expects($this->once())
            ->method('findById')
            ->with('user_id')
            ->willReturn($user);
        $scopeConverter->expects($this->once())
            ->method('toDomainArray')
            ->willReturn($scopes);

        $accessTokenManager->expects($this->once())
            ->method('create')
            ->with(
                'identifier',
                $entity->getExpiryDateTime(),
                $client,
                $user,
                $scopes
            )
            ->willReturn($accessToken);

        $accessTokenManager->expects($this->once())
            ->method('save')
            ->with($accessToken);

        $repository->persistNewAccessToken($entity);
    }

    public function testItThrowsWhenAccessTokenIdentifierExist()
    {
        $expected = UniqueTokenIdentifierConstraintViolationException::create();
        $accessTokenManager = $this->accessTokenManager;
        $repository = $this->repository;
        $accessToken = $this->createMock(AccessTokenInterface::class);
        $entity = $this->accessTokenEntity;

        $this->expectExceptionObject($expected);

        $accessTokenManager->expects($this->once())
            ->method('findById')
            ->willReturn($accessToken);

        $repository->persistNewAccessToken($entity);
    }

    public function testItRevokeAccessTokenUsingIdentifier()
    {
        $accessTokenManager = $this->accessTokenManager;
        $accessToken = $this->createMock(AccessTokenInterface::class);
        $repository = $this->repository;

        $accessTokenManager->expects($this->once())
            ->method('findById')
            ->with($tokenId = 'token-id')
            ->willReturn($accessToken);

        $accessToken->expects($this->once())
            ->method('revoke');

        $accessTokenManager->expects($this->once())
            ->method('save')
            ->with($accessToken);
        $repository->revokeAccessToken($tokenId);
    }

    public function testItShouldCheckRevokedTokenId()
    {
        $accessTokenManager = $this->accessTokenManager;
        $accessToken = $this->createMock(AccessTokenInterface::class);
        $repository = $this->repository;
        $tokenId = 'token-id';

        $accessTokenManager->expects($this->exactly(2))
            ->method('findById')
            ->with($tokenId)
            ->willReturnOnConsecutiveCalls(
                null,
                $accessToken
            );

        $accessToken->expects($this->once())
            ->method('isRevoked')
            ->willReturn(false);

        $this->assertTrue($repository->isAccessTokenRevoked($tokenId));
        $this->assertFalse($repository->isAccessTokenRevoked($tokenId));
    }
}
