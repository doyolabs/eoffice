<?php

namespace EOffice\Components\User\Tests\Util;

use EOffice\Components\User\Contracts\CanonicalizerInterface;
use EOffice\Components\User\Contracts\UserInterface;
use EOffice\Components\User\Util\CanonicalFieldsUpdater;
use PHPUnit\Framework\TestCase;

class CanonicalFieldsUpdaterTest extends TestCase
{
    /**
     * @var CanonicalizerInterface|mixed|\PHPUnit\Framework\MockObject\MockObject
     */
    private $canonicalizer;

    private CanonicalFieldsUpdater $updater;

    protected function setUp(): void
    {
        $this->canonicalizer = $this->createMock(CanonicalizerInterface::class);

        $this->canonicalizer
            ->expects($this->any())
            ->method('canonicalize')
            ->willReturnMap([
                ['username', 'username_canonicalized'],
                ['email', 'email_canonicalized'],
                ['string', 'canonicalized']
            ]);

        $this->updater = new CanonicalFieldsUpdater($this->canonicalizer, $this->canonicalizer);
    }

    public function testItShouldCanonicalizeUsername()
    {
        $this->assertSame(
            'canonicalized',
            $this->updater->canonicalizeUsername('string')
        );
    }

    public function testItShouldCanonicalizeEmail()
    {
        $this->assertSame(
            'canonicalized',
            $this->updater->canonicalizeEmail('string')
        );
    }

    public function testItShouldUpdateCanonicalFields()
    {
        $user = $this->createMock(UserInterface::class);
        $user->expects($this->once())
            ->method('getUsername')
            ->willReturn('username');
        $user->expects($this->once())
            ->method('getEmail')
            ->willReturn('email');

        $user->expects($this->once())
            ->method('setUsernameCanonical')
            ->with('username_canonicalized');
        $user->expects($this->once())
            ->method('setEmailCanonical')
            ->with('email_canonicalized');

        $this->updater->updateCanonicalFields($user);
    }
}
