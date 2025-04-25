@extends('layouts.app')

@section('content')
    <div class="container mt-4">

        <!-- Client Information Card -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h4>Client Information</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Name:</label>
                            <p>{{ $client->name }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Email:</label>
                            <p>{{ $client->email }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Phone:</label>
                            <p>{{ $client->phone }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">POC Name:</label>
                            <p>{{ $client->poc_name }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Address:</label>
                            <p>{{ $client->address }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Company Type:</label>
                            <p>{{ $client->company_type }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">City:</label>
                            <p>{{ $client->city }}</p> {{-- assuming city is stored in city_id --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tasks Section -->
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h4>Tasks</h4>
            </div>
            <div class="card-body">
                @if($client->tasks->isEmpty())
                    <p>No tasks found for this client.</p>
                @else
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Organization Name</th>
                            <th>Form Name</th>
                            <th>Status</th>
                            <th>Renewal Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($client->tasks as $task)
                            <tr>
                                <td>{{ $task->organization_name }}</td>
                                <td>{{ $task->form_name }}</td>
                                <td>
                                        <span class="badge {{ $task->status === 'Completed' ? 'bg-success' : ($task->status === 'Overdue' ? 'bg-danger' : 'bg-warning') }}">
                                            {{ $task->status }}
                                        </span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($task->renewal_date)->format('d M Y') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

        <!-- Registrations Section -->
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h4>Registrations</h4>
            </div>
            <div class="card-body">
                @if($client->registrations->isEmpty())
                    <p>No registrations found for this client.</p>
                @else
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Organization</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Pin</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($client->registrations as $registration)
                            <tr>
                                <td>{{ $registration->organization_name }}</td>
                                <td>{{ $registration->username }}</td>
                                <td>{{ $registration->password }}</td>
                                <td>{{ $registration->pin }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection
