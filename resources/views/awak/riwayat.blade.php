@extends('layouts.dashboard')

@section('title', 'Riwayat Logbook')
@section('navbar') @include('partials.navbar-awak') @endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
    <div>
        <h4><i class="bi bi-clock-history me-2 text-pertamina-blue"></i>Riwayat Logbook Kapal</h4>
        <p>Riwayat pengisian logbook pemakaian BBM & pelumas kapal KM Nusantara Jaya</p>
    </div>
    <a href="{{ route('logbook.create') }}" class="btn btn-pertamina btn-sm">
        <i class="bi bi-plus-lg me-1"></i>Tulis Logbook Baru
    </a>
</div>

<!-- FILTERS -->
<div class="card-modern filter-card p-3 mb-4">
    <form class="row g-3 align-items-end">
        <div class="col-md-4">
            <label class="form-label">Tanggal Mulai</label>
            <input type="date" class="form-control" value="2026-07-01">
        </div>
        <div class="col-md-4">
            <label class="form-label">Tanggal Selesai</label>
            <input type="date" class="form-control" value="2026-07-14">
        </div>
        <div class="col-md-4">
            <button type="button" class="btn btn-pertamina w-100">
                <i class="bi bi-search me-1"></i>Filter Riwayat
            </button>
        </div>
    </form>
</div>

<!-- HISTORY TABLE -->
<div class="card-modern">
    <div class="table-responsive">
        <table class="table table-modern">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Vessel Code</th>
                    <th>Rute Perjalanan</th>
                    <th>Total Konsumsi (DO/FO/Lube)</th>
                    <th>Status Verifikasi</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                <!-- Row 1 -->
                <tr>
                    <td>14/07/2026</td>
                    <td><strong>VSL-001</strong></td>
                    <td>Surabaya → Balikpapan</td>
                    <td>
                        <span class="badge bg-primary">DO: 320L</span>
                        <span class="badge bg-danger">FO: 0L</span>
                        <span class="badge bg-warning text-dark">Lube: 17L</span>
                    </td>
                    <td><span class="badge badge-verified"><i class="bi bi-check-circle-fill me-1"></i>Verified</span></td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#detailModal1">
                            <i class="bi bi-eye"></i> Detail
                        </button>
                    </td>
                </tr>
                <!-- Row 2 -->
                <tr>
                    <td>13/07/2026</td>
                    <td><strong>VSL-001</strong></td>
                    <td>Surabaya (Persiapan/Sandar)</td>
                    <td>
                        <span class="badge bg-primary">DO: 45L</span>
                        <span class="badge bg-danger">FO: 0L</span>
                        <span class="badge bg-warning text-dark">Lube: 3L</span>
                    </td>
                    <td><span class="badge badge-verified"><i class="bi bi-check-circle-fill me-1"></i>Verified</span></td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#detailModal2">
                            <i class="bi bi-eye"></i> Detail
                        </button>
                    </td>
                </tr>
                <!-- Row 3 -->
                <tr>
                    <td>12/07/2026</td>
                    <td><strong>VSL-001</strong></td>
                    <td>Balikpapan → Surabaya</td>
                    <td>
                        <span class="badge bg-primary">DO: 310L</span>
                        <span class="badge bg-danger">FO: 0L</span>
                        <span class="badge bg-warning text-dark">Lube: 15L</span>
                    </td>
                    <td><span class="badge badge-verified"><i class="bi bi-check-circle-fill me-1"></i>Verified</span></td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#detailModal3">
                            <i class="bi bi-eye"></i> Detail
                        </button>
                    </td>
                </tr>
                <!-- Row 4 -->
                <tr>
                    <td>11/07/2026</td>
                    <td><strong>VSL-001</strong></td>
                    <td>Balikpapan (Sandar)</td>
                    <td>
                        <span class="badge bg-primary">DO: 25L</span>
                        <span class="badge bg-danger">FO: 0L</span>
                        <span class="badge bg-warning text-dark">Lube: 2L</span>
                    </td>
                    <td><span class="badge badge-pending"><i class="bi bi-hourglass-split me-1"></i>Pending</span></td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#detailModal4">
                            <i class="bi bi-eye"></i> Detail
                        </button>
                    </td>
                </tr>
                <!-- Row 5 -->
                <tr>
                    <td>10/07/2026</td>
                    <td><strong>VSL-001</strong></td>
                    <td>Surabaya → Balikpapan</td>
                    <td>
                        <span class="badge bg-primary">DO: 295L</span>
                        <span class="badge bg-danger">FO: 0L</span>
                        <span class="badge bg-warning text-dark">Lube: 12L</span>
                    </td>
                    <td><span class="badge badge-verified"><i class="bi bi-check-circle-fill me-1"></i>Verified</span></td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#detailModal5">
                            <i class="bi bi-eye"></i> Detail
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- DETAIL MODALS (DUMMY DATA FOR DEMO) -->
@for ($i = 1; $i <= 5; $i++)
@php
    $dates = [1 => '14/07/2026', 2 => '13/07/2026', 3 => '12/07/2026', 4 => '11/07/2026', 5 => '10/07/2026'];
    $routes = [1 => 'Surabaya → Balikpapan', 2 => 'Surabaya (Persiapan/Sandar)', 3 => 'Balikpapan → Surabaya', 4 => 'Balikpapan (Sandar)', 5 => 'Surabaya → Balikpapan'];
    $status = [1 => 'Verified', 2 => 'Verified', 3 => 'Verified', 4 => 'Pending', 5 => 'Verified'];
    $badge = [1 => 'badge-verified', 2 => 'badge-verified', 3 => 'badge-verified', 4 => 'badge-pending', 5 => 'badge-verified'];
    $do_kemarin = [1 => 1250, 2 => 1295, 3 => 1605, 4 => 1630, 5 => 1925];
    $do_induk = [1 => 200, 2 => 30, 3 => 190, 4 => 15, 5 => 185];
    $do_bantu = [1 => 80, 2 => 10, 3 => 85, 4 => 8, 5 => 75];
    $do_lain = [1 => 40, 2 => 5, 3 => 35, 4 => 2, 5 => 35];
    $do_tambah = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];
    $do_sekarang = [1 => 930, 2 => 1250, 3 => 1295, 4 => 1605, 5 => 1630];
