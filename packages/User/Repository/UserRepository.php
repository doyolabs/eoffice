<?php

/*
 * This file is part of the EOffice project.
 * (c) Anthonius Munthi <https://itstoni.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace EOffice\User\Repository;

use EOffice\User\Contracts\UserRepositoryInterface;
use EOffice\User\Model\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface
{
    private string $model;

    public function __construct(string $model = User::class)
    {
        $this->model = $model;
    }

    public function all(): Collection
    {
        $model = $this->createModel();

        return $model->all();
    }

    public function create(array $data): User
    {
        $user = $this->createModel($data);
        $user->save();

        return $user;
    }

    private function createModel(array $data = []): User
    {
        $class = $this->model;

        return new $class($data);
    }
}
