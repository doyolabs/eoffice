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

namespace EOffice\Packages\User\Model;

use Doctrine\ORM\Mapping as ORM;
use EOffice\Components\User\Model\User as BaseUser;
use EOffice\Packages\User\Contracts\UserInterface;
use Laravel\Passport\HasApiTokens;

/**
 * @ORM\Entity
 * @ORM\Table(name="eoffice_user")
 */
class User extends BaseUser implements UserInterface
{
    use Authenticatable;
    use HasApiTokens;

    /**
     * @ORM\Column(name="id", type="string")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected ?string $id;
}
