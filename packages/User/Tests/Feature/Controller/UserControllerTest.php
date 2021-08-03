<?php

/*
 * This file is part of the EOffice project.
 * (c) Anthonius Munthi <https://itstoni.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace EOffice\User\Tests\Feature\Controller;

use EOffice\Core\Test\TestCase;
use EOffice\User\Contracts\UserManagerInterface;
use EOffice\User\Model\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Laravel\Passport\Passport;

/**
 * @covers \EOffice\User\Controller\UserController
 */
class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testItHandlesUserRegistration()
    {
        /** @var \EOffice\User\Contracts\UserManagerInterface $userManager */
        $userManager = app()->get(UserManagerInterface::class);
        $user        = $userManager->create([
            'nama' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@example.org',
            'password' => 'admin',
        ]);

        $this->assertInstanceOf(User::class, $user);
        Passport::actingAs($user);

        $response = $this->post('/api/user', [
            'nama' => 'Test User',
            'username' => 'user',
            'email' => 'user@test.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ]);
        $response->assertCreated();
    }

    public function testItHandlesUserUpdate()
    {

    }
}
