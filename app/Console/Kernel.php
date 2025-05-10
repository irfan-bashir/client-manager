<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        // ✅ Schedule your commands here
        $schedule->command('tasks:update-statuses')->everyMinute();
        $schedule->command('tasks:send-reminders')->everyMinute();
    }

    protected function commands(): void
    {
        // ✅ This loads your custom command classes automatically
        $this->load(__DIR__ . '/Commands');

        // ✅ Also loads console routes (optional, but standard)
        require base_path('routes/console.php');
    }
}
