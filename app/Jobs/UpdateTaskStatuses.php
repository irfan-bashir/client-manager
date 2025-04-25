<?php

namespace App\Jobs;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateTaskStatuses implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
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
    }
}
