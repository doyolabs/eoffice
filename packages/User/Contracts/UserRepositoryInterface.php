<?php

namespace EOffice\User\Contracts;

use EOffice\User\Model\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    public function all(): Collection;

    public function create(array $data): User;
}
