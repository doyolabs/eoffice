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

namespace EOffice\Packages\Core\Tests\Providers;

use EOffice\Packages\Core\Test\TestCase;

/**
 * @covers \EOffice\Packages\Core\Providers\EOfficeServiceProvider
 */
class EOfficeServiceProviderTest extends TestCase
{
    public function testBoot()
    {
        $app = $this->app;

        $this->assertTrue($app->isBooted());
    }
}
