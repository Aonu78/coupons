<?php

namespace App\Enum\Users;

enum UserType: string
{
    case COMPANY = "company";
    case USER = "user";
    case ADMIN = "admin";
    case BOT = "bot";
}
