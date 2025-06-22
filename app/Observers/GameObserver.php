<?php

namespace App\Observers;

use App\Models\Game;
use App\Services\StandingService;

class GameObserver
{
    public function __construct(protected StandingService $standingService)
    {}

    /**
     * Handle the Game "updated" event.
     */
    public function updated(Game $game): void
    {
        if ($game->is_simulated && $game->wasChanged(['home_team_score', 'away_team_score'])) {
            $this->standingService->updateByGame($game);
        }
    }
}
