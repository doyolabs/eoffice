<?php

namespace EOffice\Components\User\Util;

use EOffice\Components\User\Contracts\CanonicalizerInterface;

final class Canonicalizer implements CanonicalizerInterface
{
    /** @psalm-suppress PossiblyNullArgument */
    public function canonicalize(?string $string): ?string
    {
        return null === $string ? null : mb_convert_case($string, \MB_CASE_LOWER, mb_detect_encoding($string) ?: null);
    }
}
