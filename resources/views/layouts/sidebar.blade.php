<div class="d-flex flex-column vh-100 bg-white border-end shadow-sm px-3 pt-4">
    <!-- Logo -->
    <a href="{{ route('dashboard') }}" class="mb-4 d-flex align-items-center text-decoration-none">
        <img src="/logo.svg" alt="Logo" style="height: 30px;" class="me-2">
        <span class="fw-bold fs-5">Sneat</span>
    </a>

    <!-- Menu -->
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : 'text-dark' }}">
                <i class="bi bi-house-door-fill me-2"></i> Dashboards
                <span class="badge bg-danger rounded-pill ms-auto">5</span>
            </a>
        </li>
        <li>
            <a href="#" class="nav-link {{ request()->is('crm*') ? 'active' : 'text-dark' }}">
                <i class="bi bi-person-lines-fill me-2"></i> CRM
            </a>
        </li>
        <li>
            <a href="#" class="nav-link text-dark">
                <i class="bi bi-bag-check me-2"></i> eCommerce
            </a>
        </li>
        <li>
            <a href="#" class="nav-link text-dark">
                <i class="bi bi-truck me-2"></i> Logistics
            </a>
        </li>
        <li>
            <a href="#" class="nav-link text-dark">
                <i class="bi bi-mortarboard me-2"></i> Academy
            </a>
        </li>
    </ul>

    <hr>

    <h6 class="text-muted small">APPS & PAGES</h6>
    <ul class="nav nav-pills flex-column">
        <li>
            <a href="#" class="nav-link text-dark">
                <i class="bi bi-columns-gap me-2"></i> Layouts
            </a>
        </li>
        <li>
            <a href="#" class="nav-link text-dark">
                <i class="bi bi-window me-2"></i> Front Pages
            </a>
        </li>
    </ul>
</div>
