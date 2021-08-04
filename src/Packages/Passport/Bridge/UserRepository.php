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

namespace EOffice\Packages\Passport\Bridge;

use EOffice\Packages\Passport\Contracts\UserManagerInterface;
use Illuminate\Contracts\Hashing\Hasher;
use Laravel\Passport\Bridge\User;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\UserEntityInterface;
use League\OAuth2\Server\Repositories\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    private UserManagerInterface $userManager;
    private Hasher $hasher;

    public function __construct(
        UserManagerInterface $userManager,
        Hasher $hasher
    ) {
        $this->userManager = $userManager;
        $this->hasher      = $hasher;
    }

    public function getUserEntityByUserCredentials($username, $password, $grantType, ClientEntityInterface $clientEntity): ?UserEntityInterface
    {
        $userManager = $this->userManager;
        $user        = $userManager->findByUsername($username);
        if (null === $user) {
            $user = $userManager->findByEmail($username);
        }

        if (null === $user) {
            return null;
        }

        if ($this->hasher->check($password, $user->getPassword())) {
            return new User($user->getId());
        }

        return null;
    }
}
