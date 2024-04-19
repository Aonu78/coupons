<?php

namespace App\Constants;

class UserFiles
{
    const DEFAULT_AVATARS_DIR = "common/default/avatars";
    const USER_AVATAR_FILE_PATH = "user/%s";
    const USER_AVATAR_FILE_NAME = "avatar_%s.png";
    const USER_AVATAR_FULL_NAME = self::USER_AVATAR_FILE_PATH . "/" . self::USER_AVATAR_FILE_NAME;
    const DEFAULT_AVATAR = "https://gmembers.s3.eu-central-1.amazonaws.com/user/3/avatar.png?nocache=1697048336";
}
