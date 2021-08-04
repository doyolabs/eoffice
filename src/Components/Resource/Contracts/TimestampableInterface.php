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

namespace EOffice\Components\Resource\Contracts;

interface TimestampableInterface
{
    public function getCreatedAt(): ?\DateTimeInterface;

    /** @psalm-suppress MissingReturnType */
    public function setCreatedAt(?\DateTimeInterface $createdAt);

    public function getUpdatedAt(): ?\DateTimeInterface;

    /** @psalm-suppress MissingReturnType */
    public function setUpdatedAt(?\DateTimeInterface $updatedAt);
}
