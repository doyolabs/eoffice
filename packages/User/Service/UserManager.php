<?php

namespace EOffice\User\Service;

use EOffice\User\Contracts\UserManagerInterface;
use EOffice\User\Contracts\UserRepositoryInterface;
use EOffice\User\Model\User;
use EOffice\User\Request\CreateUserRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Passport\Bridge\UserRepository;

class UserManager implements UserManagerInterface
{
    private UserRepositoryInterface $userRepository;

    private string $model;

    public function __construct(UserRepositoryInterface $userRepository, string $model = User::class)
    {
        $this->userRepository = $userRepository;
        $this->model = $model;
    }

    public static function factory(Application $app): UserManagerInterface
    {
        $userRepository = $app->get(UserRepositoryInterface::class);
        return new self($userRepository);
    }

    public function getLists(Request $request): JsonResponse
    {
        $userRepository = $this->userRepository;
        $users = $userRepository->all();

        return new JsonResponse($users->toArray());
    }

    public function create(array $data): User
    {
        return $this->userRepository->create($data);
    }

    public function register(CreateUserRequest $request): JsonResponse
    {
        $repository = $this->userRepository;
        $user = $repository->create($request->all());
        return new JsonResponse($user->toArray());
    }
}
