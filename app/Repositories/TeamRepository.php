<?php

namespace App\Repositories;

use App\Contracts\TeamRepositoryInterface;
use App\Models\Team;
use Illuminate\Support\Collection;

class TeamRepository implements TeamRepositoryInterface
{
    public function all(): Collection
    {
        return Team::all();
    }
}
