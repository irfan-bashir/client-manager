<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\UpdateTaskStatusesCommand;
use App\Console\Commands\SendTaskReminders;

class Kernel extends ConsoleKernel
{
    /**
     * Register the Artisan commands for the application.
     */
    protected $commands = [
        UpdateTaskStatusesCommand::class,
        SendTaskReminders::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('tasks:update-statuses')->everyMinute();
        $schedule->command('tasks:send-reminders')->daily();
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
