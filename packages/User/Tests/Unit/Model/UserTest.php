<?php

namespace EOffice\User\Tests\Unit\Model;

use EOffice\User\Database\Factories\UserFactory;
use EOffice\User\Model\User;
use EOffice\Core\Test\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @covers \EOffice\User\Model\User
 */
class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testDefinition()
    {
        $model = new User([
            'nama' => 'test',
            'username' => 'test',
            'password' => 'test',
            'email' => 'test@test.org'
        ]);
        $this->assertInstanceOf(
            UserFactory::class,
            User::factory()
        );
        $this->assertFalse($model->getIncrementing());
        $this->assertSame('string', $model->getKeyType());

        $model->save();
        $this->assertNotNull($model->id);
    }
}
