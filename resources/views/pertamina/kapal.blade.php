@extends('layouts.dashboard')

@section('title', 'Data Kapal')
@section('navbar') @include('partials.navbar-pertamina') @endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-start flex-wrap gap-2">
    <div>
        <h4><i class="bi bi-ship me-2 text-pertamina-blue"></i>Data Kapal</h4>
        <p>Daftar kapal penumpang yang terdaftar dalam sistem</p>
    </div>
    <button class="btn btn-pertamina btn-sm"><i class="bi bi-plus-lg me-1"></i>Tambah Kapal</button>
</div>

<div class="card-modern">
    <div class="table-responsive">
        <table class="table table-modern">
            <thead>
                <tr>
                    <th>Nama Kapal</th>
                    <th>Kode Vessel</th>
                    <th>Klasifikasi Sektor</th>
                    <th>Kelompok Kuota</th>
                    <th>Stok BBM (L)</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><i class="bi bi-ship me-1 text-pertamina-blue"></i> KM Nusantara Jaya</td>
                    <td><strong>VSL-001</strong></td>
                    <td>Kapal Penumpang</td>
                    <td>Kuota A</td>
                    <td>1.250</td>
                    <td><span class="badge badge-filled">Aktif</span></td>
                </tr>
                <tr>
                    <td><i class="bi bi-ship me-1 text-pertamina-blue"></i> KM Samudra Indah</td>
                    <td><strong>VSL-002</strong></td>
                    <td>Kapal Penumpang</td>
                    <td>Kuota A</td>
                    <td>980</td>
                    <td><span class="badge badge-filled">Aktif</span></td>
                </tr>
                <tr>
                    <td><i class="bi bi-ship me-1 text-pertamina-blue"></i> KM Pelangi Nusantara</td>
                    <td><strong>VSL-003</strong></td>
                    <td>Kapal Penumpang</td>
                    <td>Kuota B</td>
                    <td>1.450</td>
                    <td><span class="badge badge-filled">Aktif</span></td>
                </tr>
                <tr>
                    <td><i class="bi bi-ship me-1 text-pertamina-blue"></i> KM Bahari Sejahtera</td>
                    <td><strong>VSL-004</strong></td>
                    <td>Kapal Penumpang</td>
                    <td>Kuota B</td>
                    <td>720</td>
                    <td><span class="badge badge-filled">Aktif</span></td>
                </tr>
                <tr>
                    <td><i class="bi bi-ship me-1 text-pertamina-blue"></i> KM Citra Lautan</td>
                    <td><strong>VSL-005</strong></td>
                    <td>Kapal Penumpang</td>
                    <td>Kuota A</td>
                    <td>1.100</td>
                    <td><span class="badge badge-filled">Aktif</span></td>
                </tr>
                <tr>
                    <td><i class="bi bi-ship me-1 text-pertamina-blue"></i> KM Lautan Biru</td>
                    <td><strong>VSL-006</strong></td>
                    <td>Kapal Penumpang</td>
                    <td>Kuota C</td>
                    <td>890</td>
                    <td><span class="badge badge-pending">Perawatan</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
