<?php

namespace Database\Factories;

use App\Models\Simulation;
use App\Models\Standing;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Standing>
 */
class StandingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Standing::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $played = $this->faker->numberBetween(0, 6);
        $won = $this->faker->numberBetween(0, $played);
        $drawn = $this->faker->numberBetween(0, $played - $won);
        $lost = $played - $won - $drawn;
        $goalsFor = $this->faker->numberBetween(0, $played * 3);
        $goalsAgainst = $this->faker->numberBetween(0, $played * 3);

        return [
            'simulation_id' => Simulation::factory(),
            'team_id' => Team::factory(),
            'played' => $played,
            'wins' => $won,
            'draws' => $drawn,
            'losses' => $lost,
            'goals_for' => $goalsFor,
            'goals_against' => $goalsAgainst,
            'goal_difference' => $goalsFor - $goalsAgainst,
            'points' => ($won * 3) + ($drawn * 1),
        ];
    }
}
