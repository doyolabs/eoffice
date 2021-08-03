<?php

/*
 * This file is part of the EOffice project.
 * (c) Anthonius Munthi <https://itstoni.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace EOffice\Core\Providers;

use EOffice\Surat\Providers\SuratServiceProvider;
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
        $app->register(SuratServiceProvider::class);
    }
}
