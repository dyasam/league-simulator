<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'power' => $this->power,
            'home_advantage' => $this->home_advantage,
            'supporter_strength' => $this->supporter_strength,
            'attack_power' => $this->attack_power,
            'defense_power' => $this->defense_power,
        ];
    }
}
