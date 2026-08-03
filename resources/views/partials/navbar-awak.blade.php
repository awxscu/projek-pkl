<nav class="navbar-horizontal">
    <div class="container-fluid d-flex align-items-center justify-content-between">
        <!-- BRAND -->
        <a href="{{ route('dashboard.awak') }}" class="navbar-brand-section">
            <i class="bi bi-person-badge text-pertamina-red fs-4"></i>
            <span class="d-none d-md-inline text-dark">Awak Kapal</span>
        </a>

        <!-- NAV NAVIGATION MENU (HORIZONTAL) -->
        @php
            $pertaminaNotesCount = \App\Models\DokumenLogbook::where('id_user', auth()->id())
                ->whereNotNull('catatan_pertamina')
                ->where('catatan_pertamina', '!=', '')
                ->count();
        @endphp
        <div class="nav-menu-wrapper d-lg-flex" id="navMenu">
            <ul class="nav-menu">
                <li><a href="{{ route('dashboard.awak') }}" class="nav-link {{ request()->routeIs('dashboard.awak') ? 'active' : '' }}"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
                <li><a href="{{ route('logbook.create') }}" class="nav-link {{ request()->routeIs('logbook.create') ? 'active' : '' }}"><i class="bi bi-plus-circle"></i> Tambah Logbook</a></li>
                <li>
                    <a href="{{ route('awak.upload-pdf') }}" class="nav-link {{ request()->routeIs('awak.upload-pdf') ? 'active' : '' }} d-inline-flex align-items-center gap-1">
                        <i class="bi bi-file-earmark-pdf"></i> Upload PDF Logbook
                        @if($pertaminaNotesCount > 0)
                            <span class="badge bg-danger ms-1" style="font-size: 0.72rem; padding: 0.2rem 0.45rem; border-radius: 50px;">{{ $pertaminaNotesCount }}</span>
                        @endif
                    </a>
                </li>
                <li><a href="{{ route('awak.riwayat') }}" class="nav-link {{ request()->routeIs('awak.riwayat') ? 'active' : '' }}"><i class="bi bi-clock-history"></i> Riwayat Logbook</a></li>
            </ul>
        </div>

        <!-- RIGHT SIDE (MOBILE TOGGLE, USER PROFILE & LOGO) -->
        <div class="navbar-right d-flex align-items-center gap-2 gap-md-3">
            <!-- Mobile Menu Toggle Button -->
            <button class="navbar-toggler-custom d-lg-none" id="navToggle" type="button" title="Menu">
                <i class="bi bi-list"></i>
            </button>

            <!-- User Dropdown (Avatar) -->
            @php
                $nameParts = explode(' ', auth()->user()->nama_user);
                $initials = '';
                if (count($nameParts) >= 2) {
                    $initials = strtoupper(substr($nameParts[0], 0, 1) . substr($nameParts[1], 0, 1));
                } else {
                    $initials = strtoupper(substr($nameParts[0], 0, 2));
                }
            @endphp
            <div class="dropdown">
                <button class="user-avatar-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Profil User">
                    <div class="user-avatar">{{ $initials }}</div>
                </button>
                <ul class="dropdown-menu dropdown-menu-end profile-dropdown-menu animate slideIn">
                    <li><a class="dropdown-item" href="{{ route('awak.profil') }}"><i class="bi bi-person"></i> Profil</a></li>
                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#settingsModal"><i class="bi bi-gear"></i> Pengaturan</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item logout-link-dropdown" href="{{ route('logout') }}"><i class="bi bi-box-arrow-left"></i> Keluar</a></li>
                </ul>
            </div>

            <!-- Pertamina Patra Niaga Logo -->
            @include('partials.logo', ['href' => route('dashboard.awak'), 'size' => 'logo-md'])
        </div>
    </div>
</nav>
