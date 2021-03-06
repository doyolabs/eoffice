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

namespace EOffice\Packages\User\Contracts;

use EOffice\Components\User\Contracts\UserInterface as BaseUserInterface;
use Illuminate\Contracts\Auth\Authenticatable;

interface UserInterface extends BaseUserInterface, Authenticatable
{
}
