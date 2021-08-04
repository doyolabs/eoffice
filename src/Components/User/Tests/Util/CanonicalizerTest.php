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
        $ob     = new Canonicalizer();
        $result = $ob->canonicalize('tEsTsTrInG');
        $this->assertSame('teststring', $result);
    }
}
