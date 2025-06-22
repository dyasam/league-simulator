<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'power',
        'home_advantage',
        'supporter_strength',
        'attack_power',
        'defense_power',
    ];

    public function standings()
    {
        return $this->hasMany(Standing::class);
    }
}
