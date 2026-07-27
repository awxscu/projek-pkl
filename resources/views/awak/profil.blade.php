@extends('layouts.dashboard')

@section('title', 'Profil Awak Kapal')
@section('navbar') @include('partials.navbar-awak') @endsection

@section('content')
<div class="page-header">
    <h4><i class="bi bi-person-badge me-2 text-pertamina-blue"></i>Profil Awak & Informasi Kapal</h4>
    <p>Informasi detail akun awak kapal dan spesifikasi kapal penugasan aktif</p>
</div>

<div class="row g-4">
    <!-- LEFT COLUMN: USER PROFILE CARD -->
    <div class="col-lg-4">
        <div class="card-modern text-center p-4 h-100">
            <div class="mx-auto mb-3 user-avatar" style="width: 80px; height: 80px; font-size: 2.2rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; background: var(--pertamina-blue-light); color: var(--pertamina-blue); font-weight: bold;">
                {{ strtoupper(substr($user->nama_user, 0, 2)) }}
            </div>
            <h5 class="fw-bold mb-1">{{ $user->nama_user }}</h5>
            <p class="text-pertamina-blue fw-semibold mb-3">Nakhoda Kapal Utama</p>
            <hr class="my-3">
            
            <div class="text-start">
                <div class="mb-3">
                    <small class="text-muted d-block"><i class="bi bi-person me-1"></i> ID User</small>
                    <span class="fw-semibold">USR-AWAK-{{ $user->id_user }}</span>
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block"><i class="bi bi-card-text me-1"></i> NIP / No. Lisensi</small>
                    <span class="fw-semibold">{{ $user->id_user }}</span>
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block"><i class="bi bi-envelope me-1"></i> Email</small>
                    <span class="fw-semibold">{{ strtolower($user->id_user) }}@nusantara.id</span>
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block"><i class="bi bi-phone me-1"></i> No. Telepon</small>
                    <span class="fw-semibold">+62 812-3456-7890</span>
                </div>
            </div>
            
            <hr class="my-3">
            <button class="btn btn-pertamina btn-sm w-100" data-bs-toggle="modal" data-bs-target="#settingsModal"><i class="bi bi-pencil-square me-1"></i>Edit Profil</button>
        </div>
    </div>

    <!-- RIGHT COLUMN: ASSIGNED VESSEL INFO -->
    <div class="col-lg-8">
        <div class="card-modern p-4 h-100 d-flex flex-column justify-content-between">
            <div>
                <h5 class="fw-bold text-pertamina-blue mb-4">
                    <i class="bi bi-ship me-2"></i>Kapal Penugasan Aktif
                </h5>
                
                <div class="row g-4">
                    <div class="col-sm-6">
                        <div class="p-4 bg-light rounded-3 border-start border-primary border-4 shadow-sm">
                            <small class="text-muted d-block fw-semibold text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.5px;">Nama Kapal</small>
                            <span class="fw-bold text-dark fs-5">{{ $vessel->nama_kapal }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-4 bg-light rounded-3 border-start border-danger border-4 shadow-sm">
                            <small class="text-muted d-block fw-semibold text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.5px;">Kode Vessel</small>
                            <span class="fw-bold text-dark fs-5">{{ $vessel->kode_vessel }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-4 p-4 rounded-3 border text-center bg-light-subtle" style="border-style: dashed !important; border-width: 2px !important; border-color: rgba(0,87,184,0.15) !important;">
                <i class="bi bi-info-circle-fill text-pertamina-blue mb-2 fs-3 d-block"></i>
                <h6 class="fw-bold text-dark mb-1">Status Penugasan Aktif</h6>
                <p class="text-muted small mb-0">Anda terdaftar sebagai awak resmi untuk kapal ini. Seluruh logbook harian yang Anda kirimkan akan otomatis tercatat atas nama kapal di atas.</p>
            </div>
        </div>
    </div>
</div>
@endsection
