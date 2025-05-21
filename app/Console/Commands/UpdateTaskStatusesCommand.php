<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use Carbon\Carbon;

class UpdateTaskStatusesCommand extends Command
{
    protected $signature = 'tasks:update-statuses';
    protected $description = 'Update task statuses based on renewal dates';

    public function handle(): void
    {
        $now = Carbon::now()->startOfDay();
        $twoWeeksFromNow = $now->copy()->addDays(14);

        Task::whereDate('renewal_date', '<', $now)
            ->where('status', '!=', 'Overdue')
            ->whereNotIn('status', ['Completed', 'Not Interested'])
            ->update(['status' => 'Overdue']);

        Task::whereBetween('renewal_date', [$now, $twoWeeksFromNow])
            ->whereNotIn('status', ['Completed', 'Not Interested'])
            ->update(['status' => 'Upcoming']);

        $this->info('Task statuses updated.');
    }
}
