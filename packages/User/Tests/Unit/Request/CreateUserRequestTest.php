<?php

namespace EOffice\User\Tests\Unit\Request;

use EOffice\User\Request\CreateUserRequest;
use EOffice\Core\Test\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;

/**
 * @covers \EOffice\User\Request\CreateUserRequest
 */
class CreateUserRequestTest extends TestCase
{
    use RefreshDatabase;

    public function testMessages()
    {
        $request = new CreateUserRequest();
        $validator = Validator::make([
            'nama' => 'test',
            'username' => 'test',
            'email' => 'test@email.com',
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ], $request->rules());
        $this->assertTrue($request->authorize());
        $this->assertSame([],$request->messages());
        $this->assertTrue($validator->passes());
    }
}
