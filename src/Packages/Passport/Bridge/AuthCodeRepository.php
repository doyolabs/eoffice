<?php

namespace EOffice\Packages\Passport\Bridge;

use EOffice\Packages\Passport\Contracts\AuthCodeInterface;
use EOffice\Packages\Passport\Contracts\AuthCodeManagerInterface;
use EOffice\Packages\Passport\Contracts\ClientManagerInterface;
use EOffice\Packages\Passport\Contracts\ScopeConverterInterface;
use EOffice\Packages\Passport\Contracts\UserManagerInterface;
use Laravel\Passport\Bridge\AuthCode;

use League\OAuth2\Server\Entities\AuthCodeEntityInterface;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface;

class AuthCodeRepository implements AuthCodeRepositoryInterface
{
    private AuthCodeManagerInterface $authCodeManager;
    private ClientManagerInterface $clientManager;
    private ScopeConverterInterface $scopeConverter;
    private UserManagerInterface $userManager;

    public function __construct(
        AuthCodeManagerInterface $authCodeManager,
        ClientManagerInterface $clientManager,
        ScopeConverterInterface $scopeConverter,
        UserManagerInterface $userManager
    )
    {
        $this->authCodeManager = $authCodeManager;
        $this->clientManager = $clientManager;
        $this->scopeConverter = $scopeConverter;
        $this->userManager = $userManager;
    }

    public function getNewAuthCode(): AuthCodeEntityInterface
    {
        return new AuthCode();
    }

    public function persistNewAuthCode(AuthCodeEntityInterface $authCodeEntity)
    {
        if(null !== $this->authCodeManager->findById($authCodeEntity->getIdentifier())){
            throw UniqueTokenIdentifierConstraintViolationException::create();
        }

        $authCode = $this->buildAuthCode($authCodeEntity);
        $this->authCodeManager->save($authCode);
    }

    public function revokeAuthCode($codeId): void
    {
        $authCodeManager = $this->authCodeManager;
        $authCode = $authCodeManager->findById($codeId);

        if(!is_null($authCode)){
            $authCode->revoke();
            $authCodeManager->save($authCode);
        }
    }

    public function isAuthCodeRevoked($codeId): bool
    {
        $authCodeManager = $this->authCodeManager;
        $authCode = $authCodeManager->findById($codeId);

        if(is_null($authCode)){
            return true;
        }
        return $authCode->isRevoked();
    }

    private function buildAuthCode(AuthCodeEntityInterface $authCode): AuthCodeInterface
    {
        $client = $this->clientManager->findById($authCode->getClient()->getIdentifier());
        $user = $this->userManager->findById($authCode->getUserIdentifier());

        return $this->authCodeManager->create(
            $authCode->getIdentifier(),
            $authCode->getExpiryDateTime(),
            $client,
            $user,
            $this->scopeConverter->toDomainArray($authCode->getScopes())
        );
    }

}
