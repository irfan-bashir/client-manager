@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="flex justify-between items-center mb-4">
            <h2>Tasks for {{ $client->name }}</h2>
            <a href="{{ route('tasks.export') }}" class="bg-green-500 hover:bg-green-600 text-white text-sm px-4 py-2 rounded" target="_blank">
                Export CSV
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addTaskModal">Add Task</button>

        @if($tasks->isEmpty())
            <p>No tasks found.</p>
        @else
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Organization</th>
                    <th>Form</th>
                    <th>Description</th>
                    <th>Renewal Date</th>
                    <th>Status</th>
                    <th>Reminder?</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($tasks as $task)
                    <tr>
                        <td>{{ ($tasks->currentPage() - 1) * $tasks->perPage() + $loop->iteration }}</td>
                        <td>{{ $task->organization_name }}</td>
                        <td>{{ $task->form_name }}</td>
                        <td>{{ $task->description }}</td>
                        <td>{{ $task->renewal_date }}</td>
                        <td>
                            @php
                                $color = match($task->status) {
                                    'Completed' => 'success',  // green
                                    'Overdue' => 'danger',      // red
                                    'Upcoming' => 'primary',    // blue
                                    'Not Interested' => 'secondary', // grey
                                    default => 'dark',
                                };
                            @endphp
                            <span class="badge bg-{{ $color }}">{{ $task->status }}</span>
                        </td>
                        <td>{{ $task->send_reminder ? 'Yes' : 'No' }}</td>
                        <td>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $task->id }}">Edit</button>
                            <form action="{{ route('tasks.destroy', [$client->id, $task->id]) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this task?')">Delete</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editModal{{ $task->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $task->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('tasks.update', [$client->id, $task->id]) }}" method="POST">
                                    @csrf @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel{{ $task->id }}">Edit Task</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        @include('tasks._form', ['task' => $task])
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
                </tbody>
            </table>
            <div class="mt-3">
                {{ $tasks->links('pagination::bootstrap-5') }}
            </div>
    </div>
        @endif
    </div>

    <!-- Add Task Modal -->
    <div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg"> <!-- wider modal for spacing -->
            <div class="modal-content border-0 shadow">
                <form action="{{ route('tasks.store', $client->id) }}" method="POST">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title">
                            <i class="bi bi-list-check me-2"></i>Add Task
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        @include('tasks._form', ['task' => null])
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check2-circle me-1"></i>Save Task
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
