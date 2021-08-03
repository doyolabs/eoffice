<?php

/*
 * This file is part of the EOffice project.
 * (c) Anthonius Munthi <https://itstoni.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace EOffice\Core\Providers;

use EOffice\Core\Contracts\HasApiRoutes;
use EOffice\Core\Contracts\HasWebRoutes;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as BaseRouteServiceProvider;
use Illuminate\Support\Facades\Route;

abstract class RouteServiceProvider extends BaseRouteServiceProvider
{
    public function boot()
    {
        $that      = $this;
        $namespace = $this->namespace;
        $this->routes(function () use ($that, $namespace) {
            if ($that instanceof HasApiRoutes) {
                Route::prefix('api')
                    ->middleware('auth:api')
                    ->namespace($namespace)
                    ->group($that->getApiRoutesPath());
            }
            if ($that  instanceof HasWebRoutes) {
                Route::prefix('web')
                    ->namespace($namespace)
                    ->group($that->getWebRoutesPath());
            }
        });
    }
}
