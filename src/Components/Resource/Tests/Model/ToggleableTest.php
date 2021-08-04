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

class ToggleableTest extends TestCase
{
    public function testItsEnabledShouldBeMutable()
    {
        $ob = new TestToggleable();

        $this->assertTrue($ob->isEnabled());

        $ob->setEnabled(false);
        $this->assertFalse($ob->isEnabled());

        $ob->enable();
        $this->assertTrue($ob->isEnabled());

        $ob->disable();
        $this->assertFalse($ob->isEnabled());
    }
}
