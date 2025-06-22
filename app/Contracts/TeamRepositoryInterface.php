<?php

namespace App\Contracts;

use Illuminate\Support\Collection;

interface TeamRepositoryInterface
{
    public function all(): Collection;
}
