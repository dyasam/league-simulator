<?php

namespace App\Providers;

use App\Contracts\TeamRepositoryInterface;
use App\Models\Game;
use App\Observers\GameObserver;
use App\Repositories\TeamRepository;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(TeamRepositoryInterface::class, TeamRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Game::observe(GameObserver::class);

        Response::macro('success', function ($data = [], $message = 'success', $status = 200) {
            return response()->json([
                'status' => true,
                'message' => $message,
                'data' => $data
            ], $status);
        });

        Response::macro('error', function ($data = [], $message = 'Failed', $status = 400) {
            return response()->json([
                'status' => false,
                'message' => $message,
                'data' => $data
            ], $status);
        });
    }
}
