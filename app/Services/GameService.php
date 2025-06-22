<?php

namespace App\Services;

use App\Models\Game;
use App\Repositories\GameRepository;

class GameService
{
    public function __construct(
        protected GameRepository $gameRepository
    ) {}

    public function updateResult(Game $game, int $homeScore, int $awayScore): Game
    {
        return $this->gameRepository->update($game, [
            'home_team_score' => $homeScore,
            'away_team_score' => $awayScore,
            'is_simulated' => true,
        ]);
    }
}
