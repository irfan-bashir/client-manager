@php use Carbon\Carbon; @endphp
@extends('layouts.app')

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h2 class="fw-bold">Renewals</h2>
        </div>

        <div class="d-flex justify-content-between align-items-center flex-wrap mb-4 gap-2">
            <!-- Search Form -->
            <form action="{{ route('renewals.index') }}" method="GET" class="d-flex align-items-center" style="gap: 10px;">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search clients..."
                    class="form-control"
                    style="min-width: 250px;"
                >
                <button type="submit" class="btn btn-outline-primary">Search</button>
            </form>

            <!-- Status Filter Form -->
            <form method="GET" class="d-flex align-items-center gap-2">
                <label for="status" class="fw-semibold me-2 mb-0">Status:</label>
                <input type="hidden" name="status[]" value="">
                @php
                    $selectedStatuses = request()->has('status') ? (array) request('status') : $statusFilter;
                @endphp
                <select name="status[]" id="status" class="form-select" multiple>
                    @foreach(['Upcoming', 'Overdue', 'Completed', 'Not Interested'] as $status)
                        <option value="{{ $status }}" {{ in_array($status, $selectedStatuses, true) ? 'selected' : '' }}>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-outline-primary">Filter</button>
            </form>

            <!-- Export Button -->
            <a href="{{ route('renewals.export') }}" class="btn btn-success">
                <i class="bi bi-download me-1"></i> Export Renewals
            </a>
        </div>
        <div class="d-flex justify-content-center flex-wrap gap-3 mb-4">
            <div class="card text-center border-primary" style="width: 140px;">
                <div class="card-body">
                    <h6 class="card-title text-muted">All</h6>
                    <h4 class="fw-bold text-primary">{{ $totalCount }}</h4>
                </div>
            </div>
            @foreach(['Upcoming', 'Overdue', 'Completed', 'Not Interested'] as $status)
                <div class="card text-center border-{{
            $status === 'Upcoming' ? 'primary' :
            ($status === 'Overdue' ? 'danger' :
            ($status === 'Completed' ? 'success' : 'secondary'))
        }}" style="width: 150px;">
                    <div class="card-body">
                        <h6 class="card-title text-muted">{{ $status }}</h6>
                        <h4 class="fw-bold text-{{
                    $status === 'Upcoming' ? 'primary' :
                    ($status === 'Overdue' ? 'danger' :
                    ($status === 'Completed' ? 'success' : 'secondary'))
                }}">
                            {{ $statusCounts[$status] ?? 0 }}
                        </h4>
                    </div>
                </div>
            @endforeach
        </div>




    </div>


    <table class="table table-hover table-bordered align-middle">
        <!-- Table Head -->
        <thead class="table-primary">
        <tr>
            <th style="width: 40px;">#</th>
            <th style="min-width: 120px;">Client</th>
            <th style="min-width: 120px;">Organization</th>
            <th style="min-width: 200px; max-width: 300px;">Form</th>
            <th style="min-width: 200px; max-width: 300px;">Description</th>
            <th style="white-space: nowrap; width: 140px;">Renewal Date</th>
            <th style="white-space: nowrap; width: 140px;">Status</th>
            <th style="white-space: nowrap; width: 160px;">Actions</th>
        </tr>
        </thead>

        <tbody>
        @forelse($tasks as $task)
            <tr>
                <td class="text-center">{{ ($tasks->currentPage() - 1) * $tasks->perPage() + $loop->iteration }}</td>
                <td>{{ $task->client->name ?? '-' }}</td>
                <td>{{ $task->organization_name }}</td>
                <td>{{ $task->form_name }}</td>
                <td>{{ $task->description }}</td>
                <td>{{ Carbon::parse($task->renewal_date)->format('jS F Y') }}</td>
                @php
                    $statusClasses = [
                        'Completed' => 'text-white bg-success',
                        'Overdue' => 'text-white bg-danger',
                        'Upcoming' => 'text-white bg-primary',
                        'Not Interested' => 'text-white bg-secondary',
                    ];
                @endphp

                <td>
                    <form method="POST" action="{{ url('/renewals/'.$task->id.'/update-status') }}">
                        @csrf
                        <select name="status"
                                class="form-select form-select-sm {{ $statusClasses[$task->status] ?? '' }}"
                                onchange="this.form.submit()">
                            @foreach(['Upcoming', 'Overdue', 'Completed', 'Not Interested'] as $s)
                                <option value="{{ $s }}" {{ $task->status === $s ? 'selected' : '' }}>
                                    {{ $s }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </td>
                <td class="text-nowrap">
                    <div class="d-flex gap-2">
                        <form method="POST" action="{{ route('renewals.sendReminder', $task) }}">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-info">Email</button>
                        </form>

                        <form method="POST" action="{{ route('renewals.generateWhatsapp', $task) }}">
                            @csrf
                            <button type="button" class="btn btn-sm btn-outline-success"
                                    onclick="showWhatsappMessage({{ $task->id }})">WhatsApp
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center text-muted">No renewals found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $tasks->appends(request()->query())->links('pagination::bootstrap-5') }}
        {{--            {{ $tasks->links('pagination::bootstrap-5') }}--}}
    </div>
    </div>

    <!-- WhatsApp Modal -->
    <div class="modal fade" id="whatsappModal" tabindex="-1" aria-labelledby="whatsappModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">WhatsApp Message Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="whatsappMessageContent" class="whatsapp-message-preview"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="copyToClipboard()">Copy Message</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#status').select2({
                placeholder: "Select Status",
                allowClear: true,
                width: '300px'
            });
        });

        function showWhatsappMessage(taskId) {
            fetch(`/renewals/${taskId}/generate-whatsapp`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    const formatted = data.message.replace(/\*(.*?)\*/g, '<b>$1</b>');
                    document.getElementById('whatsappMessageContent').innerHTML = formatted;
                    new bootstrap.Modal(document.getElementById('whatsappModal')).show();
                });
        }

        function copyToClipboard() {
            const text = document.getElementById('whatsappMessageContent').textContent;
            navigator.clipboard.writeText(text).then(() => alert('Copied!'));
        }
    </script>

    <style>
        .whatsapp-message-preview {
            white-space: pre-wrap;
            font-family: system-ui, sans-serif;
            line-height: 1.6;
            padding: 15px;
            background-color: #f1f3f5;
            border-radius: 6px;
        }

        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
        }
    </style>
@endsection
