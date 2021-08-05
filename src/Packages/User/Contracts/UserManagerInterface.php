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

namespace EOffice\Packages\User\Contracts;

interface UserManagerInterface
{
    /**
     * @param string|int|null $id
     *
     * @return UserInterface|null
     */
    public function find($id): ?UserInterface;

    /**
     * @param string $username
     *
     * @return UserInterface|null
     */
    public function findByUsername(string $username): ?UserInterface;

    /**
     * @param string $email
     *
     * @return UserInterface|null
     */
    public function findByEmail(string $email): ?UserInterface;
}
