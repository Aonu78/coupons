<?php

namespace App\DataTransfer\User;

final class UpdateProfileDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $phoneNumber,
        public readonly ?string $avatar = null
    ) {}

    public function hasAvatar(): bool
    {
        return !is_null($this->avatar) && strlen($this->avatar) > 0;
    }

    /*
     * Convert Base64 String to File Content
     * */
    /**
     * @throws \Exception
     */
    public function convertAvatarToFile(): string
    {
        if (!$this->hasAvatar()) {
            throw new \Exception("Avatar is not presented");
        }

        $content = base64_decode($this->avatar);

        if (!$content) {
            throw new \Exception("Failed to convert avatar");
        }

        return $content;
    }
}
