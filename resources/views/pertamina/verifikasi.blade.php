@extends('layouts.dashboard')

@section('title', 'Laporan Logbook Kapal')
@section('navbar') @include('partials.navbar-pertamina') @endsection

@section('content')
<div class="page-header">
    <h4><i class="bi bi-journal-text me-2 text-pertamina-blue"></i>Laporan Logbook Kapal</h4>
    <p>Monitoring pencatatan logbook pemakaian Fuel Oil (FO) yang telah diinput oleh awak kapal</p>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card-modern stat-card stat-green">
            <div class="d-flex justify-content-between align-items-center">
                <div><div class="stat-label">Total Logbook Masuk</div><div class="stat-value stat-value-animate" id="stat-verified" data-target="{{ $statVerified }}">{{ $statVerified }}</div></div>
                <div class="stat-icon" style="background:#dcfce7;color:#15803d"><i class="bi bi-journal-check"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card-modern stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div><div class="stat-label">Total Kapal Aktif</div><div class="stat-value stat-value-animate" id="stat-pending" data-target="8">8</div></div>
                <div class="stat-icon" style="background:var(--pertamina-blue-light);color:var(--pertamina-blue)"><i class="bi bi-ship"></i></div>
            </div>
        </div>
    </div>
</div>

<div class="card-modern">
    <div class="p-3 border-bottom"><h6 class="mb-0 fw-bold">Daftar Logbook Fuel Oil (FO) Kapal</h6></div>
    <div class="table-responsive">
        <table class="table table-modern">
            <thead>
                <tr>
                    <th>ID Logbook</th>
                    <th>Kapal</th>
                    <th>Awak Kapal</th>
                    <th>Tanggal</th>
                    <th>Total Pemakaian FO</th>
                    <th>Catatan</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($logbooks as $log)
                    @php
                        $fo = $log->detailPemakaians->where('id_jenis', 2)->first() ?? new \App\Models\DetailPemakaian();
                        $fo_cons = $fo->motor_induk + $fo->motor_bantu + $fo->lain_lain;
                    @endphp
                    <tr id="row-LB-{{ $log->id_logbook }}">
                        <td>#LB-{{ $log->id_logbook }}</td>
                        <td>{{ $log->kapal->nama_kapal }} ({{ $log->kode_vessel }})</td>
                        <td>{{ $log->user ? $log->user->nama_user : '—' }}</td>
                        <td>{{ $log->tanggal_pencataan->format('d/m/Y') }}</td>
                        <td><strong>{{ $fo_cons }} L</strong></td>
                        <td>{{ $log->catatan ?: '—' }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <button class="btn btn-sm btn-outline-primary px-2 btn-detail-logbook"
                                        data-id="#LB-{{ $log->id_logbook }}"
                                        data-kapal="{{ $log->kapal->nama_kapal }}"
                                        data-vessel="{{ $log->kode_vessel }}"
                                        data-sektor="{{ $log->kapal->sektor_kapal ?: 'Penumpang' }}"
                                        data-awak="{{ $log->user ? $log->user->nama_user : '—' }}"
                                        data-tanggal="{{ $log->tanggal_pencataan->format('d/m/Y') }}"
                                        data-catatan="{{ $log->catatan ?: '—' }}"
                                        data-fo-kemarin="{{ $fo->sisa_kemarin ?: 0 }}" 
                                        data-fo-induk="{{ $fo->motor_induk ?: 0 }}" 
                                        data-fo-bantu="{{ $fo->motor_bantu ?: 0 }}" 
                                        data-fo-lain="{{ $fo->lain_lain ?: 0 }}" 
                                        data-fo-tambah="{{ $fo->ditambah ?: 0 }}" 
                                        data-fo-jumlah="{{ $fo->jumlah_sekarang ?: 0 }}" 
                                        data-fo-sekarang="{{ $fo->sisa_sekarang ?: 0 }}"
                                        title="Detail Logbook">
                                    <i class="bi bi-eye"></i> Detail
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Tidak ada logbook kapal yang terdaftar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Detail Logbook -->
<div class="modal fade" id="detailLogbookModal" tabindex="-1" aria-labelledby="detailLogbookModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 20px; overflow: hidden;">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold text-pertamina-blue" id="detailLogbookModalLabel">
                    <i class="bi bi-file-earmark-text me-2"></i>Detail Logbook — <span id="detail_id_display">-</span> (<span id="detail_tanggal">14/07/2026</span>)
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Info Header -->
                <div class="row g-3 mb-4 border-bottom pb-3">
                    <div class="col-md-4">
                        <small class="text-muted d-block">Nama Kapal</small>
                        <span class="fw-semibold" id="detail_nama_kapal">-</span>
                    </div>
                    <div class="col-md-4">
                        <small class="text-muted d-block">Vessel Code / Sektor</small>
                        <span class="fw-semibold" id="detail_vessel_code">-</span>
                    </div>
                    <div class="col-md-4">
                        <small class="text-muted d-block">Awak Pengisi</small>
                        <span class="fw-semibold" id="detail_awak">-</span>
                    </div>
                </div>

                <!-- Fuel Tables -->
                <h6 class="fw-bold text-pertamina-blue mb-2"><i class="bi bi-droplet-fill me-1"></i> Rincian Konsumsi Fuel Oil (FO)</h6>
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
                                <th>Jumlah Sekarang</th>
                                <th>Sisa Sekarang</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <tr>
                                <td class="fw-semibold text-start">Fuel Oil (FO)</td>
                                <td id="fo_kemarin">-</td>
                                <td id="fo_induk">-</td>
                                <td id="fo_bantu">-</td>
                                <td id="fo_lain">-</td>
                                <td id="fo_tambah">-</td>
                                <td class="fw-bold text-pertamina-red" id="fo_jumlah">-</td>
                                <td class="fw-bold text-danger" id="fo_sekarang">-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Notes Section -->
                <div class="p-3 bg-light rounded">
                    <h6 class="fw-bold mb-1 small"><i class="bi bi-chat-left-text me-1"></i> Catatan Awak Kapal:</h6>
                    <p class="mb-0 text-muted small" id="detail_catatan">-</p>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Modal Detail Logbook Handler
        const detailModalEl = document.getElementById('detailLogbookModal');
        const detailModal = new bootstrap.Modal(detailModalEl);

        document.querySelectorAll('.btn-detail-logbook').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const kapal = this.getAttribute('data-kapal');
                const vessel = this.getAttribute('data-vessel');
                const sektor = this.getAttribute('data-sektor');
                const awak = this.getAttribute('data-awak');
                const tanggal = this.getAttribute('data-tanggal');
                const catatan = this.getAttribute('data-catatan');

                document.getElementById('detail_id_display').textContent = id;
                document.getElementById('detail_tanggal').textContent = tanggal;
                document.getElementById('detail_nama_kapal').textContent = kapal;
                document.getElementById('detail_vessel_code').textContent = `${vessel} / ${sektor}`;
                document.getElementById('detail_awak').textContent = awak;
                document.getElementById('detail_catatan').textContent = catatan;

                // Load FO fuel data
                document.getElementById(`fo_kemarin`).textContent = this.getAttribute(`data-fo-kemarin`) + ' L';
                document.getElementById(`fo_induk`).textContent = this.getAttribute(`data-fo-induk`) + ' L';
                document.getElementById(`fo_bantu`).textContent = this.getAttribute(`data-fo-bantu`) + ' L';
                document.getElementById(`fo_lain`).textContent = this.getAttribute(`data-fo-lain`) + ' L';
                document.getElementById(`fo_tambah`).textContent = this.getAttribute(`data-fo-tambah`) + ' L';
                document.getElementById(`fo_jumlah`).textContent = this.getAttribute(`data-fo-jumlah`) + ' L';
                document.getElementById(`fo_sekarang`).textContent = this.getAttribute(`data-fo-sekarang`) + ' L';

                detailModal.show();
            });
        });
    });
</script>
@endpush
@endsection
