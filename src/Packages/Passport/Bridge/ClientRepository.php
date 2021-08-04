<?php

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
    )
    {
        $this->clientManager = $clientManager;
    }

    public function getClientEntity($clientIdentifier): ?ClientEntityInterface
    {
        return $this->clientManager->createEntityByIdentifier($clientIdentifier);
    }

    public function validateClient($clientIdentifier, $clientSecret, $grantType): bool
    {
        $clientManager = $this->clientManager;
        $record = $clientManager->findActive($clientIdentifier);

        if(!$record || !$this->handlesGrant($record, $grantType)){
            return false;
        }

        return !$record->confidential() || $this->verifySecret((string)$clientSecret, $record->getSecret());
    }

    private function handlesGrant(ClientInterface $record, ?string $grantType): bool
    {
        if (is_array($record->getGrants()) && ! in_array($grantType, $record->getGrants())) {
            return false;
        }

        $personal = $record->isPersonalAccessClient();
        $confidential = $record->confidential();
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
        return Passport::$hashesClientSecrets ? password_verify($clientSecret, $storedHash):hash_equals($storedHash, $clientSecret);
    }
}
