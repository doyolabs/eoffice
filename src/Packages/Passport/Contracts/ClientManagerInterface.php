<?php

namespace EOffice\Packages\Passport\Contracts;

use League\OAuth2\Server\Entities\ClientEntityInterface;

interface ClientManagerInterface
{
    public function findById(string $id): ?ClientInterface;

    public function findActive(string $id): ?ClientInterface;

    public function createEntityByIdentifier(string $identifier): ?ClientEntityInterface;
}
