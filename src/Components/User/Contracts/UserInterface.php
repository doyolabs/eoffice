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

use EOffice\Components\Resource\Contracts\ResourceInterface;
use EOffice\Components\Resource\Contracts\TimestampableInterface;
use EOffice\Components\Resource\Contracts\ToggleableInterface;

interface UserInterface extends TimestampableInterface, ToggleableInterface, ResourceInterface
{
    public function setEmail(?string $email): void;

    public function getEmail(): ?string;

    public function setEmailCanonical(?string $emailCanonical): void;

    public function getEmailCanonical(): ?string;

    public function setUsername(?string $username): void;

    public function getUsername(): ?string;

    public function setUsernameCanonical(?string $usernameCanonical): void;

    public function getUsernameCanonical(): ?string;

    public function setPlainPassword(?string $plainPassword): void;

    public function getPlainPassword(): ?string;

    public function setPassword(?string $password): void;

    public function getPassword(): ?string;

    public function setEmailVerificationToken(?string $emailVerificationToken): void;

    public function getEmailVerificationToken(): ?string;

    public function setPasswordResetToken(?string $passwordResetToken): void;

    public function getPasswordResetToken(): ?string;
}
