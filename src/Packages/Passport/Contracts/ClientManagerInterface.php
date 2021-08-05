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

use League\OAuth2\Server\Entities\ClientEntityInterface;

interface ClientManagerInterface
{
    public function find(string $id): ?ClientInterface;

    public function findActive(string $id): ?ClientInterface;

    public function createEntityByIdentifier(string $identifier): ?ClientEntityInterface;
}
