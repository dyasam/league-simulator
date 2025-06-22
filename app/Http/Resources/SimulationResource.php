<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SimulationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'uid' => $this->uid,
            'games' => $this->games
                ->groupBy('week')
                ->mapWithKeys(fn($games, $week) => [
                    $week => GameResource::collection($games),
                ]),
            'standings' => StandingResource::collection($this->standings),
            'predictions' => $this->getPrediction() ? collect($this->getPrediction())->map(function ($item) {
                return [
                    'team' => [
                        'name' => $item['name'],
                    ],
                    'probability' => $item['champion_probability'],
                ];
            })->values() : null
        ];
    }
}
