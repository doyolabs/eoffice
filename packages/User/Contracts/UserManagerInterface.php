<?php

/*
 * This file is part of the EOffice project.
 * (c) Anthonius Munthi <https://itstoni.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

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
     *
     * @return User
     */
    public function create(array $data): User;

    public function register(CreateUserRequest $request): JsonResponse;
}
