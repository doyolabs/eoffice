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

use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;

interface RefreshTokenManagerInterface
{
    public function find(string $getIdentifier): ?RefreshTokenInterface;

    public function createFromEntity(RefreshTokenEntityInterface $refreshTokenEntity): void;

    public function save(RefreshTokenInterface $refreshToken): void;

    public function create(string $getIdentifier, \DateTimeImmutable $getExpiryDateTime, ?AccessTokenInterface $accessToken): RefreshTokenInterface;
}
