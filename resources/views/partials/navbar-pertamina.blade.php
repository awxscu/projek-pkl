<nav class="navbar-horizontal">
    <div class="container-fluid d-flex align-items-center justify-content-between">
        <!-- BRAND -->
        <a href="{{ route('dashboard.pertamina') }}" class="navbar-brand-section">
            <i class="bi bi-journal-bookmark-fill text-pertamina-red fs-4"></i>
            <span class="d-none d-md-inline text-dark">Logbook Kapal</span>
        </a>

        <!-- NAV NAVIGATION MENU (HORIZONTAL) -->
        <div class="nav-menu-wrapper d-lg-flex" id="navMenu">
            <ul class="nav-menu">
                <li><a href="{{ route('dashboard.pertamina') }}" class="nav-link {{ request()->routeIs('dashboard.pertamina') ? 'active' : '' }}"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
                <li><a href="{{ route('pertamina.monitoring') }}" class="nav-link {{ request()->routeIs('pertamina.monitoring') ? 'active' : '' }}"><i class="bi bi-eye"></i> Monitoring</a></li>
                <li><a href="{{ route('pertamina.verifikasi') }}" class="nav-link {{ request()->routeIs('pertamina.verifikasi') ? 'active' : '' }}"><i class="bi bi-patch-check"></i> Verifikasi</a></li>
                <li><a href="{{ route('pertamina.kapal') }}" class="nav-link {{ request()->routeIs('pertamina.kapal') ? 'active' : '' }}"><i class="bi bi-ship"></i> Data Kapal</a></li>
                <li><a href="{{ route('pertamina.perjalanan') }}" class="nav-link {{ request()->routeIs('pertamina.perjalanan') ? 'active' : '' }}"><i class="bi bi-signpost-split"></i> Perjalanan</a></li>
                <li><a href="{{ route('pertamina.laporan') }}" class="nav-link {{ request()->routeIs('pertamina.laporan') ? 'active' : '' }}"><i class="bi bi-file-earmark-bar-graph"></i> Laporan</a></li>
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
                    <div class="user-avatar">PN</div>
                </button>
                <ul class="dropdown-menu dropdown-menu-end profile-dropdown-menu animate slideIn">
                    <li><a class="dropdown-item" href="{{ route('pertamina.profil') }}"><i class="bi bi-person"></i> Profil</a></li>
                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#settingsModal"><i class="bi bi-gear"></i> Pengaturan</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item logout-link-dropdown" href="{{ route('landing') }}"><i class="bi bi-box-arrow-left"></i> Keluar</a></li>
                </ul>
            </div>

            <!-- Pertamina Patra Niaga Logo -->
            @include('partials.logo', ['href' => route('dashboard.pertamina'), 'size' => 'logo-sm'])
        </div>
    </div>
</nav>
