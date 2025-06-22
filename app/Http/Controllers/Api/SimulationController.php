<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\SimulationFinishedException;
use App\Http\Controllers\Controller;
use App\Http\Resources\SimulationResource;
use App\Models\Simulation;
use App\Services\SimulationService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class SimulationController extends Controller
{
    public function __construct(protected SimulationService $simulationService)
    {
    }

    public function store(): JsonResponse
    {
        $simulation = $this->simulationService->create();

        return response()->success(new SimulationResource($simulation));
    }

    public function playNextWeek(Simulation $simulation)
    {
        try {
            $simulation = $this->simulationService->playNextWeek($simulation);

            return response()->success(new SimulationResource($simulation));
        } catch (SimulationFinishedException $e) {
            return response()->error(
                message: $e->getMessage(),
                status: Response::HTTP_BAD_REQUEST
            );
        }
    }

    public function playAll(Simulation $simulation)
    {
        try {
            $simulation = $this->simulationService->playAllWeeks($simulation);

            return response()->success(new SimulationResource($simulation));
        } catch (SimulationFinishedException $e) {
            return response()->error(
                message: $e->getMessage(),
                status: Response::HTTP_BAD_REQUEST
            );
        }
    }
}
