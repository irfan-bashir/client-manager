@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Registrations for {{ $client->name }}</h2>

        <!-- Add Button -->
        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addRegistrationModal">Add Registration</button>


        @if($registrations->isEmpty())
            <p>No registrations found.</p>
        @else
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Organization</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>PIN</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($registrations as $registration)
                    <tr>
                        <td>{{ ($registrations->currentPage() - 1) * $registrations->perPage() + $loop->iteration }}</td>
                        <td>{{ $registration->organization_name }}</td>
                        <td>{{ $registration->username }}</td>
                        <td>{{ $registration->password }}</td>
                        <td>{{ $registration->pin }}</td>
                        <td>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $registration->id }}">Edit</button>
                            <form action="{{ route('registrations.destroy', [$client->id, $registration->id]) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editModal{{ $registration->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('registrations.update', [$client->id, $registration->id]) }}" method="POST">
                                    @csrf @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Registration</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        @include('registrations._form', ['registration' => $registration])
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
                </tbody>
            </table>
            <div class="mt-3">
                {{ $registrations->links('pagination::bootstrap-5') }}
            </div>
    </div>
        @endif
    </div>

    <!-- Add Registration Modal -->
    <div class="modal fade" id="addRegistrationModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg"> <!-- Wider for better spacing -->
            <div class="modal-content border-0 shadow">
                <form action="{{ route('registrations.store', $client->id) }}" method="POST">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">
                            <i class="bi bi-journal-plus me-2"></i>Add Registration
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        @include('registrations._form', ['registration' => null])
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle me-1"></i>Save Registration
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
