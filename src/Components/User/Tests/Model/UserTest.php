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

namespace EOffice\Components\User\Tests\Model;

use PHPUnit\Framework\TestCase;

/**
 * @covers \EOffice\Components\User\Model\User
 */
class UserTest extends TestCase
{
    public function testItsUsernameShouldBeMutable()
    {
        $ob = new TestUser();

        $this->assertNull($ob->getUsername());

        $ob->setUsername('foo');
        $this->assertSame('foo', $ob->getUsername());
    }

    public function testItsUsernameCanonicalShouldBeMutable()
    {
        $ob = new TestUser();

        $this->assertNull($ob->getUsernameCanonical());

        $ob->setUsernameCanonical($name='test');
        $this->assertSame($name, $ob->getUsernameCanonical());
    }

    public function testItsEmailShouldBeMutable()
    {
        $ob = new TestUser();

        $this->assertNull($ob->getEmail());

        $ob->setEmail($email = 'test@foobar.org');
        $this->assertSame($email, $ob->getEmail());
    }

    public function testItsEmailCanonicalShouldBeMutable()
    {
        $ob = new TestUser();
        $this->assertNull($ob->getEmailCanonical());

        $ob->setEmailCanonical($email = 'test@foo.org');
        $this->assertSame($email, $ob->getEmailCanonical());
    }

    public function testItsPlainPasswordShouldBeMutable()
    {
        $ob = new TestUser();
        $this->assertNull($ob->getPlainPassword());

        $ob->setPlainPassword($password = 'test');
        $this->assertSame($password, $ob->getPlainPassword());
    }

    public function testItsPasswordShouldBeMutable()
    {
        $ob = new TestUser();
        $this->assertNull($ob->getPassword());

        $ob->setPassword($password = 'test');
        $this->assertSame($password, $ob->getPassword());
    }

    public function testItsEmailVerificationTokenShouldBeMutable()
    {
        $ob = new TestUser();
        $this->assertNull($ob->getEmailVerificationToken());

        $ob->setEmailVerificationToken($token = 'token');
        $this->assertSame($token, $ob->getEmailVerificationToken());
    }

    public function testItsPasswordResetTokenShouldBeMutable()
    {
        $ob = new TestUser();
        $this->assertNull($ob->getPasswordResetToken());

        $ob->setPasswordResetToken($token = 'token');
        $this->assertSame($token, $ob->getPasswordResetToken());
    }
}
