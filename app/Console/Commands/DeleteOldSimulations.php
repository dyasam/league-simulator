<?php

namespace App\Console\Commands;

use App\Models\Simulation;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DeleteOldSimulations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-old-simulations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all unsaved simulations created 24 hours ago';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            Simulation::where('created_at', '<', Carbon::now()->subHours(24))->each(function ($simulation) {
                $simulation->delete();
            });
        } catch (\Exception $exception) {
            Log::error(
                'Error deleting old simulations: ' . $exception->getMessage(),
                ['exception' => $exception]
            );
        }

        Log::info(
            'Old simulations deletion command executed successfully.'
        );
    }
}
