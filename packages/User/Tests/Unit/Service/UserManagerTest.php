<?php

namespace EOffice\User\Tests\Unit\Service;

use EOffice\User\Contracts\UserManagerInterface;
use EOffice\User\Contracts\UserRepositoryInterface;
use EOffice\User\Model\User;
use EOffice\User\Request\CreateUserRequest;
use EOffice\User\Service\UserManager;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;

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
        $this->app = $this->createMock(Application::class);
        $this->app->expects($this->any())
            ->method('get')
            ->with(UserRepositoryInterface::class)
            ->willReturn($this->userRepository);

        $this->userManager = UserManager::factory($this->app);
    }

    public function testGetLists()
    {
        $request = $this->createMock(Request::class);
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
        $data = ['test'];
        $request = $this->createMock(CreateUserRequest::class);
        $request->expects($this->once())
            ->method('all')
            ->willReturn($data);

        $user = $this->createMock(User::class);
        $user->expects($this->once())
            ->method('toArray')
            ->willReturn($data);

        $this->userRepository->expects($this->once())
            ->method('create')
            ->with($data)
            ->willReturn($user);

        $response = $this->userManager->register($request);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertSame($data, $response->getData());
    }
}
