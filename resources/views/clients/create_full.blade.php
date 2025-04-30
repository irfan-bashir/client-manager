@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="card shadow rounded">
            <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                <h4 class="mb-0"><i class="bi bi-person-plus-fill me-2"></i>Add New Client</h4>
            </div>

            <div class="card-body">
                <!-- Tabs -->
                <ul class="nav nav-tabs mb-4" id="clientTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="client-tab" data-bs-toggle="tab" data-bs-target="#client" type="button">Basic Information</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link disabled" id="registrations-tab" type="button">Registrations</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link disabled" id="tasks-tab" type="button">Tasks</button>
                    </li>
                </ul>

                <div class="tab-content">
                    <!-- Tab 1: Client Info -->
                    <div class="tab-pane fade show active" id="client" role="tabpanel">
                        <form action="{{ route('clients.store') }}" method="POST">
                            @csrf
                            @include('clients.partials.form', ['client' => null])

                            <div class="text-end mt-3">
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-check-circle me-1"></i>Create Client
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
