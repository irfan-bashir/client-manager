<?php

namespace App\Notifications;

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Task;

class TaskReminderNotification extends Notification
{
    use Queueable;

    public Task $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Task Reminder: ' . $this->task->form_name)
            ->line('This is a reminder that the task "' . $this->task->form_name . '" is due for renewal on ' . $this->task->renewal_date. '.')
            ->line('Description: ' . $this->task->description)
            ->line('Thank you!');
    }
}
