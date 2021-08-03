<?php

namespace EOffice\Surat\Providers;

use EOffice\Core\Contracts\HasApiRoutes;
use EOffice\Core\Providers\RouteServiceProvider as BaseRouteServiceProvider;

class RouteServiceProvider extends BaseRouteServiceProvider implements HasApiRoutes
{
    protected $namespace = "EOffice\\Surat\\Controller";

    public function getApiRoutesPath(): string
    {
        return realpath(__DIR__.'/../Resources/routes/api.php');
    }
}
