@extends('layouts.dashboard')

@section('title', 'Data User')
@section('navbar') @include('partials.navbar-pertamina') @endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-start flex-wrap gap-2 mb-4">
    <div>
        <h4><i class="bi bi-people me-2 text-pertamina-blue"></i>Data User</h4>
        <p class="text-muted mb-0 small">Daftar pengguna terdaftar dalam sistem monitoring logbook</p>
    </div>
    <button class="btn btn-pertamina btn-sm" data-bs-toggle="modal" data-bs-target="#tambahUserModal">
        <i class="bi bi-plus-lg me-1"></i>Tambah Data
    </button>
</div>

<!-- TABLE CARD -->
<div class="card-modern">
    <div class="table-responsive">
        <table class="table table-modern">
            <thead>
                <tr>
                    <th>ID User</th>
                    <th>Nama User</th>
                    <th>Nama Perusahaan</th>
                    <th>Role</th>
                </tr>
            </thead>
            <tbody id="userTableBody">
                @forelse ($users as $u)
                    @php
                        $roleBadge = $u->role === 'admin' ? 'badge-filled' : 'badge-pending';
                        $roleLabel = $u->role === 'admin' ? 'Admin' : 'Awak Kapal';
                    @endphp
                    <tr>
                        <td><strong>{{ $u->id_user }}</strong></td>
                        <td><i class="bi bi-person me-2 text-pertamina-blue"></i> {{ $u->nama_user }}</td>
                        <td>{{ $u->perusahaan->nama_perusahaan ?? '—' }}</td>
                        <td><span class="badge {{ $roleBadge }}">{{ $roleLabel }}</span></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">Tidak ada data user.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- TAMBAH USER MODAL -->
