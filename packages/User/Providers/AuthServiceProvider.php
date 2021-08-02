<?php

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
