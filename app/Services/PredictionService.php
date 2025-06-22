<?php

namespace App\Services;

use App\Models\Simulation;
use App\Services\Support\GameSimulator;

class PredictionService
{
    public function __construct(
        protected GameSimulator $gameSimulator,
    ) {}

    public function calculate(Simulation $simulation, int $iterations = 1000): array
    {
        $teams = $simulation->standings->pluck('team')->keyBy('id');
        $basePoints = $simulation->standings->pluck('points', 'team_id');

        $remainingGames = $simulation->games()
            ->where('is_simulated', false)
            ->with('homeTeam', 'awayTeam')
            ->get();

        $championCounts = collect($teams)->mapWithKeys(fn($team, $id) => [$id => 0])->toArray();

        for ($i = 0; $i < $iterations; $i++) {
            $points = $basePoints->toArray();

            foreach ($remainingGames as $game) {
                [$homeGoals, $awayGoals] = $this->gameSimulator->simulate($game);

                if ($homeGoals > $awayGoals) {
                    $points[$game->home_team_id] += 3;
                } elseif ($homeGoals < $awayGoals) {
                    $points[$game->away_team_id] += 3;
                } else {
                    $points[$game->home_team_id] += 1;
                    $points[$game->away_team_id] += 1;
                }
            }

            $maxPoints = max($points);
            $topTeams = array_keys(array_filter($points, fn($pts) => $pts === $maxPoints));

            $championId = $topTeams[array_rand($topTeams)];
            $championCounts[$championId]++;
        }

        $results = [];
        foreach ($championCounts as $teamId => $count) {
            $results[] = [
                'name' => $teams[$teamId]->name,
                'champion_probability' => round(($count / $iterations) * 100, 2)
            ];
        }

        return collect($results)->sortByDesc('champion_probability')->values()->toArray();
    }
}
