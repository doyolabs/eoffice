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

namespace EOffice\Components\User\Model;

use EOffice\Components\Resource\Model\TimestampableTrait;
use EOffice\Components\Resource\Model\ToggleableTrait;
use EOffice\Components\User\Contracts\UserInterface;

abstract class User implements UserInterface
{
    use TimestampableTrait;
    use ToggleableTrait;

    protected ?string $email = null;

    protected ?string $emailCanonical = null;

    protected ?string $username = null;

    protected ?string $usernameCanonical = null;

    protected ?string $plainPassword = null;

    protected ?string $password = null;

    protected ?string $emailVerificationToken = null;

    protected ?string $passwordResetToken = null;

    /**
     * @return string|null
     */
    public function getEmailCanonical(): ?string
    {
        return $this->emailCanonical;
    }

    /**
     * @param string|null $emailCanonical
     */
    public function setEmailCanonical(?string $emailCanonical): void
    {
        $this->emailCanonical = $emailCanonical;
    }

    /**
     * @return string|null
     */
    public function getUsernameCanonical(): ?string
    {
        return $this->usernameCanonical;
    }

    /**
     * @param string|null $usernameCanonical
     */
    public function setUsernameCanonical(?string $usernameCanonical): void
    {
        $this->usernameCanonical = $usernameCanonical;
    }

    /**
     * @return string|null
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * @param string|null $plainPassword
     */
    public function setPlainPassword(?string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     */
    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string|null
     */
    public function getEmailVerificationToken(): ?string
    {
        return $this->emailVerificationToken;
    }

    /**
     * @param string|null $emailVerificationToken
     */
    public function setEmailVerificationToken(?string $emailVerificationToken): void
    {
        $this->emailVerificationToken = $emailVerificationToken;
    }

    /**
     * @return string|null
     */
    public function getPasswordResetToken(): ?string
    {
        return $this->passwordResetToken;
    }

    /**
     * @param string|null $passwordResetToken
     */
    public function setPasswordResetToken(?string $passwordResetToken): void
    {
        $this->passwordResetToken = $passwordResetToken;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string|null $username
     */
    public function setUsername(?string $username): void
    {
        $this->username = $username;
    }
}
