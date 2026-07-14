@extends('layouts.dashboard')

@section('title', 'Jadwal Perjalanan')
@section('navbar') @include('partials.navbar-pertamina') @endsection

@section('content')
<div class="page-header">
    <h4><i class="bi bi-signpost-split me-2 text-pertamina-blue"></i>Jadwal Perjalanan Kapal</h4>
    <p>Monitoring jadwal perjalanan seluruh kapal penumpang</p>
</div>

<div class="card-modern filter-card">
    <form class="row g-3 align-items-end">
        <div class="col-md-4">
            <label class="form-label">Kapal</label>
            <select class="form-select">
                <option value="">Semua Kapal</option>
                <option>KM Nusantara Jaya</option>
                <option>KM Samudra Indah</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Status</label>
            <select class="form-select">
                <option value="">Semua</option>
                <option>Terjadwal</option>
                <option>Berlangsung</option>
                <option>Selesai</option>
                <option>Batal</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Tanggal</label>
            <input type="date" class="form-control" value="2026-07-14">
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
                    <th>Vessel Code</th>
                    <th>Pelabuhan Asal</th>
                    <th>Pelabuhan Tujuan</th>
                    <th>Berangkat</th>
                    <th>Tiba</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>KM Nusantara Jaya</td>
                    <td>VSL-001</td>
                    <td>Surabaya</td>
                    <td>Balikpapan</td>
                    <td>14/07/2026 06:00</td>
                    <td>15/07/2026 14:00</td>
                    <td><span class="badge" style="background:#dbeafe;color:#1d4ed8">Berlangsung</span></td>
                </tr>
                <tr>
                    <td>KM Samudra Indah</td>
                    <td>VSL-002</td>
                    <td>Jakarta</td>
                    <td>Semarang</td>
                    <td>14/07/2026 08:00</td>
                    <td>14/07/2026 20:00</td>
                    <td><span class="badge" style="background:#dbeafe;color:#1d4ed8">Berlangsung</span></td>
                </tr>
                <tr>
                    <td>KM Pelangi Nusantara</td>
                    <td>VSL-003</td>
                    <td>Makassar</td>
                    <td>Baubau</td>
                    <td>16/07/2026 07:00</td>
                    <td>17/07/2026 10:00</td>
                    <td><span class="badge badge-pending">Terjadwal</span></td>
                </tr>
                <tr>
                    <td>KM Bahari Sejahtera</td>
                    <td>VSL-004</td>
                    <td>Denpasar</td>
                    <td>Lombok</td>
                    <td>13/07/2026 09:00</td>
                    <td>13/07/2026 18:00</td>
                    <td><span class="badge badge-verified">Selesai</span></td>
                </tr>
                <tr>
                    <td>KM Citra Lautan</td>
                    <td>VSL-005</td>
                    <td>Pontianak</td>
                    <td>Ketapang</td>
                    <td>15/07/2026 06:30</td>
                    <td>15/07/2026 16:00</td>
                    <td><span class="badge badge-pending">Terjadwal</span></td>
                </tr>
                <tr>
                    <td>KM Lautan Biru</td>
                    <td>VSL-006</td>
                    <td>Balikpapan</td>
                    <td>Tarakan</td>
                    <td>12/07/2026 10:00</td>
                    <td>—</td>
                    <td><span class="badge badge-empty">Batal</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
