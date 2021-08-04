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

namespace EOffice\Packages\Doctrine\Providers;

use Doctrine\ORM\EntityManagerInterface;
use EOffice\Packages\Doctrine\Service\MetadataConfigurator;
use EOffice\Packages\Doctrine\Service\TargetEntityResolver;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use LaravelDoctrine\ORM\BootChain;
use LaravelDoctrine\ORM\DoctrineServiceProvider as LaravelDoctrineServiceProvider;
use LaravelDoctrine\ORM\IlluminateRegistry;
use function PHPUnit\Framework\assertInstanceOf;

/**
 * @psalm-suppress MixedArgument
 * @psalm-suppress MixedAssignment
 */
class DoctrineServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->app->register(LaravelDoctrineServiceProvider::class);
        $this->app->singleton(MetadataConfigurator::class, function (Application $app) {
            $config = $app->get('config');

            return new MetadataConfigurator($config);
        });
        BootChain::add([$this, 'handleOnDoctrineBoot']);
    }

    /**
     * @psalm-suppress MixedArgument
     */
    public function register()
    {
        config([
            'doctrine.extensions' => array_merge(
                [TargetEntityResolver::class], config('doctrine.extensions', [])
            ),
        ]);
        config([
            'doctrine.managers.default.mappings' => array_merge([], config('doctrine.managers.default.mappings', [])),
        ]);
    }

    public function handleOnDoctrineBoot(IlluminateRegistry $registry): void
    {
        $configurator = $this->app->make(MetadataConfigurator::class);
        assertInstanceOf(MetadataConfigurator::class, $configurator);

        foreach ($registry->getManagerNames() as $managerName) {
            $manager = $registry->getManager((string) $managerName);
            assertInstanceOf(EntityManagerInterface::class, $manager);
            $configurator->configure((string) $managerName, $manager);
        }
    }
}
