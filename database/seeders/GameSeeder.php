<?php

namespace Database\Seeders;

use App\Models\Game;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $game = Game::where("game_name", "Test Game")->first();

        if (is_null($game)) {
            Game::create([
                'game_uuid'    => Str::uuid(),
                'game_name'    => "Test Game",
                'game_active'  => true,
                'game_visible' => false
            ]);
        }
    }
}
