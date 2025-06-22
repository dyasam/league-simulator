<?php

namespace App\Services;

use App\Exceptions\SimulationFinishedException;
use App\Models\Simulation;
use App\Services\Support\GameSimulator;

class SimulationService
{
    public function __construct(
        protected FixtureService $fixtureService,
        protected GameService $gameService,
        protected StandingService $standingService,
        protected PredictionService $predictionService,
        protected GameSimulator $gameSimulator
    ) {}

    public function create(): Simulation
    {
        $simulation = Simulation::create();

        $this->fixtureService->generate($simulation);
        $this->standingService->create($simulation);

        $simulation->load('games.homeTeam', 'games.awayTeam', 'standings');

        return $simulation;
    }

    public function playNextWeek(Simulation $simulation): Simulation
    {
        $nextWeek = $simulation->games()
            ->where('is_simulated', false)
            ->orderBy('week')
            ->pluck('week')
            ->first();

        if (is_null($nextWeek)) {
            throw new SimulationFinishedException('All the matches have been played. The simulation is completed.');
        }

        $games = $simulation->games()
            ->where('week', $nextWeek)
            ->get();

        foreach ($games as $game) {
            [$homeGoals, $awayGoals] = $this->gameSimulator->simulate($game);
            $this->gameService->updateResult($game, $homeGoals, $awayGoals);
        }

        $simulation->load('games.homeTeam', 'games.awayTeam', 'standings');

        if ($nextWeek > 3 && $nextWeek < 6) {
            $prediction = $this->predictionService->calculate($simulation);
            $simulation->setPrediction($prediction);
        }

        return $simulation;
    }

    public function playAllWeeks(Simulation $simulation): Simulation
    {
        $games = $simulation->games()
            ->where('is_simulated', false)
            ->orderBy('week')
            ->get();

        if ($games->isEmpty()) {
            throw new SimulationFinishedException('All the matches have been played. The simulation is completed.');
        }

        foreach ($games as $game) {
            [$homeGoals, $awayGoals] = $this->gameSimulator->simulate($game);

            $this->gameService->updateResult($game, $homeGoals, $awayGoals);
        }

        $simulation->load('games.homeTeam', 'games.awayTeam', 'standings');

        return $simulation;
    }
}
