<?php

namespace App\Services\Game;

use App\Models\Game;
use Illuminate\Support\Str;
use App\Constants\GamesFiles;
use App\Models\Games\Category;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Query\Builder;
use App\DataTransfer\Admin\Games\GameDTO;
use Illuminate\Database\Eloquent\Collection;
use App\Services\Filesystem\FilesystemService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class GameService
{
    public function __construct(
        //Services
        private readonly FilesystemService $filesystemService,
        //Models
        private readonly Category $gamesCategoriesModel,
        private readonly Game $gameModel
    ) {}

    public function getCategories(): Collection
    {
        $query = $this->gamesCategoriesModel->newQuery();

        return $query->get();
    }

    public function findCategory(string $categoryId): ?Category
    {
        $query = $this->gamesCategoriesModel->newQuery();

        /** @var ?Category $category */
        $category = $query->with("games")->whereHas('games', function ($query) {
            $query->where('game_visible', true);
        })->where("category_uuid", $categoryId)->first();

        return $category;
    }

    public function getAllPaginatedGames(bool $showOnlyVisible = true): LengthAwarePaginator
    {
        $query = $this->gameModel->newQuery();

        if ($showOnlyVisible) {
            $query->where('game_visible', true);
        }

        return $query->orderByDesc('game_visible')->paginate();
    }

    public function getAllGames(): Collection
    {
        $query = $this->gameModel->newQuery();

        return $query->where('game_visible', true)->orderByDesc('game_visible')->get();
    }

    public function searchGame(string $name): LengthAwarePaginator
    {
        $query = $this->gameModel->newQuery();

        return $query->where('game_visible', true)
            ->whereRaw('LOWER(`game_name`) LIKE ?', ['%' . strtolower($name) . '%'])
            ->paginate();
    }

    public function findGame(string $id): ?Game
    {
        $query = $this->gameModel->newQuery();

        return $query->where("game_uuid", $id)->first();
    }

    public function updateGame(Game $game, GameDTO $updatedData): Game
    {
        $game->game_name = $updatedData->name;
        $game->game_description = $updatedData->description;
        $game->game_visible = $updatedData->isVisible;

        $game->save();

        return $game;
    }

    public function create(GameDTO $gameData): Game
    {
        $game = $this->gameModel->newInstance();

        $game->game_uuid = Str::uuid();
        $game->game_name = $gameData->name;
        $game->game_description = $gameData->description;

        $game->game_active = true;
        $game->game_visible = $gameData->isVisible;

        if (!is_null($gameData->cover)) {
            $imageName = time() . '.' . $gameData->cover->extension();
            $gameData->cover->move(public_path('uploads/game_image'), $imageName);
            $game->game_image = 'uploads/game_image/' . $imageName;
        }
    
        $game->save();

        return $game;
    }

    public function saveGameCover(UploadedFile $file, string $gameName): string
    {
        $uniqueFileName = time() . "_" . $gameName;

        $filePath = sprintf(GamesFiles::GAME_COVER, $uniqueFileName, $file->getClientOriginalExtension());

        $this->filesystemService->save($filePath, $file->getContent());

        return $filePath;
    }
}
