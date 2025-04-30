@php use Carbon\Carbon; @endphp
    <!-- Tasks Tab -->
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Tasks for {{ $client->name }}</h5>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addTaskModal">Add Task</button>
    </div>
    <div class="card-body">

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif


        @if ($tasks->isEmpty())
            <p class="mb-0">No tasks found.</p>
        @else
            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle mb-0">
                    <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Organization Name</th>
                        <th>Form Name</th>
                        <th>Description</th>
                        <th>Renewal Date</th>
                        <th>Status</th>
                        <th>Reminder?</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($tasks as $task)
                        <tr>
                            <td>{{ ($tasks->currentPage() - 1) * $tasks->perPage() + $loop->iteration }}</td>
                            <td>{{ $task->organization_name }}</td>
                            <td>{{ $task->form_name }}</td>
                            <td>{{ $task->description }}</td>
                            <td>{{ Carbon::parse($task->renewal_date)->format('jS F Y') }}</td>
                            <td>
                                @php
                                    $color = match($task->status) {
                                        'Completed' => 'success',
                                        'Overdue' => 'danger',
                                        'Upcoming' => 'primary',
                                        'Not Interested' => 'secondary',
                                        default => 'dark',
                                    };
                                @endphp
                                <span class="badge bg-{{ $color }}">{{ $task->status }}</span>
                            </td>
                            <td>{{ $task->send_reminder ? 'Yes' : 'No' }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <button class="btn btn-sm btn-outline-success me-2" data-bs-toggle="modal"
                                            data-bs-target="#editTaskModal{{ $task->id }}">
                                        Edit
                                    </button>
                                    <form action="{{ route('tasks.destroy', [$client->id, $task->id]) }}" method="POST"
                                          onsubmit="return confirm('Delete this task?')" class="m-0">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-info">Delete</button>
                                    </form>
                                </div>

                            </td>
                        </tr>

                        <!-- Edit Task Modal -->
                        <div class="modal fade" id="editTaskModal{{ $task->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('tasks.update', [$client->id, $task->id]) }}" method="POST">
                                        @csrf @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Task</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            @include('tasks._form', ['task' => $task])
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $tasks->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>

<!-- Add Task Modal -->
<div class="modal fade" id="addTaskModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('tasks.store', $client->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @include('tasks._form', ['task' => null])
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Add Task</button>
                </div>
            </form>
        </div>
    </div>
</div>
