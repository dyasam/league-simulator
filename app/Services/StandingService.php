<?php

namespace App\Services;


use App\Models\Game;
use App\Models\Simulation;
use App\Repositories\StandingRepository;
use App\Repositories\TeamRepository;

class StandingService
{
    public function __construct(
        protected TeamRepository $teamRepository,
        protected StandingRepository $standingRepository
    ) {}

    public function create(Simulation $simulation): void
    {
        $teams = $this->teamRepository->all();

        $this->standingRepository->createForAllTeams($simulation, $teams);
    }

    public function updateByGame(Game $game): void
    {
        $simulationId = $game->simulation_id;

        $homeStanding = $this->standingRepository
            ->getBySimulationIdAndTeamId($simulationId, $game->home_team_id);

        $awayStanding = $this->standingRepository
            ->getBySimulationIdAndTeamId($simulationId, $game->away_team_id);

        $homeGoals = $game->home_team_score;
        $awayGoals = $game->away_team_score;

        $homeStanding->played += 1;
        $awayStanding->played += 1;

        $homeStanding->goals_for += $homeGoals;
        $homeStanding->goals_against += $awayGoals;

        $awayStanding->goals_for += $awayGoals;
        $awayStanding->goals_against += $homeGoals;

        $homeStanding->goal_difference = $homeStanding->goals_for - $homeStanding->goals_against;
        $awayStanding->goal_difference = $awayStanding->goals_for - $awayStanding->goals_against;

        if ($homeGoals > $awayGoals) {
            $homeStanding->wins += 1;
            $homeStanding->points += 3;

            $awayStanding->losses += 1;
        } elseif ($homeGoals < $awayGoals) {
            $awayStanding->wins += 1;
            $awayStanding->points += 3;

            $homeStanding->losses += 1;
        } else {
            $homeStanding->draws += 1;
            $awayStanding->draws += 1;

            $homeStanding->points += 1;
            $awayStanding->points += 1;
        }

        $homeStanding->save();
        $awayStanding->save();
    }
}
