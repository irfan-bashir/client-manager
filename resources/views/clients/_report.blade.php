<!-- client/_report.blade.php -->
<div id="pdf-style-content">
    <h1>Client Report: {{ $client->name }}</h1>
    <div class="section-title">Basic Information</div>
    <div class="info-grid">
        <div class="info-item"><span class="label">Client Name:</span> <span class="value">{{ $client->name }}</span></div>
        <div class="info-item"><span class="label">Company Type:</span> <span class="value">{{ $client->company_type }}</span></div>
        <div class="info-item"><span class="label">POC Name:</span> <span class="value">{{ $client->poc_name }}</span></div>
        <div class="info-item"><span class="label">Phone:</span> <span class="value">{{ $client->phone }}</span></div>
        <div class="info-item"><span class="label">Email:</span> <span class="value">{{ $client->email }}</span></div>
        <div class="info-item"><span class="label">Address:</span> <span class="value">{{ $client->address }}</span></div>
        <div class="info-item"><span class="label">City:</span> <span class="value">{{ $client->city }}</span></div>
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
            @foreach($client->tasks as $task)
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
