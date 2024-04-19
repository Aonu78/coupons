<?php

namespace Database\Seeders;

use App\Enum\Users\UserType;
use App\Services\User\UserService;
use App\DataTransfer\User\CreateUserDTO;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

final class AdminSeeder extends Seeder
{
    const EMAIL = "admin@system.com";
    const PASSWORD = "aqswdefr1";

    public function __construct(private readonly UserService $userService) {}

    /**
     * Run the database seeds.
     * @throws \Exception
     */
    public function run(): void
    {
        $user = $this->userService->findByLogin(self::EMAIL);

        if (is_null($user)) {
            $this->userService->create(new CreateUserDTO(
                "System Admin",
                self::EMAIL,
                "+111111111",
                self::PASSWORD,
                UserType::ADMIN
            ));

            echo "System Admin has been created\n";
        } else {
            echo "System Admin already exists\n";
        }
    }
}
