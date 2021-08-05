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

namespace EOffice\Packages\Doctrine;

use EOffice\Packages\Doctrine\Service\TargetEntityResolver;

class Doctrine
{
    public static function resolveTargetEntity(
        string $abstract,
        string $concrete,
        array $options = []
    ): void {
        $resolver = app(TargetEntityResolver::class);
        $resolver->addResolveTargetEntity($abstract, $concrete, $options);
    }
}
