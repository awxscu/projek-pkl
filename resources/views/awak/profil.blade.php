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
            <div class="mx-auto mb-3 user-avatar" style="width: 80px; height: 80px; font-size: 2.2rem; border-radius: 50%;">
                BS
            </div>
            <h5 class="fw-bold mb-1">Budi Santoso</h5>
            <p class="text-pertamina-blue fw-semibold mb-3">Nakhoda Kapal Utama</p>
            <hr class="my-3">
            
            <div class="text-start">
                <div class="mb-3">
                    <small class="text-muted d-block"><i class="bi bi-person me-1"></i> ID User</small>
                    <span class="fw-semibold">USR-AWAK-001</span>
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block"><i class="bi bi-card-text me-1"></i> NIP / No. Lisensi</small>
                    <span class="fw-semibold">19920815 201703 1 002</span>
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block"><i class="bi bi-envelope me-1"></i> Email</small>
                    <span class="fw-semibold">budi.santoso@nusantara.id</span>
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
        <div class="card-modern p-4 h-100">
            <h5 class="fw-bold text-pertamina-blue mb-3">
                <i class="bi bi-ship me-2"></i>Kapal Penugasan Aktif
            </h5>
            
            <div class="row g-3">
                <div class="col-sm-6">
                    <div class="p-3 bg-light rounded border-start border-primary border-3">
                        <small class="text-muted d-block">Nama Kapal</small>
                        <span class="fw-bold fs-6">KM Nusantara Jaya</span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="p-3 bg-light rounded border-start border-danger border-3">
                        <small class="text-muted d-block">Kode Vessel</small>
                        <span class="fw-bold fs-6">VSL-001</span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="p-3 bg-light rounded border-start border-success border-3">
                        <small class="text-muted d-block">Klasifikasi Sektor</small>
                        <span class="fw-bold fs-6">Kapal Penumpang</span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="p-3 bg-light rounded border-start border-warning border-3">
                        <small class="text-muted d-block">Kelompok Kuota BBM</small>
                        <span class="fw-bold fs-6">Kuota A (Operasional Utama)</span>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <h6 class="fw-bold text-pertamina-blue mb-3">
                <i class="bi bi-fuel-pump-fill me-1"></i> Estimasi Sisa Stok BBM & Pelumas Terkini
            </h6>
            
            <div class="row g-3">
                <!-- Diesel Oil -->
                <div class="col-md-6 col-lg-3 text-center">
                    <div class="border rounded p-3 bg-white">
                        <div class="mb-1 text-primary"><i class="bi bi-droplet-fill fs-4"></i></div>
                        <small class="text-muted d-block" style="font-size:0.75rem">Diesel Oil (DO)</small>
                        <span class="fw-bold fs-6 text-primary">930 L</span>
                    </div>
                </div>
                <!-- Fuel Oil -->
                <div class="col-md-6 col-lg-3 text-center">
                    <div class="border rounded p-3 bg-white">
                        <div class="mb-1 text-danger"><i class="bi bi-droplet-half fs-4"></i></div>
                        <small class="text-muted d-block" style="font-size:0.75rem">Fuel Oil (FO)</small>
                        <span class="fw-bold fs-6 text-danger">800 L</span>
                    </div>
                </div>
                <!-- Lube Oil -->
                <div class="col-md-6 col-lg-3 text-center">
                    <div class="border rounded p-3 bg-white">
                        <div class="mb-1 text-warning"><i class="bi bi-oil-barrel fs-4"></i></div>
                        <small class="text-muted d-block" style="font-size:0.75rem">Lube Oil</small>
                        <span class="fw-bold fs-6 text-warning text-dark">283 L</span>
                    </div>
                </div>
                <!-- Cylinder Oil -->
                <div class="col-md-6 col-lg-3 text-center">
                    <div class="border rounded p-3 bg-white">
                        <div class="mb-1 text-secondary"><i class="bi bi-gear-wide-connected fs-4"></i></div>
                        <small class="text-muted d-block" style="font-size:0.75rem">Cylinder Oil</small>
                        <span class="fw-bold fs-6 text-secondary">142 L</span>
                    </div>
                </div>
            </div>

            <hr class="my-4">
            
            <div class="p-3 bg-light rounded d-flex align-items-center gap-3">
                <i class="bi bi-exclamation-triangle-fill text-warning fs-3"></i>
                <div class="small">
                    <span class="fw-bold">Catatan Stok BBM:</span> Nilai di atas merupakan hasil kalkulasi dari data logbook terakhir yang diinput dan diverifikasi oleh Pertamina. Pastikan pengisian logbook dilakukan setiap hari untuk menjamin keakuratan kuota kapal.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