@endphp
<div class="modal fade" id="detailModal{{ $i }}" tabindex="-1" aria-labelledby="detailModalLabel{{ $i }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold text-pertamina-blue" id="detailModalLabel{{ $i }}">
                    <i class="bi bi-file-earmark-text me-2"></i>Detail Logbook — {{ $dates[$i] }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Info Header -->
                <div class="row g-3 mb-4 border-bottom pb-3">
                    <div class="col-md-6 col-lg-3">
                        <small class="text-muted d-block">Nama Kapal</small>
                        <span class="fw-semibold">KM Nusantara Jaya</span>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <small class="text-muted d-block">Vessel Code / Sektor</small>
                        <span class="fw-semibold">VSL-001 / Penumpang</span>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <small class="text-muted d-block">Rute Pelayaran</small>
                        <span class="fw-semibold">{{ $routes[$i] }}</span>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <small class="text-muted d-block">Status Verifikasi</small>
                        <span class="badge {{ $badge[$i] }}">{{ $status[$i] }}</span>
                    </div>
                </div>

                <!-- Fuel Tables -->
                <h6 class="fw-bold text-pertamina-blue mb-2"><i class="bi bi-droplet-fill me-1"></i> Rincian Konsumsi BBM (Liter)</h6>
                <div class="table-responsive mb-4">
                    <table class="table table-bordered table-sm small">
                        <thead class="table-light text-center">
                            <tr>
                                <th>Jenis BBM</th>
                                <th>Sisa Kemarin</th>
                                <th>Motor Induk</th>
                                <th>Motor Bantu</th>
                                <th>Lain-lain</th>
                                <th>Ditambah</th>
                                <th>Sisa Sekarang</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <tr>
                                <td class="fw-semibold text-start">Diesel Oil (DO)</td>
                                <td>{{ $do_kemarin[$i] }}</td>
                                <td>{{ $do_induk[$i] }}</td>
                                <td>{{ $do_bantu[$i] }}</td>
                                <td>{{ $do_lain[$i] }}</td>
                                <td>{{ $do_tambah[$i] }}</td>
                                <td class="fw-bold text-primary">{{ $do_sekarang[$i] }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-start">Fuel Oil (FO)</td>
                                <td>800</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td class="fw-bold text-danger">800</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-start">Lube Oil</td>
                                <td>300</td>
                                <td>10</td>
                                <td>5</td>
                                <td>2</td>
                                <td>0</td>
                                <td class="fw-bold text-warning text-dark">283</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-start">Cylinder Oil</td>
                                <td>150</td>
                                <td>5</td>
                                <td>2</td>
                                <td>1</td>
                                <td>0</td>
                                <td class="fw-bold text-secondary">142</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Notes Section -->
                <div class="p-3 bg-light rounded">
                    <h6 class="fw-bold mb-1 small"><i class="bi bi-chat-left-text me-1"></i> Catatan Awak Kapal:</h6>
                    <p class="mb-0 text-muted small">
                        {{ $i == 1 ? 'Operasi pelayaran normal, cuaca bersahabat.' : ($i == 4 ? 'Menunggu kapal tangki untuk pengisian ulang BBM jenis DO.' : 'Tidak ada kendala operasional.') }}
                    </p>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endfor

@endsection
