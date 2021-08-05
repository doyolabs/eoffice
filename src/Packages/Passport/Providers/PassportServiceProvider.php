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

namespace EOffice\Packages\Passport\Providers;

use EOffice\Packages\Doctrine\Doctrine;
use EOffice\Packages\Passport\Contracts\AccessTokenInterface;
use EOffice\Packages\Passport\Contracts\AuthCodeInterface;
use EOffice\Packages\Passport\Contracts\ClientInterface;
use EOffice\Packages\Passport\Model\AccessToken;
use EOffice\Packages\Passport\Model\AuthCode;
use EOffice\Packages\Passport\Model\Client;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use Laravel\Passport\PassportServiceProvider as LaravelPassportServiceProvider;

/**
 * @psalm-suppress MixedOperand
 */
class PassportServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->app->register(LaravelPassportServiceProvider::class);
        Passport::ignoreMigrations();
        $this->configureDoctrine();
    }

    private function configureDoctrine(): void
    {
        $mappings = [
            'EOffice\\Packages\\Passport\\Model' => [
                'dir' => realpath(__DIR__.'/../Model'),
            ],
        ];
        $configKey = 'doctrine.managers.'.config('eoffice.orm.manager_name', 'default').'.mappings';
        config([
            $configKey => array_merge(
                $mappings,
                (array) config($configKey, [])
            ),
        ]);

        Doctrine::resolveTargetEntity(ClientInterface::class, Client::class);
        Doctrine::resolveTargetEntity(AuthCodeInterface::class, AuthCode::class);
        Doctrine::resolveTargetEntity(AccessTokenInterface::class, AccessToken::class);
    }
}
