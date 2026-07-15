@extends('layouts.dashboard')

@section('title', 'Riwayat Logbook')
@section('navbar') @include('partials.navbar-awak') @endsection

@section('content')
@php
    $dates = [1 => '14/07/2026', 2 => '13/07/2026', 3 => '12/07/2026', 4 => '11/07/2026', 5 => '10/07/2026'];
    $routes = [1 => 'Surabaya → Balikpapan', 2 => 'Surabaya (Persiapan/Sandar)', 3 => 'Balikpapan → Surabaya', 4 => 'Balikpapan (Sandar)', 5 => 'Surabaya → Balikpapan'];
    $status = [1 => 'Verified', 2 => 'Verified', 3 => 'Verified', 4 => 'Pending', 5 => 'Verified'];
    $badge = [1 => 'badge-verified', 2 => 'badge-verified', 3 => 'badge-verified', 4 => 'badge-pending', 5 => 'badge-verified'];
    
    // DO
    $do_kemarin = [1 => 1250, 2 => 1295, 3 => 1605, 4 => 1630, 5 => 1925];
    $do_induk = [1 => 200, 2 => 30, 3 => 190, 4 => 15, 5 => 185];
    $do_bantu = [1 => 80, 2 => 10, 3 => 85, 4 => 8, 5 => 75];
    $do_lain = [1 => 40, 2 => 5, 3 => 35, 4 => 2, 5 => 35];
    $do_tambah = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];
    
    // FO
    $fo_kemarin = [1 => 800, 2 => 800, 3 => 800, 4 => 800, 5 => 800];
    $fo_induk = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];
    $fo_bantu = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];
    $fo_lain = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];
    $fo_tambah = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];

    // Lube
    $lube_kemarin = [1 => 300, 2 => 300, 3 => 300, 4 => 300, 5 => 300];
    $lube_induk = [1 => 10, 2 => 1, 3 => 10, 4 => 1, 5 => 10];
    $lube_bantu = [1 => 5, 2 => 1, 3 => 5, 4 => 1, 5 => 5];
    $lube_lain = [1 => 2, 2 => 1, 3 => 2, 4 => 0, 5 => 2];
    $lube_tambah = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];

    // Cylinder
    $cyl_kemarin = [1 => 150, 2 => 150, 3 => 150, 4 => 150, 5 => 150];
    $cyl_induk = [1 => 5, 2 => 5, 3 => 5, 4 => 5, 5 => 5];
    $cyl_bantu = [1 => 2, 2 => 2, 3 => 2, 4 => 2, 5 => 2];
    $cyl_lain = [1 => 1, 2 => 1, 3 => 1, 4 => 1, 5 => 1];
    $cyl_tambah = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];

    // Catatan
    $catatan = [
        1 => 'Operasi pelayaran normal, cuaca bersahabat.',
        2 => 'Tidak ada kendala operasional.',
        3 => 'Tidak ada kendala operasional.',
        4 => 'Menunggu kapal tangki untuk pengisian ulang BBM jenis DO.',
        5 => 'Tidak ada kendala operasional.'
    ];
@endphp

