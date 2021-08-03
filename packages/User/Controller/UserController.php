<?php

namespace EOffice\User\Controller;

use EOffice\Core\Http\Controller\Controller;
use EOffice\User\Contracts\UserManagerInterface;
use EOffice\User\Request\CreateUserRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(UserManagerInterface $manager, Request $request): JsonResponse
    {
        return $manager->getLists($request);
    }

    public function register(UserManagerInterface $manager, CreateUserRequest $request): JsonResponse
    {
        return $manager->register($request);
    }
}
