<?php

/*
 * This file is part of the EOffice project.
 * (c) Anthonius Munthi <https://itstoni.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace EOffice\User\Tests\Unit\Service;

use EOffice\User\Contracts\UserManagerInterface;
use EOffice\User\Contracts\UserRepositoryInterface;
use EOffice\User\Http\Resources\UserResource;
use EOffice\User\Model\User;
use EOffice\User\Request\CreateUserRequest;
use EOffice\User\Service\UserManager;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;

/**
 * @covers \EOffice\User\Service\UserManager
 */
class UserManagerTest extends TestCase
{
    /**
     * @var Application|mixed|\PHPUnit\Framework\MockObject\MockObject
     */
    private $app;

    /**
     * @var UserRepositoryInterface|mixed|\PHPUnit\Framework\MockObject\MockObject
     */
    private $userRepository;
    private UserManagerInterface $userManager;

    protected function setUp(): void
    {
        $this->userRepository = $this->createMock(UserRepositoryInterface::class);
        $this->app            = $this->createMock(Application::class);
        $this->app->expects($this->any())
            ->method('get')
            ->with(UserRepositoryInterface::class)
            ->willReturn($this->userRepository);

        $this->userManager = UserManager::factory($this->app);
    }

    public function testGetLists()
    {
        $request    = $this->createMock(Request::class);
        $collection = $this->createMock(Collection::class);
        $collection->expects($this->once())
            ->method('toArray')
            ->willReturn($array = ['test']);
        $this->userRepository->expects($this->once())
            ->method('all')
            ->willReturn($collection);

        $resp = $this->userManager->getLists($request);

        $this->assertInstanceOf(JsonResponse::class, $resp);
        $this->assertSame($array, $resp->getData());
    }

    public function testRegister()
    {
        $data    = ['test'];
        $request = $this->createMock(CreateUserRequest::class);
        $user = $this->createMock(User::class);


        $request->expects($this->once())
            ->method('all')
            ->willReturn($data);

        $this->userRepository->expects($this->once())
            ->method('create')
            ->with($data)
            ->willReturn($user);

        $response = $this->userManager->register($request);
        $this->assertInstanceOf(UserResource::class, $response);
    }

    public function testCreate()
    {
        $data = ['test'];
        $user = $this->createMock(User::class);

        $repository = $this->userRepository;
        $repository->expects($this->once())
            ->method('create')
            ->with($data)
            ->willReturn($user);

        $result = $this->userManager->create($data);
        $this->assertSame($user, $result);
    }
}
