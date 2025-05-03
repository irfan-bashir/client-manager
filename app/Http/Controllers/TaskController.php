<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\ExportsCsv;

class TaskController extends Controller
{
    use ExportsCsv;
    public function index(Client $client)
    {
        $tasks = $client->tasks()->latest()->paginate(10);
        return view('tasks.index', compact('client', 'tasks'));
    }

    public function store(Request $request, Client $client)
    {
        $validated = $request->validate([
            'organization_name' => 'required|string|max:255',
            'form_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'renewal_date' => 'required|date',
            'status' => 'required|in:Completed,Overdue,Upcoming,Not Interested',
//            'send_reminder' => 'sometimes|boolean',
        ]);

        $validated['send_reminder'] = $request->has('send_reminder');
        $client->tasks()->create($validated);

        return redirect()
            ->route('clients.edit', $client->id)
            ->with('success', 'Task added successfully.')
            ->withFragment('tasks');
//        return redirect()->route('tasks.index', $client)->with('success', 'Task added successfully.');
    }

    public function update(Request $request, Client $client, Task $task)
    {
        $validated = $request->validate([
            'organization_name' => 'required|string|max:255',
            'form_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'renewal_date' => 'required|date',
            'status' => 'required|in:Completed,Overdue,Upcoming,Not Interested',
//            'send_reminder' => 'sometimes|boolean',
        ]);

        $validated['send_reminder'] = $request->has('send_reminder');
        $task->update($validated);
        return redirect()
            ->route('clients.edit', $client->id)
            ->with('success', 'Task updated successfully.')
            ->withFragment('tasks');

//        return redirect()->route('tasks.index', $client)->with('success', 'Task updated successfully.');
    }

    public function destroy(Client $client, Task $task)
    {
        $task->delete();
        return redirect()
            ->route('clients.edit', $client->id)
            ->with('success', 'Task deleted successfully.')
            ->withFragment('tasks');
//        return redirect()->route('tasks.index', $client)->with('success', 'Task deleted.');
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
                $task->send_reminder ? 'Yes' : 'No',
            ];
        });

        $headers = [
            'Client Name',
            'Organization Name',
            'Form Name',
            'Description',
            'Renewal Date',
            'Status',
            'Reminder Sent?',
        ];

        return $this->exportToCsv('tasks.csv', $data, $headers);
    }

}
