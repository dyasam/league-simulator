<?php

use App\Http\Controllers\Api\SimulationController;
use App\Http\Controllers\Api\TeamController;
use Illuminate\Support\Facades\Route;

Route::get('/teams', [TeamController::class, 'index'])
    ->name('teams.index');

Route::prefix('/simulations')
    ->name('simulations.')
    ->group(function () {
        Route::post('/', [SimulationController::class, 'store'])
            ->name('store');
        Route::post('/{simulation}/play-next-week', [SimulationController::class, 'playNextWeek'])
            ->name('play-next-week');
        Route::post('/{simulation}/play-all', [SimulationController::class, 'playAll'])
            ->name('play-all');
    }
    );
