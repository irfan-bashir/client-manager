@extends('layouts.app')

@section('content')
    @if(session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger mt-3">
            {{ session('error') }}
        </div>
    @endif
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Dashboard</h2>
        <form method="GET" class="d-flex align-items-center gap-2 mb-3">
            <label for="status" class="form-label m-0 me-2 fw-semibold">Status Filter:</label>

            <select name="status[]" id="status" class="form-select w-auto" multiple>
                @foreach(['Upcoming', 'Overdue', 'Completed', 'Not Interested'] as $status)
                    <option value="{{ $status }}" {{ in_array($status, (array) request('status'), true) ? 'selected' : '' }}>
                        {{ $status }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="btn btn-primary">Filter</button>
        </form>
    </div>
    <!-- Include Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Include jQuery (required for Select2) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#status').select2({
                placeholder: "Select Status",
                allowClear: true,
                width: '400px' // or 'resolve' to auto adjust width
            });
        });
    </script>



    <table class="table table-bordered table-hover">
        <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Client</th>
            <th>Organization Name</th>
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
                <td>{{ ($tasks->currentPage() - 1) * $tasks->perPage() + $loop->iteration }}</td>
                <td>{{ $task->client->name ?? '' }}</td>
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
                <td class="d-flex gap-1">
                    <form method="POST" action="{{ route('renewals.sendReminder', $task) }}">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-info">Send Email</button>
                    </form>

                    <form method="POST" action="{{ route('renewals.generateWhatsapp', $task) }}">
                        @csrf
                        <button type="button" class="btn btn-sm btn-success" onclick="showWhatsappMessage({{ $task->id }})">WhatsApp Preview</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center">No renewals found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    <div class="mt-3">
        {{ $tasks->links('pagination::bootstrap-5') }}
    </div>
    </div>
    <!-- WhatsApp Message Modal -->
    <div class="modal fade" id="whatsappModal" tabindex="-1" aria-labelledby="whatsappModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
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

    <style>
        .whatsapp-message-preview {
            white-space: pre-wrap;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.5;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        .whatsapp-message-preview b {
            font-weight: 600;
        }
    </style>

    <script>
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
                    // Convert WhatsApp formatting (*bold*) to HTML <b> tags for display
                    const formattedMessage = data.message
                        .replace(/\*(.*?)\*/g, '<b>$1</b>')
                        .replace(/•/g, '•');

                    document.getElementById('whatsappMessageContent').innerHTML = formattedMessage;
                    new bootstrap.Modal(document.getElementById('whatsappModal')).show();
                })
                .catch(error => console.error('Error:', error));
        }

        function copyToClipboard() {
            const content = document.getElementById('whatsappMessageContent').textContent;
            navigator.clipboard.writeText(content)
                .then(() => alert('Message copied to clipboard!'))
                .catch(err => console.error('Failed to copy: ', err));
        }
    </script>

@endsection
