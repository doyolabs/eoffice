<?php

namespace EOffice\Components\User\Contracts;

interface CanonicalizerInterface
{
    public function canonicalize(?string $string): ?string;
}
