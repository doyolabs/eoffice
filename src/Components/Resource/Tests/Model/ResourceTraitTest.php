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

class ResourceTraitTest extends TestCase
{
    public function testItsIdShouldBeReadable()
    {
        $ob = new TestResource();
        $this->assertNull($ob->getId());

        $ob = new TestResource($id = 'test-id');
        $this->assertSame($id, $ob->getId());
    }
}
