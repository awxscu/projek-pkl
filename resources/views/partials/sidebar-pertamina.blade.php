<div class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon">
            <i class="bi bi-fuel-pump-fill"></i>
        </div>
        <div>
            <h6>Pertamina Marine</h6>
            <small>Panel Admin</small>
        </div>
    </div>

    <nav class="sidebar-nav">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('dashboard.pertamina') }}" class="nav-link {{ request()->routeIs('dashboard.pertamina') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-journal-text"></i> Monitoring Logbook
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-patch-check"></i> Verifikasi
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-ship"></i> Data Kapal
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-calendar-event"></i> Jadwal Perjalanan
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-file-earmark-bar-graph"></i> Laporan
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
