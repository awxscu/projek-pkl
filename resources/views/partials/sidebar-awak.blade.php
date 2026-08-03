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
            @php
                $pertaminaNotesCount = \App\Models\DokumenLogbook::where('id_user', auth()->id())
                    ->whereNotNull('catatan_pertamina')
                    ->where('catatan_pertamina', '!=', '')
                    ->count();
            @endphp
            <li class="nav-item">
                <a href="{{ route('awak.upload-pdf') }}" class="nav-link {{ request()->routeIs('awak.upload-pdf') ? 'active' : '' }} d-flex align-items-center justify-content-between">
                    <span><i class="bi bi-file-earmark-pdf"></i> Upload PDF Logbook</span>
                    @if($pertaminaNotesCount > 0)
                        <span class="badge bg-danger ms-1" style="font-size: 0.72rem; padding: 0.2rem 0.45rem; border-radius: 50px;">{{ $pertaminaNotesCount }}</span>
                    @endif
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('awak.riwayat') }}" class="nav-link {{ request()->routeIs('awak.riwayat') ? 'active' : '' }}">
                    <i class="bi bi-clock-history"></i> Riwayat Logbook
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('awak.perjalanan') }}" class="nav-link {{ request()->routeIs('awak.perjalanan') ? 'active' : '' }}">
                    <i class="bi bi-calendar-event"></i> Jadwal Perjalanan
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('perjalanan.create') }}" class="nav-link {{ request()->routeIs('perjalanan.create') ? 'active' : '' }}">
                    <i class="bi bi-calendar-plus"></i> Tambah Jadwal Perjalanan
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('awak.profil') }}" class="nav-link {{ request()->routeIs('awak.profil') ? 'active' : '' }}">
                    <i class="bi bi-person"></i> Profil
                </a>
            </li>
            <li class="nav-item mt-3">
                <a href="{{ route('logout') }}" class="nav-link logout-link">
                    <i class="bi bi-box-arrow-left"></i> Logout
                </a>
            </li>
        </ul>
    </nav>

    <div class="sidebar-footer">
        &copy; {{ date('Y') }} Pertamina Marine
    </div>
</div>
