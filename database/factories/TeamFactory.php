<?php

namespace Database\Factories;

use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Team>
 */
class TeamFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Team::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->company() . ' FC',
            'power' => $this->faker->numberBetween(70, 100),
            'attack_power' => $this->faker->numberBetween(70, 100),
            'defense_power' => $this->faker->numberBetween(70, 100),
            'home_advantage' => $this->faker->numberBetween(3, 8),
            'supporter_strength' => $this->faker->numberBetween(70, 100),
        ];
    }
}
