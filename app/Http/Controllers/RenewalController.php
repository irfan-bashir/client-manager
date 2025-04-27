<?php

namespace App\Http\Controllers;

use App\Mail\TaskReminderMail;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class RenewalController extends Controller
{
    public function index(Request $request)
    {
        $statusFilter = $request->get('status', ['Overdue', 'Upcoming']);

        $tasks = Task::with('registration.client')
            ->whereIn('status', $statusFilter)
            ->orderBy('renewal_date')
            ->paginate(10);

        return view('renewals.index', compact('tasks', 'statusFilter'));
    }

    public function sendReminder(Task $task)
    {
        Mail::to($task->client->email)->send(new TaskReminderMail($task));

        return back()->with('success', 'Reminder email sent successfully.');
    }

    public function generateWhatsapp(Task $task)
    {
        $message = "Subject: Reminder - Pending Form Submission\n" .
            "Dear {$task->client->poc_name},\n" .
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

        return response()->json(['message' => $message]);
    }

    public function updateStatus(Task $task, Request $request)
    {
        $task->status = $request->input('status');
        $task->save();

        return back()->with('success', 'Status updated successfully!');
    }
}
