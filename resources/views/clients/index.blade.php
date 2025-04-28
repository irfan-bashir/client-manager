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
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                                Actions
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="openClientModal('{{ route('clients.show', $client) }}', 'View Client')">
                                        <i class="fas fa-eye me-2"></i> View
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="openClientModal('{{ route('clients.edit', $client) }}', 'Edit Client')">
                                        <i class="fas fa-edit me-2"></i> Edit
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('clients.pdf', $client->id) }}" target="_blank">
                                        <i class="fas fa-file-pdf me-2"></i> PDF
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('tasks.index', $client->id) }}">
                                        <i class="fas fa-tasks me-2"></i> Tasks
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('registrations.index', $client->id) }}">
                                        <i class="fas fa-clipboard-list me-2"></i> Registrations
                                    </a>
                                </li>
                                @if($client->location_url)
                                    <li>
                                        <a class="dropdown-item" href="{{ $client->location_url }}" target="_blank">
                                            <i class="fas fa-map-marker-alt me-2"></i> Map
                                        </a>
                                    </li>
                                @endif
                                <li>
                                    <form action="{{ route('clients.destroy', $client) }}" method="POST" onsubmit="return confirm('Delete this client?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="dropdown-item text-danger" type="submit">
                                            <i class="fas fa-trash-alt me-2"></i> Delete
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
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
