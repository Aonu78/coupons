<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

final class AddInviteCodeToUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:invite-code:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::all();

        foreach ($users as $user) {
            $user->invite_code = rand(100000, 999999);
            $user->save();
        }
    }
}
