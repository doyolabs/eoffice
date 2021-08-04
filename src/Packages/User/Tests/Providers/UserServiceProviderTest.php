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

namespace EOffice\Packages\User\Tests\Providers;

use EOffice\Components\User\Contracts\CanonicalizerInterface;
use EOffice\Components\User\Util\CanonicalFieldsUpdater;
use EOffice\Packages\Core\Test\TestCase;
use EOffice\Packages\User\Providers\UserServiceProvider;

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
