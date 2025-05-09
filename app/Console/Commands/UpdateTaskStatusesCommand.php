<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use Carbon\Carbon;

class UpdateTaskStatusesCommand extends Command
{
    protected $signature = 'tasks:update-statuses';
    protected $description = 'Update task statuses based on renewal date';

    public function handle()
    {
        $now = Carbon::now()->startOfDay();
        $twoWeeksFromNow = $now->copy()->addDays(14);

        // Set status to "Overdue" for expired tasks
        Task::whereDate('renewal_date', '<', $now)
            ->where('status', '!=', 'Overdue')
            ->update(['status' => 'Overdue']);

        // Set status to "Upcoming" for tasks due in next 14 days
        Task::whereBetween('renewal_date', [$now, $twoWeeksFromNow])
            ->whereNotIn('status', ['Completed', 'Not Interested'])
            ->update(['status' => 'Upcoming']);

        $this->info('Task statuses updated successfully.');
    }
}
