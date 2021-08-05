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

use Doctrine\Persistence\ObjectManager;
use EOffice\Packages\Core\Test\TestCase;
use EOffice\Packages\Passport\Bridge\AuthCodeRepository;
use EOffice\Packages\Passport\Contracts\AuthCodeInterface;
use EOffice\Packages\Passport\Contracts\AuthCodeManagerInterface;
use EOffice\Packages\Passport\Contracts\ClientInterface;
use EOffice\Packages\Passport\Contracts\ClientManagerInterface;
use EOffice\Packages\Passport\Contracts\ScopeConverterInterface;
use EOffice\Packages\User\Contracts\UserInterface;
use EOffice\Packages\User\Contracts\UserManagerInterface;
use Laravel\Passport\Bridge\AuthCode;
use Laravel\Passport\Bridge\Client;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;

class AuthCodeRepositoryTest extends TestCase
{
    /**
     * @var ObjectManager|mixed|\PHPUnit\Framework\MockObject\MockObject
     */
    private $om;

    private AuthCodeRepository $repository;
    /**
     * @var AuthCodeManagerInterface|mixed|\PHPUnit\Framework\MockObject\MockObject
     */
    private $authCodeManager;
    /**
     * @var ClientManagerInterface|mixed|\PHPUnit\Framework\MockObject\MockObject
     */
    private $clientManager;
    /**
     * @var ScopeConverterInterface|mixed|\PHPUnit\Framework\MockObject\MockObject
     */
    private $scopeConverter;
    /**
     * @var \EOffice\Packages\User\Contracts\UserManagerInterface|mixed|\PHPUnit\Framework\MockObject\MockObject
     */
    private $userManager;

    protected function setUp(): void
    {
        $this->authCodeManager = $this->createMock(AuthCodeManagerInterface::class);
        $this->clientManager   = $this->createMock(ClientManagerInterface::class);
        $this->scopeConverter  = $this->createMock(ScopeConverterInterface::class);
        $this->userManager     = $this->createMock(UserManagerInterface::class);

        $this->repository = new AuthCodeRepository(
            $this->authCodeManager,
            $this->clientManager,
            $this->scopeConverter,
            $this->userManager
        );
    }

    public function testItCreatesNewAuthCode()
    {
        $repository = $this->repository;

        $this->assertInstanceOf(AuthCode::class, $repository->getNewAuthCode());
    }

    public function testItThrowsExceptionWhenPersistWithExistingIdentifier()
    {
        $exception = UniqueTokenIdentifierConstraintViolationException::create();

        $authCodeManager = $this->authCodeManager;
        $repository      = $this->repository;
        $authCode        = new AuthCode();
        $authCode->setIdentifier('identifier');

        $exist = $this->createMock(AuthCodeInterface::class);

        $authCodeManager->expects($this->once())
            ->method('find')
            ->with('identifier')
            ->willReturn($exist);

        $this->expectException(\get_class($exception));
        $this->expectExceptionMessage($exception->getMessage());
        $repository->persistNewAuthCode($authCode);
    }

    public function testItShouldPersistNewAuthCode()
    {
        $repository      = $this->repository;
        $authCodeManager = $this->authCodeManager;
        $clientManager   = $this->clientManager;
        $userManager     = $this->userManager;
        $client          = $this->createMock(ClientInterface::class);
        $user            = $this->createMock(UserInterface::class);
        $authCode        = new AuthCode();
        $scopes          = ['scopes'];

        $authCode->setClient(new Client('client_id', 'name', 'uri'));
        $authCode->setIdentifier('identifier');
        $authCode->setExpiryDateTime(new \DateTimeImmutable('now'));
        $authCode->setUserIdentifier('user_id');

        $clientManager->expects($this->once())
            ->method('find')
            ->with('client_id')
            ->willReturn($client);

        $authCodeManager->expects($this->once())
            ->method('find')
            ->with('identifier')
            ->willReturn(null);

        $userManager->expects($this->once())
            ->method('find')
            ->with('user_id')
            ->willReturn($user);
        $this->scopeConverter->expects($this->once())
            ->method('toDomainArray')
            ->with($authCode->getScopes())
            ->willReturn($scopes);

        $authCodeManager->expects($this->once())
            ->method('create')
            ->with(
                'identifier',
                $authCode->getExpiryDateTime(),
                $client,
                $user,
                $scopes
            );

        $repository->persistNewAuthCode($authCode);
    }

    public function testItShouldRevokeAuthCode()
    {
        $authCode        = $this->createMock(AuthCodeInterface::class);
        $authCodeManager = $this->authCodeManager;
        $repository      = $this->repository;

        $authCodeManager->expects($this->once())
            ->method('find')
            ->with('id')
            ->willReturn($authCode);

        $authCode->expects($this->once())
            ->method('revoke');

        $authCodeManager->expects($this->once())
            ->method('save')
            ->with($authCode);

        $repository->revokeAuthCode('id');
    }

    public function testItShouldChecksRevokedAuthCode()
    {
        $authCodeManager = $this->authCodeManager;
        $authCode        = $this->createMock(AuthCodeInterface::class);
        $repository      = $this->repository;

        $authCode->expects($this->once())
            ->method('isRevoked')
            ->willReturn(false);

        $authCodeManager
            ->expects($this->exactly(2))
            ->method('find')
            ->with('id')
            ->willReturnOnConsecutiveCalls(
                null,
                $authCode
            );

        $this->assertTrue($repository->isAuthCodeRevoked('id'));

        $this->assertFalse($repository->isAuthCodeRevoked('id'));
    }
}
