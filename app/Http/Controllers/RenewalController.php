<?php

namespace App\Http\Controllers;

use App\Mail\TaskReminderMail;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Traits\ExportsCsv;

class RenewalController extends Controller
{
    use ExportsCsv;
    public function index(Request $request)
    {
        $hasStatusParam = $request->has('status');
        $statusFilter = $request->get('status'); // can be null, [], or array
        $search = $request->get('search');
        $hasSearchParam = $request->has('search');

        if ($hasSearchParam) {
            $statusFilterToQuery = null;
        } elseif (!$hasStatusParam) {
            $statusFilterToQuery = ['Overdue', 'Upcoming'];
        } elseif (is_array($statusFilter) && count($statusFilter) > 1) {
            $statusFilterToQuery = $statusFilter;
        } else {
            $statusFilterToQuery = null;
        }

        $tasksQuery = Task::with(['registration.client'])
            ->when($statusFilterToQuery, fn($q) => $q->whereIn('status', $statusFilterToQuery))
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('client', function ($clientQuery) use ($search) {
                        $clientQuery->where('name', 'like', "%{$search}%");
                    })
                        ->orWhere('organization_name', 'like', "%{$search}%")
                        ->orWhere('form_name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->orderBy('renewal_date');

        $tasks = $tasksQuery
            ->paginate(10)
            ->appends([
                'status' => $statusFilter,
                'search' => $search,
            ]);

        $statusFilterForView = !$hasStatusParam && !$hasSearchParam ? ['Overdue', 'Upcoming'] : ($statusFilter ?? []);

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

    public function export()
    {
        $tasks = Task::with('client')->get();

        $data = $tasks->map(function ($task) {
            return [
                optional($task->client)->name,
                $task->organization_name,
                $task->form_name,
                $task->description,
                Carbon::parse($task->renewal_date)->format('jS F Y'),
                $task->status,
            ];
        });

        $headers = [
            'Client Name',
            'Organization Name',
            'Form Name',
            'Description',
            'Renewal Date',
            'Status',
        ];

        return $this->exportToCsv('renewals.csv', $data, $headers);
    }


}
