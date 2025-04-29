@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Client: {{ $client->name }}</h2>

        <!-- Tabs -->
        <ul class="nav nav-tabs" id="clientTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info-tab-pane"
                        type="button" role="tab">Client Info</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="registrations-tab" data-bs-toggle="tab"
                        data-bs-target="#registrations-tab-pane" type="button" role="tab">Registrations</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tasks-tab" data-bs-toggle="tab"
                        data-bs-target="#tasks-tab-pane" type="button" role="tab">Tasks</button>
            </li>
        </ul>

        <div class="tab-content mt-4" id="clientTabsContent">
            <!-- Client Info -->
            <div class="tab-pane fade show active" id="info-tab-pane" role="tabpanel">
                <p><strong>Email:</strong> {{ $client->email }}</p>
                <p><strong>Phone:</strong> {{ $client->phone }}</p>
                <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-primary">Edit Client</a>
            </div>

            <!-- Registrations Tab -->
            <div class="tab-pane fade" id="registrations-tab-pane" role="tabpanel">
                @include('clients.partials.registrations', ['client' => $client, 'registrations' => $registrations])
            </div>

            <!-- Tasks Tab -->
            <div class="tab-pane fade" id="tasks-tab-pane" role="tabpanel">
                @include('clients.partials.tasks', ['client' => $client, 'tasks' => $tasks])
            </div>
        </div>
    </div>
@endsection
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const hash = window.location.hash;
        if (hash) {
            const tabTrigger = document.querySelector(`button[data-bs-target="${hash}"]`);
            if (tabTrigger) {
                const tab = new bootstrap.Tab(tabTrigger);
                tab.show();
            }
        }
    });
</script>

