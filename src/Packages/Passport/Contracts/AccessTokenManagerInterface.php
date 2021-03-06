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

interface AccessTokenManagerInterface
{
    public function find(?string $getUserIdentifier): ?AccessTokenInterface;

    public function save(AccessTokenInterface $accessToken): void;

    public function create(string $identifier, \DateTimeImmutable $expiryDateTime, ?ClientInterface $client, ?UserInterface $user, array $scopes): AccessTokenInterface;
}
