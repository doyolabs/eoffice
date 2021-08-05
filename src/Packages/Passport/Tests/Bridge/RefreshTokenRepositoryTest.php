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

namespace EOffice\Packages\Passport\Tests\Bridge;

use EOffice\Packages\Passport\Bridge\RefreshTokenRepository;
use EOffice\Packages\Passport\Contracts\AccessTokenInterface;
use EOffice\Packages\Passport\Contracts\AccessTokenManagerInterface;
use EOffice\Packages\Passport\Contracts\RefreshTokenInterface;
use EOffice\Packages\Passport\Contracts\RefreshTokenManagerInterface;
use Illuminate\Contracts\Events\Dispatcher;
use Laravel\Passport\Bridge\RefreshToken;
use Laravel\Passport\Events\RefreshTokenCreated;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \EOffice\Packages\Passport\Bridge\RefreshTokenRepository
 */
class RefreshTokenRepositoryTest extends TestCase
{
    /**
     * @var RefreshTokenManagerInterface|mixed|\PHPUnit\Framework\MockObject\MockObject
     */
    private $refreshTokenManager;
    /**
     * @var AccessTokenManagerInterface|mixed|\PHPUnit\Framework\MockObject\MockObject
     */
    private $accessTokenManager;

    private RefreshTokenRepository $repository;
    /**
     * @var Dispatcher|mixed|\PHPUnit\Framework\MockObject\MockObject
     */
    private $dispatcher;

    protected function setUp(): void
    {
        $this->refreshTokenManager = $this->createMock(RefreshTokenManagerInterface::class);
        $this->accessTokenManager  = $this->createMock(AccessTokenManagerInterface::class);
        $this->dispatcher          = $this->createMock(Dispatcher::class);
        $this->repository          = new RefreshTokenRepository(
            $this->refreshTokenManager,
            $this->accessTokenManager,
            $this->dispatcher
        );
    }

    public function testItCreatesNewRefreshTokenEntity()
    {
        $this->assertInstanceOf(RefreshToken::class, $this->repository->getNewRefreshToken());
    }

    public function testItsPersistNewRefreshTokenThrowsExceptionWhenTokenExists()
    {
        $manager    = $this->refreshTokenManager;
        $model      = $this->createMock(RefreshTokenInterface::class);
        $entity     = $this->createMock(RefreshTokenEntityInterface::class);
        $repository = $this->repository;
        $id         = 'token-id';

        $entity->expects($this->once())
            ->method('getIdentifier')
            ->willReturn($id);
        $manager->expects($this->once())
            ->method('find')
            ->with($id)
            ->willReturn($model);

        $this->expectExceptionObject(UniqueTokenIdentifierConstraintViolationException::create());
        $repository->persistNewRefreshToken($entity);
    }

    public function testItShouldPersistNewRefreshToken()
    {
        $refreshTokenManager       = $this->refreshTokenManager;
        $accessTokenManager        = $this->accessTokenManager;
        $accessTokenEntity         = $this->createMock(AccessTokenEntityInterface::class);
        $accessTokenModel          = $this->createMock(AccessTokenInterface::class);
        $entity                    = $this->createMock(RefreshTokenEntityInterface::class);
        $record                    = $this->createMock(RefreshTokenInterface::class);
        $repository                = $this->repository;
        $id                        = 'id';
        $expiry                    = new \DateTimeImmutable();

        $entity->expects($this->any())
            ->method('getIdentifier')
            ->willReturn($id);
        $entity->expects($this->any())
            ->method('getAccessToken')
            ->willReturn($accessTokenEntity);
        $entity->expects($this->any())
            ->method('getExpiryDateTime')
            ->willReturn($expiry);
        $accessTokenManager->expects($this->once())
            ->method('find')
            ->willReturn($accessTokenModel);
        $accessTokenEntity->expects($this->any())
            ->method('getIdentifier')
            ->willReturn('access-token-id');
        $refreshTokenManager->expects($this->once())
            ->method('create')
            ->with(
                $id,
                $expiry,
                $accessTokenModel
            )
            ->willReturn($record);
        $refreshTokenManager->expects($this->once())
            ->method('save')
            ->with($record);
        $this->dispatcher->expects($this->once())
            ->method('dispatch')
            ->with($this->isInstanceOf(RefreshTokenCreated::class));

        $repository->persistNewRefreshToken($entity);
    }

    public function testItShouldRevokeRefreshToken()
    {
        $manager    = $this->refreshTokenManager;
        $repository = $this->repository;
        $model      = $this->createMock(RefreshTokenInterface::class);
        $id         = 'id';

        $manager->expects($this->once())
            ->method('find')
            ->with($id)
            ->willReturn($model);
        $model->expects($this->once())
            ->method('revoke');
        $manager->expects($this->once())
            ->method('save');

        $repository->revokeRefreshToken($id);
    }

    public function testItShouldCheckIfTokenIsRevoked()
    {
        $refreshTokenManager = $this->refreshTokenManager;
        $repository          = $this->repository;
        $model               = $this->createMock(RefreshTokenInterface::class);
        $tokenId             = 'token-id';

        $refreshTokenManager->expects($this->exactly(2))
            ->method('find')
            ->with($tokenId)
            ->willReturnOnConsecutiveCalls(
                null,
                $model
            );
        $model->expects($this->once())
            ->method('isRevoked')
            ->willReturn(false);

        $this->assertTrue($repository->isRefreshTokenRevoked($tokenId));
        $this->assertFalse($repository->isRefreshTokenRevoked($tokenId));
    }
}
