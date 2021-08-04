<?php

namespace EOffice\Packages\Passport\Contracts;

use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;

interface RefreshTokenManagerInterface
{

    public function find(string $getIdentifier): ?RefreshTokenInterface;

    public function createFromEntity(RefreshTokenEntityInterface $refreshTokenEntity): void;

    public function save(RefreshTokenInterface $refreshToken): void;
}
