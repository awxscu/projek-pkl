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
        <div class="card-modern stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div><div class="stat-label">Menunggu Verifikasi</div><div class="stat-value stat-value-animate" id="stat-pending" data-target="5">0</div></div>
                <div class="stat-icon" style="background:var(--pertamina-blue-light);color:var(--pertamina-blue)"><i class="bi bi-hourglass-split"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-modern stat-card stat-green">
            <div class="d-flex justify-content-between align-items-center">
                <div><div class="stat-label">Terverifikasi Hari Ini</div><div class="stat-value stat-value-animate" id="stat-verified" data-target="9">0</div></div>
                <div class="stat-icon" style="background:#dcfce7;color:#15803d"><i class="bi bi-check-circle"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-modern stat-card stat-red">
            <div class="d-flex justify-content-between align-items-center">
                <div><div class="stat-label">Ditolak</div><div class="stat-value stat-value-animate" id="stat-rejected" data-target="1">0</div></div>
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
                <tr id="row-LB-2026-0142">
                    <td>#LB-2026-0142</td>
                    <td>KM Bahari Sejahtera (VSL-004)</td>
                    <td>Rudi Hartono</td>
                    <td>14/07/2026</td>
                    <td>198 L</td>
                    <td>Operasi normal</td>
                    <td>
                        <div class="d-flex gap-1">
                            <button class="btn btn-sm btn-outline-primary px-2 btn-detail-logbook"
                                    data-id="#LB-2026-0142"
                                    data-kapal="KM Bahari Sejahtera"
                                    data-vessel="VSL-004"
                                    data-sektor="Penumpang"
                                    data-awak="Rudi Hartono"
                                    data-tanggal="14/07/2026"
                                    data-rute="Denpasar → Lombok"
                                    data-catatan="Operasi normal"
                                    data-do-kemarin="1200" data-do-induk="150" data-do-bantu="30" data-do-lain="18" data-do-tambah="0" data-do-sekarang="1002"
                                    data-fo-kemarin="800" data-fo-induk="0" data-fo-bantu="0" data-fo-lain="0" data-fo-tambah="0" data-fo-sekarang="800"
                                    data-lube-kemarin="250" data-lube-induk="8" data-lube-bantu="4" data-lube-lain="1" data-lube-tambah="0" data-lube-sekarang="237"
                                    data-cyl-kemarin="120" data-cyl-induk="4" data-cyl-bantu="2" data-cyl-lain="1" data-cyl-tambah="0" data-cyl-sekarang="113"
                                    title="Detail Logbook">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-success btn-verify-logbook" data-id="#LB-2026-0142" title="Verifikasi Logbook"><i class="bi bi-check-lg"></i></button>
                            <button class="btn btn-sm btn-outline-danger btn-reject-logbook" data-id="#LB-2026-0142" title="Tolak Logbook"><i class="bi bi-x-lg"></i></button>
                        </div>
                    </td>
                </tr>
                <tr id="row-LB-2026-0141">
                    <td>#LB-2026-0141</td>
                    <td>KM Citra Lautan (VSL-005)</td>
                    <td>Dedi Kurniawan</td>
                    <td>14/07/2026</td>
                    <td>410 L</td>
                    <td>Pemakaian tinggi karena arus kuat</td>
                    <td>
                        <div class="d-flex gap-1">
                            <button class="btn btn-sm btn-outline-primary px-2 btn-detail-logbook"
                                    data-id="#LB-2026-0141"
                                    data-kapal="KM Citra Lautan"
                                    data-vessel="VSL-005"
                                    data-sektor="Penumpang"
                                    data-awak="Dedi Kurniawan"
                                    data-tanggal="14/07/2026"
                                    data-rute="Pontianak → Ketapang"
                                    data-catatan="Pemakaian tinggi karena arus kuat"
                                    data-do-kemarin="1500" data-do-induk="320" data-do-bantu="60" data-do-lain="30" data-do-tambah="0" data-do-sekarang="1090"
                                    data-fo-kemarin="500" data-fo-induk="0" data-fo-bantu="0" data-fo-lain="0" data-fo-tambah="0" data-fo-sekarang="500"
                                    data-lube-kemarin="300" data-lube-induk="15" data-lube-bantu="6" data-lube-lain="2" data-lube-tambah="0" data-lube-sekarang="277"
                                    data-cyl-kemarin="140" data-cyl-induk="6" data-cyl-bantu="3" data-cyl-lain="1" data-cyl-tambah="0" data-cyl-sekarang="130"
                                    title="Detail Logbook">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-success btn-verify-logbook" data-id="#LB-2026-0141" title="Verifikasi Logbook"><i class="bi bi-check-lg"></i></button>
                            <button class="btn btn-sm btn-outline-danger btn-reject-logbook" data-id="#LB-2026-0141" title="Tolak Logbook"><i class="bi bi-x-lg"></i></button>
                        </div>
                    </td>
                </tr>
                <tr id="row-LB-2026-0138">
                    <td>#LB-2026-0138</td>
                    <td>KM Samudera Makmur (VSL-007)</td>
                    <td>Joko Prasetyo</td>
                    <td>14/07/2026</td>
                    <td>265 L</td>
                    <td>—</td>
                    <td>
                        <div class="d-flex gap-1">
                            <button class="btn btn-sm btn-outline-primary px-2 btn-detail-logbook"
                                    data-id="#LB-2026-0138"
                                    data-kapal="KM Samudera Makmur"
                                    data-vessel="VSL-007"
                                    data-sektor="Penumpang"
                                    data-awak="Joko Prasetyo"
                                    data-tanggal="14/07/2026"
                                    data-rute="Surabaya → Banjarmasin"
                                    data-catatan="—"
                                    data-do-kemarin="1000" data-do-induk="200" data-do-bantu="45" data-do-lain="20" data-do-tambah="0" data-do-sekarang="735"
                                    data-fo-kemarin="600" data-fo-induk="0" data-fo-bantu="0" data-fo-lain="0" data-fo-tambah="0" data-fo-sekarang="600"
                                    data-lube-kemarin="200" data-lube-induk="10" data-lube-bantu="4" data-lube-lain="2" data-lube-tambah="0" data-lube-sekarang="184"
                                    data-cyl-kemarin="100" data-cyl-induk="5" data-cyl-bantu="2" data-cyl-lain="1" data-cyl-tambah="0" data-cyl-sekarang="92"
                                    title="Detail Logbook">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-success btn-verify-logbook" data-id="#LB-2026-0138" title="Verifikasi Logbook"><i class="bi bi-check-lg"></i></button>
                            <button class="btn btn-sm btn-outline-danger btn-reject-logbook" data-id="#LB-2026-0138" title="Tolak Logbook"><i class="bi bi-x-lg"></i></button>
                        </div>
                    </td>
                </tr>
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
                    <div class="col-md-6 col-lg-3">
                        <small class="text-muted d-block">Nama Kapal</small>
                        <span class="fw-semibold" id="detail_nama_kapal">-</span>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <small class="text-muted d-block">Vessel Code / Sektor</small>
                        <span class="fw-semibold" id="detail_vessel_code">-</span>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <small class="text-muted d-block">Rute Pelayaran</small>
                        <span class="fw-semibold" id="detail_rute">-</span>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <small class="text-muted d-block">Awak Pengisi</small>
                        <span class="fw-semibold" id="detail_awak">-</span>
                    </div>
                </div>

                <!-- Fuel Tables -->
                <h6 class="fw-bold text-pertamina-blue mb-2"><i class="bi bi-droplet-fill me-1"></i> Rincian Konsumsi BBM & Pelumas (Liter)</h6>
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
                                <td id="do_kemarin">-</td>
                                <td id="do_induk">-</td>
                                <td id="do_bantu">-</td>
                                <td id="do_lain">-</td>
                                <td id="do_tambah">-</td>
                                <td class="fw-bold text-primary" id="do_sekarang">-</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-start">Fuel Oil (FO)</td>
                                <td id="fo_kemarin">-</td>
                                <td id="fo_induk">-</td>
                                <td id="fo_bantu">-</td>
                                <td id="fo_lain">-</td>
                                <td id="fo_tambah">-</td>
                                <td class="fw-bold text-danger" id="fo_sekarang">-</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-start">Lube Oil</td>
                                <td id="lube_kemarin">-</td>
                                <td id="lube_induk">-</td>
                                <td id="lube_bantu">-</td>
                                <td id="lube_lain">-</td>
                                <td id="lube_tambah">-</td>
                                <td class="fw-bold text-warning text-dark" id="lube_sekarang">-</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-start">Cylinder Oil</td>
                                <td id="cyl_kemarin">-</td>
                                <td id="cyl_induk">-</td>
                                <td id="cyl_bantu">-</td>
                                <td id="cyl_lain">-</td>
                                <td id="cyl_tambah">-</td>
                                <td class="fw-bold text-secondary" id="cyl_sekarang">-</td>
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

