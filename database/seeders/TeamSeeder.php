<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teams = [
            [
                'name' => 'Manchester City',
                'power' => 98,
                'attack_power' => 97,
                'defense_power' => 95,
                'home_advantage' => 6,
                'supporter_strength' => 92,
            ],
            [
                'name' => 'Liverpool',
                'power' => 93,
                'attack_power' => 91,
                'defense_power' => 89,
                'home_advantage' => 7,
                'supporter_strength' => 95,
            ],
            [
                'name' => 'Newcastle United',
                'power' => 85,
                'attack_power' => 83,
                'defense_power' => 82,
                'home_advantage' => 5,
                'supporter_strength' => 80,
            ],
            [
                'name' => 'Chelsea',
                'power' => 78,
                'attack_power' => 75,
                'defense_power' => 74,
                'home_advantage' => 5,
                'supporter_strength' => 78,
            ],
        ];

        foreach ($teams as $team) {
            Team::create($team);
        }
    }
}
