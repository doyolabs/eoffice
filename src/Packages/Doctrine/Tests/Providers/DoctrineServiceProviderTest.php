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

namespace EOffice\Packages\Doctrine\Tests\Providers;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use EOffice\Packages\Doctrine\Service\MetadataConfigurator;
use EOffice\Packages\Doctrine\Tests\TestCase;

/**
 * @covers \EOffice\Packages\Doctrine\Providers\DoctrineServiceProvider
 */
class DoctrineServiceProviderTest extends TestCase
{
    public function testShouldLoadMetadataConfigurator()
    {
        $object = $this->app->get(MetadataConfigurator::class);
        $this->assertIsObject($object);
    }

    public function testShouldHandleRegister()
    {
        $config = config('doctrine.managers.default.connection');
        $this->assertSame('sqlite', $config);

        $em = $this->app->get(EntityManagerInterface::class);
        $this->assertIsObject($em);
        $this->assertInstanceOf(EntityManager::class, $em);
    }
}
