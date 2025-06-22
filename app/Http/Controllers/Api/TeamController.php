<?php

namespace App\Http\Controllers\Api;

use App\Contracts\TeamRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Resources\TeamResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function __construct(protected TeamRepositoryInterface $teamRepository)
    {}

    /**
     * Display a listing of the teams.
     */
    public function index(Request $request): JsonResponse
    {
        $teams = $this->teamRepository->all();

        return response()->success(
            TeamResource::collection($teams)
        );
    }
}
