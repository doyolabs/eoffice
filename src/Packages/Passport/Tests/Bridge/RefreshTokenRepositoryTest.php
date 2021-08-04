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
use EOffice\Packages\Passport\Contracts\AccessTokenManagerInterface;
use EOffice\Packages\Passport\Contracts\RefreshTokenInterface;
use EOffice\Packages\Passport\Contracts\RefreshTokenManagerInterface;
use Illuminate\Contracts\Events\Dispatcher;
use Laravel\Passport\Bridge\RefreshToken;
use Laravel\Passport\Events\RefreshTokenCreated;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
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

    public function testItShouldPersistNewRefreshToken()
    {
        $refreshTokenManager = $this->refreshTokenManager;
        $accessToken         = $this->createMock(AccessTokenEntityInterface::class);
        $entity              = $this->createMock(RefreshTokenEntityInterface::class);
        $record              = $this->createMock(RefreshTokenInterface::class);
        $repository          = $this->repository;
        $id                  = 'id';

        $entity->expects($this->any())
            ->method('getIdentifier')
            ->willReturn($id);
        $entity->expects($this->any())
            ->method('getAccessToken')
            ->willReturn($accessToken);
        $accessToken->expects($this->any())
            ->method('getIdentifier')
            ->willReturn('access-token-id');
        $refreshTokenManager->expects($this->once())
            ->method('createFromEntity')
            ->with($entity);
        $this->dispatcher->expects($this->once())
            ->method('dispatch')
            ->with($this->isInstanceOf(RefreshTokenCreated::class));

        $repository->persistNewRefreshToken($entity);
    }
}
