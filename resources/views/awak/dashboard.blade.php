@extends('layouts.dashboard')

@section('title', 'Dashboard Awak Kapal')
@section('navbar') @include('partials.navbar-awak') @endsection

@section('content')
<div class="welcome-banner">
    <h4><i class="bi bi-hand-wave me-2"></i>Selamat Datang, Budi Santoso</h4>
    <p>KM Nusantara Jaya (VSL-001) — Surabaya → Balikpapan</p>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card-modern stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div><div class="stat-label">Logbook Hari Ini</div><div class="stat-value">1 <small class="text-muted" style="font-size:0.8rem">/ 1</small></div></div>
                <div class="stat-icon bg-pertamina-blue text-white"><i class="bi bi-journal-text"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-modern stat-card stat-orange">
            <div class="d-flex justify-content-between align-items-center">
                <div><div class="stat-label">Total Pemakaian BBM</div><div class="stat-value">320 <small class="text-muted" style="font-size:0.8rem">L</small></div></div>
                <div class="stat-icon" style="background:#fef3c7;color:#b45309"><i class="bi bi-fuel-pump"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-modern stat-card stat-green">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-label">Status Verifikasi</div>
                    <div class="stat-value" style="font-size:1.1rem"><span class="badge badge-verified">Verified</span></div>
                </div>
                <div class="stat-icon" style="background:#dcfce7;color:#15803d"><i class="bi bi-patch-check"></i></div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <a href="{{ route('logbook.create') }}" class="quick-action-card">
            <i class="bi bi-pencil-square"></i>
            <h5>Tulis Logbook Baru</h5>
            <p class="mb-0 small opacity-75">Input pemakaian BBM hari ini</p>
        </a>
    </div>
    <div class="col-md-8">
        <div class="card-modern p-3 h-100 d-flex align-items-center">
            <div class="d-flex align-items-center gap-3 w-100">
                <div class="stat-icon bg-pertamina-blue text-white flex-shrink-0"><i class="bi bi-calendar-event"></i></div>
                <div class="flex-grow-1">
                    <h6 class="fw-bold mb-1">Jadwal Perjalanan Aktif</h6>
                    <p class="mb-0 text-muted small"><strong>Surabaya → Balikpapan</strong> | Berangkat: 14/07/2026 06:00 | Status: <span class="badge" style="background:#dbeafe;color:#1d4ed8">Berlangsung</span></p>
                </div>
                <a href="{{ route('awak.perjalanan') }}" class="btn btn-pertamina-outline btn-sm flex-shrink-0">Detail</a>
            </div>
        </div>
    </div>
</div>

<div class="card-modern">
    <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
        <div><h6 class="mb-0 fw-bold">Riwayat Logbook Terbaru</h6><small class="text-muted">5 entri terakhir</small></div>
        <a href="{{ route('awak.riwayat') }}" class="btn btn-pertamina-outline btn-sm">Lihat Semua</a>
    </div>
    <div class="table-responsive">
        <table class="table table-modern">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Vessel</th>
                    <th>Rute</th>
                    <th>Konsumsi BBM</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>14/07/2026</td>
                    <td>VSL-001</td>
                    <td>Surabaya → Balikpapan</td>
                    <td>320 L</td>
                    <td><span class="badge badge-verified">Verified</span></td>
                </tr>
                <tr>
                    <td>13/07/2026</td>
                    <td>VSL-001</td>
                    <td>Surabaya (persiapan)</td>
                    <td>45 L</td>
                    <td><span class="badge badge-verified">Verified</span></td>
                </tr>
                <tr>
                    <td>12/07/2026</td>
                    <td>VSL-001</td>
                    <td>Balikpapan → Surabaya</td>
                    <td>310 L</td>
                    <td><span class="badge badge-verified">Verified</span></td>
                </tr>
                <tr>
                    <td>11/07/2026</td>
                    <td>VSL-001</td>
                    <td>Balikpapan (sandar)</td>
                    <td>25 L</td>
                    <td><span class="badge badge-pending">Pending</span></td>
                </tr>
                <tr>
                    <td>10/07/2026</td>
                    <td>VSL-001</td>
                    <td>Surabaya → Balikpapan</td>
                    <td>295 L</td>
                    <td><span class="badge badge-verified">Verified</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
