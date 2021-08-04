<?php

namespace EOffice\Packages\User\Contracts;

use EOffice\Components\User\Contracts\UserInterface as BaseUserInterface;
use Illuminate\Contracts\Auth\Authenticatable;

interface UserInterface extends
    BaseUserInterface,
    Authenticatable
{

}
