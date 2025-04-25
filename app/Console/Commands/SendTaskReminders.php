<?php

namespace App\Console\Commands;

use App\Mail\TaskReminderMail;
use Illuminate\Console\Command;
use App\Models\Task;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendTaskReminders extends Command
{
    protected $signature = 'tasks:send-reminders';
    protected $description = 'Send reminders for upcoming task renewals';

    public function handle()
    {
        $upcoming = Carbon::now()->addDays(3)->startOfDay();
        $tasks = Task::whereDate('renewal_date', $upcoming)
            ->where('send_reminder', true)
            ->get();

        foreach ($tasks as $task) {
            $client = $task->client;

            if ($client->email) {
                Mail::to($task->client->email)->send(new TaskReminderMail($task));
            }
        }

        $this->info('Task reminders processed: ' . count($tasks));
    }
}
