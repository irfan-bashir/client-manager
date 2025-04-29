<!-- Registrations Tab -->
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Registrations for {{ $client->name }}</h5>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addRegistrationModal">
            <i class="fas fa-plus-circle me-1"></i> Add Registration
        </button>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($registrations->isEmpty())
            <p class="mb-0">No registrations found.</p>
        @else
            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle mb-0">
                    <thead class="table-light">
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
                                <div class="d-flex align-items-center">
                                    <button class="btn btn-sm btn-primary me-2" data-bs-toggle="modal" data-bs-target="#editModal{{ $registration->id }}">
                                        Edit
                                    </button>
                                    <form action="{{ route('registrations.destroy', [$client->id, $registration->id]) }}" method="POST" onsubmit="return confirm('Are you sure?')" class="m-0">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal{{ $registration->id }}" tabindex="-1" aria-hidden="true">
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
                                            <button class="btn btn-primary">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $registrations->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addRegistrationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('registrations.store', $client->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Registration</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @include('registrations._form', ['registration' => null])
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
