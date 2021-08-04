<?php

/*
 * This file is part of the EOffice project.
 *
 * (c) Anthonius Munthi <https://itstoni.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace EOffice\Packages\Passport\Contracts;

use EOffice\Packages\User\Contracts\UserInterface;

interface UserManagerInterface
{
    public function findById(?string $id): ?UserInterface;

    public function findByUsername(string $username): ?UserInterface;

    public function findByEmail(string $email): ?UserInterface;
}