<?php

namespace App\Enums;

enum RoleEnum: int
{
    case ADMIN = 1;
    case USER = 2;
    case DIRECTOR = 3;
    case HR = 4;
}
