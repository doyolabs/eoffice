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

namespace EOffice\Packages\Core\Providers;

use EOffice\Packages\Doctrine\Providers\DoctrineServiceProvider;
use Illuminate\Support\ServiceProvider;

class EOfficeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadProviders();
    }

    private function loadProviders()
    {
        $app = $this->app;
        $app->register(DoctrineServiceProvider::class);
    }
}