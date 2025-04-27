@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Clients</h2>

        <button class="btn btn-primary mb-3" onclick="openClientModal('{{ route('clients.create') }}', 'Add Client')">Add Client</button>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="m-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>Client Name</th>
                <th>Company Type</th>
                <th>POC Name</th>
                <th>Contact Number</th>
                <th>Email</th>
                <th>City</th>
                <th>Location</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($clients as $client)
                <tr>
                    <td>{{ ($clients->currentPage() - 1) * $clients->perPage() + $loop->iteration }}</td>
                    <td>{{ $client->name }}</td>
                    <td>{{ $client->company_type }}</td>
                    <td>{{ $client->poc_name }}</td>
                    <td>{{ $client->phone }}</td>
                    <td>{{ $client->email }}</td>
                    <td>{{ $client->city }}</td>
                    <td>{{ $client->address }}</td>
                    <td>
                        <button class="btn btn-sm btn-info" onclick="openClientModal('{{ route('clients.show', $client) }}', 'View Client')">View</button>
                        <button class="btn btn-sm btn-warning" onclick="openClientModal('{{ route('clients.edit', $client) }}', 'Edit Client')">Edit</button>
                        <a href="{{ route('clients.pdf', $client->id) }}" class="btn btn-sm btn-secondary">PDF</a>
                        <a href="{{ route('tasks.index', $client->id) }}" class="btn btn-sm btn-outline-dark">Tasks</a>
                        <a href="{{ route('registrations.index', $client->id) }}" class="btn btn-sm btn-success">Registrations</a>
                        @if($client->location_url)
                            <a href="{{ $client->location_url }}" class="btn btn-sm btn-info" target="_blank" title="View Location">
                                <i class="fa fa-map-marker-alt"></i> Map
                            </a>
                        @endif
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
