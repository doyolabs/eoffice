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

namespace EOffice\Components\Resource\Tests\Model;

use PHPUnit\Framework\TestCase;

/**
 * @covers \EOffice\Components\Resource\Model\TimestampableTrait
 */
class TimestampableTest extends TestCase
{
    public function testItsCreatedAtShouldBeMutable()
    {
        $ob = new TestTimestampable();
        $this->assertNull($ob->getCreatedAt());

        $now = new \DateTime();
        $ob->setCreatedAt($now);
        $this->assertSame($now, $ob->getCreatedAt());
    }

    public function testItsUpdatedAtShouldBeMutable()
    {
        $ob  = new TestTimestampable();
        $now = new \DateTime();

        $this->assertNull($ob->getUpdatedAt());

        $ob->setUpdatedAt($now);
        $this->assertSame($now, $ob->getUpdatedAt());
    }
}
