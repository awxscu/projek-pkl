@extends('layouts.dashboard')

@section('title', 'Verifikasi Logbook')
@section('navbar') @include('partials.navbar-pertamina') @endsection

@section('content')
<div class="page-header">
    <h4><i class="bi bi-patch-check me-2 text-pertamina-blue"></i>Verifikasi Logbook</h4>
    <p>Verifikasi atau tolak logbook yang telah diinput oleh awak kapal</p>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card-modern stat-card stat-yellow">
            <div class="d-flex justify-content-between align-items-center">
                <div><div class="stat-label">Menunggu Verifikasi</div><div class="stat-value">5</div></div>
                <div class="stat-icon" style="background:#fef3c7;color:#b45309"><i class="bi bi-hourglass-split"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-modern stat-card stat-green">
            <div class="d-flex justify-content-between align-items-center">
                <div><div class="stat-label">Terverifikasi Hari Ini</div><div class="stat-value">9</div></div>
                <div class="stat-icon" style="background:#dcfce7;color:#15803d"><i class="bi bi-check-circle"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-modern stat-card stat-red">
            <div class="d-flex justify-content-between align-items-center">
                <div><div class="stat-label">Ditolak</div><div class="stat-value">1</div></div>
                <div class="stat-icon" style="background:#fee2e2;color:#E31E24"><i class="bi bi-x-circle"></i></div>
            </div>
        </div>
    </div>
</div>

<div class="card-modern">
    <div class="p-3 border-bottom"><h6 class="mb-0 fw-bold">Daftar Logbook Perlu Verifikasi</h6></div>
    <div class="table-responsive">
        <table class="table table-modern">
            <thead>
                <tr>
                    <th>ID Logbook</th>
                    <th>Kapal</th>
                    <th>Awak Kapal</th>
                    <th>Tanggal</th>
                    <th>Total Pemakaian</th>
                    <th>Catatan</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>#LB-2026-0142</td>
                    <td>KM Bahari Sejahtera (VSL-004)</td>
                    <td>Rudi Hartono</td>
                    <td>14/07/2026</td>
                    <td>198 L</td>
                    <td>Operasi normal</td>
                    <td>
                        <button class="btn btn-sm btn-success"><i class="bi bi-check-lg me-1"></i>Verifikasi</button>
                        <button class="btn btn-sm btn-danger"><i class="bi bi-x-lg me-1"></i>Tolak</button>
                    </td>
                </tr>
                <tr>
                    <td>#LB-2026-0141</td>
                    <td>KM Citra Lautan (VSL-005)</td>
                    <td>Dedi Kurniawan</td>
                    <td>14/07/2026</td>
                    <td>410 L</td>
                    <td>Pemakaian tinggi karena arus kuat</td>
                    <td>
                        <button class="btn btn-sm btn-success"><i class="bi bi-check-lg me-1"></i>Verifikasi</button>
                        <button class="btn btn-sm btn-danger"><i class="bi bi-x-lg me-1"></i>Tolak</button>
                    </td>
                </tr>
                <tr>
                    <td>#LB-2026-0138</td>
                    <td>KM Samudera Makmur (VSL-007)</td>
                    <td>Joko Prasetyo</td>
                    <td>14/07/2026</td>
                    <td>265 L</td>
                    <td>—</td>
                    <td>
                        <button class="btn btn-sm btn-success"><i class="bi bi-check-lg me-1"></i>Verifikasi</button>
                        <button class="btn btn-sm btn-danger"><i class="bi bi-x-lg me-1"></i>Tolak</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
