<?php

namespace EOffice\Core\Providers;

use EOffice\Core\Contracts\HasApiRoutes;
use EOffice\Core\Contracts\HasWebRoutes;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as BaseRouteServiceProvider;
use Illuminate\Support\Facades\Route;

abstract class RouteServiceProvider extends BaseRouteServiceProvider
{
    public function boot()
    {
        $that = $this;
        $namespace = $this->namespace;
        $this->routes(function() use($that, $namespace){
            if($that instanceof HasApiRoutes){
                Route::prefix('api')
                    ->middleware('auth:api')
                    ->namespace($namespace)
                    ->group($that->getApiRoutesPath());
            }
            if($that  instanceof HasWebRoutes){
                Route::prefix('web')
                    ->namespace($namespace)
                    ->group($that->getWebRoutesPath());
            }
        });
    }
}
