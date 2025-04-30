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
        $hasStatusParam = $request->has('status');
        $statusFilter = $request->get('status'); // can be null, [], or array

        if (!$hasStatusParam) {
            // First load → show only 'Overdue' and 'Upcoming'
            $statusFilterToQuery = ['Overdue', 'Upcoming'];
        } elseif (is_array($statusFilter) && count($statusFilter) > 1) {
            // User selected filters → use them
            $statusFilterToQuery = $statusFilter;
        } else {
            // User cleared all selections → show all
            $statusFilterToQuery = null;
        }

        $tasksQuery = Task::with('registration.client')
            ->when($statusFilterToQuery, fn($q) => $q->whereIn('status', $statusFilterToQuery))
            ->orderBy('renewal_date');

        $tasks = $tasksQuery
            ->paginate(10)
            ->appends(['status' => $statusFilter]);

        // For preselecting dropdown
        $statusFilterForView = !$hasStatusParam ? ['Overdue', 'Upcoming'] : ($statusFilter ?? []);

        return view('renewals.index', [
            'tasks' => $tasks,
            'statusFilter' => $statusFilterForView,
        ]);
    }




    public function sendReminder(Task $task)
    {
        Mail::to($task->client->email)->send(new TaskReminderMail($task));

        return back()->with('success', 'Reminder email sent successfully.');
    }

    public function generateWhatsapp(Task $task)
    {
        $formattedDate = \Carbon\Carbon::parse($task->renewal_date)->format('jS F Y');
        $statusWithIcon = $task->status === 'Overdue' ? '⚠️ ' . $task->status : $task->status;

        $message = "*Subject: Reminder - Pending Form Submission*\n\n" .
            "Dear *{$task->client->poc_name}*,\n\n" .
            "I hope you are doing well. This is a gentle reminder regarding the following pending form that requires your attention:\n\n" .
            "*Organization Name:* {$task->organization_name}\n" .
            "*Form Name:* {$task->form_name}\n" .
            "*Description:* {$task->description}\n" .
            "*Renewal Date:* {$formattedDate}\n" .
            "*Status:* {$statusWithIcon}\n\n" .
            "*Action Required:*\n" .
            "• Please ensure the form is completed at your earliest convenience to avoid any delays or penalties.\n" .
            "• If the form has already been submitted, you may disregard this message.\n\n" .
            "For any questions or support, feel free to contact us at *sales.abconsultants@gmail.com* or *+923365573186*.\n\n" .
            "Thank you for your prompt attention.\n\n" .
            "*Best regards*,\n" .
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
