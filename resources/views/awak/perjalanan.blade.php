@extends('layouts.dashboard')

@section('title', 'Jadwal Perjalanan')
@section('navbar') @include('partials.navbar-awak') @endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
    <div>
        <h4><i class="bi bi-calendar-event me-2 text-pertamina-blue"></i>Jadwal Perjalanan Kapal</h4>
        <p>Daftar penugasan pelayaran untuk kapal KM Nusantara Jaya (VSL-001)</p>
    </div>
    <span class="badge bg-pertamina-blue px-3 py-2"><i class="bi bi-ship me-1"></i> Kapal Aktif: KM Nusantara Jaya</span>
</div>

<!-- INFO STRIP -->
<div class="row g-3 mb-4">
    <div class="col-md-6 col-lg-3">
        <div class="card-modern stat-card">
            <div class="stat-label">Total Pelayaran</div>
            <div class="stat-value">24</div>
            <small class="text-muted">Tahun 2026</small>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card-modern stat-card stat-green">
            <div class="stat-label">Selesai</div>
            <div class="stat-value">18</div>
            <small class="text-muted">Tepat waktu</small>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card-modern stat-card stat-blue">
            <div class="stat-label">Berlangsung</div>
            <div class="stat-value">1</div>
            <small class="text-muted">Rute Surabaya → Balikpapan</small>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card-modern stat-card stat-yellow">
            <div class="stat-label">Terjadwal</div>
            <div class="stat-value">4</div>
            <small class="text-muted">Pelayaran mendatang</small>
        </div>
    </div>
</div>

<!-- SCHEDULE TABLE -->
<div class="card-modern">
    <div class="p-3 border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h6 class="mb-0 fw-bold">Jadwal Penugasan Pelayaran</h6>
        <div class="d-flex gap-2">
            <select class="form-select form-select-sm" style="width: auto;">
                <option value="">Semua Status</option>
                <option>Terjadwal</option>
                <option>Berlangsung</option>
                <option>Selesai</option>
                <option>Batal</option>
            </select>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-modern">
            <thead>
                <tr>
                    <th>Rute Pelayaran</th>
                    <th>Pelabuhan Asal</th>
                    <th>Pelabuhan Tujuan</th>
                    <th>Jadwal Berangkat</th>
                    <th>Jadwal Kedatangan</th>
                    <th>Status</th>
                    <th style="width: 160px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Voyage 1 -->
                <tr>
                    <td><strong>Surabaya → Balikpapan</strong></td>
                    <td>Tanjung Perak (SUB)</td>
                    <td>Semayang (BPN)</td>
                    <td>14/07/2026</td>
                    <td>15/07/2026</td>
                    <td><span class="badge" style="background:#dbeafe;color:#1d4ed8"><i class="bi bi-arrow-right-circle-fill me-1"></i>Berlangsung</span></td>
                    <td class="text-center">
                        <a href="{{ route('logbook.create') }}" class="btn btn-sm btn-pertamina btn-action-table">
                            <i class="bi bi-pencil-square me-1"></i>Tulis Logbook
                        </a>
                    </td>
                </tr>
                <!-- Voyage 2 -->
                <tr>
                    <td><strong>Balikpapan → Surabaya</strong></td>
                    <td>Semayang (BPN)</td>
                    <td>Tanjung Perak (SUB)</td>
                    <td>17/07/2026</td>
                    <td>18/07/2026</td>
                    <td><span class="badge badge-pending"><i class="bi bi-calendar-check-fill me-1"></i>Terjadwal</span></td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-outline-secondary btn-action-table" disabled>
                            <i class="bi bi-lock-fill"></i> Logbook
                        </button>
                    </td>
                </tr>
                <!-- Voyage 3 -->
                <tr>
                    <td><strong>Surabaya → Makassar</strong></td>
                    <td>Tanjung Perak (SUB)</td>
                    <td>Soekarno-Hatta (MAK)</td>
                    <td>20/07/2026</td>
                    <td>21/07/2026</td>
                    <td><span class="badge badge-pending"><i class="bi bi-calendar-check-fill me-1"></i>Terjadwal</span></td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-outline-secondary btn-action-table" disabled>
                            <i class="bi bi-lock-fill"></i> Logbook
                        </button>
                    </td>
                </tr>
                <!-- Voyage 4 -->
                <tr>
                    <td><strong>Balikpapan → Surabaya</strong></td>
                    <td>Semayang (BPN)</td>
                    <td>Tanjung Perak (SUB)</td>
                    <td>12/07/2026</td>
                    <td>13/07/2026</td>
                    <td><span class="badge badge-verified"><i class="bi bi-check-circle-fill me-1"></i>Selesai</span></td>
                    <td class="text-center">
                        <a href="{{ route('awak.riwayat') }}" class="btn btn-sm btn-outline-primary btn-action-table">
                            <i class="bi bi-eye-fill"></i> Lihat Log
                        </a>
                    </td>
                </tr>
                <!-- Voyage 5 -->
                <tr>
                    <td><strong>Surabaya → Balikpapan</strong></td>
                    <td>Tanjung Perak (SUB)</td>
                    <td>Semayang (BPN)</td>
                    <td>10/07/2026</td>
                    <td>11/07/2026</td>
                    <td><span class="badge badge-verified"><i class="bi bi-check-circle-fill me-1"></i>Selesai</span></td>
                    <td class="text-center">
                        <a href="{{ route('awak.riwayat') }}" class="btn btn-sm btn-outline-primary btn-action-table">
                            <i class="bi bi-eye-fill"></i> Lihat Log
                        </a>
                    </td>
                </tr>
                <!-- Voyage 6 -->
                <tr>
                    <td><strong>Surabaya → Banjarmasin</strong></td>
                    <td>Tanjung Perak (SUB)</td>
                    <td>Trisakti (BDJ)</td>
                    <td>08/07/2026</td>
                    <td>09/07/2026</td>
                    <td><span class="badge badge-empty"><i class="bi bi-x-circle-fill me-1"></i>Batal</span></td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-light text-danger btn-action-table" disabled>
                            <i class="bi bi-x-circle me-1"></i>Dibatalkan
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
