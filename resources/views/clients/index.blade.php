@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Clients</h2>

        <button class="btn btn-primary mb-3" onclick="openClientModal('{{ route('clients.create') }}', 'Add Client')">Add Client</button>


    @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($clients as $client)
                <tr>
                    <td>{{ ($clients->currentPage() - 1) * $clients->perPage() + $loop->iteration }}</td>
                    <td>{{ $client->name }}</td>
                    <td>{{ $client->email }}</td>
                    <td>{{ $client->phone }}</td>
                    <td>
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
        <div class="mt-3">
            {{ $clients->links('pagination::bootstrap-5') }}
        </div>
    </div>

@endsection
