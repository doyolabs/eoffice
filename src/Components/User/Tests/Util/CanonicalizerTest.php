<?php

namespace EOffice\Components\User\Tests\Util;

use EOffice\Components\User\Contracts\CanonicalizerInterface;
use EOffice\Components\User\Util\Canonicalizer;
use PHPUnit\Framework\TestCase;

class CanonicalizerTest extends TestCase
{
    public function testItImplementsCanonicalizerInterface()
    {
        $ob = new Canonicalizer();
        $this->assertInstanceOf(CanonicalizerInterface::class, $ob);
    }

    public function testItConvertsStringsToLowerCase()
    {
        $ob = new Canonicalizer();
        $result = $ob->canonicalize('tEsTsTrInG');
        $this->assertSame("teststring", $result);
    }
}
