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

namespace EOffice\Packages\User\Exception;

class UserException extends \Exception
{
    /**
     * @param string|int|null $id
     *
     * @return UserException
     */
    public static function userNotFound($id): self
    {
        return new self(sprintf(
            'Passport user with id: "%s" not found.',
            null === $id ? 'null' : $id
        ));
    }
}
