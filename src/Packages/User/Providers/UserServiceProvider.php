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

namespace EOffice\Packages\User\Providers;

use EOffice\Components\User\Contracts\CanonicalizerInterface;
use EOffice\Components\User\Util\CanonicalFieldsUpdater;
use EOffice\Components\User\Util\Canonicalizer;
use EOffice\Packages\Doctrine\Doctrine;
use EOffice\Packages\Passport\Providers\PassportServiceProvider;
use EOffice\Packages\User\Contracts\UserInterface;
use EOffice\Packages\User\Model\User;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->register(PassportServiceProvider::class);
        $this->loadServices();
        $this->configureDoctrine();
    }

    public function register()
    {
        $this->configureDoctrine();
    }

    private function loadServices()
    {
        $app = $this->app;

        $app->singleton(CanonicalizerInterface::class, Canonicalizer::class);
        $app->singleton(CanonicalFieldsUpdater::class, CanonicalFieldsUpdater::class);
    }

    private function configureDoctrine()
    {
        $config = $this->app['config'];

        $mappings = [
            'EOffice\\Components\\User\\Model' => [
                'type' => 'xml',
                'dir' => realpath(__DIR__.'/../Resources/doctrine/model'),
            ],
            'EOffice\\Packages\\User\\Model' => [
                'dir' => realpath(__DIR__.'/../Model'),
            ],
        ];

        $configKey = 'doctrine.managers.'.config('eoffice.user.manager_name', 'default').'.mappings';
        config([
            $configKey => array_merge(
                $mappings,
                config($configKey, [])
            ),
        ]);
        Doctrine::resolveTargetEntity(UserInterface::class, User::class, []);
        $config->set('auth.providers.users.model', User::class);
        $config->set('auth.providers.users.driver', 'doctrine');
    }
}
