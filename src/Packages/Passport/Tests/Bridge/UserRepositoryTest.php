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

use EOffice\Packages\Passport\Bridge\UserRepository;
use EOffice\Packages\Passport\Contracts\UserManagerInterface;
use EOffice\Packages\User\Contracts\UserInterface;
use Illuminate\Contracts\Hashing\Hasher;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\UserEntityInterface;
use PHPUnit\Framework\TestCase;

class UserRepositoryTest extends TestCase
{
    /**
     * @var UserManagerInterface|mixed|\PHPUnit\Framework\MockObject\MockObject
     */
    private $userManager;
    /**
     * @var Hasher|mixed|\PHPUnit\Framework\MockObject\MockObject
     */
    private $hasher;
    private UserRepository $repository;

    protected function setUp(): void
    {
        $this->userManager = $this->createMock(UserManagerInterface::class);
        $this->hasher      = $this->createMock(Hasher::class);
        $this->repository  = new UserRepository(
            $this->userManager,
            $this->hasher
        );
    }

    /**
     * @param bool   $assertNull
     * @param string $username
     * @dataProvider getTestRetrieveUserEntity
     */
    public function testItShouldRetrieveUserEntityByCredentials(
        bool $assertNull = true,
        string $username = 'email@test.com',
        bool $hasherResult = true
    ) {
        $userManager  = $this->userManager;
        $user         = $this->createMock(UserInterface::class);
        $repository   = $this->repository;
        $hasher       = $this->hasher;
        $clientEntity = $this->createMock(ClientEntityInterface::class);
        $password     = 'password';
        $hashed       = 'hashed';

        $userManager->expects($this->once())
            ->method('findByUsername')
            ->with($username)
            ->willReturn(null);
        $userManager->expects($this->once())
            ->method('findByEmail')
            ->with($username)
            ->willReturnMap([
                ['foo', null],
                ['email@test.com', $user],
            ]);

        $user->expects($this->any())
            ->method('getPassword')
            ->willReturn('hashed');
        $hasher->expects($this->any())
            ->method('check')
            ->with($password, $hashed)
            ->willReturn($hasherResult);

        $result = $repository->getUserEntityByUserCredentials(
            $username,
            'password',
            'grant',
            $clientEntity
        );
        if ($assertNull) {
            $this->assertNull($result);
        } else {
            $this->assertInstanceOf(UserEntityInterface::class, $result);
        }
    }

    public function getTestRetrieveUserEntity()
    {
        return [
            [true, 'foo'],
            [false],
            [true, 'email@test.com', false],
        ];
    }
}
