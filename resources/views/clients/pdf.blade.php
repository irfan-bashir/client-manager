<!DOCTYPE html>
<html>
<head>
    <title>Client Details</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 0;
            padding: 0;
        }
        h1, h2 {
            text-align: center;
        }
        .container {
            margin: 20px;
        }
        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 20px;
            padding: 15px;
        }
        .card-header {
            background-color: #007bff;
            color: white;
            padding: 10px;
            font-size: 18px;
            border-radius: 8px 8px 0 0;
        }
        .card-body {
            padding: 15px;
        }
        .row {
            display: flex;
            flex-wrap: wrap;
        }
        .col-md-6 {
            width: 48%;
            margin-right: 2%;
        }
        .col-md-6:last-child {
            margin-right: 0;
        }
        .mb-3 {
            margin-bottom: 15px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .table th, .table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .table th {
            background-color: #f8f9fa;
        }
        .badge {
            padding: 5px 10px;
            border-radius: 5px;
            color: white;
            font-size: 12px;
        }
        .bg-success { background-color: #28a745; }
        .bg-danger { background-color: #dc3545; }
        .bg-warning { background-color: #ffc107; }
    </style>
</head>
<body>

<div class="container">
    <h1>{{ $client->name }} - Details</h1>

    <!-- Client Information Card -->
    <div class="card">
        <div class="card-header">
            <h4>Client Information</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <strong>Name:</strong> {{ $client->name }}
                    </div>
                    <div class="mb-3">
                        <strong>Email:</strong> {{ $client->email }}
                    </div>
                    <div class="mb-3">
                        <strong>Phone:</strong> {{ $client->phone }}
                    </div>
                    <div class="mb-3">
                        <strong>POC Name:</strong> {{ $client->poc_name }}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <strong>Address:</strong> {{ $client->address }}
                    </div>
                    <div class="mb-3">
                        <strong>Company Type:</strong> {{ $client->company_type }}
                    </div>
                    <div class="mb-3">
                        <strong>City:</strong> {{ $client->city }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tasks Section -->
    <div class="card">
        <div class="card-header">
            <h4>Tasks</h4>
        </div>
        <div class="card-body">
            @if($client->tasks->isEmpty())
                <p>No tasks found for this client.</p>
            @else
                <table class="table">
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
                            <td>{{ \Carbon\Carbon::parse($task->renewal_date)->format('d M Y') }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <!-- Registrations Section -->
    <div class="card">
        <div class="card-header">
            <h4>Registrations</h4>
        </div>
        <div class="card-body">
            @if($client->registrations->isEmpty())
                <p>No registrations found for this client.</p>
            @else
                <table class="table">
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

</body>
</html>