<div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
    <div>
        <h4><i class="bi bi-clock-history me-2 text-pertamina-blue"></i>Riwayat Logbook Kapal</h4>
        <p class="text-muted mb-0 small">Riwayat pengisian logbook pemakaian BBM & pelumas kapal KM Nusantara Jaya</p>
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
                    <th>Total Konsumsi (DO/FO/Lube/Cylinder)</th>
                    <th>Status Verifikasi</th>
                    <th style="width: 150px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 1; $i <= 5; $i++)
                @php
                    $do_cons = $do_induk[$i] + $do_bantu[$i] + $do_lain[$i];
                    $fo_cons = $fo_induk[$i] + $fo_bantu[$i] + $fo_lain[$i];
                    $lube_cons = $lube_induk[$i] + $lube_bantu[$i] + $lube_lain[$i];
                    $cyl_cons = $cyl_induk[$i] + $cyl_bantu[$i] + $cyl_lain[$i];
                @endphp
                <tr id="row-{{ $i }}">
                    <td>{{ $dates[$i] }}</td>
                    <td><strong>VSL-001</strong></td>
                    <td>{{ $routes[$i] }}</td>
                    <td>
                        <span class="badge bg-primary" id="do-badge-{{ $i }}">DO: {{ $do_cons }}L</span>
                        <span class="badge bg-danger" id="fo-badge-{{ $i }}">FO: {{ $fo_cons }}L</span>
                        <span class="badge bg-warning text-dark" id="lube-badge-{{ $i }}">Lube: {{ $lube_cons }}L</span>
                        <span class="badge text-white" id="cyl-badge-{{ $i }}" style="background: #eab308;">CO: {{ $cyl_cons }}L</span>
                    </td>
                    <td>
                        @if ($status[$i] == 'Verified')
                            <span class="badge badge-verified"><i class="bi bi-check-circle-fill me-1"></i>Verified</span>
                        @else
                            <span class="badge badge-pending"><i class="bi bi-hourglass-split me-1"></i>Pending</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="d-flex gap-1 justify-content-center">
                            <button class="btn btn-sm btn-outline-primary px-2" data-bs-toggle="modal" data-bs-target="#detailModal{{ $i }}" title="Detail">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-warning edit-logbook-btn px-2" 
                                data-id="{{ $i }}" 
                                data-date="{{ $dates[$i] }}" 
                                data-route="{{ $routes[$i] }}"
                                data-do-kemarin="{{ $do_kemarin[$i] }}" data-do-induk="{{ $do_induk[$i] }}" data-do-bantu="{{ $do_bantu[$i] }}" data-do-lain="{{ $do_lain[$i] }}" data-do-tambah="{{ $do_tambah[$i] }}"
                                data-fo-kemarin="{{ $fo_kemarin[$i] }}" data-fo-induk="{{ $fo_induk[$i] }}" data-fo-bantu="{{ $fo_bantu[$i] }}" data-fo-lain="{{ $fo_lain[$i] }}" data-fo-tambah="{{ $fo_tambah[$i] }}"
                                data-lube-kemarin="{{ $lube_kemarin[$i] }}" data-lube-induk="{{ $lube_induk[$i] }}" data-lube-bantu="{{ $lube_bantu[$i] }}" data-lube-lain="{{ $lube_lain[$i] }}" data-lube-tambah="{{ $lube_tambah[$i] }}"
                                data-cyl-kemarin="{{ $cyl_kemarin[$i] }}" data-cyl-induk="{{ $cyl_induk[$i] }}" data-cyl-bantu="{{ $cyl_bantu[$i] }}" data-cyl-lain="{{ $cyl_lain[$i] }}" data-cyl-tambah="{{ $cyl_tambah[$i] }}"
                                data-catatan="{{ $catatan[$i] }}" 
                                title="Edit">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger delete-logbook-btn px-2" 
                                data-id="{{ $i }}" 
                                title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endfor
            </tbody>
        </table>
    </div>
</div>

<!-- DETAIL MODALS (DUMMY DATA FOR DEMO) -->
@for ($i = 1; $i <= 5; $i++)
@php
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

