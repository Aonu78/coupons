<?php

namespace App\Console\Commands;

use App\Models\Game;
use App\Models\Games\Category;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

class TransferGames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'games:transfer';

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
        $oldGames = DB::table('old_games')->get();

        $categories = Category::all();

        foreach ($oldGames as $oldGame) {
            /** @var Category $attachedCategory */
            $attachedCategory = $categories->random();

            /** @var Game $newGame*/
            $newGame = $attachedCategory->games()->newModelInstance();

            $newGame->game_uuid = $oldGame->game_uuid;
            $newGame->game_name = $oldGame->game_name;
            $newGame->game_description = $oldGame->game_description ?? '';
            $newGame->game_image = $oldGame->game_image;
            $newGame->game_active = true;
            $newGame->game_visible = true;

            $newGame->save();

            $attachedCategory->games()->attach($newGame->id);
        }
    }
}
