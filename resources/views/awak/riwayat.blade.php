@extends('layouts.dashboard')

@section('title', 'Riwayat Logbook')
@section('navbar') @include('partials.navbar-awak') @endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
    <div>
        <h4><i class="bi bi-clock-history me-2 text-pertamina-blue"></i>Riwayat Logbook Kapal</h4>
    </div>
    <a href="{{ route('logbook.create') }}" class="btn btn-pertamina btn-sm">
        <i class="bi bi-plus-lg me-1"></i>Tulis Logbook Baru
    </a>
</div>

<!-- FILTERS -->
<div class="card-modern filter-card p-3 mb-4">
    <form class="row g-3">
        <div class="col-md-3">
            <label class="form-label fw-semibold">Nama Kapal</label>
            <select class="form-select form-select-sm" id="filter_nama_kapal">
                <option value="">Semua Kapal</option>
                @foreach ($logbooks->pluck('kapal')->unique('kode_vessel') as $kapal)
                    <option value="{{ $kapal->nama_kapal }}">{{ $kapal->nama_kapal }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label fw-semibold">Tanggal</label>
            <select class="form-select form-select-sm" id="filter_tanggal">
                <option value="">Semua Tanggal</option>
                @for ($d = 1; $d <= 31; $d++)
                    <option value="{{ sprintf('%02d', $d) }}">{{ $d }}</option>
                @endfor
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label fw-semibold">Bulan</label>
            <select class="form-select form-select-sm" id="filter_bulan">
                <option value="">Semua Bulan</option>
                @php
                    $months = [
                        '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
                        '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
                        '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                    ];
                @endphp
                @foreach ($months as $num => $name)
                    <option value="{{ $num }}">{{ $name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label fw-semibold">Tahun</label>
            <select class="form-select form-select-sm" id="filter_tahun">
                <option value="">Semua Tahun</option>
                @for ($y = 2024; $y <= 2026; $y++)
                    <option value="{{ $y }}">{{ $y }}</option>
                @endfor
            </select>
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
                    <th>Nama Kapal</th>
                    <th>Konsumsi Fuel Oil (FO)</th>
                    <th>Jumlah Sekarang (FO)</th>
                    <th>Catatan</th>
                    <th style="width: 150px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($logbooks as $log)
                @php
                    $fo = $log->detailPemakaians->where('id_jenis', 2)->first() ?? new \App\Models\DetailPemakaian();
                    $fo_cons = $fo->total ?: ($fo->motor_induk + $fo->motor_bantu + $fo->lain_lain);
                @endphp
                <tr id="row-{{ $log->id_logbook }}" data-kapal="{{ $log->kapal->nama_kapal }}" data-tanggal="{{ $log->tanggal_pencataan->format('d') }}" data-bulan="{{ $log->tanggal_pencataan->format('m') }}" data-tahun="{{ $log->tanggal_pencataan->format('Y') }}">
                    <td>{{ $log->tanggal_pencataan->format('d/m/Y') }}</td>
                    <td><strong>{{ $log->kapal->nama_kapal ?? $log->kode_vessel }}</strong></td>
                    <td>
                         <span class="badge bg-danger" id="fo-badge-{{ $log->id_logbook }}">FO: {{ $fo_cons }} L</span>
                    </td>
                    <td>
                        <strong id="fo-sekarang-{{ $log->id_logbook }}">{{ $fo->jumlah_sekarang }} L</strong>
                    </td>
                    <td>{{ $log->catatan ?: '—' }}</td>
                    <td class="text-center">
                        <div class="d-flex gap-1 justify-content-center">
                            <button class="btn btn-sm btn-outline-primary px-2" data-bs-toggle="modal" data-bs-target="#detailModal{{ $log->id_logbook }}" title="Detail">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-warning edit-logbook-btn px-2" 
                                data-id="{{ $log->id_logbook }}" 
                                data-date="{{ $log->tanggal_pencataan->format('d/m/Y') }}" 
                                data-fo-kemarin="{{ $fo->sisa_kemarin ?: 0 }}" 
                                data-fo-induk="{{ $fo->motor_induk ?: 0 }}" 
                                data-fo-bantu="{{ $fo->motor_bantu ?: 0 }}" 
                                data-fo-lain="{{ $fo->lain_lain ?: 0 }}" 
                                data-fo-tambah="{{ $fo->ditambah ?: 0 }}"
                                data-fo-sekarang="{{ $fo->sisa_sekarang ?: 0 }}"
                                data-fo-jumlah="{{ $fo->jumlah_sekarang ?: 0 }}"
                                data-fo-total="{{ $fo->total ?: 0 }}"
                                data-catatan="{{ $log->catatan ?: '' }}" 
                                title="Edit">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger delete-logbook-btn px-2" 
                                data-id="{{ $log->id_logbook }}" 
                                title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">Belum ada riwayat logbook.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- PAGINATION -->
    <div class="mt-4 d-flex justify-content-center">
        {{ $logbooks->links('pagination::bootstrap-5') }}
    </div>
</div>

<!-- DETAIL MODALS -->
@foreach ($logbooks as $log)
@php
    $fo = $log->detailPemakaians->where('id_jenis', 2)->first() ?? new \App\Models\DetailPemakaian();
@endphp
<div class="modal fade" id="detailModal{{ $log->id_logbook }}" tabindex="-1" aria-labelledby="detailModalLabel{{ $log->id_logbook }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold text-pertamina-blue" id="detailModalLabel{{ $log->id_logbook }}">
                    <i class="bi bi-file-earmark-text me-2"></i>Detail Logbook — {{ $log->tanggal_pencataan->format('d/m/Y') }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Info Header -->
                <div class="row g-3 mb-4 border-bottom pb-3">
                    <div class="col-md-4">
                        <small class="text-muted d-block">Nama Kapal</small>
                        <span class="fw-semibold">{{ $log->kapal->nama_kapal }}</span>
                    </div>
                    <div class="col-md-4">
                        <small class="text-muted d-block">Vessel Code / Sektor</small>
                        <span class="fw-semibold">{{ $log->kode_vessel }} / {{ $log->kapal->sektor_kapal ?: 'Penumpang' }}</span>
                    </div>
                    <div class="col-md-4">
                        <small class="text-muted d-block">Tanggal Pencatatan</small>
                        <span class="fw-semibold">{{ $log->tanggal_pencataan->format('d/m/Y') }}</span>
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
                                <td>{{ $fo->sisa_kemarin ?: 0 }} L</td>
                                <td>{{ $fo->motor_induk ?: 0 }} L</td>
                                <td>{{ $fo->motor_bantu ?: 0 }} L</td>
                                <td>{{ $fo->lain_lain ?: 0 }} L</td>
                                <td>{{ $fo->ditambah ?: 0 }} L</td>
                                <td class="fw-bold text-pertamina-red">{{ $fo->jumlah_sekarang ?: 0 }} L</td>
                                <td class="fw-bold text-danger">{{ $fo->sisa_sekarang ?: 0 }} L</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Notes Section -->
                <div class="p-3 bg-light rounded">
                    <h6 class="fw-bold mb-1 small"><i class="bi bi-chat-left-text me-1"></i> Catatan Awak Kapal:</h6>
                    <p class="mb-0 text-muted small">
                        {{ $log->catatan ?: 'Tidak ada kendala operasional.' }}
                    </p>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endforeach

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
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Tanggal Pencatatan</label>
                            <input type="text" class="form-control" id="edit_tanggal" readonly style="background-color:#e9ecef;">
                        </div>
                    </div>

                    <!-- FO Content Direct Layout -->
                    <h6 class="fw-bold text-pertamina-red mb-3"><i class="bi bi-droplet-half me-1"></i> Detail Pemakaian Fuel Oil (FO)</h6>
                    <div class="mb-4">
                        <!-- SISA KEMARIN -->
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Sisa Kemarin (L)</label>
                            <input type="number" class="form-control form-control-sm" id="edit_fo_kemarin" required>
                        </div>

                        <!-- PENGGUNAAN -->
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-dark d-block">Penggunaan (L)</label>
                            <div class="row g-2">
                                <div class="col-3">
                                    <label for="edit_fo_induk" class="form-label xx-small text-muted" style="font-size: 0.75rem;">Mesin Induk</label>
                                    <input type="number" class="form-control form-control-sm" id="edit_fo_induk" required>
                                </div>
                                <div class="col-3">
                                    <label for="edit_fo_bantu" class="form-label xx-small text-muted" style="font-size: 0.75rem;">Mesin Bantu</label>
                                    <input type="number" class="form-control form-control-sm" id="edit_fo_bantu" required>
                                </div>
                                <div class="col-3">
                                    <label for="edit_fo_lain" class="form-label xx-small text-muted" style="font-size: 0.75rem;">Lain-lain</label>
                                    <input type="number" class="form-control form-control-sm" id="edit_fo_lain" required>
                                </div>
                                <div class="col-3">
                                    <label for="edit_fo_total" class="form-label xx-small text-muted" style="font-size: 0.75rem;">Total</label>
                                    <input type="number" class="form-control form-control-sm" id="edit_fo_total">
                                </div>
                            </div>
                        </div>

                        <!-- SISA SEKARANG -->
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Sisa Sekarang (L)</label>
                            <input type="number" class="form-control form-control-sm fw-bold text-danger" id="edit_fo_sekarang" required>
                        </div>

                        <!-- DITAMBAH -->
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Ditambah (L)</label>
                            <input type="number" class="form-control form-control-sm" id="edit_fo_tambah" required>
                        </div>

                        <!-- JUMLAH SEKARANG -->
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-pertamina-red">Jumlah Sekarang (L)</label>
                            <input type="number" class="form-control form-control-sm fw-bold text-pertamina-red" id="edit_fo_jumlah" required>
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="mb-3">
                        <label for="edit_catatan" class="form-label fw-bold">Catatan Tambahan</label>
                        <textarea class="form-control" id="edit_catatan" rows="3" placeholder="Masukkan catatan tambahan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light px-4 py-3 d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-outline-secondary px-4 py-2 fw-semibold" style="font-size: 0.85rem; border-radius: 8px;" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-pertamina px-4 py-2 fw-semibold" style="font-size: 0.85rem; border-radius: 8px;">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- DELETE CONFIRM MODAL -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
        <div class="modal-content text-center p-3" style="border-radius: 20px;">
            <div class="modal-body">
                <i class="bi bi-exclamation-triangle text-danger fs-1 mb-3"></i>
                <h5 class="fw-bold mb-2">Hapus Logbook?</h5>
                <p class="text-muted small">Tindakan ini tidak dapat dibatalkan. Seluruh data logbook ini akan terhapus secara permanen dari sistem.</p>
                <div class="d-flex gap-2 justify-content-center mt-4">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger px-4" id="confirmDeleteBtn">Ya, Hapus</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let deleteId = null;
        // Click Edit Logbook Handler
        document.querySelectorAll('.edit-logbook-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                document.getElementById('edit_row_id').value = id;
                document.getElementById('edit_tanggal').value = this.getAttribute('data-date');
                
                // Load FO data
                document.getElementById('edit_fo_kemarin').value = this.getAttribute('data-fo-kemarin');
                document.getElementById('edit_fo_induk').value = this.getAttribute('data-fo-induk');
                document.getElementById('edit_fo_bantu').value = this.getAttribute('data-fo-bantu');
                document.getElementById('edit_fo_lain').value = this.getAttribute('data-fo-lain');
                document.getElementById('edit_fo_tambah').value = this.getAttribute('data-fo-tambah');
                document.getElementById('edit_fo_sekarang').value = this.getAttribute('data-fo-sekarang');
                document.getElementById('edit_fo_jumlah').value = this.getAttribute('data-fo-jumlah');
                document.getElementById('edit_fo_total').value = this.getAttribute('data-fo-total');

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

            fetch('/logbook/edit/' + id, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    fo_kemarin: parseFloat(document.getElementById('edit_fo_kemarin').value) || 0,
                    fo_induk: parseFloat(document.getElementById('edit_fo_induk').value) || 0,
                    fo_bantu: parseFloat(document.getElementById('edit_fo_bantu').value) || 0,
                    fo_lain: parseFloat(document.getElementById('edit_fo_lain').value) || 0,
                    fo_tambah: parseFloat(document.getElementById('edit_fo_tambah').value) || 0,
                    fo_sekarang: parseFloat(document.getElementById('edit_fo_sekarang').value) || 0,
                    fo_jumlah: parseFloat(document.getElementById('edit_fo_jumlah').value) || 0,
                    fo_total: parseFloat(document.getElementById('edit_fo_total').value) || 0,
                    catatan: document.getElementById('edit_catatan').value
                })
            })
            .then(response => {
                if (!response.ok) throw new Error('Gagal memperbarui logbook');
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    const foKemarin = parseFloat(document.getElementById('edit_fo_kemarin').value) || 0;
                    const foInduk = parseFloat(document.getElementById('edit_fo_induk').value) || 0;
                    const foBantu = parseFloat(document.getElementById('edit_fo_bantu').value) || 0;
                    const foLain = parseFloat(document.getElementById('edit_fo_lain').value) || 0;
                    const foTambah = parseFloat(document.getElementById('edit_fo_tambah').value) || 0;
                    const foSekarang = parseFloat(document.getElementById('edit_fo_sekarang').value) || 0;
                    const foJumlah = parseFloat(document.getElementById('edit_fo_jumlah').value) || 0;
                    const foTotal = parseFloat(document.getElementById('edit_fo_total').value) || 0;

                    // Update DOM values
                    document.getElementById(`fo-badge-${id}`).textContent = `FO: ${foTotal} L`;
                    document.getElementById(`fo-sekarang-${id}`).textContent = `${foJumlah} L`;

                    // Update button data attributes
                    const btn = document.querySelector(`.edit-logbook-btn[data-id="${id}"]`);
                    btn.setAttribute('data-fo-kemarin', foKemarin);
                    btn.setAttribute('data-fo-induk', foInduk);
                    btn.setAttribute('data-fo-bantu', foBantu);
                    btn.setAttribute('data-fo-lain', foLain);
                    btn.setAttribute('data-fo-tambah', foTambah);
                    btn.setAttribute('data-fo-sekarang', foSekarang);
                    btn.setAttribute('data-fo-jumlah', foJumlah);
                    btn.setAttribute('data-fo-total', foTotal);
                    btn.setAttribute('data-catatan', document.getElementById('edit_catatan').value);

                    // Hide modal and show success toast
                    const modalEl = document.getElementById('editLogbookModal');
                    const modal = bootstrap.Modal.getInstance(modalEl);
                    modal.hide();

                    showToast('Logbook berhasil diperbarui!', 'success');
                }
            })
            .catch(error => {
                alert(error.message);
            });
        });

        // Click Delete Logbook Handler
        document.querySelectorAll('.delete-logbook-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                deleteId = this.getAttribute('data-id');
                const deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
                deleteModal.show();
            });
        });

        // Click confirm deletion
        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            if (deleteId) {
                fetch('/logbook/delete/' + deleteId, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => {
                    if (!response.ok) throw new Error('Gagal menghapus logbook');
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
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
                })
                .catch(error => {
                    alert(error.message);
                });
            }
        });

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

        // Filter handler
        function applyFilters() {
            const filterKapal = document.getElementById('filter_nama_kapal').value;
            const filterTanggal = document.getElementById('filter_tanggal').value;
            const filterBulan = document.getElementById('filter_bulan').value;
            const filterTahun = document.getElementById('filter_tahun').value;
            
            document.querySelectorAll('tbody tr').forEach(row => {
                if (!row.cells || row.cells.length < 5) return;
                
                const kapal = row.getAttribute('data-kapal') || '';
                const tanggal = row.getAttribute('data-tanggal') || '';
                const bulan = row.getAttribute('data-bulan') || '';
                const tahun = row.getAttribute('data-tahun') || '';
                
                let matches = true;
                if (filterKapal && kapal !== filterKapal) matches = false;
                if (filterTanggal && tanggal !== filterTanggal) matches = false;
                if (filterBulan && bulan !== filterBulan) matches = false;
                if (filterTahun && tahun !== filterTahun) matches = false;
                
                row.style.display = matches ? '' : 'none';
            });
        }

        // Attach event listeners
        document.querySelectorAll('#filter_nama_kapal, #filter_tanggal, #filter_bulan, #filter_tahun').forEach(el => {
            el.addEventListener('change', applyFilters);
        });
    });
</script>
@endpush
