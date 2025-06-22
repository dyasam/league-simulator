<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeamControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_lists_all_teams()
    {
        $this->artisan('db:seed', ['--class' => 'TeamSeeder']);

        $response = $this->getJson('/api/teams');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'name',
                        'power',
                        'home_advantage',
                        'supporter_strength',
                        'attack_power',
                        'defense_power'
                    ]
                ]
            ]);
    }
}
