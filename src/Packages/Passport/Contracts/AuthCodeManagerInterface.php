<?php

namespace EOffice\Packages\Passport\Contracts;

use EOffice\Packages\User\Contracts\UserInterface;

interface AuthCodeManagerInterface
{
    public function findById(string $id): ?AuthCodeInterface;

    public function create(
        string $identifier,
        \DateTimeInterface $expiry,
        ClientInterface $client,
        UserInterface $user,
        array $scopes
    ): AuthCodeInterface;

    public function save(AuthCodeInterface $authCode): void;
}
