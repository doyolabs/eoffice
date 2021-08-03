<?php

namespace EOffice\Packages\Core\Test;

use EOffice\Packages\Core\Providers\EOfficeServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            EOfficeServiceProvider::class
        ];
    }
}
