<?php

namespace EOffice\User\Providers;

use EOffice\User\Contracts\UserManagerInterface;
use EOffice\User\Contracts\UserRepositoryInterface;
use EOffice\User\Repository\UserRepository;
use EOffice\User\Service\UserManager;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $app = $this->app;

        $app->register(RouteServiceProvider::class);
        $this->loadMigrationsFrom(__DIR__.'/../Resources/database');
        $this->loadServices($app);
    }

    private function loadServices(Application $app)
    {
        $app->singleton(UserManagerInterface::class, function(Application $app){
            return UserManager::factory($app);
        });
        $app->singleton(UserRepositoryInterface::class, UserRepository::class);
    }
}