<!-- Modal Tolak Logbook -->
<div class="modal fade" id="rejectReasonModal" tabindex="-1" aria-labelledby="rejectReasonModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px;">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold text-danger" id="rejectReasonModalLabel">
                    <i class="bi bi-x-circle-fill me-2"></i>Tolak Logbook — <span id="reject_lb_id"></span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="rejectReasonForm">
                <input type="hidden" id="reject_row_id">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="reject_reason" class="form-label fw-bold">Alasan Penolakan</label>
                        <textarea class="form-control" id="reject_reason" rows="3" placeholder="Masukkan alasan penolakan..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-x-lg me-1"></i>Tolak Logbook</button>
                </div>
            </form>
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
                const rute = this.getAttribute('data-rute');
                const catatan = this.getAttribute('data-catatan');

                document.getElementById('detail_id_display').textContent = id;
                document.getElementById('detail_tanggal').textContent = tanggal;
                document.getElementById('detail_nama_kapal').textContent = kapal;
                document.getElementById('detail_vessel_code').textContent = `${vessel} / ${sektor}`;
                document.getElementById('detail_rute').textContent = rute;
                document.getElementById('detail_awak').textContent = awak;
                document.getElementById('detail_catatan').textContent = catatan;

                // Load fuel data helper
                const setFuelRow = (prefix) => {
                    document.getElementById(`${prefix}_kemarin`).textContent = this.getAttribute(`data-${prefix}-kemarin`) + ' L';
                    document.getElementById(`${prefix}_induk`).textContent = this.getAttribute(`data-${prefix}-induk`) + ' L';
                    document.getElementById(`${prefix}_bantu`).textContent = this.getAttribute(`data-${prefix}-bantu`) + ' L';
                    document.getElementById(`${prefix}_lain`).textContent = this.getAttribute(`data-${prefix}-lain`) + ' L';
                    document.getElementById(`${prefix}_tambah`).textContent = this.getAttribute(`data-${prefix}-tambah`) + ' L';
                    document.getElementById(`${prefix}_sekarang`).textContent = this.getAttribute(`data-${prefix}-sekarang`) + ' L';
                };

                setFuelRow('do');
                setFuelRow('fo');
                setFuelRow('lube');
                setFuelRow('cyl');

                detailModal.show();
            });
        });

        // Verification & Rejection logic helpers
        function updateStats(type) {
            const pendingEl = document.getElementById('stat-pending');
            const verifiedEl = document.getElementById('stat-verified');
            const rejectedEl = document.getElementById('stat-rejected');

            if (pendingEl) {
                let currentPending = parseInt(pendingEl.textContent) || 0;
                if (currentPending > 0) pendingEl.textContent = currentPending - 1;
            }

            if (type === 'verify' && verifiedEl) {
                let currentVerified = parseInt(verifiedEl.textContent) || 0;
                verifiedEl.textContent = currentVerified + 1;
            } else if (type === 'reject' && rejectedEl) {
                let currentRejected = parseInt(rejectedEl.textContent) || 0;
                rejectedEl.textContent = currentRejected + 1;
            }
        }

        function removeRow(rowId) {
            const row = document.getElementById(`row-${rowId}`);
            if (row) {
                row.style.transition = 'all 0.5s ease';
                row.style.opacity = '0';
                row.style.transform = 'translateX(-30px)';
                setTimeout(() => {
                    row.remove();
                }, 500);
            }
        }

        function showToast(message, type) {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type === 'danger' ? 'danger' : 'success'} alert-dismissible fade show shadow-md`;
            alertDiv.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 9999; border-radius: 12px; min-width: 320px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); border-left: 5px solid ' + (type === 'danger' ? '#E31E24' : '#0057B8') + ';';
            alertDiv.innerHTML = `
                <div class="d-flex align-items-center">
                    <i class="bi ${type === 'danger' ? 'bi-x-circle-fill' : 'bi-check-circle-fill'} fs-5 me-2" style="color: ${type === 'danger' ? '#E31E24' : '#0057B8'};"></i>
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

        // Verify button click
        document.querySelectorAll('.btn-verify-logbook').forEach(btn => {
            btn.addEventListener('click', function() {
                const lbId = this.getAttribute('data-id');
                const cleanId = lbId.replace('#', '');
                
                // Confirm Verification
                if (confirm(`Apakah Anda yakin ingin memverifikasi logbook ${lbId}?`)) {
                    updateStats('verify');
                    removeRow(cleanId);
                    showToast(`Logbook ${lbId} berhasil diverifikasi!`, 'success');
                }
            });
        });

        // Reject button click
        const rejectModalEl = document.getElementById('rejectReasonModal');
        const rejectModal = new bootstrap.Modal(rejectModalEl);
        
        document.querySelectorAll('.btn-reject-logbook').forEach(btn => {
            btn.addEventListener('click', function() {
                const lbId = this.getAttribute('data-id');
                const cleanId = lbId.replace('#', '');
                
                document.getElementById('reject_lb_id').textContent = lbId;
                document.getElementById('reject_row_id').value = cleanId;
                document.getElementById('reject_reason').value = '';
                
                rejectModal.show();
            });
        });

        // Reject Form submit
        document.getElementById('rejectReasonForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const cleanId = document.getElementById('reject_row_id').value;
            const lbId = '#' + cleanId;
            const reason = document.getElementById('reject_reason').value;

            rejectModal.hide();
            updateStats('reject');
            removeRow(cleanId);
            showToast(`Logbook ${lbId} ditolak. Alasan: "${reason}"`, 'danger');
        });
    });
</script>
@endpush
@endsection
