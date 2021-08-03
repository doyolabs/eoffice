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

namespace EOffice\Packages\Doctrine\Tests\Fixtures\Contracts;

interface UserInterface
{
    /**
     * @param string $username
     *
     * @return static
     */
    public function setUsername(string $username);

    /**
     * @return string
     */
    public function getUsername();

    /**
     * @param string $password
     *
     * @return static
     */
    public function setPassword(string $password);

    /**
     * @return string
     */
    public function getPassword();
}
