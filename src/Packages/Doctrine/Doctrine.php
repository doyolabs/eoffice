<?php

namespace EOffice\Packages\Doctrine;

use EOffice\Packages\Doctrine\Service\TargetEntityResolver;
use Laravel\Passport\Passport;

class Doctrine
{
    public static function resolveTargetEntity(
        string $abstract,
        string $concrete,
        array $options = []
    ){
        /* @var \EOffice\Packages\Doctrine\Service\TargetEntityResolver $resolver */
        $resolver = app(TargetEntityResolver::class);

        $resolver->addResolveTargetEntity($abstract, $concrete, $options);
    }
}
