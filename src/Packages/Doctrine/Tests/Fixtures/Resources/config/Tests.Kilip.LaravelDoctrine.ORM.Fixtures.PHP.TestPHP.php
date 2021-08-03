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

use Doctrine\ORM\Mapping\ClassMetadataInfo as ClassMetadataInfo;

/* @var ClassMetadataInfo $metadata */
$metadata->setPrimaryTable(['name' => 'test_php']);
$metadata->mapField([
    'id' => true,
    'fieldName' => 'id',
    'type' => 'string',
]);

$metadata->setIdGeneratorType(ClassMetadataInfo::GENERATOR_TYPE_UUID);
$metadata->mapField([
    'fieldName' => 'name',
    'type' => 'string',
]);
