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
            <div class="mx-auto mb-3 user-avatar" style="width: 80px; height: 80px; font-size: 2.2rem; border-radius: 50%;">
                PN
            </div>
            <h5 class="fw-bold mb-1">Admin Pertamina</h5>
            <p class="text-pertamina-blue fw-semibold mb-3">Pertamina Patra Niaga</p>
            <hr class="my-3">
            
            <div class="text-start">
                <div class="mb-3">
                    <small class="text-muted d-block"><i class="bi bi-person me-1"></i> ID User</small>
                    <span class="fw-semibold">USR-ADMIN-001</span>
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block"><i class="bi bi-briefcase me-1"></i> Departemen / Divisi</small>
                    <span class="fw-semibold">Marine Aviation & Logistics</span>
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block"><i class="bi bi-envelope me-1"></i> Email Resmi</small>
                    <span class="fw-semibold">admin.patraniaga@pertamina.com</span>
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
                    <div class="p-3 bg-light rounded border-start border-primary border-3">
                        <small class="text-muted d-block">Level Otoritas</small>
                        <span class="fw-bold fs-6 text-pertamina-blue">Super Administrator</span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="p-3 bg-light rounded border-start border-primary border-3">
                        <small class="text-muted d-block">Cakupan Pengawasan</small>
                        <span class="fw-bold fs-6">Seluruh Armada Kapal Penumpang</span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="p-3 bg-light rounded border-start border-primary border-3">
                        <small class="text-muted d-block">Fungsi Utama</small>
                        <span class="fw-bold fs-6">Verifikasi Logbook & Monitoring Stok Real-time</span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="p-3 bg-light rounded border-start border-primary border-3">
                        <small class="text-muted d-block">Kelompok Laporan</small>
                        <span class="fw-bold fs-6">Rekapitulasi Konsumsi Harian & Bulanan</span>
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
                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                        <span>Melakukan verifikasi logbook <strong>KM Nusantara Jaya (VSL-001)</strong> untuk tanggal 14/07/2026</span>
                    </div>
                    <span class="text-muted">10 menit yang lalu</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                    <div>
                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                        <span>Melakukan verifikasi logbook <strong>KM Samudra Indah (VSL-002)</strong> untuk tanggal 14/07/2026</span>
                    </div>
                    <span class="text-muted">45 menit yang lalu</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                    <div>
                        <i class="bi bi-x-circle-fill text-danger me-2"></i>
                        <span>Menolak pengisian logbook <strong>KM Samudera Makmur (VSL-007)</strong> (sisa kemarin tidak sesuai)</span>
                    </div>
                    <span class="text-muted">2 jam yang lalu</span>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection
