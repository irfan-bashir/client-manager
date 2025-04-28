<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>{{ config('app.name', 'AB Consultants') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="https://abconsultants.pk/wp-content/uploads/2023/10/Untitled-1-2-e1698391157747.png">

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Select2 Styles -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Optional: Better Bootstrap look -->
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.1.1/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />


    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            height: 100vh;
            background-color: #343a40;
            padding-top: 1rem;
            color: white;
            position: fixed;
            top: 56px;
            left: 0;
            width: 250px;
            overflow-y: auto;
        }
        .sidebar a, .sidebar .accordion-button {
            color: white;
            background-color: #343a40;
        }
        .sidebar .accordion-button:not(.collapsed),
        .sidebar .accordion-button:focus {
            background-color: #495057;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .main-content {
            margin-left: 250px;
            padding: 2rem;
            margin-top: 56px;
        }
    </style>
</head>
<body>

<!-- Top Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">AB Consultants</a>
        <div class="collapse navbar-collapse justify-content-end">
            @auth
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            @endauth
        </div>
    </div>
</nav>

<!-- Sidebar -->
<div class="sidebar">
    <div class="accordion" id="sidebarAccordion">

        <!-- Dashboard Section -->
        <div class="accordion-item bg-dark border-0">
            <h2 class="accordion-header" id="headingDashboard">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDashboard" aria-expanded="false">
                    Dashboard
                </button>
            </h2>
            <div id="collapseDashboard" class="accordion-collapse collapse" data-bs-parent="#sidebarAccordion">
                <div class="accordion-body p-0">
                    <a href="{{ route('renewals.index') }}" class="d-block px-4 py-2">Renewals</a>
                </div>
            </div>
        </div>

        <!-- Clients Section -->
        <div class="accordion-item bg-dark border-0">
            <h2 class="accordion-header" id="headingClients">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseClients" aria-expanded="false">
                    Clients
                </button>
            </h2>
            <div id="collapseClients" class="accordion-collapse collapse" data-bs-parent="#sidebarAccordion">
                <div class="accordion-body p-0">
{{--                    <a href="{{ route('clients.create') }}" class="d-block px-4 py-2">Add Client</a>--}}
                    <a href="javascript:void(0)"
                       onclick="openClientModal('{{ route('clients.create') }}', 'Add Client')"
                       class="d-block px-4 py-2">
                        Add Client
                    </a>
                    <a href="{{ route('clients.index') }}" class="d-block px-4 py-2">
                        Manage Clients
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Main Content -->
<div class="main-content">
    @yield('content')
</div>
<!-- Modal -->
<div class="modal fade" id="clientModal" tabindex="-1" aria-labelledby="clientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="clientModalLabel">Client</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="clientModalContent">
                <!-- Dynamic Content Loaded Here -->
            </div>
            {{--                <div class="modal-footer">--}}
            {{--                    <button type="button" class="btn btn-success" id="modalSaveButton">Save</button>--}}
            {{--                </div>--}}
            <div class="modal-footer" id="clientModalFooter">
                <!-- Save button will be inserted dynamically here -->
            </div>
        </div>
    </div>
</div>


<!-- jQuery and Select2 Script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function () {
        $('.select2-status').select2({
            theme: 'bootstrap-5',
            placeholder: 'Select Status',
            closeOnSelect: false, // So dropdown stays open
            width: 'resolve'
        });
    });
</script>

<!-- Other scripts if any... -->

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const clientModal = document.getElementById('clientModal');

        clientModal.addEventListener('shown.bs.modal', function () {
            const form = document.getElementById('clientForm');
            if (!form) return;

            const newForm = form.cloneNode(true);
            form.parentNode.replaceChild(newForm, form);

            newForm.addEventListener('submit', function (e) {
                e.preventDefault();
                let formData = new FormData(newForm);

                fetch(newForm.action, {
                    method: newForm.method,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json',
                    },
                    body: formData
                }).then(response => {
                    if (response.ok) {
                        response.text().then(() => {
                            bootstrap.Modal.getInstance(clientModal).hide();
                            window.location.reload();
                        });
                    } else {
                        response.text().then(console.error);
                    }
                });
            });
        });
    });
</script>
<script>
    function openClientModal(url, title = 'Client') {
        fetch(url)
            .then(response => response.text())
            .then(html => {
                document.getElementById('clientModalLabel').innerText = title;
                document.getElementById('clientModalContent').innerHTML = html;

                const isViewMode = title.toLowerCase().includes('view');
                const footer = document.getElementById('clientModalFooter');
                footer.innerHTML = isViewMode
                    ? ''
                    : `<button type="button" class="btn btn-success" id="modalSaveButton">Save</button>`;
                const modal = new bootstrap.Modal(document.getElementById('clientModal'));
                modal.show();



                // Attach click event to modal Save button
                document.getElementById('modalSaveButton').onclick = function () {
                    const form = document.querySelector('#clientModalContent form');
                    if (form) {
                        form.submit(); // Submit the form
                    }
                };
            });
    }
</script>




</body>
</html>
