<?php

/*
 * This file is part of the EOffice project.
 * (c) Anthonius Munthi <https://itstoni.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace EOffice\Surat\Providers;

use EOffice\Core\Contracts\HasApiRoutes;
use EOffice\Core\Providers\RouteServiceProvider as BaseRouteServiceProvider;

class RouteServiceProvider extends BaseRouteServiceProvider implements HasApiRoutes
{
    protected $namespace = 'EOffice\\Surat\\Controller';

    public function getApiRoutesPath(): string
    {
        return realpath(__DIR__.'/../Resources/routes/api.php');
    }
}
