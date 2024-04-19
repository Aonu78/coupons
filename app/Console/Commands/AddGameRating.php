<?php

namespace App\Console\Commands;

use App\Models\Game;
use Illuminate\Console\Command;

class AddGameRating extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'games:rating';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add dummy games rating';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $games = Game::all();

        foreach ($games as $game) {
            $game->game_rating = rand(1, 5);
            $game->save();
        }
    }
}
