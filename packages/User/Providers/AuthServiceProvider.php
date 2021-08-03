<?php

/*
 * This file is part of the EOffice project.
 * (c) Anthonius Munthi <https://itstoni.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace EOffice\User\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as BaseServiceProvider;
use Laravel\Passport\Passport;

/**
 * @covers \EOffice\User\Providers\AuthServiceProvider
 */
class AuthServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        $this->registerPolicies();
        Passport::routes();
        Passport::loadKeysFrom(storage_path());
        Passport::hashClientSecrets();
        Passport::tokensExpireIn(now()->addDays(15));
        Passport::refreshTokensExpireIn(now()->addDays(30));
        Passport::personalAccessTokensExpireIn(now()->addMonths(6));
    }
}
