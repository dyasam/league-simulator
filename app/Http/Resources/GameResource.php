<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'home_team' => [
                'name' => $this->homeTeam->name,
            ],
            'away_team' => [
                'name' => $this->awayTeam->name,
            ],
            'home_team_score' => $this->home_team_score,
            'away_team_score' => $this->away_team_score,
            'week' => $this->week,
        ];
    }
}
