<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Make sure the command is scheduled correctly
        $schedule->command('tasks:update-statuses')->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        // Auto-load all commands from the Commands directory
        $this->load(__DIR__ . '/Commands');

        // Load console routes
        require base_path('routes/console.php');
    }
}
