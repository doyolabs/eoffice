<?php

namespace EOffice\Packages\Passport\Contracts;

use EOffice\Packages\User\Contracts\UserInterface;

interface AccessTokenManagerInterface
{
    public function findById(?string $getUserIdentifier): ?AccessTokenInterface;

    public function save(AccessTokenInterface $accessToken);

    public function create(string $identifier, \DateTimeImmutable $expiryDateTime, ?ClientInterface $client, ?UserInterface $user, array $scopes);
}
