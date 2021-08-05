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
        $this->app->singleton(TargetEntityResolver::class, TargetEntityResolver::class);
        $this->app->alias(TargetEntityResolver::class, 'eoffice.doctrine.entity_resolver');

        BootChain::add([$this, 'handleOnDoctrineBoot']);
        $this->booted(function (Application $app) {
            /** @var EntityManagerInterface $em */
            $em = $app->get('em');
            $evm = $em->getEventManager();
            $evm->addEventSubscriber($app->get(TargetEntityResolver::class));
        });
    }

    /**
     * @psalm-suppress MixedArgument
     */
    public function register(): void
    {
        $this->mergeConfig();
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

    private function mergeConfig(): void
    {
        $this->mergeConfigFrom(
            realpath(__DIR__.'/../Resources/config/doctrine.php'),
            'doctrine'
        );
    }
}
