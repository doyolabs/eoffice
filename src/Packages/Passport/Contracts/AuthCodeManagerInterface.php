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

interface AuthCodeManagerInterface
{
    /**
     * @param string $id
     *
     * @return AuthCodeInterface|null
     */
    public function find(string $id): ?AuthCodeInterface;

    public function create(
        string $identifier,
        \DateTimeInterface $expiry,
        ClientInterface $client,
        UserInterface $user,
        array $scopes
    ): AuthCodeInterface;

    public function save(AuthCodeInterface $authCode): void;
}