<!-- EDIT MODAL -->
<div class="modal fade" id="editLogbookModal" tabindex="-1" aria-labelledby="editLogbookModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 20px; overflow: hidden;">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold text-pertamina-blue" id="editLogbookModalLabel">
                    <i class="bi bi-pencil-square me-2"></i>Edit Logbook Kapal
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editLogbookForm">
                <input type="hidden" id="edit_row_id">
                <div class="modal-body p-4">
                    <!-- General Info -->
                    <div class="row g-3 mb-4 border-bottom pb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Tanggal Pencatatan</label>
                            <input type="text" class="form-control" id="edit_tanggal" readonly style="background-color:#e9ecef;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Rute Pelayaran</label>
                            <input type="text" class="form-control" id="edit_rute" readonly style="background-color:#e9ecef;">
                        </div>
                    </div>

                    <!-- Tabs for BBM -->
                    <ul class="nav nav-tabs mb-3" id="editBbmTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="edit-do-tab" data-bs-toggle="tab" data-bs-target="#edit-do-content" type="button" role="tab"><i class="bi bi-droplet-fill text-pertamina-blue me-1"></i>DO</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="edit-fo-tab" data-bs-toggle="tab" data-bs-target="#edit-fo-content" type="button" role="tab"><i class="bi bi-droplet-half text-pertamina-red me-1"></i>FO</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="edit-lube-tab" data-bs-toggle="tab" data-bs-target="#edit-lube-content" type="button" role="tab"><i class="bi bi-oil-barrel text-warning me-1"></i>Lube Oil</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="edit-cyl-tab" data-bs-toggle="tab" data-bs-target="#edit-cyl-content" type="button" role="tab"><i class="bi bi-gear-wide-connected text-secondary me-1"></i>Cylinder</button>
                        </li>
                    </ul>

                    <div class="tab-content border p-3 rounded bg-white mb-4" id="editBbmTabsContent">
                        <!-- DO Content -->
                        <div class="tab-pane fade show active" id="edit-do-content" role="tabpanel">
                            <div class="row g-3">
                                <div class="col-md-4"><label class="form-label small">Sisa Kemarin (L)</label><input type="number" class="form-control form-control-sm edit-calc" id="edit_do_kemarin"></div>
                                <div class="col-md-4"><label class="form-label small">Motor Induk (L)</label><input type="number" class="form-control form-control-sm edit-calc" id="edit_do_induk"></div>
                                <div class="col-md-4"><label class="form-label small">Motor Bantu (L)</label><input type="number" class="form-control form-control-sm edit-calc" id="edit_do_bantu"></div>
                                <div class="col-md-4"><label class="form-label small">Lain-lain (L)</label><input type="number" class="form-control form-control-sm edit-calc" id="edit_do_lain"></div>
                                <div class="col-md-4"><label class="form-label small">Ditambah (L)</label><input type="number" class="form-control form-control-sm edit-calc" id="edit_do_tambah"></div>
                                <div class="col-md-4"><label class="form-label small fw-bold text-pertamina-blue">Sisa Sekarang (L)</label><input type="number" class="form-control form-control-sm bg-light fw-bold text-pertamina-blue" id="edit_do_sekarang" readonly></div>
                            </div>
                        </div>
                        <!-- FO Content -->
                        <div class="tab-pane fade" id="edit-fo-content" role="tabpanel">
                            <div class="row g-3">
                                <div class="col-md-4"><label class="form-label small">Sisa Kemarin (L)</label><input type="number" class="form-control form-control-sm edit-calc" id="edit_fo_kemarin"></div>
                                <div class="col-md-4"><label class="form-label small">Motor Induk (L)</label><input type="number" class="form-control form-control-sm edit-calc" id="edit_fo_induk"></div>
                                <div class="col-md-4"><label class="form-label small">Motor Bantu (L)</label><input type="number" class="form-control form-control-sm edit-calc" id="edit_fo_bantu"></div>
                                <div class="col-md-4"><label class="form-label small">Lain-lain (L)</label><input type="number" class="form-control form-control-sm edit-calc" id="edit_fo_lain"></div>
                                <div class="col-md-4"><label class="form-label small">Ditambah (L)</label><input type="number" class="form-control form-control-sm edit-calc" id="edit_fo_tambah"></div>
                                <div class="col-md-4"><label class="form-label small fw-bold text-pertamina-red">Sisa Sekarang (L)</label><input type="number" class="form-control form-control-sm bg-light fw-bold text-pertamina-red" id="edit_fo_sekarang" readonly></div>
                            </div>
                        </div>
                        <!-- LUBE OIL Content -->
                        <div class="tab-pane fade" id="edit-lube-content" role="tabpanel">
                            <div class="row g-3">
                                <div class="col-md-4"><label class="form-label small">Sisa Kemarin (L)</label><input type="number" class="form-control form-control-sm edit-calc" id="edit_lube_kemarin"></div>
                                <div class="col-md-4"><label class="form-label small">Motor Induk (L)</label><input type="number" class="form-control form-control-sm edit-calc" id="edit_lube_induk"></div>
                                <div class="col-md-4"><label class="form-label small">Motor Bantu (L)</label><input type="number" class="form-control form-control-sm edit-calc" id="edit_lube_bantu"></div>
                                <div class="col-md-4"><label class="form-label small">Lain-lain (L)</label><input type="number" class="form-control form-control-sm edit-calc" id="edit_lube_lain"></div>
                                <div class="col-md-4"><label class="form-label small">Ditambah (L)</label><input type="number" class="form-control form-control-sm edit-calc" id="edit_lube_tambah"></div>
                                <div class="col-md-4"><label class="form-label small fw-bold text-warning text-dark">Sisa Sekarang (L)</label><input type="number" class="form-control form-control-sm bg-light fw-bold text-warning text-dark" id="edit_lube_sekarang" readonly></div>
                            </div>
                        </div>
                        <!-- CYLINDER OIL Content -->
                        <div class="tab-pane fade" id="edit-cyl-content" role="tabpanel">
                            <div class="row g-3">
                                <div class="col-md-4"><label class="form-label small">Sisa Kemarin (L)</label><input type="number" class="form-control form-control-sm edit-calc" id="edit_cyl_kemarin"></div>
                                <div class="col-md-4"><label class="form-label small">Motor Induk (L)</label><input type="number" class="form-control form-control-sm edit-calc" id="edit_cyl_induk"></div>
                                <div class="col-md-4"><label class="form-label small">Motor Bantu (L)</label><input type="number" class="form-control form-control-sm edit-calc" id="edit_cyl_bantu"></div>
                                <div class="col-md-4"><label class="form-label small">Lain-lain (L)</label><input type="number" class="form-control form-control-sm edit-calc" id="edit_cyl_lain"></div>
                                <div class="col-md-4"><label class="form-label small">Ditambah (L)</label><input type="number" class="form-control form-control-sm edit-calc" id="edit_cyl_tambah"></div>
                                <div class="col-md-4"><label class="form-label small fw-bold text-secondary">Sisa Sekarang (L)</label><input type="number" class="form-control form-control-sm bg-light fw-bold text-secondary" id="edit_cyl_sekarang" readonly></div>
                            </div>
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Catatan Awak Kapal</label>
                        <textarea class="form-control" id="edit_catatan" rows="3" placeholder="Masukkan catatan tambahan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-pertamina btn-sm"><i class="bi bi-save me-1"></i>Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- DELETE CONFIRMATION MODAL -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px;">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold text-danger" id="deleteConfirmModalLabel">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <i class="bi bi-trash-fill text-danger" style="font-size: 3rem;"></i>
                <h5 class="fw-bold mt-3">Apakah Anda yakin ingin menghapus logbook ini?</h5>
                <p class="text-muted small">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer bg-light justify-content-center">
                <button type="button" class="btn btn-outline-secondary btn-sm px-4" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger btn-sm px-4" id="confirmDeleteBtn"><i class="bi bi-trash me-1"></i>Ya, Hapus</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let deleteId = null;

        // Function to recalculate current fuel stock in Edit Modal
        function recalculate(prefix) {
            const kemarin = parseFloat(document.getElementById(`edit_${prefix}_kemarin`).value) || 0;
            const induk = parseFloat(document.getElementById(`edit_${prefix}_induk`).value) || 0;
            const bantu = parseFloat(document.getElementById(`edit_${prefix}_bantu`).value) || 0;
            const lain = parseFloat(document.getElementById(`edit_${prefix}_lain`).value) || 0;
            const tambah = parseFloat(document.getElementById(`edit_${prefix}_tambah`).value) || 0;
            const sekarang = (kemarin + tambah) - (induk + bantu + lain);
            document.getElementById(`edit_${prefix}_sekarang`).value = Math.max(0, sekarang);
        }

        // Attach calculation triggers to input fields
        document.querySelectorAll('.edit-calc').forEach(input => {
            input.addEventListener('input', function() {
                const id = this.id;
                const prefix = id.split('_')[1];
                recalculate(prefix);
            });
        });

        // Click Edit Logbook Handler
        document.querySelectorAll('.edit-logbook-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                document.getElementById('edit_row_id').value = id;
                document.getElementById('edit_tanggal').value = this.getAttribute('data-date');
                document.getElementById('edit_rute').value = this.getAttribute('data-route');
                
                // Load DO data
                document.getElementById('edit_do_kemarin').value = this.getAttribute('data-do-kemarin');
                document.getElementById('edit_do_induk').value = this.getAttribute('data-do-induk');
                document.getElementById('edit_do_bantu').value = this.getAttribute('data-do-bantu');
                document.getElementById('edit_do_lain').value = this.getAttribute('data-do-lain');
                document.getElementById('edit_do_tambah').value = this.getAttribute('data-do-tambah');
                recalculate('do');

                // Load FO data
                document.getElementById('edit_fo_kemarin').value = this.getAttribute('data-fo-kemarin');
                document.getElementById('edit_fo_induk').value = this.getAttribute('data-fo-induk');
                document.getElementById('edit_fo_bantu').value = this.getAttribute('data-fo-bantu');
                document.getElementById('edit_fo_lain').value = this.getAttribute('data-fo-lain');
                document.getElementById('edit_fo_tambah').value = this.getAttribute('data-fo-tambah');
                recalculate('fo');

                // Load Lube data
                document.getElementById('edit_lube_kemarin').value = this.getAttribute('data-lube-kemarin');
                document.getElementById('edit_lube_induk').value = this.getAttribute('data-lube-induk');
                document.getElementById('edit_lube_bantu').value = this.getAttribute('data-lube-bantu');
                document.getElementById('edit_lube_lain').value = this.getAttribute('data-lube-lain');
                document.getElementById('edit_lube_tambah').value = this.getAttribute('data-lube-tambah');
                recalculate('lube');

                // Load Cylinder data
                document.getElementById('edit_cyl_kemarin').value = this.getAttribute('data-cyl-kemarin');
                document.getElementById('edit_cyl_induk').value = this.getAttribute('data-cyl-induk');
                document.getElementById('edit_cyl_bantu').value = this.getAttribute('data-cyl-bantu');
                document.getElementById('edit_cyl_lain').value = this.getAttribute('data-cyl-lain');
                document.getElementById('edit_cyl_tambah').value = this.getAttribute('data-cyl-tambah');
                recalculate('cyl');

                // Load Notes
                document.getElementById('edit_catatan').value = this.getAttribute('data-catatan');

                // Open the modal
                const editModal = new bootstrap.Modal(document.getElementById('editLogbookModal'));
                editModal.show();
            });
        });

        // Form Submit handler for Saving/Updating Logbook
        document.getElementById('editLogbookForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const id = document.getElementById('edit_row_id').value;

            // Compute values to update dashboard badges
            const doCons = (parseFloat(document.getElementById('edit_do_induk').value) || 0) +
                           (parseFloat(document.getElementById('edit_do_bantu').value) || 0) +
                           (parseFloat(document.getElementById('edit_do_lain').value) || 0);

            const foCons = (parseFloat(document.getElementById('edit_fo_induk').value) || 0) +
                           (parseFloat(document.getElementById('edit_fo_bantu').value) || 0) +
                           (parseFloat(document.getElementById('edit_fo_lain').value) || 0);

            const lubeCons = (parseFloat(document.getElementById('edit_lube_induk').value) || 0) +
                             (parseFloat(document.getElementById('edit_lube_bantu').value) || 0) +
                             (parseFloat(document.getElementById('edit_lube_lain').value) || 0);

            // Update DOM text contents
            document.getElementById(`do-badge-${id}`).textContent = `DO: ${doCons}L`;
            document.getElementById(`fo-badge-${id}`).textContent = `FO: ${foCons}L`;
            document.getElementById(`lube-badge-${id}`).textContent = `Lube: ${lubeCons}L`;

            // Keep HTML data attributes updated so next edit loads modified values
            const btn = document.querySelector(`.edit-logbook-btn[data-id="${id}"]`);
            btn.setAttribute('data-do-kemarin', document.getElementById('edit_do_kemarin').value);
            btn.setAttribute('data-do-induk', document.getElementById('edit_do_induk').value);
            btn.setAttribute('data-do-bantu', document.getElementById('edit_do_bantu').value);
            btn.setAttribute('data-do-lain', document.getElementById('edit_do_lain').value);
            btn.setAttribute('data-do-tambah', document.getElementById('edit_do_tambah').value);

            btn.setAttribute('data-fo-kemarin', document.getElementById('edit_fo_kemarin').value);
            btn.setAttribute('data-fo-induk', document.getElementById('edit_fo_induk').value);
            btn.setAttribute('data-fo-bantu', document.getElementById('edit_fo_bantu').value);
            btn.setAttribute('data-fo-lain', document.getElementById('edit_fo_lain').value);
            btn.setAttribute('data-fo-tambah', document.getElementById('edit_fo_tambah').value);

            btn.setAttribute('data-lube-kemarin', document.getElementById('edit_lube_kemarin').value);
            btn.setAttribute('data-lube-induk', document.getElementById('edit_lube_induk').value);
            btn.setAttribute('data-lube-bantu', document.getElementById('edit_lube_bantu').value);
            btn.setAttribute('data-lube-lain', document.getElementById('edit_lube_lain').value);
            btn.setAttribute('data-lube-tambah', document.getElementById('edit_lube_tambah').value);

            btn.setAttribute('data-cyl-kemarin', document.getElementById('edit_cyl_kemarin').value);
            btn.setAttribute('data-cyl-induk', document.getElementById('edit_cyl_induk').value);
            btn.setAttribute('data-cyl-bantu', document.getElementById('edit_cyl_bantu').value);
            btn.setAttribute('data-cyl-lain', document.getElementById('edit_cyl_lain').value);
            btn.setAttribute('data-cyl-tambah', document.getElementById('edit_cyl_tambah').value);

            btn.setAttribute('data-catatan', document.getElementById('edit_catatan').value);

            // Hide the Modal
            const modalEl = document.getElementById('editLogbookModal');
            const modal = bootstrap.Modal.getInstance(modalEl);
            modal.hide();

            // Display Toast feedback
            showToast('Logbook berhasil diperbarui!', 'success');
        });

        // Click Delete Logbook Handler
        document.querySelectorAll('.delete-logbook-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                deleteId = this.getAttribute('data-id');
                const deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
                deleteModal.show();
            });
        });

        // Click confirm deletion inside delete confirmation modal
        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            if (deleteId) {
                const row = document.getElementById(`row-${deleteId}`);
                if (row) {
                    row.style.transition = 'all 0.4s ease';
                    row.style.opacity = '0';
                    row.style.transform = 'translateX(-20px)';
                    setTimeout(() => {
                        row.remove();
                        showToast('Logbook berhasil dihapus!', 'danger');
                    }, 400);
                }
                const modalEl = document.getElementById('deleteConfirmModal');
                const modal = bootstrap.Modal.getInstance(modalEl);
                modal.hide();
            }
        });

        // Helper to show custom float alerts (toast simulation)
        function showToast(message, type) {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type === 'danger' ? 'danger' : 'success'} alert-dismissible fade show shadow-md`;
            alertDiv.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 9999; border-radius: 12px; min-width: 280px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); border-left: 5px solid ' + (type === 'danger' ? 'red' : 'green') + ';';
            alertDiv.innerHTML = `
                <div class="d-flex align-items-center">
                    <i class="bi ${type === 'danger' ? 'bi-trash-fill' : 'bi-check-circle-fill'} fs-5 me-2"></i>
                    <div class="fw-semibold">${message}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;
            document.body.appendChild(alertDiv);
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alertDiv);
                bsAlert.close();
            }, 3000);
        }
    });
</script>
@endpush
