<?php

namespace App\Services;

use App\Models\Simulation;
use App\Repositories\GameRepository;
use App\Repositories\TeamRepository;

class FixtureService
{
    public function __construct(
        protected TeamRepository $teamRepository,
        protected GameRepository $gameRepository
    ) {}

    public function generate(Simulation $simulation): void
    {
        $teams = $this->teamRepository->all();
        $teamIds = $teams->pluck('id')->toArray();

        $firstRound = $this->generateFirstRound($teamIds);
        $secondRound = $this->generateSecondRound($firstRound);

        $allRounds = array_merge($firstRound, $secondRound);

        $week = 1;
        foreach ($allRounds as $round) {
            foreach ($round as $game) {
                $this->gameRepository->create([
                    'simulation_id' => $simulation->id,
                    'home_team_id' => $game['home'],
                    'away_team_id' => $game['away'],
                    'week' => $week,
                ]);
            }
            $week++;
        }
    }

    private function generateFirstRound(array $teamIds): array
    {
        shuffle($teamIds);
        $teamCount = count($teamIds);
        $gameCount = $teamCount - 1;
        $half = $teamCount / 2;

        $games = [];

        for ($currentGameCount = 0; $currentGameCount < $gameCount; $currentGameCount++) {
            $weekGames = [];

            for ($i = 0; $i < $half; $i++) {
                $home = $teamIds[$i];
                $away = $teamIds[$teamCount - 1 - $i];

                if ($currentGameCount % 2 == 1 && $i % 2 == 0) {
                    [$home, $away] = [$away, $home];
                }

                $weekGames[] = compact('home', 'away');
            }

            $games[] = $weekGames;

            $fixed = array_shift($teamIds);
            $last = array_pop($teamIds);
            array_unshift($teamIds, $fixed);
            array_splice($teamIds, 1, 0, [$last]);
        }

        return $games;
    }

    private function generateSecondRound(array $firstRound): array
    {
        $secondRound = [];
        $reversed = array_reverse($firstRound);

        foreach ($reversed as $week) {

            $reversedWeek = array_reverse($week);

            $weekGames = [];
            foreach ($reversedWeek as $game) {
                $weekGames[] = [
                    'home' => $game['away'],
                    'away' => $game['home'],
                ];
            }
            $secondRound[] = $weekGames;
        }

        return $secondRound;
    }
}
