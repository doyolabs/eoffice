<?php

namespace EOffice\User\Tests\Feature;

use EOffice\Core\Test\TestCase;
use EOffice\User\Model\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_servers_can_be_created()
    {
        $this->assertFalse($this->isAuthenticated());
    }
}
