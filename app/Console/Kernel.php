<?php

namespace App\Console;

use App\Jobs\UpdateTaskStatuses;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // ⏰ This will run the reminder command daily
        $schedule->command('tasks:update-statuses')->daily();
        $schedule->command('tasks:send-reminders')->daily();
//        $schedule->job(new UpdateTaskStatuses)->daily();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
