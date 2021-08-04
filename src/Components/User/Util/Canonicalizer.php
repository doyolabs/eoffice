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

namespace EOffice\Components\User\Util;

use EOffice\Components\User\Contracts\CanonicalizerInterface;

final class Canonicalizer implements CanonicalizerInterface
{
    /** @psalm-suppress PossiblyNullArgument */
    public function canonicalize(?string $string): ?string
    {
        return null === $string ? null : mb_convert_case($string, \MB_CASE_LOWER, mb_detect_encoding($string, mb_detect_order(), true) ?: null);
    }
}
