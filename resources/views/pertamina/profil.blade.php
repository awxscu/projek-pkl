@extends('layouts.dashboard')

@section('title', 'Profil Pertamina Patra Niaga')
@section('navbar') @include('partials.navbar-pertamina') @endsection

@section('content')
<div class="page-header">
    <h4><i class="bi bi-person-badge me-2 text-pertamina-blue"></i>Profil Administrator</h4>
    <p>Informasi detail akun manajemen Pertamina Patra Niaga</p>
</div>

<div class="row g-4">
    <!-- LEFT COLUMN: USER PROFILE CARD -->
    <div class="col-lg-4">
        <div class="card-modern text-center p-4 h-100">
            <div class="mx-auto mb-3 user-avatar" style="width: 80px; height: 80px; font-size: 2.2rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; background: var(--pertamina-blue-light); color: var(--pertamina-blue); font-weight: bold;">
                {{ strtoupper(substr(auth()->user()->nama_user, 0, 2)) }}
            </div>
            <h5 class="fw-bold mb-1">{{ auth()->user()->nama_user }}</h5>
            <p class="text-pertamina-blue fw-semibold mb-3">Pertamina Patra Niaga</p>
            <hr class="my-3">
            
            <div class="text-start">
                <div class="mb-3">
                    <small class="text-muted d-block"><i class="bi bi-person me-1"></i> ID User</small>
                    <span class="fw-semibold">USR-ADMIN-{{ auth()->user()->id_user }}</span>
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block"><i class="bi bi-briefcase me-1"></i> Departemen / Divisi</small>
                    <span class="fw-semibold">Marine Aviation & Logistics</span>
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block"><i class="bi bi-envelope me-1"></i> Email Resmi</small>
                    <span class="fw-semibold">{{ strtolower(auth()->user()->id_user) }}@pertamina.com</span>
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block"><i class="bi bi-geo-alt me-1"></i> Lokasi Kantor</small>
                    <span class="fw-semibold">Gedung Wisma Tugu II, Jakarta</span>
                </div>
            </div>
            
            <hr class="my-3">
            <button class="btn btn-pertamina btn-sm w-100" data-bs-toggle="modal" data-bs-target="#settingsModal">
                <i class="bi bi-pencil-square me-1"></i>Pengaturan Akun
            </button>
        </div>
    </div>

    <!-- RIGHT COLUMN: SYSTEM ROLES & ACCESS SUMMARY -->
    <div class="col-lg-8">
        <div class="card-modern p-4 h-100">
            <h5 class="fw-bold text-pertamina-blue mb-3">
                <i class="bi bi-shield-lock me-2"></i>Hak Akses & Otoritas Sistem
            </h5>
            
            <div class="row g-3">
                <div class="col-sm-6">
                    <div class="p-3 bg-light rounded-3 border-start border-primary border-4 shadow-sm">
                        <small class="text-muted d-block fw-semibold mb-1" style="font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.5px;">Level Otoritas</small>
                        <span class="fw-bold text-pertamina-blue fs-6">Super Administrator</span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="p-3 bg-light rounded-3 border-start border-success border-4 shadow-sm">
                        <small class="text-muted d-block fw-semibold mb-1" style="font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.5px;">Cakupan Pengawasan</small>
                        <span class="fw-bold text-dark fs-6">Seluruh Armada Kapal Penumpang</span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="p-3 bg-light rounded-3 border-start border-info border-4 shadow-sm">
                        <small class="text-muted d-block fw-semibold mb-1" style="font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.5px;">Fungsi Utama</small>
                        <span class="fw-bold text-dark fs-6">Verifikasi Logbook & Monitoring Stok Real-time</span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="p-3 bg-light rounded-3 border-start border-warning border-4 shadow-sm">
                        <small class="text-muted d-block fw-semibold mb-1" style="font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.5px;">Kelompok Laporan</small>
                        <span class="fw-bold text-dark fs-6">Rekapitulasi Konsumsi Harian & Bulanan</span>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <h6 class="fw-bold text-pertamina-blue mb-3">
                <i class="bi bi-activity me-1"></i> Aktivitas Terakhir
            </h6>
            
            <ul class="list-group list-group-flush small">
                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                    <div>
                        <i class="bi bi-plus-circle-fill text-success me-2"></i>
                        <span>Menambahkan data perusahaan baru <strong>PT. FLOBAMOR</strong> ke database</span>
                    </div>
                    <span class="text-muted">10 menit yang lalu</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                    <div>
                        <i class="bi bi-pencil-fill text-primary me-2"></i>
                        <span>Memperbarui informasi master data kapal <strong>KM Nusantara Jaya</strong></span>
                    </div>
                    <span class="text-muted">45 menit yang lalu</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                    <div>
                        <i class="bi bi-plus-circle-fill text-success me-2"></i>
                        <span>Menambahkan depot FT/IT baru <strong>IT TENAU Kupang</strong></span>
                    </div>
                    <span class="text-muted">2 jam yang lalu</span>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection
