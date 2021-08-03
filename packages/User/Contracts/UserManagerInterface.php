<?php

namespace EOffice\User\Contracts;

use EOffice\User\Model\User;
use EOffice\User\Request\CreateUserRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface UserManagerInterface
{
    public function getLists(Request $request): JsonResponse;

    /**
     * @param array $data
     * @return User
     */
    public function create(array $data): User;

    public function register(CreateUserRequest $request): JsonResponse;
}
