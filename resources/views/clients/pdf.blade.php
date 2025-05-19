<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Client Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 40px;
            font-size: 13px;
            color: #2c2c2c;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }

        .header .logo {
            width: 120px;
        }

        .header .company-info {
            text-align: right;
        }

        .company-name {
            font-size: 18px;
            font-weight: bold;
            color: #007bff;
        }

        h1 {
            text-align: center;
            margin-bottom: 25px;
            font-size: 20px;
            color: #007bff;
            text-transform: uppercase;
        }

        .section-title {
            background-color: #007bff;
            color: white;
            padding: 8px 12px;
            font-size: 14px;
            font-weight: bold;
            margin-top: 20px;
            text-align: center; /* Centered the title */
        }

        .info-grid {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 15px;
        }

        .info-item {
            width: 48%;
            margin-right: 4%;
            margin-bottom: 10px;
        }

        .info-item:nth-child(2n) {
            margin-right: 0;
        }

        .label {
            font-weight: bold;
            color: #444;
        }

        .value {
            margin-left: 5px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table th, .table td {
            padding: 8px;
            border: 1px solid #ccc;
            font-size: 12px;
            vertical-align: top;
        }

        .table th {
            background-color: #f2f2f2;
            color: #333;
            text-align: left;
        }

        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            color: #fff;
            font-size: 11px;
        }

        .bg-success { background-color: #28a745; }
        .bg-danger { background-color: #dc3545; }
        .bg-warning { background-color: #ffc107; color: #212529; }
        .bg-primary { background-color: #007bff; }
        .bg-secondary { background-color: #6c757d; }
        .bg-dark { background-color: #343a40; }

        .footer {
            position: fixed;
            bottom: -30px;
            left: 0;
            right: 0;
            height: 30px;
            text-align: center;
            font-size: 11px;
            color: #999;
        }
    </style>
</head>
<body>

<div class="header">
    <!--     <div class="logo">
        <img src="{{ public_path('images/logo.png') }}" width="100">
    </div> -->
    <div class="company-info">
        <div class="company-name">AB Consultants</div>
        <div>www.abconsultants.com.pk</div>
        <div>info@abconsultants.com.pk</div>
        <div>+923365573186</div>
    </div>
</div>

<h1>Client Report: {{ $client->name }}</h1>

<!-- Basic Information -->
<div class="section-title" style="margin-bottom: 10px;">Basic Information</div>
<div class="info-grid" style="margin-bottom: 20px;">
    <div class="info-item"><span class="label">Client Name:</span> <span class="value">{{ $client->name }}</span></div>
    <div class="info-item"><span class="label">Company Type:</span> <span class="value">{{ $client->company_type }}</span></div>
    <div class="info-item"><span class="label">POC Name:</span> <span class="value">{{ $client->poc_name }}</span></div>
    <div class="info-item"><span class="label">Contact Number:</span> <span class="value">{{ $client->phone }}</span></div>
    <div class="info-item"><span class="label">Email:</span> <span class="value">{{ $client->email }}</span></div>
    <div class="info-item"><span class="label">Address:</span> <span class="value">{{ $client->address }}</span></div>
    <div class="info-item" style="white-space: nowrap;">
        <span class="label" style="margin-right: 5px;">Location URL:</span>
        <a href="{{ $client->location_url }}" target="_blank" style="text-decoration: none; color: #007bff;">{{ $client->location_url }}</a>
    </div>
    <div class="info-item"><span class="label">City:</span> <span class="value">{{ $client->city }}</span></div>
</div>

<!-- Registrations -->
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
@else
    <p>No registrations found for this client.</p>
@endif

<!-- Tasks -->
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
                <td>{{ \Carbon\Carbon::parse($task->renewal_date)->format('jS F Y') }}</td>  <!-- Updated date format -->
                <td><span class="badge bg-{{ $color }}">{{ $task->status }}</span></td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <p>No tasks found for this client.</p>
@endif

<!-- Footer -->
<div class="footer">
    © {{ now()->year }} AB Consultants — Confidential Report
</div>

</body>
</html>
