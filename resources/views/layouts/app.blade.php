<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>{{ config('app.name', 'AB Consultants') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="https://abconsultants.pk/wp-content/uploads/2023/10/Untitled-1-2-e1698391157747.png">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Select2 Styles -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.1.1/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

    <!-- Fonts and Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-nx1nP4JxTwS8FF7gIwbAgKJ6A5p+qg0lT+FESXuX2iAYImnv+FjkaA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Add in your layouts/app.blade.php head -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

{{--    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">--}}



    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Inter', sans-serif;
            font-size: 14px;
        }
        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .sidebar {
            height: 100vh;
            background-color: #1f2937;
            padding-top: 1rem;
            color: white;
            position: fixed;
            top: 56px;
            left: 0;
            width: 250px;
            overflow-y: auto;
            transition: all 0.3s;
        }
        .sidebar a,
        .sidebar .accordion-button {
            color: white;
            background-color: #1f2937;
            transition: background 0.2s ease;
        }
        .sidebar a:hover,
        .sidebar .accordion-button:not(.collapsed),
        .sidebar .accordion-button:focus {
            background-color: #374151;
        }
        .sidebar .accordion-body a {
            padding-left: 2.5rem;
        }
        .main-content {
            margin-left: 250px;
            padding: 2rem;
            margin-top: 56px;
        }
        .accordion-button::after {
            filter: brightness(0) invert(1);
        }
        .nav-link.dropdown-toggle {
            color: white;
        }
        .modal-header, .modal-footer {
            background-color: #f8f9fa;
        }
        .sidebar a.bg-secondary {
            background-color: #4b5563 !important;
        }
        .sidebar a:hover {
            background-color: #374151 !important;
        }

    </style>
</head>
<body>

<!-- Top Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="#"><i class="fa-solid fa-building-columns me-2"></i>AB Consultants</a>
        <div class="collapse navbar-collapse justify-content-end">
            @auth
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-user me-1"></i>{{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item"><i class="fa-solid fa-right-from-bracket me-2"></i>Logout</button>
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
        <div class="accordion-item border-0">
            <h2 class="accordion-header" id="headingDashboard">
                <button class="accordion-button {{ Request::is('renewals*') ? '' : 'collapsed' }}"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapseDashboard">
                    <i class="fa-solid fa-gauge me-2"></i>Dashboard
                </button>
            </h2>
            <div id="collapseDashboard"
                 class="accordion-collapse collapse {{ Request::is('renewals*') ? 'show' : '' }}"
                 data-bs-parent="#sidebarAccordion">
                <div class="accordion-body p-0">
                    <a href="{{ route('renewals.index') }}"
                       class="d-block px-4 py-2 {{ Request::is('renewals*') ? 'bg-secondary text-white fw-semibold' : '' }}">
                        Renewals
                    </a>
                </div>
            </div>
        </div>

        <!-- Clients Section -->
        <div class="accordion-item border-0">
            <h2 class="accordion-header" id="headingClients">
                <button class="accordion-button {{ Request::is('clients*') ? '' : 'collapsed' }}"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapseClients">
                    <i class="fa-solid fa-users me-2"></i>Clients
                </button>
            </h2>
            <div id="collapseClients"
                 class="accordion-collapse collapse {{ Request::is('clients*') ? 'show' : '' }}"
                 data-bs-parent="#sidebarAccordion">
                <div class="accordion-body p-0">
                    <a href="{{ route('clients.create') }}"
                       class="d-block px-4 py-2 {{ Request::is('clients/create') ? 'bg-secondary text-white fw-semibold' : '' }}">
                        Add Client
                    </a>
                    <a href="{{ route('clients.index') }}"
                       class="d-block px-4 py-2 {{ Request::is('clients') ? 'bg-secondary text-white fw-semibold' : '' }}">
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
            <div class="modal-body" id="clientModalContent"></div>
            <div class="modal-footer" id="clientModalFooter"></div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function () {
        $('.select2-status').select2({
            theme: 'bootstrap-5',
            placeholder: 'Select Status',
            closeOnSelect: false,
            width: 'resolve'
        });
    });
</script>
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
    function openClientModal(url, title = '') {
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

                const saveBtn = document.getElementById('modalSaveButton');
                if (saveBtn) {
                    saveBtn.onclick = function () {
                        const form = document.querySelector('#clientModalContent form');
                        if (form) {
                            form.submit();
                        }
                    };
                }
            });
    }
</script>

<script>
    // Auto-dismiss alerts after 5 seconds
    setTimeout(function () {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function (alert) {
            if (alert.classList.contains('show')) {
                bootstrap.Alert.getOrCreateInstance(alert).close();
            }
        });
    }, 5000);
</script>
@stack('scripts')
</body>
</html>
