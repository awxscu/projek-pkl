<nav class="navbar-horizontal">
    <div class="container-fluid d-flex align-items-center justify-content-between">
        <!-- BRAND -->
        <a href="{{ route('dashboard.awak') }}" class="navbar-brand-section">
            <i class="bi bi-person-badge text-pertamina-red fs-4"></i>
            <span class="d-none d-md-inline text-dark">Awak Kapal</span>
        </a>

        <!-- NAV NAVIGATION MENU (HORIZONTAL) -->
        <div class="nav-menu-wrapper d-lg-flex" id="navMenu">
            <ul class="nav-menu">
                <li><a href="{{ route('dashboard.awak') }}" class="nav-link {{ request()->routeIs('dashboard.awak') ? 'active' : '' }}"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
                <li><a href="{{ route('logbook.create') }}" class="nav-link {{ request()->routeIs('logbook.create') ? 'active' : '' }}"><i class="bi bi-plus-circle"></i> Tambah Logbook</a></li>
                <li><a href="{{ route('awak.riwayat') }}" class="nav-link {{ request()->routeIs('awak.riwayat') ? 'active' : '' }}"><i class="bi bi-clock-history"></i> Riwayat Logbook</a></li>
                <li><a href="{{ route('awak.perjalanan') }}" class="nav-link {{ request()->routeIs('awak.perjalanan') ? 'active' : '' }}"><i class="bi bi-calendar-event"></i> Jadwal Perjalanan</a></li>
            </ul>
        </div>

        <!-- RIGHT SIDE (MOBILE TOGGLE, USER PROFILE & LOGO) -->
        <div class="navbar-right d-flex align-items-center gap-2 gap-md-3">
            <!-- Mobile Menu Toggle Button -->
            <button class="navbar-toggler-custom d-lg-none" id="navToggle" type="button" title="Menu">
                <i class="bi bi-list"></i>
            </button>

            <!-- User Dropdown (Avatar) -->
            <div class="dropdown">
                <button class="user-avatar-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Profil User">
                    <div class="user-avatar">BS</div>
                </button>
                <ul class="dropdown-menu dropdown-menu-end profile-dropdown-menu animate slideIn">
                    <li><a class="dropdown-item" href="{{ route('awak.profil') }}"><i class="bi bi-person"></i> Profil</a></li>
                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#settingsModal"><i class="bi bi-gear"></i> Pengaturan</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item logout-link-dropdown" href="{{ route('landing') }}"><i class="bi bi-box-arrow-left"></i> Keluar</a></li>
                </ul>
            </div>

            <!-- Pertamina Patra Niaga Logo -->
            @include('partials.logo', ['href' => route('dashboard.awak'), 'size' => 'logo-sm'])
        </div>
    </div>
</nav>
