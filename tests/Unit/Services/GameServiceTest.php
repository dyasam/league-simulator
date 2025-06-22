<?php

namespace Tests\Unit\Services;

use App\Models\Game;
use App\Models\Team;
use App\Repositories\GameRepository;
use App\Services\GameService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class GameServiceTest extends TestCase
{
    use RefreshDatabase;

    protected GameService $gameService;
    protected $gameRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->gameRepository = Mockery::mock(GameRepository::class);
        $this->gameService = new GameService($this->gameRepository);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /**
     * Test that game result is updated successfully.
     */
    public function test_update_result_successfully(): void
    {
        $homeTeam = Team::factory()->create();
        $awayTeam = Team::factory()->create();

        $game = Game::factory()->create([
            'home_team_id' => $homeTeam->id,
            'away_team_id' => $awayTeam->id,
            'home_team_score' => null,
            'away_team_score' => null,
            'is_simulated' => false,
        ]);

        $expectedData = [
            'home_team_score' => 2,
            'away_team_score' => 1,
            'is_simulated' => true,
        ];

        $updatedGame = Game::factory()->make([
            'home_team_score' => 2,
            'away_team_score' => 1,
            'is_simulated' => true,
        ]);
        $updatedGame->id = $game->id;

        $this->gameRepository
            ->shouldReceive('update')
            ->once()
            ->with($game, $expectedData)
            ->andReturn($updatedGame);

        $result = $this->gameService->updateResult($game, 2, 1);

        $this->assertInstanceOf(Game::class, $result);
        $this->assertEquals(2, $result->home_team_score);
        $this->assertEquals(1, $result->away_team_score);
        $this->assertTrue($result->is_simulated);
    }

    /**
     * Test that game result can be updated with zero scores.
     */
    public function test_update_result_with_zero_scores(): void
    {
        $homeTeam = Team::factory()->create();
        $awayTeam = Team::factory()->create();

        $game = Game::factory()->create([
            'home_team_id' => $homeTeam->id,
            'away_team_id' => $awayTeam->id,
            'home_team_score' => null,
            'away_team_score' => null,
            'is_simulated' => false,
        ]);

        $expectedData = [
            'home_team_score' => 0,
            'away_team_score' => 0,
            'is_simulated' => true,
        ];

        $updatedGame = Game::factory()->make([
            'home_team_score' => 0,
            'away_team_score' => 0,
            'is_simulated' => true,
        ]);
        $updatedGame->id = $game->id;

        $this->gameRepository
            ->shouldReceive('update')
            ->once()
            ->with($game, $expectedData)
            ->andReturn($updatedGame);

        $result = $this->gameService->updateResult($game, 0, 0);

        $this->assertInstanceOf(Game::class, $result);
        $this->assertEquals(0, $result->home_team_score);
        $this->assertEquals(0, $result->away_team_score);
        $this->assertTrue($result->is_simulated);
    }

    /**
     * Test that game result can be updated with high scores.
     */
    public function test_update_result_with_high_scores(): void
    {
        $homeTeam = Team::factory()->create();
        $awayTeam = Team::factory()->create();

        $game = Game::factory()->create([
            'home_team_id' => $homeTeam->id,
            'away_team_id' => $awayTeam->id,
            'home_team_score' => null,
            'away_team_score' => null,
            'is_simulated' => false,
        ]);

        $expectedData = [
            'home_team_score' => 5,
            'away_team_score' => 3,
            'is_simulated' => true,
        ];

        $updatedGame = Game::factory()->make([
            'home_team_score' => 5,
            'away_team_score' => 3,
            'is_simulated' => true,
        ]);
        $updatedGame->id = $game->id;

        $this->gameRepository
            ->shouldReceive('update')
            ->once()
            ->with($game, $expectedData)
            ->andReturn($updatedGame);

        $result = $this->gameService->updateResult($game, 5, 3);

        $this->assertInstanceOf(Game::class, $result);
        $this->assertEquals(5, $result->home_team_score);
        $this->assertEquals(3, $result->away_team_score);
        $this->assertTrue($result->is_simulated);
    }

    /**
     * Test that repository is called with correct parameters.
     */
    public function test_repository_called_with_correct_parameters(): void
    {
        $game = Game::factory()->create();
        $homeScore = 3;
        $awayScore = 2;

        $this->gameRepository
            ->shouldReceive('update')
            ->once()
            ->with(
                $game,
                [
                    'home_team_score' => $homeScore,
                    'away_team_score' => $awayScore,
                    'is_simulated' => true,
                ]
            )
            ->andReturn($game);

        $result = $this->gameService->updateResult($game, $homeScore, $awayScore);

        $this->assertInstanceOf(Game::class, $result);
    }
}
