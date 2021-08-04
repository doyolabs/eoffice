<?php

namespace EOffice\Packages\Passport\Contracts;

interface ScopeConverterInterface
{
    public function toDomainArray(array $getScopes): array;
}
