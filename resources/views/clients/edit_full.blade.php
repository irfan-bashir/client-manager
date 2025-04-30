@extends('layouts.app')

@section('content')
    <div class="container mt-4">
{{--        <h2>Edit Client</h2>--}}

        <!-- Tabs -->
        <ul class="nav nav-tabs mb-4" id="clientTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="client-tab" data-bs-toggle="tab" data-bs-target="#client" type="button">Basic Information</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="registrations-tab" data-bs-toggle="tab" data-bs-target="#registrations" type="button">Registrations</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tasks-tab" data-bs-toggle="tab" data-bs-target="#tasks" type="button">Tasks</button>
            </li>
        </ul>

        <div class="tab-content">
            <!-- Client Info -->
            <div class="tab-pane fade show active" id="client" role="tabpanel">
                <form action="{{ route('clients.update', $client->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @include('clients.partials.form', ['client' => $client])
                    <button type="submit" class="btn btn-primary mt-3">Update Client</button>
                </form>
            </div>

            <!-- Tab 2: Registrations -->
            <div class="tab-pane fade" id="registrations" role="tabpanel">
                @include('clients.partials._registrations_tab', ['client' => $client, 'registrations' => $client->registrations()->paginate(10)])
            </div>

            <!-- Tab 3: Tasks -->
            <div class="tab-pane fade" id="tasks" role="tabpanel">
                @include('clients.partials._tasks_tab', [
                    'client' => $client,
                    'tasks' => $client->tasks()
                         ->orderByRaw("CASE WHEN renewal_date >= CURDATE() THEN 0 ELSE 1 END, renewal_date ASC")
                        ->paginate(10)
                ])
            </div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const hash = window.location.hash;
        if (hash) {
            const triggerEl = document.querySelector(`button[data-bs-target="${hash}"]`);
            if (triggerEl) {
                const tab = new bootstrap.Tab(triggerEl);
                tab.show();
            }
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const hash = window.location.hash;
        if (hash) {
            const triggerEl = document.querySelector(`button[data-bs-target="${hash}"]`);
            if (triggerEl) {
                triggerEl.classList.remove('disabled'); // ✅ enable the tab
                const tab = new bootstrap.Tab(triggerEl);
                tab.show();
            }
        }
    });
</script>

