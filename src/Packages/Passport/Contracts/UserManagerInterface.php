<?php

namespace EOffice\Packages\Passport\Contracts;

use EOffice\Packages\User\Contracts\UserInterface;

interface UserManagerInterface
{
    public function findById(?string $id): ?UserInterface;
}
