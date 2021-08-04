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

use EOffice\Components\Resource\Contracts\ResourceInterface;
use EOffice\Components\User\Model\ResourceTrait;

class TestResource implements ResourceInterface
{
    use ResourceTrait;

    public function __construct($id = null)
    {
        $this->id = $id;
    }
}
