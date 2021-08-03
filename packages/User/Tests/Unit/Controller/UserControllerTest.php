<?php

namespace EOffice\User\Tests\Unit\Controller;

use EOffice\User\Contracts\UserManagerInterface;
use EOffice\User\Controller\UserController;
use EOffice\User\Request\CreateUserRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;

/**
 * @covers \EOffice\User\Controller\UserController
 */
class UserControllerTest extends TestCase
{
    /**
     * @var UserManagerInterface|mixed|\PHPUnit\Framework\MockObject\MockObject
     */
    private $userManager;

    private UserController $userController;

    /**
     * @var JsonResponse|mixed|\PHPUnit\Framework\MockObject\MockObject
     */
    private $response;

    /**
     * @var Request|mixed|\PHPUnit\Framework\MockObject\MockObject
     */
    private $request;

    protected function setUp(): void
    {
        $this->userManager = $this->createMock(UserManagerInterface::class);
        $this->userController = new UserController();
        $this->response = $this->createMock(JsonResponse::class);
        $this->request = $this->createMock(Request::class);
    }

    public function testGetLists()
    {
        $this->userManager->expects($this->once())
            ->method('getLists')
            ->with($this->isInstanceOf(Request::class))
            ->willReturn($this->response);

        $this->userController->index($this->userManager, $this->request);
    }

    public function testRegister()
    {
        $request = $this->createMock(CreateUserRequest::class);
        $this->userManager->expects($this->once())
            ->method('register')
            ->with($request)
            ->willReturn($this->response);

        $this->userController->register($this->userManager, $request);
    }
}