<div class="modal fade" id="tambahUserModal" tabindex="-1" aria-labelledby="tambahUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 20px; overflow: hidden;">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold text-pertamina-blue" id="tambahUserModalLabel">
                    <i class="bi bi-person-fill-add me-2"></i>Tambah Data Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="tambahUserForm">
                @csrf
                <div class="modal-body p-4">
                    <!-- NAMA USER -->
                    <div class="mb-3">
                        <label for="nama_user" class="form-label fw-bold">Nama User</label>
                        <input type="text" class="form-control" id="nama_user" required placeholder="Contoh: Ahmad Wijaya">
                    </div>

                    <!-- ROLE -->
                    <div class="mb-3">
                        <label for="role" class="form-label fw-bold">Role</label>
                        <select id="role" class="form-select" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="admin">Admin</option>
                            <option value="awak_kapal">Awak Kapal</option>
                        </select>
                    </div>

                    <!-- NAMA PERUSAHAAN -->
                    <div class="mb-3" id="company_wrapper" style="display: none;">
                        <label for="id_perusahaan" class="form-label fw-bold">Nama Perusahaan</label>
                        <select id="id_perusahaan" style="width: 100%; display: none;">
                            <option value="">-- Pilih Perusahaan --</option>
                            @foreach ($companies as $company)
                                <option value="{{ $company->id_perusahaan }}">{{ $company->nama_perusahaan }}</option>
                            @endforeach
                            <option value="lainnya">Lainnya (Tambah Baru)</option>
                        </select>
                    </div>

                    <!-- KOTAK ISI MANUAL PERUSAHAAN BARU -->
                    <div class="mb-3" id="new_company_wrapper" style="display: none;">
                        <label for="nama_perusahaan_baru" class="form-label fw-bold text-pertamina-blue">Nama Perusahaan Baru</label>
                        <input type="text" class="form-control" id="nama_perusahaan_baru" placeholder="Masukkan nama perusahaan baru">
                    </div>

                    <!-- PASSWORD -->
                    <div class="mb-3">
                        <label for="password" class="form-label fw-bold">Password</label>
                        <input type="password" class="form-control" id="password" required placeholder="Minimal 6 karakter">
                    </div>
                </div>
                <div class="modal-footer bg-light px-4 py-3 d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-outline-secondary px-4 py-2 fw-semibold" style="font-size: 0.85rem; border-radius: 8px;" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-pertamina px-4 py-2 fw-semibold" style="font-size: 0.85rem; border-radius: 8px;">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container {
        width: 100% !important;
    }
    .select2-container--default .select2-selection--single {
        border: 1.5px solid var(--gray-border, #cbd5e1) !important;
        border-radius: 10px !important;
        height: auto !important;
        padding: 0.65rem 0.95rem !important;
        background-color: #fff !important;
        display: flex !important;
        align-items: center !important;
        position: relative !important;
        transition: all 0.2s !important;
    }
    .select2-container--default .select2-selection--single:focus,
    .select2-container--default.select2-container--focus .select2-selection--single {
        border-color: var(--pertamina-blue, #0057b8) !important;
        box-shadow: 0 0 0 4px rgba(0, 87, 184, 0.12) !important;
        outline: none !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #475569 !important;
        padding-left: 0 !important;
        padding-right: 20px !important;
        font-size: 0.92rem !important;
        line-height: normal !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__placeholder {
        color: #94a3b8 !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 100% !important;
        position: absolute !important;
        top: 0 !important;
        right: 12px !important;
        display: flex !important;
        align-items: center !important;
    }
    .select2-dropdown {
        border: 1.5px solid var(--gray-border, #cbd5e1) !important;
        border-radius: 10px !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08) !important;
        z-index: 99999 !important;
    }
    .select2-container--default .select2-results__option {
        padding: 8px 12px !important;
        font-size: 0.92rem !important;
    }
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: var(--pertamina-blue, #0057b8) !important;
        color: white !important;
    }
    .select2-container--default .select2-search--dropdown .select2-search__field {
        border: 1.5px solid var(--gray-border, #cbd5e1) !important;
        border-radius: 6px !important;
        outline: none !important;
        padding: 6px 10px !important;
    }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize Select2
        $('#id_perusahaan').select2({
            dropdownParent: $('#tambahUserModal'),
            placeholder: '-- Pilih Perusahaan --',
            allowClear: true
        });

        // Clear/Show/Hide company fields based on role selection
        document.getElementById('role').addEventListener('change', function () {
            if (this.value === 'admin') {
                $('#company_wrapper').slideDown();
            } else {
                $('#company_wrapper').slideUp();
                $('#id_perusahaan').val(null).trigger('change');
                $('#new_company_wrapper').slideUp();
                $('#nama_perusahaan_baru').val('');
            }
        });

        // Show/hide manual company name field based on choice
        $('#id_perusahaan').on('change', function () {
            if ($(this).val() === 'lainnya') {
                $('#new_company_wrapper').slideDown();
                $('#nama_perusahaan_baru').attr('required', true);
            } else {
                $('#new_company_wrapper').slideUp();
                $('#nama_perusahaan_baru').removeAttr('required').val('');
            }
        });

        const form = document.getElementById('tambahUserForm');
        
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            
            // Get values
            const nama = document.getElementById('nama_user').value;
            const role = document.getElementById('role').value;
            const password = document.getElementById('password').value;
            const perusahaanId = document.getElementById('id_perusahaan').value;
            const namaPerusahaanBaru = document.getElementById('nama_perusahaan_baru').value;
            
            // Strict Validation
            if (!nama.trim()) {
                showToast('Nama User wajib diisi!', 'danger');
                return;
            }
            if (!role) {
                showToast('Role wajib dipilih!', 'danger');
                return;
            }
            if (role === 'admin' && !perusahaanId) {
                showToast('Nama Perusahaan wajib dipilih untuk Admin!', 'danger');
                return;
            }
            if (role === 'admin' && perusahaanId === 'lainnya' && !namaPerusahaanBaru.trim()) {
                showToast('Nama Perusahaan Baru wajib diisi!', 'danger');
                return;
            }
            if (!password) {
                showToast('Password wajib diisi!', 'danger');
                return;
            }
            if (password.length < 6) {
                showToast('Password minimal harus 6 karakter!', 'danger');
                return;
            }
            
            fetch('/dashboard/pertamina/user/tambah', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify({
                    nama_user: nama,
                    role: role,
                    password: password,
                    id_perusahaan: role === 'admin' ? perusahaanId : null,
                    nama_perusahaan_baru: role === 'admin' ? namaPerusahaanBaru : null
                })
            })
            .then(response => {
                return response.json().then(data => {
                    if (!response.ok) {
                        let errMsg = 'Gagal menambahkan user';
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
                    const displayCompany = data.data.perusahaan ? data.data.perusahaan.nama_perusahaan : '—';
                    
                    // Add new company option dynamically to Select2 if it was added manually
                    if (role === 'admin' && perusahaanId === 'lainnya' && data.data.id_perusahaan) {
                        const newOption = new Option(displayCompany, data.data.id_perusahaan, false, false);
                        $('#id_perusahaan').prepend(newOption).trigger('change');
                    }

                    // Create new row
                    const tbody = document.getElementById('userTableBody');
                    
                    // Remove "tidak ada data" row if it exists
                    if (tbody.children.length === 1 && tbody.children[0].cells.length === 1) {
                        tbody.innerHTML = '';
                    }

                    const tr = document.createElement('tr');
                    tr.style.opacity = '0';
                    tr.style.transform = 'translateY(10px)';
                    tr.style.transition = 'all 0.4s ease';
                    
                    const roleLabel = data.data.role === 'admin' ? 'Admin' : 'Awak Kapal';
                    const roleBadge = data.data.role === 'admin' ? 'badge-filled' : 'badge-pending';
                    
                    tr.innerHTML = `
                        <td><strong>${data.data.id_user}</strong></td>
                        <td><i class="bi bi-person me-2 text-pertamina-blue"></i> ${nama}</td>
                        <td>${displayCompany}</td>
                        <td><span class="badge ${roleBadge}">${roleLabel}</span></td>
                    `;
                    
                    // Insert at the beginning of the table body
                    tbody.insertBefore(tr, tbody.firstChild);
                    
                    // Hide modal
                    const modalEl = document.getElementById('tambahUserModal');
                    const modal = bootstrap.Modal.getInstance(modalEl);
                    modal.hide();
                    
                    // Reset form and select2
                    form.reset();
                    $('#id_perusahaan').val(null).trigger('change');
                    $('#company_wrapper').hide();
                    $('#new_company_wrapper').hide();
                    
                    // Trigger animation
                    setTimeout(() => {
                        tr.style.opacity = '1';
                        tr.style.transform = 'translateY(0)';
                    }, 100);
                    
                    // Show toast message
                    showToast('User baru berhasil ditambahkan!', 'success');
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
