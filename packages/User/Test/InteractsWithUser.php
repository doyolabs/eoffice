<?php

/*
 * This file is part of the EOffice project.
 * (c) Anthonius Munthi <https://itstoni.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace EOffice\User\Test;

use EOffice\User\Contracts\UserManagerInterface;
use EOffice\User\Model\User;
use Illuminate\Support\Facades\Hash;

trait InteractsWithUser
{
    public function iHaveTestUser($username = "test"): User
    {
        $manager = $this->getUserManager();
        $user = $manager->findByUsername($username);
        if(is_null($user)){
            $user = $manager->create([
                "nama" => "Test User",
                "username" => "test",
                "email" => "test@example.com",
                "password" => Hash::make('test')
            ]);
        }
        return $user;
    }

    /**
     * @return UserManagerInterface
     */
    protected function getUserManager()
    {
        return app()->get(UserManagerInterface::class);
    }
}
