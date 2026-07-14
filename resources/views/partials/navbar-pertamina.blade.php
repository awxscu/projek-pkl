<nav class="navbar-horizontal">
    <div class="container-fluid d-flex align-items-center flex-wrap">
        <a href="{{ route('dashboard.pertamina') }}" class="navbar-brand-section">
            <i class="bi bi-journal-bookmark-fill text-pertamina-red"></i>
            <span class="d-none d-md-inline">Logbook Kapal</span>
        </a>

        <button class="navbar-toggler-custom d-lg-none ms-auto me-2" id="navToggle" type="button">
            <i class="bi bi-list"></i>
        </button>

        <div class="nav-menu-wrapper d-lg-flex flex-grow-1" id="navMenu">
            <ul class="nav-menu">
                <li><a href="{{ route('dashboard.pertamina') }}" class="nav-link {{ request()->routeIs('dashboard.pertamina') ? 'active' : '' }}"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
                <li><a href="{{ route('pertamina.monitoring') }}" class="nav-link {{ request()->routeIs('pertamina.monitoring') ? 'active' : '' }}"><i class="bi bi-eye"></i> Monitoring Logbook</a></li>
                <li><a href="{{ route('pertamina.verifikasi') }}" class="nav-link {{ request()->routeIs('pertamina.verifikasi') ? 'active' : '' }}"><i class="bi bi-patch-check"></i> Verifikasi</a></li>
                <li><a href="{{ route('pertamina.kapal') }}" class="nav-link {{ request()->routeIs('pertamina.kapal') ? 'active' : '' }}"><i class="bi bi-ship"></i> Data Kapal</a></li>
                <li><a href="{{ route('pertamina.perjalanan') }}" class="nav-link {{ request()->routeIs('pertamina.perjalanan') ? 'active' : '' }}"><i class="bi bi-signpost-split"></i> Perjalanan</a></li>
                <li><a href="{{ route('pertamina.laporan') }}" class="nav-link {{ request()->routeIs('pertamina.laporan') ? 'active' : '' }}"><i class="bi bi-file-earmark-bar-graph"></i> Laporan</a></li>
                <li><a href="{{ route('landing') }}" class="nav-link logout-link"><i class="bi bi-box-arrow-left"></i> Logout</a></li>
            </ul>
        </div>

        <div class="navbar-right d-none d-lg-flex">
            <div class="user-info">
                <div class="user-avatar">PN</div>
                <div>
                    <div class="fw-semibold" style="font-size:0.82rem">Admin Pertamina</div>
                    <small class="text-muted">Pertamina Patra Niaga</small>
                </div>
            </div>
            @include('partials.logo', ['href' => route('dashboard.pertamina')])
        </div>
    </div>
</nav>
