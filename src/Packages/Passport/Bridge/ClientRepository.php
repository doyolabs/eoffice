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

namespace EOffice\Packages\Passport\Bridge;

use EOffice\Packages\Passport\Contracts\ClientInterface;
use EOffice\Packages\Passport\Contracts\ClientManagerInterface;
use Laravel\Passport\Passport;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;

class ClientRepository implements ClientRepositoryInterface
{
    private ClientManagerInterface $clientManager;

    public function __construct(
        ClientManagerInterface $clientManager
    ) {
        $this->clientManager = $clientManager;
    }

    public function getClientEntity($clientIdentifier): ?ClientEntityInterface
    {
        return $this->clientManager->createEntityByIdentifier($clientIdentifier);
    }

    /**
     * @param string      $clientIdentifier
     * @param string|null $clientSecret
     * @param string|null $grantType
     *
     * @return bool
     */
    public function validateClient($clientIdentifier, $clientSecret, $grantType): bool
    {
        $clientManager = $this->clientManager;
        $record        = $clientManager->findActive($clientIdentifier);

        if (null === $record) {
            return false;
        }
        if ( ! $this->handlesGrant($record, $grantType)) {
            return false;
        }

        return ! $record->confidential() || $this->verifySecret((string) $clientSecret, (string) $record->getSecret());
    }

    private function handlesGrant(ClientInterface $record, ?string $grantType): bool
    {
        if ( ! \in_array($grantType, $record->getGrants(), true)) {
            return false;
        }

        switch ($grantType) {
            case 'authorization_code':
                return ! $record->firstParty();
            case 'personal_access':
                return $record->isPersonalAccessClient() && $record->confidential();
            case 'password':
                return $record->isPasswordClient();
            case 'client_credentials':
                return $record->confidential();
            default:
                return true;
        }
    }

    private function verifySecret(string $clientSecret, string $storedHash): bool
    {
        return Passport::$hashesClientSecrets ? password_verify($clientSecret, $storedHash) : hash_equals($storedHash, $clientSecret);
    }
}
