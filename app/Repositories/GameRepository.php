<?php

namespace App\Repositories;

use App\Models\Game;
use App\Models\Simulation;

class GameRepository
{
    public function create(array $data): Game
    {
        return Game::create($data);
    }

    public function update(Game $game, array $data): Game
    {
        $game->update($data);

        return $game;
    }
}
