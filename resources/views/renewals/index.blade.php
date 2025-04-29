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
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Renewals Dashboard</h2>
            <form method="GET" class="d-flex align-items-center gap-2">
                <label for="status" class="fw-semibold me-2 mb-0">Filter by Status:</label>
                <select name="status[]" id="status" class="form-select" multiple>
                    @foreach(['Upcoming', 'Overdue', 'Completed', 'Not Interested'] as $status)
                        <option value="{{ $status }}" {{ in_array($status, (array) request('status'), true) ? 'selected' : '' }}>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-outline-primary">Apply</button>
            </form>
        </div>

        <table class="table table-hover table-bordered align-middle">
            <thead class="table-primary text-center">
            <tr>
                <th>#</th>
                <th>Client</th>
                <th>Organization</th>
                <th>Form</th>
                <th>Description</th>
                <th>Renewal Date</th>
                <th>Status</th>
                <th>Actions</th>
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
                    <td>{{ \Carbon\Carbon::parse($task->renewal_date)->format('d M Y') }}</td>
                    <td>
                        <form method="POST" action="{{ url('/renewals/'.$task->id.'/update-status') }}">
                            @csrf
                            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                @foreach(['Upcoming', 'Overdue', 'Completed', 'Not Interested'] as $s)
                                    <option value="{{ $s }}" {{ $task->status === $s ? 'selected' : '' }}>
                                        {{ $s }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </td>
                    <td class="d-flex gap-2">
                        <form method="POST" action="{{ route('renewals.sendReminder', $task) }}">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-info">Email</button>
                        </form>

                        <form method="POST" action="{{ route('renewals.generateWhatsapp', $task) }}">
                            @csrf
                            <button type="button" class="btn btn-sm btn-outline-success" onclick="showWhatsappMessage({{ $task->id }})">WhatsApp</button>
                        </form>
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
            {{ $tasks->links('pagination::bootstrap-5') }}
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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
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
