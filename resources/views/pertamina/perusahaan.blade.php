@extends('layouts.dashboard')

@section('title', 'Data Perusahaan')
@section('navbar') @include('partials.navbar-pertamina') @endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-start flex-wrap gap-2 mb-4">
    <div>
        <h4><i class="bi bi-building me-2 text-pertamina-blue"></i>Data Perusahaan</h4>
        <p class="text-muted mb-0 small">Daftar perusahaan pelayaran yang terdaftar dalam sistem logbook</p>
    </div>
    <button class="btn btn-pertamina btn-sm" data-bs-toggle="modal" data-bs-target="#tambahPerusahaanModal">
        <i class="bi bi-plus-lg me-1"></i>Tambah Perusahaan
    </button>
</div>



<!-- TABLE CARD -->
<div class="card-modern">
    <div class="table-responsive">
        <table class="table table-modern">
            <thead>
                <tr>
                    <th>Nama Perusahaan</th>
                    <th>Kode Perusahaan</th>
                </tr>
            </thead>
            <tbody id="perusahaanTableBody">
                @forelse ($perusahaan as $p)
                    <tr>
                        <td><i class="bi bi-building me-2 text-pertamina-blue"></i> {{ $p->nama_perusahaan }}</td>
                        <td><strong>{{ $p->kode_perusahaan }}</strong></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="text-center text-muted py-4">Tidak ada data perusahaan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- TAMBAH PERUSAHAAN MODAL -->
<div class="modal fade" id="tambahPerusahaanModal" tabindex="-1" aria-labelledby="tambahPerusahaanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 20px; overflow: hidden;">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold text-pertamina-blue" id="tambahPerusahaanModalLabel">
                    <i class="bi bi-building-add me-2"></i>Tambah Perusahaan Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="tambahPerusahaanForm">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="nama_perusahaan" class="form-label fw-bold">Nama Perusahaan</label>
                        <input type="text" class="form-control" id="nama_perusahaan" required placeholder="Contoh: PT Pelayaran Nusantara">
                    </div>
                    <div class="mb-3">
                        <label for="kode_perusahaan" class="form-label fw-bold">Kode Perusahaan</label>
                        <input type="text" class="form-control" id="kode_perusahaan" required placeholder="Contoh: PT-09">
                    </div>

                </div>
                <div class="modal-footer bg-light px-4 py-3 d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-outline-secondary px-4 py-2 fw-semibold" style="font-size: 0.85rem; border-radius: 8px;" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-pertamina px-4 py-2 fw-semibold" style="font-size: 0.85rem; border-radius: 8px;">Simpan Perusahaan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('tambahPerusahaanForm');
        
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            
            // Get values
            const nama = document.getElementById('nama_perusahaan').value;
            const kode = document.getElementById('kode_perusahaan').value;
            
            fetch('/dashboard/pertamina/perusahaan/tambah', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify({
                    nama_perusahaan: nama,
                    kode_perusahaan: kode
                })
            })
            .then(response => {
                return response.json().then(data => {
                    if (!response.ok) {
                        let errMsg = 'Gagal menambahkan perusahaan';
                        if (data.errors) {
                            errMsg = Object.values(data.errors).flat().join(', ');
                        } else if (data.message) {
                            errMsg = data.message;
                        }
                        throw new Error(errMsg);
                    }
                    return data;
                });
            })
            .then(data => {
                if (data.success) {
                    const tbody = document.getElementById('perusahaanTableBody');
                    
                    // Remove "tidak ada data" row if it exists
                    if (tbody.children.length === 1 && tbody.children[0].cells.length === 1) {
                        tbody.innerHTML = '';
                    }

                    // Create new row
                    const tr = document.createElement('tr');
                    tr.style.opacity = '0';
                    tr.style.transform = 'translateY(10px)';
                    tr.style.transition = 'all 0.4s ease';
                    
                    tr.innerHTML = `
                        <td><i class="bi bi-building me-2 text-pertamina-blue"></i> ${nama}</td>
                        <td><strong>${kode}</strong></td>
                    `;
                    
                    // Insert at the beginning of the table body
                    tbody.insertBefore(tr, tbody.firstChild);
                    
                    // Update stats counters
                    const totalEl = document.getElementById('statTotalPerusahaan');
                    if (totalEl) totalEl.textContent = parseInt(totalEl.textContent) + 1;
                    
                    // Hide modal
                    const modalEl = document.getElementById('tambahPerusahaanModal');
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
                    showToast('Perusahaan baru berhasil ditambahkan!', 'success');
                }
            })
            .catch(error => {
                showToast(error.message, 'danger');
            });
        });
        
        function showToast(message, type = 'success') {
            const alertDiv = document.createElement('div');
            const isSuccess = type === 'success';
            const alertClass = isSuccess ? 'alert-success' : 'alert-danger';
            const iconClass = isSuccess ? 'bi-check-circle-fill text-success' : 'bi-exclamation-triangle-fill text-danger';
            const borderStyle = isSuccess ? 'border-left: 5px solid #198754;' : 'border-left: 5px solid #dc3545;';

            alertDiv.className = `alert ${alertClass} alert-dismissible fade show shadow-md`;
            alertDiv.style.cssText = `position: fixed; top: 20px; right: 20px; z-index: 9999; border-radius: 12px; min-width: 320px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); ${borderStyle}`;
            alertDiv.innerHTML = `
                <div class="d-flex align-items-center">
                    <i class="bi ${iconClass} fs-5 me-2"></i>
                    <div class="fw-semibold text-dark">${message}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;
            document.body.appendChild(alertDiv);
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alertDiv);
                bsAlert.close();
            }, 4000);
        }
    });
</script>
@endpush
