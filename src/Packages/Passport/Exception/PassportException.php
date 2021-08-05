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

namespace EOffice\Packages\Passport\Exception;

class PassportException extends \Exception
{
    public static function create(string $message): self
    {
        return new self($message);
    }

    public static function clientNotFound(string $id): self
    {
        return new self(sprintf(
            'Passport client with id: "%s" not found.',
            $id
        ));
    }
}
