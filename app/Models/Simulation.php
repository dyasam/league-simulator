<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Simulation extends Model
{
    use HasFactory;

    protected $fillable = [
        'uid',
    ];

    protected $appends = ['prediction'];

    protected $prediction = null;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uid = (string) Str::uuid();
        });
    }

    public function standings()
    {
        return $this->hasMany(Standing::class)
            ->orderByDesc('points')
            ->orderByDesc('goal_difference')
            ->orderByDesc('goals_for');
    }

    public function games()
    {
        return $this->hasMany(Game::class);
    }

    public function getRouteKeyName(): string
    {
        return 'uid';
    }

    public function setPrediction(array $data)
    {
        $this->prediction = $data;
    }

    public function getPrediction()
    {
        return $this->prediction;
    }


}
