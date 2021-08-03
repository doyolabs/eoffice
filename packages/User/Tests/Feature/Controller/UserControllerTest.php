<?php

namespace EOffice\User\Tests\Feature\Controller;

use EOffice\User\Contracts\UserManagerInterface;
use EOffice\User\Controller\UserController;
use EOffice\Core\Test\TestCase;
use EOffice\User\Model\User;
use EOffice\User\Request\CreateUserRequest;
use EOffice\User\Service\UserManager;
use Illuminate\Foundation\Testing\Concerns\InteractsWithContainer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Laravel\Passport\Passport;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_handles_user_registration()
    {
        /* @var \EOffice\User\Contracts\UserManagerInterface $userManager */
        $userManager = app()->get(UserManagerInterface::class);
        $user = $userManager->create([
            'nama' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@example.org',
            'password' => 'admin'
        ]);

        $this->assertInstanceOf(User::class, $user);
        Passport::actingAs($user);

        $response = $this->post('/api/user',[
            'nama' => 'Test User',
            'username' => 'user',
            'email' => 'user@test.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ]);
        $response->assertStatus(200);
        $data = $response->getData();
        $this->assertNotNull($data->id);
        $this->assertSame('Test User', $data->nama);
    }
}
