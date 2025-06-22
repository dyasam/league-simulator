<?php

namespace Tests\Feature\Controllers;

use App\Models\Simulation;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SimulationControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Team::factory()->count(4)->create();
    }

    /**
     * Test that simulation can be created successfully.
     */
    public function test_simulation_can_be_created(): void
    {
        $response = $this->post('/api/simulations');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'message',
            'data' => [
                'uid',
                'standings',
                'games',
            ]
        ]);

        $response->assertJson([
            'status' => true,
            'message' => 'success',
        ]);

        $this->assertDatabaseHas('simulations', [
            'uid' => $response->json('data.uid')
        ]);
    }

    /**
     * Test that next week can be played in a simulation.
     */
    public function test_simulation_can_play_next_week(): void
    {
        $response = $this->post('/api/simulations');

        $simulationUid = $response->json('data.uid');

        $response = $this->post("/api/simulations/{$simulationUid}/play-next-week");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'message',
            'data' => [
                'uid',
                'standings',
                'games',
            ]
        ]);

        $response->assertJson([
            'status' => true,
            'message' => 'success',
        ]);
    }

    /**
     * Test that all weeks can be played in a simulation.
     */
    public function test_simulation_can_play_all_weeks(): void
    {
        $response = $this->post('/api/simulations');

        $simulationUid = $response->json('data.uid');

        $response = $this->post("/api/simulations/{$simulationUid}/play-all");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'message',
            'data' => [
                'uid',
                'standings',
                'games',
            ]
        ]);

        $response->assertJson([
            'status' => true,
            'message' => 'success',
        ]);
    }

    /**
     * Test that playing next week on completed simulation returns error.
     */
    public function test_play_next_week_on_completed_simulation_returns_error(): void
    {
        $simulation = Simulation::factory()->create();

        $this->post("/api/simulations/{$simulation->uid}/play-all");

        $response = $this->post("/api/simulations/{$simulation->uid}/play-next-week");

        $response->assertStatus(400);
        $response->assertJson([
            'status' => false,
        ]);
    }

    /**
     * Test that playing all weeks on completed simulation returns error.
     */
    public function test_play_all_weeks_on_completed_simulation_returns_error(): void
    {
        $simulation = Simulation::factory()->create();

        $this->post("/api/simulations/{$simulation->uid}/play-all");

        $response = $this->post("/api/simulations/{$simulation->uid}/play-all");

        $response->assertStatus(400);
        $response->assertJson([
            'status' => false,
        ]);
    }
}
