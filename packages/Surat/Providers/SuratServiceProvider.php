<?php

namespace EOffice\Surat\Providers;

use Illuminate\Support\ServiceProvider;

class SuratServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->register(RouteServiceProvider::class);
    }
}
