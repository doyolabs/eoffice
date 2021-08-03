<?php

/*
 * This file is part of the EOffice project.
 * (c) Anthonius Munthi <https://itstoni.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

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
