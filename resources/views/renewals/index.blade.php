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

            <select name="status[]" class="form-select w-auto">
                <option value="">-- Select Status --</option>
                @foreach(['Upcoming', 'Overdue', 'Completed', 'Not Interested'] as $status)
                    <option value="{{ $status }}" {{ in_array($status, (array) request('status'), true) ? 'selected' : '' }}>
                        {{ $status }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="btn btn-primary">Filter</button>
        </form>


    </div>

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
                    <pre id="whatsappMessageContent"></pre>
                </div>
            </div>
        </div>
    </div>
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
                    document.getElementById('whatsappMessageContent').textContent = data.message;
                    new bootstrap.Modal(document.getElementById('whatsappModal')).show();
                })
                .catch(error => console.error('Error:', error));
        }
    </script>

@endsection
