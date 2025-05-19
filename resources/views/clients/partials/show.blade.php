<!-- client/_report.blade.php -->
<style>
    /* Updated with scoped styles */
    #pdf-report-container {
        font-family: 'Roboto', sans-serif;
        font-size: 13px;
        color: #2c2c2c;
    }

    #pdf-report-container .section-title {
        background-color: #007bff;
        color: white;
        padding: 8px 12px;
        font-size: 14px;
        font-weight: bold;
        margin-top: 20px;
        text-align: center;
    }

    #pdf-report-container .info-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    #pdf-report-container .info-item {
        flex: 1 1 45%;
    }

    #pdf-report-container .table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    #pdf-report-container .table th,
    #pdf-report-container .table td {
        padding: 8px;
        border: 1px solid #ccc;
        font-size: 12px;
    }

    #pdf-report-container .table th {
        background-color: #f2f2f2;
        color: #333;
    }

    #pdf-report-container .badge {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 11px;
        color: white;
    }

    #pdf-report-container .bg-success { background-color: #28a745; }
    #pdf-report-container .bg-danger { background-color: #dc3545; }
    #pdf-report-container .bg-primary { background-color: #007bff; }
    #pdf-report-container .bg-secondary { background-color: #6c757d; }
    #pdf-report-container .bg-dark { background-color: #343a40; }
</style>

<div id="pdf-report-container">
    <div class="section-title">Basic Information</div>
    <div class="info-grid">
        <div class="info-item"><span class="label">Client Name:</span> <span class="value">{{ $client->name }}</span></div>
        <div class="info-item"><span class="label">Company Type:</span> <span class="value">{{ $client->company_type }}</span></div>
        <div class="info-item"><span class="label">POC Name:</span> <span class="value">{{ $client->poc_name }}</span></div>
        <div class="info-item"><span class="label">Phone:</span> <span class="value">{{ $client->phone }}</span></div>
        <div class="info-item"><span class="label">Email:</span> <span class="value">{{ $client->email }}</span></div>
        <div class="info-item"><span class="label">Address:</span> <span class="value">{{ $client->address }}</span></div>
        <div class="info-item"><span class="label">City:</span> <span class="value">{{ $client->city }}</span></div>
        <div class="info-item" style="white-space: nowrap;">
            <span class="label" style="margin-right: 5px;">Location URL:</span>
            <a href="{{ $client->location_url }}" target="_blank" style="text-decoration: none; color: #007bff;">{{ $client->location_url }}</a>
        </div>
    </div>

    @if($client->registrations->isNotEmpty())
        <div class="section-title">Registrations</div>
        <table class="table">
            <thead>
            <tr>
                <th>Sr No.</th>
                <th>Organization</th>
                <th>Username</th>
                <th>Password</th>
                <th>Pin</th>
            </tr>
            </thead>
            <tbody>
            @foreach($client->registrations as $registration)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $registration->organization_name }}</td>
                    <td>{{ $registration->username }}</td>
                    <td>{{ $registration->password }}</td>
                    <td>{{ $registration->pin }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif

    @if($client->tasks->isNotEmpty())
        <div class="section-title">Tasks</div>
        <table class="table">
            <thead>
            <tr>
                <th>Sr No.</th>
                <th>Organization</th>
                <th>Form Name</th>
                <th>Description</th>
                <th>Renewal Date</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            @foreach($client->tasks->sortBy('renewal_date') as $task)
                @php
                    $color = match($task->status) {
                        'Completed' => 'success',
                        'Overdue' => 'danger',
                        'Upcoming' => 'primary',
                        'Not Interested' => 'secondary',
                        default => 'dark',
                    };
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $task->organization_name }}</td>
                    <td>{{ $task->form_name }}</td>
                    <td>{{ $task->description }}</td>
                    <td>{{ \Carbon\Carbon::parse($task->renewal_date)->format('d M Y') }}</td>
                    <td><span class="badge bg-{{ $color }}">{{ $task->status }}</span></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>
