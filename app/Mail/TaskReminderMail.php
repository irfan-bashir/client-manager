<?php

namespace App\Mail;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TaskReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $task;
    public $messageText;

    public function __construct(Task $task)
    {
        $this->task = $task;

        $this->messageText = "Subject: Reminder - Pending Form Submission\n" .
            "Dear [POC Name],\n" .
            "I hope you are doing well. This is a gentle reminder regarding the following pending form that requires your attention:\n\n" .
            "Organization Name: {$task->organization_name}\n" .
            "Form Name: {$task->form_name}\n" .
            "Description: {$task->description}\n" .
            "Renewal Date: " . \Carbon\Carbon::parse($task->renewal_date)->format('jS F Y') . "\n" .
            "Status: {$task->status}\n\n" .
            "Action Required:\n" .
            "Please ensure the form is completed at your earliest convenience to avoid any delays or penalties.\n" .
            "If the form has already been submitted, you may disregard this message.\n\n" .
            "For any questions or support, feel free to contact us at sales.abcosnultants@gmail.com or 0336 5573186.\n\n" .
            "Thank you for your prompt attention.\n" .
            "Best regards,\n" .
            "AB Consultants";
    }

    public function build()
    {
        return $this->subject('Reminder - Pending Form Submission')
            ->text('emails.task_reminder_plain'); // Plain text template
    }
}
