<?php

namespace EOffice\Components\User\Util;

use EOffice\Components\User\Contracts\CanonicalizerInterface;
use EOffice\Components\User\Contracts\UserInterface;

class CanonicalFieldsUpdater
{
    private CanonicalizerInterface $usernameCanonicalizer;
    private CanonicalizerInterface $emailCanonicalizer;

    /**
     * @param CanonicalizerInterface $usernameCanonicalizer
     * @param CanonicalizerInterface $emailCanonicalizer
     */
    public function __construct(CanonicalizerInterface $usernameCanonicalizer, CanonicalizerInterface $emailCanonicalizer)
    {
        $this->usernameCanonicalizer = $usernameCanonicalizer;
        $this->emailCanonicalizer = $emailCanonicalizer;
    }

    public function canonicalizeUsername(?string $string): ?string
    {
        return $this->usernameCanonicalizer->canonicalize($string);
    }

    public function canonicalizeEmail(?string $string): ?string
    {
        return $this->emailCanonicalizer->canonicalize($string);
    }

    public function updateCanonicalFields(UserInterface $user): void
    {
        $user->setUsernameCanonical($this->canonicalizeUsername($user->getUsername()));
        $user->setEmailCanonical($this->canonicalizeEmail($user->getEmail()));
    }
}
