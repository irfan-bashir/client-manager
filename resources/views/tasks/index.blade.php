@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Tasks for {{ $client->name }}</h2>

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
                        <td>{{ $task->organization_name }}</td>
                        <td>{{ $task->form_name }}</td>
                        <td>{{ $task->description }}</td>
                        <td>{{ $task->renewal_date }}</td>
                        <td>{{ $task->status }}</td>
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
        @endif
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('tasks.store', $client->id) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTaskLabel">Add Task</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @include('tasks._form', ['task' => null])
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Add Task</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
