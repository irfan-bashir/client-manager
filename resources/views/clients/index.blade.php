@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Clients</h2>

{{--        <a href="{{ route('clients.create') }}" class="btn btn-primary mb-3">Add New Client</a>--}}
        <button class="btn btn-primary mb-3" onclick="openClientModal('{{ route('clients.create') }}', 'Add Client')">Add Client</button>


    @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($clients as $client)
                <tr>
                    <td>{{ $client->name }}</td>
                    <td>{{ $client->email }}</td>
                    <td>{{ $client->phone }}</td>
                    <td>
{{--                        <a href="{{ route('clients.show', $client) }}" class="btn btn-sm btn-info">View</a>--}}
{{--                        <a href="{{ route('clients.edit', $client) }}" class="btn btn-sm btn-warning">Edit</a>--}}
                                <button class="btn btn-sm btn-info" onclick="openClientModal('{{ route('clients.show', $client) }}', 'View Client')">View</button>
                                <button class="btn btn-sm btn-warning" onclick="openClientModal('{{ route('clients.edit', $client) }}', 'Edit Client')">Edit</button>
                        <a href="{{ route('clients.pdf', $client->id) }}" class="btn btn-sm btn-secondary">PDF</a>
                        <a href="{{ route('tasks.index', $client->id) }}" class="btn btn-sm btn-outline-dark">Tasks</a>
                        <a href="{{ route('registrations.index', $client->id) }}" class="btn btn-sm btn-success">Registrations</a>
                        <form action="{{ route('clients.destroy', $client) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this client?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4">No clients found.</td></tr>
            @endforelse
            </tbody>
        </table>

        {{ $clients->links() }}
    </div>


{{--    <script>--}}
{{--        function openClientModal(url, title = 'Client') {--}}
{{--            fetch(url)--}}
{{--                .then(response => response.text())--}}
{{--                .then(html => {--}}
{{--                    document.getElementById('clientModalLabel').innerText = title;--}}
{{--                    document.getElementById('clientModalContent').innerHTML = html;--}}

{{--                    const isViewMode = title.toLowerCase().includes('view');--}}
{{--                    const footer = document.getElementById('clientModalFooter');--}}
{{--                    footer.innerHTML = isViewMode--}}
{{--                        ? ''--}}
{{--                        : `<button type="button" class="btn btn-success" id="modalSaveButton">Save</button>`;--}}
{{--                    const modal = new bootstrap.Modal(document.getElementById('clientModal'));--}}
{{--                    modal.show();--}}



{{--                    // Attach click event to modal Save button--}}
{{--                    document.getElementById('modalSaveButton').onclick = function () {--}}
{{--                        const form = document.querySelector('#clientModalContent form');--}}
{{--                        if (form) {--}}
{{--                            form.submit(); // Submit the form--}}
{{--                        }--}}
{{--                    };--}}
{{--                });--}}
{{--        }--}}
{{--    </script>--}}


@endsection
