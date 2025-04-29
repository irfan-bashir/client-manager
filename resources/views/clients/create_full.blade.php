@extends('layouts.app')

@section('content')
    <div class="container mt-4">
{{--        <h2>Add New Client</h2>--}}

        <!-- Tabs -->
        <ul class="nav nav-tabs mb-4" id="clientTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="client-tab" data-bs-toggle="tab" data-bs-target="#client" type="button">Client Info</button>
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
                    <button type="submit" class="btn btn-primary mt-3">Create Client</button>
                </form>
            </div>

            <!-- Tabs 2 and 3 are not visible until client is created -->
        </div>
    </div>
@endsection
