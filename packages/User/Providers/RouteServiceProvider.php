<?php

namespace EOffice\User\Providers;

use EOffice\Core\Contracts\HasApiRoutes;
use EOffice\Core\Providers\RouteServiceProvider as BaseRouteServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends BaseRouteServiceProvider implements HasApiRoutes
{
    protected $namespace = "EOffice\\User\\Controller";

    public function getApiRoutesPath(): string
    {
        return realpath(__DIR__.'/../Resources/routes/api.php');
    }
}
