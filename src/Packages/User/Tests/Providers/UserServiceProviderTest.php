<?php

namespace EOffice\Packages\User\Tests\Providers;

use EOffice\Components\User\Contracts\CanonicalizerInterface;
use EOffice\Components\User\Util\CanonicalFieldsUpdater;
use EOffice\Packages\User\Providers\UserServiceProvider;
use EOffice\Packages\Core\Test\TestCase;

/**
 * @covers \EOffice\Packages\User\Providers\UserServiceProvider
 */
class UserServiceProviderTest extends TestCase
{
    public function testBoot()
    {
        $app = $this->app;
        $this->assertTrue($app->providerIsLoaded(UserServiceProvider::class));
    }

    public function testItShouldLoadCanonicalFieldsUpdaterService()
    {
        $this->assertTrue($this->app->has(CanonicalizerInterface::class));
        $this->assertTrue($this->app->has(CanonicalFieldsUpdater::class));
    }
}
