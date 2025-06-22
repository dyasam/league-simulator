<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Standing extends Model
{
    use HasFactory;

    protected $fillable = [
        'simulation_id',
        'team_id',
        'played',
        'wins',
        'draws',
        'losses',
        'goals_for',
        'goals_against',
        'goal_difference',
        'points',
    ];

    public function simulation()
    {
        return $this->belongsTo(Simulation::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
