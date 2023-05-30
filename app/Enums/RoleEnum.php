<?php

declare(strict_types=1);

namespace App\Enums;

enum RoleEnum: int
{
    case USER = 1;
    case ADMIN = 2;
}
