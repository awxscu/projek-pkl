<nav class="navbar-horizontal">
    <div class="container-fluid d-flex align-items-center flex-wrap">
        <a href="{{ route('dashboard.awak') }}" class="navbar-brand-section">
            <i class="bi bi-person-badge text-pertamina-red"></i>
            <span class="d-none d-md-inline">Awak Kapal</span>
        </a>

        <button class="navbar-toggler-custom d-lg-none ms-auto me-2" id="navToggle" type="button">
            <i class="bi bi-list"></i>
        </button>

        <div class="nav-menu-wrapper d-lg-flex flex-grow-1" id="navMenu">
            <ul class="nav-menu">
                <li><a href="{{ route('dashboard.awak') }}" class="nav-link {{ request()->routeIs('dashboard.awak') ? 'active' : '' }}"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
                <li><a href="{{ route('logbook.create') }}" class="nav-link {{ request()->routeIs('logbook.create') ? 'active' : '' }}"><i class="bi bi-plus-circle"></i> Tambah Logbook</a></li>
                <li><a href="{{ route('awak.riwayat') }}" class="nav-link {{ request()->routeIs('awak.riwayat') ? 'active' : '' }}"><i class="bi bi-clock-history"></i> Riwayat Logbook</a></li>
                <li><a href="{{ route('awak.perjalanan') }}" class="nav-link {{ request()->routeIs('awak.perjalanan') ? 'active' : '' }}"><i class="bi bi-calendar-event"></i> Jadwal Perjalanan</a></li>
                <li><a href="{{ route('awak.profil') }}" class="nav-link {{ request()->routeIs('awak.profil') ? 'active' : '' }}"><i class="bi bi-person"></i> Profil</a></li>
                <li><a href="{{ route('landing') }}" class="nav-link logout-link"><i class="bi bi-box-arrow-left"></i> Logout</a></li>
            </ul>
        </div>

        <div class="navbar-right d-none d-lg-flex">
            <div class="user-info">
                <div class="user-avatar">BS</div>
                <div>
                    <div class="fw-semibold" style="font-size:0.82rem">Budi Santoso</div>
                    <small class="text-muted">Nakhoda — KM Nusantara Jaya</small>
                </div>
            </div>
            @include('partials.logo', ['href' => route('dashboard.awak')])
        </div>
    </div>
</nav>
