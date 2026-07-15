@extends('layouts.dashboard')

@section('title', 'Data Kapal')
@section('navbar') @include('partials.navbar-pertamina') @endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-start flex-wrap gap-2">
    <div>
        <h4><i class="bi bi-ship me-2 text-pertamina-blue"></i>Data Kapal</h4>
        <p class="text-muted mb-0 small">Daftar kapal penumpang yang terdaftar dalam sistem</p>
    </div>
    <button class="btn btn-pertamina btn-sm" data-bs-toggle="modal" data-bs-target="#tambahKapalModal">
        <i class="bi bi-plus-lg me-1"></i>Tambah Kapal
    </button>
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
            <tbody id="kapalTableBody">
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

<!-- TAMBAH KAPAL MODAL -->
<div class="modal fade" id="tambahKapalModal" tabindex="-1" aria-labelledby="tambahKapalModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 20px; overflow: hidden;">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold text-pertamina-blue" id="tambahKapalModalLabel">
                    <i class="bi bi-ship me-2"></i>Tambah Kapal Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="tambahKapalForm">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="nama_kapal" class="form-label fw-bold">Nama Kapal</label>
                        <input type="text" class="form-control" id="nama_kapal" required placeholder="Contoh: KM Samudera Jaya">
                    </div>
                    <div class="mb-3">
                        <label for="kode_vessel" class="form-label fw-bold">Kode Vessel</label>
                        <input type="text" class="form-control" id="kode_vessel" required placeholder="Contoh: VSL-007">
                    </div>
                    <div class="mb-3">
                        <label for="sektor" class="form-label fw-bold">Klasifikasi Sektor</label>
                        <select class="form-select" id="sektor" required>
                            <option value="Kapal Penumpang" selected>Kapal Penumpang</option>
                            <option value="Kapal Kargo">Kapal Kargo</option>
                            <option value="Kapal Tanker">Kapal Tanker</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="kuota" class="form-label fw-bold">Kelompok Kuota</label>
                        <select class="form-select" id="kuota" required>
                            <option value="Kuota A" selected>Kuota A</option>
                            <option value="Kuota B">Kuota B</option>
                            <option value="Kuota C">Kuota C</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="stok_bbm" class="form-label fw-bold">Stok BBM Awal (L)</label>
                        <input type="number" class="form-control" id="stok_bbm" required placeholder="Contoh: 1000" min="0">
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label fw-bold">Status</label>
                        <select class="form-select" id="status" required>
                            <option value="Aktif" selected>Aktif</option>
                            <option value="Perawatan">Perawatan</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary btn-sm px-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-pertamina btn-sm px-4">Simpan Kapal</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('tambahKapalForm');
        
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            
            // Get values
            const nama = document.getElementById('nama_kapal').value;
            const kode = document.getElementById('kode_vessel').value;
            const sektor = document.getElementById('sektor').value;
            const kuota = document.getElementById('kuota').value;
            const stokRaw = parseFloat(document.getElementById('stok_bbm').value) || 0;
            const stokFormatted = stokRaw.toLocaleString('id-ID');
            const status = document.getElementById('status').value;
            
            // Create new row
            const tbody = document.getElementById('kapalTableBody');
            const tr = document.createElement('tr');
            tr.style.opacity = '0';
            tr.style.transform = 'translateY(10px)';
            tr.style.transition = 'all 0.4s ease';
            
            const badgeClass = status === 'Aktif' ? 'badge-filled' : 'badge-pending';
            
            tr.innerHTML = `
                <td><i class="bi bi-ship me-1 text-pertamina-blue"></i> ${nama}</td>
                <td><strong>${kode}</strong></td>
                <td>${sektor}</td>
                <td>${kuota}</td>
                <td>${stokFormatted}</td>
                <td><span class="badge ${badgeClass}">${status}</span></td>
            `;
            
            // Insert at the beginning of the table body
            tbody.insertBefore(tr, tbody.firstChild);
            
            // Hide modal
            const modalEl = document.getElementById('tambahKapalModal');
            const modal = bootstrap.Modal.getInstance(modalEl);
            modal.hide();
            
            // Reset form
            form.reset();
            
            // Trigger animation
            setTimeout(() => {
                tr.style.opacity = '1';
                tr.style.transform = 'translateY(0)';
            }, 100);
            
            // Show toast message
            showToast('Kapal baru berhasil ditambahkan!', 'success');
        });
        
        function showToast(message, type) {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-success alert-dismissible fade show shadow-md`;
            alertDiv.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 9999; border-radius: 12px; min-width: 280px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); border-left: 5px solid green;';
            alertDiv.innerHTML = `
                <div class="d-flex align-items-center">
                    <i class="bi bi-check-circle-fill text-success fs-5 me-2"></i>
                    <div class="fw-semibold text-dark">${message}</div>
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
