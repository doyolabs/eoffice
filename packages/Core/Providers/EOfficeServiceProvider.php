<?php

namespace EOffice\Core\Providers;

use EOffice\User\Providers\AuthServiceProvider;
use EOffice\User\Providers\UserServiceProvider;
use Illuminate\Support\ServiceProvider;

class EOfficeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $app = $this->app;

        $app->register(AuthServiceProvider::class);
        $app->register(UserServiceProvider::class);
    }
}
