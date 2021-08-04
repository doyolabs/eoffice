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

use EOffice\Components\Resource\Contracts\ToggleableInterface;
use EOffice\Components\Resource\Model\ToggleableTrait;

class TestToggleable implements ToggleableInterface
{
    use ToggleableTrait;
}
