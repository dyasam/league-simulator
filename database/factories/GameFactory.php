<?php

namespace Database\Factories;

use App\Models\Game;
use App\Models\Simulation;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Game>
 */
class GameFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Game::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'simulation_id' => Simulation::factory(),
            'home_team_id' => Team::factory(),
            'away_team_id' => Team::factory(),
            'week' => $this->faker->numberBetween(1, 6),
            'home_team_score' => null,
            'away_team_score' => null,
            'is_simulated' => false,
        ];
    }

    /**
     * Indicate that the game has been simulated.
     */
    public function simulated(): static
    {
        return $this->state(fn (array $attributes) => [
            'home_team_score' => $this->faker->numberBetween(0, 5),
            'away_team_score' => $this->faker->numberBetween(0, 5),
            'is_simulated' => true,
        ]);
    }
}
