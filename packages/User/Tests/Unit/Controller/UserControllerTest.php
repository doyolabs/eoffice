<?php

/*
 * This file is part of the EOffice project.
 * (c) Anthonius Munthi <https://itstoni.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace EOffice\User\Tests\Unit\Controller;

use EOffice\User\Contracts\UserManagerInterface;
use EOffice\User\Controller\UserController;
use EOffice\User\Http\Resources\UserResource;
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
        $this->userManager    = $this->createMock(UserManagerInterface::class);
        $this->userController = new UserController();
        $this->response       = $this->createMock(JsonResponse::class);
        $this->request        = $this->createMock(Request::class);
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
        $resource = $this->createMock(UserResource::class);

        $this->userManager->expects($this->once())
            ->method('register')
            ->with($request)
            ->willReturn($resource);

        $this->userController->store($this->userManager, $request);
    }
}
