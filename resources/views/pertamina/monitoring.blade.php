@extends('layouts.dashboard')

@section('title', 'Monitoring Logbook')
@section('navbar') @include('partials.navbar-pertamina') @endsection

@section('content')
<div class="page-header">
    <h4><i class="bi bi-eye me-2 text-pertamina-blue"></i>Monitoring Logbook</h4>
    <p>Pantau dan kelola logbook pemakaian BBM seluruh kapal penumpang</p>
</div>

<div class="card-modern filter-card">
    <form class="row g-3 align-items-end">
        <div class="col-md-3">
            <label class="form-label">Kapal</label>
            <select class="form-select">
                <option value="">Semua Kapal</option>
                <option>KM Nusantara Jaya</option>
                <option>KM Samudra Indah</option>
                <option>KM Pelangi Nusantara</option>
                <option>KM Bahari Sejahtera</option>
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label">Vessel Code</label>
            <input type="text" class="form-control" placeholder="VSL-001">
        </div>
        <div class="col-md-2">
            <label class="form-label">Tanggal</label>
            <input type="date" class="form-control" value="2026-07-14">
        </div>
        <div class="col-md-3">
            <label class="form-label">Status Verifikasi</label>
            <select class="form-select">
                <option value="">Semua Status</option>
                <option>Verified</option>
                <option>Pending</option>
                <option>Belum Mengisi</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-pertamina w-100"><i class="bi bi-search me-1"></i>Filter</button>
        </div>
    </form>
</div>

<div class="card-modern">
    <div class="table-responsive">
        <table class="table table-modern">
            <thead>
                <tr>
                    <th>Kapal</th>
                    <th>Awak Kapal</th>
                    <th>Tanggal</th>
                    <th>Rute Perjalanan</th>
                    <th>Pemakaian BBM</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr id="row-monitoring-1">
                    <td><strong>KM Nusantara Jaya</strong><br><small class="text-muted">VSL-001</small></td>
                    <td>Budi Santoso</td>
                    <td>14/07/2026</td>
                    <td>Surabaya → Balikpapan</td>
                    <td>320 L</td>
                    <td><span class="badge badge-verified status-badge">Verified</span></td>
                </tr>
                <tr id="row-monitoring-2">
                    <td><strong>KM Samudra Indah</strong><br><small class="text-muted">VSL-002</small></td>
                    <td>Andi Wijaya</td>
                    <td>14/07/2026</td>
                    <td>Jakarta → Semarang</td>
                    <td>285 L</td>
                    <td><span class="badge badge-verified status-badge">Verified</span></td>
                </tr>
                <tr id="row-monitoring-3">
                    <td><strong>KM Bahari Sejahtera</strong><br><small class="text-muted">VSL-004</small></td>
                    <td>Rudi Hartono</td>
                    <td>14/07/2026</td>
                    <td>Denpasar → Lombok</td>
                    <td>198 L</td>
                    <td><span class="badge badge-pending status-badge">Pending</span></td>
                </tr>
                <tr id="row-monitoring-4">
                    <td><strong>KM Pelangi Nusantara</strong><br><small class="text-muted">VSL-003</small></td>
                    <td>Siti Aminah</td>
                    <td>14/07/2026</td>
                    <td>Makassar → Baubau</td>
                    <td>—</td>
                    <td><span class="badge badge-empty status-badge">Belum Mengisi</span></td>
                </tr>
                <tr id="row-monitoring-5">
                    <td><strong>KM Citra Lautan</strong><br><small class="text-muted">VSL-005</small></td>
                    <td>Dedi Kurniawan</td>
                    <td>14/07/2026</td>
                    <td>Pontianak → Ketapang</td>
                    <td>410 L</td>
                    <td><span class="badge badge-pending status-badge">Pending</span></td>
                </tr>
                <tr id="row-monitoring-6">
                    <td><strong>KM Lautan Biru</strong><br><small class="text-muted">VSL-006</small></td>
                    <td>Hendra Gunawan</td>
                    <td>13/07/2026</td>
                    <td>Balikpapan → Tarakan</td>
                    <td>350 L</td>
                    <td><span class="badge badge-verified status-badge">Verified</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
