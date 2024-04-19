<?php

namespace App\Enum\Users;

enum OtpType: string
{
    case EMAIL = "email";
    case PHONE = "phone_number";
}
