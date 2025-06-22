<?php

namespace App\Services\Support;

use App\Models\Game;

class GameSimulator
{
    public function simulate(Game $game): array
    {
        $home = $game->homeTeam;
        $away = $game->awayTeam;

        $weights = [
            'power' => 0.5,
            'home_advantage' => 0.15,
            'supporter_strength' => 0.1,
            'attack_power' => 0.15,
            'defense_power' => 0.1,
        ];

        $homeRating =
            $home->power * $weights['power'] +
            $home->home_advantage * $weights['home_advantage'] +
            $home->supporter_strength * $weights['supporter_strength'] +
            $home->attack_power * $weights['attack_power'] -
            $away->defense_power * $weights['defense_power'];

        $awayRating =
            $away->power * $weights['power'] +
            $away->supporter_strength * $weights['supporter_strength'] +
            $away->attack_power * $weights['attack_power'] -
            $home->defense_power * $weights['defense_power'];

        $homeRating = max(30, min(100, $homeRating));
        $awayRating = max(30, min(100, $awayRating));

        $homeChance = pow($homeRating / 100, 1.5) * 3;
        $awayChance = pow($awayRating / 100, 1.5) * 3;

        $homeGoals = $this->simulateGoals($homeChance);
        $awayGoals = $this->simulateGoals($awayChance);

        return [$homeGoals, $awayGoals];
    }

    private function simulateGoals(float $chance): int
    {
        $threshold = exp(-$chance);
        $goals = 0;
        $probability = 1.0;

        do {
            $goals++;
            $probability *= mt_rand() / mt_getrandmax();
        } while ($probability > $threshold);

        return $goals - 1;
    }
}
