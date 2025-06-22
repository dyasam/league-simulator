<?php

namespace App\Repositories;

use App\Models\Simulation;
use App\Models\Standing;
use App\Models\Team;

class StandingRepository
{
    public function create(Simulation $simulation, Team $team): Standing
    {
        return Standing::create([
            'simulation_id' => $simulation->id,
            'team_id' => $team->id,
            'played' => 0,
            'wins' => 0,
            'draws' => 0,
            'losses' => 0,
            'goals_for' => 0,
            'goals_against' => 0,
            'goal_difference' => 0,
            'points' => 0,
        ]);
    }

    public function createForAllTeams(Simulation $simulation, iterable $teams): void
    {
        foreach ($teams as $team) {
            $this->create($simulation, $team);
        }
    }

    public function getBySimulationIdAndTeamId(int $simulationId, int $teamId): Standing
    {
        return Standing::where('simulation_id', $simulationId)
            ->where('team_id', $teamId)
            ->firstOrFail();
    }
}
