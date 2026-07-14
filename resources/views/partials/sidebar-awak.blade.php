<div class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon">
            <i class="bi bi-person-badge"></i>
        </div>
        <div>
            <h6>Awak Kapal</h6>
            <small>Panel Crew</small>
        </div>
    </div>

    <nav class="sidebar-nav">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('dashboard.awak') }}" class="nav-link {{ request()->routeIs('dashboard.awak') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('logbook.create') }}" class="nav-link {{ request()->routeIs('logbook.create') ? 'active' : '' }}">
                    <i class="bi bi-plus-circle"></i> Tambah Logbook
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-clock-history"></i> Riwayat Logbook
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-calendar-event"></i> Jadwal Perjalanan
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-person"></i> Profil
                </a>
            </li>
            <li class="nav-item mt-3">
                <a href="{{ route('landing') }}" class="nav-link logout-link">
                    <i class="bi bi-box-arrow-left"></i> Logout
                </a>
            </li>
        </ul>
    </nav>

    <div class="sidebar-footer">
        &copy; {{ date('Y') }} Pertamina Marine
    </div>
</div>
