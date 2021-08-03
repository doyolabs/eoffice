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

namespace EOffice\Components\User\Contracts;

interface UserInterface
{
    public function setType(int $type): void;

    public function getType(): int;

    public function setNama(string $nama);

    public function getNama(): string;

    public function setEmail(?string $email): void;

    public function getEmail(): ?string;

    public function setUsername(?string $username): void;

    public function getUsername(): ?string;

    public function setNIP(?string $nip): void;

    public function getNIP(): ?string;
}
