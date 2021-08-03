<?php

/*
 * This file is part of the EOffice project.
 * (c) Anthonius Munthi <https://itstoni.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace EOffice\User\Tests\Feature;

use EOffice\Core\Test\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @covers \EOffice\User\Controller\UserController
 */
class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function testServersCanBeCreated()
    {
        $this->assertFalse($this->isAuthenticated());
    }
}
