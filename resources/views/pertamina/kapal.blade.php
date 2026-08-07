@extends('layouts.dashboard')

@section('title', 'Data Kapal')
@section('navbar') @include('partials.navbar-pertamina') @endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-start flex-wrap gap-2">
    <div>
        <h4><i class="bi bi-ship me-2 text-pertamina-blue"></i>Data Kapal di Regional Jatimbalinus</h4>
        <p class="text-muted mb-0 small">Daftar kapal yang terdaftar dalam sistem</p>
    </div>
    <button class="btn btn-pertamina btn-sm" data-bs-toggle="modal" data-bs-target="#tambahKapalModal">
        <i class="bi bi-plus-lg me-1"></i>Tambah Data
    </button>
</div>

<div class="card-modern">
    <div class="table-responsive">
        <table class="table table-modern">
            <thead>
                <tr>
                    <th>Nama Kapal</th>
                    <th>Nama Perusahaan</th>
                    <th>FTIT</th>
                    <th>Status</th>
                    <th style="width: 150px;" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody id="kapalTableBody">
                @forelse ($kapal as $k)
                    @php
                        $badgeClass = $k->status === 'Aktif' ? 'badge-filled' : 'badge-pending';
                    @endphp
                    <tr id="vessel-row-{{ $k->kode_vessel }}">
                        <td>
                            <i class="bi bi-ship me-1 text-pertamina-blue"></i> 
                            <span class="vessel-nama">{{ $k->nama_kapal }}</span>
                            <br><small class="text-muted vessel-kode">{{ $k->kode_vessel }}</small>
                        </td>
                        <td class="vessel-perusahaan" data-id-perusahaan="{{ $k->id_perusahaan }}">{{ $k->perusahaan->nama_perusahaan ?? '—' }}</td>
                        <td class="vessel-ftit" data-id-ftit="{{ $k->depots->pluck('id_ftit')->implode(',') }}">{{ $k->depots->pluck('nama_ftit')->implode(', ') ?: '—' }}</td>
                        <td><span class="badge {{ $badgeClass }}">{{ $k->status }}</span></td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-outline-warning btn-edit-kapal me-1" 
                                    data-kode="{{ $k->kode_vessel }}"
                                    data-nama="{{ $k->nama_kapal }}"
                                    data-perusahaan="{{ $k->id_perusahaan }}"
                                    data-ftit="{{ $k->depots->pluck('id_ftit')->implode(',') }}">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger btn-delete-kapal" 
                                    data-kode="{{ $k->kode_vessel }}"
                                    data-nama="{{ $k->nama_kapal }}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Tidak ada data kapal.</td>
                    </tr>
                @endforelse
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
                    <i class="bi bi-ship me-2"></i>Tambah Data Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="tambahKapalForm">
                @csrf
                <div class="modal-body p-4">
                    <!-- DROPDOWN NAMA PERUSAHAAN -->
                    <div class="mb-3">
                        <label for="id_perusahaan" class="form-label fw-bold">Nama Perusahaan</label>
                        <select id="id_perusahaan" required style="width: 100%; display: none;">
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

                    <!-- DROPDOWN FTIT -->
                    <div class="mb-3">
                        <label for="id_ftit" class="form-label fw-bold">Depot / Terminal FTIT</label>
                        <select id="id_ftit" class="form-select" multiple="multiple" required>
                            @foreach ($ftits as $ft)
                                <option value="{{ $ft->id_ftit }}">{{ $ft->nama_ftit }} ({{ $ft->id_ftit }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- NAMA KAPAL (MANUAL) -->
                    <div class="mb-3">
                        <label for="nama_kapal" class="form-label fw-bold">Nama Kapal</label>
                        <input type="text" class="form-control" id="nama_kapal" required placeholder="Contoh: KM Samudera Jaya">
                    </div>

                    <!-- KODE VESSEL (MANUAL) -->
                    <div class="mb-3">
                        <label for="kode_vessel" class="form-label fw-bold">Kode Vessel</label>
                        <input type="text" class="form-control" id="kode_vessel" required placeholder="Contoh: VSL-007">
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

<!-- EDIT KAPAL MODAL -->
<div class="modal fade" id="editKapalModal" tabindex="-1" aria-labelledby="editKapalModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 20px; overflow: hidden;">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold text-pertamina-blue" id="editKapalModalLabel">
                    <i class="bi bi-pencil-square me-2"></i>Edit Data Kapal
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editKapalForm">
                @csrf
                <div class="modal-body p-4">
                    <!-- KODE VESSEL -->
                    <div class="mb-3">
                        <label for="edit_kode_vessel" class="form-label fw-bold">Kode Vessel</label>
                        <input type="text" class="form-control" id="edit_kode_vessel" required placeholder="Contoh: VSL-007">
                    </div>

                    <!-- DROPDOWN NAMA PERUSAHAAN -->
                    <div class="mb-3">
                        <label for="edit_id_perusahaan" class="form-label fw-bold">Nama Perusahaan</label>
                        <select id="edit_id_perusahaan" required style="width: 100%; display: none;">
                            <option value="">-- Pilih Perusahaan --</option>
                            @foreach ($companies as $company)
                                <option value="{{ $company->id_perusahaan }}">{{ $company->nama_perusahaan }}</option>
                            @endforeach
                            <option value="lainnya">Lainnya (Tambah Baru)</option>
                        </select>
                    </div>

                    <!-- KOTAK ISI MANUAL PERUSAHAAN BARU -->
                    <div class="mb-3" id="edit_new_company_wrapper" style="display: none;">
                        <label for="edit_nama_perusahaan_baru" class="form-label fw-bold text-pertamina-blue">Nama Perusahaan Baru</label>
                        <input type="text" class="form-control" id="edit_nama_perusahaan_baru" placeholder="Masukkan nama perusahaan baru">
                    </div>

                    <!-- DROPDOWN FTIT -->
                    <div class="mb-3">
                        <label for="edit_id_ftit" class="form-label fw-bold">Depot / Terminal FTIT</label>
                        <select id="edit_id_ftit" class="form-select" multiple="multiple" required>
                            @foreach ($ftits as $ft)
                                <option value="{{ $ft->id_ftit }}">{{ $ft->nama_ftit }} ({{ $ft->id_ftit }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- NAMA KAPAL (MANUAL) -->
                    <div class="mb-3">
                        <label for="edit_nama_kapal" class="form-label fw-bold">Nama Kapal</label>
                        <input type="text" class="form-control" id="edit_nama_kapal" required placeholder="Contoh: KM Samudera Jaya">
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
            dropdownParent: $('#tambahKapalModal'),
            placeholder: '-- Pilih Perusahaan --',
            allowClear: true
        });

        $('#id_ftit').select2({
            dropdownParent: $('#tambahKapalModal'),
            placeholder: '-- Pilih Depot/Terminal FTIT --',
            allowClear: true
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

        const form = document.getElementById('tambahKapalForm');
        
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            
            // Get values
            const nama = document.getElementById('nama_kapal').value;
            const kode = document.getElementById('kode_vessel').value;
            const perusahaanSelect = document.getElementById('id_perusahaan');
            const perusahaanId = perusahaanSelect.value;
            const namaPerusahaanBaru = document.getElementById('nama_perusahaan_baru').value;
            const idFtit = $('#id_ftit').val();
            
            // Strict Validation
            if (!perusahaanId) {
                showToast('Nama Perusahaan wajib dipilih!', 'danger');
                return;
            }
            if (perusahaanId === 'lainnya' && !namaPerusahaanBaru.trim()) {
                showToast('Nama Perusahaan Baru wajib diisi!', 'danger');
                return;
            }
            if (!idFtit || idFtit.length === 0) {
                showToast('Depot / Terminal FTIT wajib dipilih!', 'danger');
                return;
            }
            if (!nama.trim()) {
                showToast('Nama Kapal wajib diisi!', 'danger');
                return;
            }
            if (!kode.trim()) {
                showToast('Kode Vessel wajib diisi!', 'danger');
                return;
            }
            
            fetch('{{ url('/dashboard/pertamina/kapal/tambah') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify({
                    nama_kapal: nama,
                    kode_vessel: kode,
                    id_perusahaan: perusahaanId,
                    nama_perusahaan_baru: namaPerusahaanBaru,
                    id_ftit: idFtit
                })
            })
            .then(response => {
                return response.json().then(data => {
                    if (!response.ok) {
                        let errMsg = 'Gagal menambahkan kapal';
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
                    const dynamicCompany = data.data.perusahaan ? data.data.perusahaan.nama_perusahaan : '';
                    
                    // Add new company option dynamically to Select2 if it was added manually
                    if (perusahaanId === 'lainnya' && data.data.id_perusahaan) {
                        const newOption = new Option(dynamicCompany, data.data.id_perusahaan, false, false);
                        $('#id_perusahaan').prepend(newOption).trigger('change');
                        const newOptionEdit = new Option(dynamicCompany, data.data.id_perusahaan, false, false);
                        $('#edit_id_perusahaan').prepend(newOptionEdit).trigger('change');
                    }

                    // Create new row
                    const tbody = document.getElementById('kapalTableBody');
                    
                    // Remove "tidak ada data" row if it exists
                    if (tbody.children.length === 1 && tbody.children[0].cells.length === 1) {
                        tbody.innerHTML = '';
                    }

                    const tr = document.createElement('tr');
                    tr.id = `vessel-row-${kode}`;
                    tr.style.opacity = '0';
                    tr.style.transform = 'translateY(10px)';
                    tr.style.transition = 'all 0.4s ease';
                    
                    let ftitNama = '—';
                    let ftitIds = '';
                    if (data.data.depots && data.data.depots.length > 0) {
                        ftitNama = data.data.depots.map(d => d.nama_ftit).join(', ');
                        ftitIds = data.data.depots.map(d => d.id_ftit).join(',');
                    }
                    
                    tr.innerHTML = `
                        <td>
                            <i class="bi bi-ship me-1 text-pertamina-blue"></i>
                            <span class="vessel-nama">${nama}</span>
                            <br><small class="text-muted vessel-kode">${kode}</small>
                        </td>
                        <td class="vessel-perusahaan" data-id-perusahaan="${data.data.id_perusahaan}">${dynamicCompany}</td>
                        <td class="vessel-ftit" data-id-ftit="${ftitIds}">${ftitNama}</td>
                        <td><span class="badge badge-filled">Aktif</span></td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-outline-warning btn-edit-kapal me-1" 
                                    data-kode="${kode}"
                                    data-nama="${nama}"
                                    data-perusahaan="${data.data.id_perusahaan}"
                                    data-ftit="${ftitIds}">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger btn-delete-kapal" 
                                    data-kode="${kode}"
                                    data-nama="${nama}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    `;
                    
                    // Insert at the beginning of the table body
                    tbody.insertBefore(tr, tbody.firstChild);
                    
                    // Hide modal
                    const modalEl = document.getElementById('tambahKapalModal');
                    const modal = bootstrap.Modal.getInstance(modalEl);
                    modal.hide();
                    
                    // Reset form and Select2
                    form.reset();
                    $('#id_perusahaan').val(null).trigger('change');
                    $('#id_ftit').val(null).trigger('change');
                    
                    // Trigger animation
                    setTimeout(() => {
                        tr.style.opacity = '1';
                        tr.style.transform = 'translateY(0)';
                    }, 100);
                    
                    // Show toast message
                    showToast('Kapal baru berhasil ditambahkan!', 'success');
                }
            })
            .catch(error => {
                showToast(error.message, 'danger');
            });
        });

        // Initialize Select2 on Edit Modal
        $('#edit_id_perusahaan').select2({
            dropdownParent: $('#editKapalModal'),
            placeholder: '-- Pilih Perusahaan --',
            allowClear: true
        });

        $('#edit_id_ftit').select2({
            dropdownParent: $('#editKapalModal'),
            placeholder: '-- Pilih Depot/Terminal FTIT --',
            allowClear: true
        });

        $('#edit_id_perusahaan').on('change', function () {
            if ($(this).val() === 'lainnya') {
                $('#edit_new_company_wrapper').slideDown();
                $('#edit_nama_perusahaan_baru').attr('required', true);
            } else {
                $('#edit_new_company_wrapper').slideUp();
                $('#edit_nama_perusahaan_baru').removeAttr('required').val('');
            }
        });

        let originalVesselCode = '';

        // Handle Edit Click
        $(document).on('click', '.btn-edit-kapal', function() {
            const kode = $(this).attr('data-kode');
            const nama = $(this).attr('data-nama');
            const perusahaan = $(this).attr('data-perusahaan');
            const ftit = $(this).attr('data-ftit');
            
            originalVesselCode = kode;
            $('#edit_kode_vessel').val(kode);
            $('#edit_nama_kapal').val(nama);
            $('#edit_id_perusahaan').val(perusahaan).trigger('change');
            
            if (ftit) {
                $('#edit_id_ftit').val(ftit.split(',')).trigger('change');
            } else {
                $('#edit_id_ftit').val(null).trigger('change');
            }
            
            const editModal = new bootstrap.Modal(document.getElementById('editKapalModal'));
            editModal.show();
        });

        // Handle Edit Form Submit
        const editForm = document.getElementById('editKapalForm');
        editForm.addEventListener('submit', function (e) {
            e.preventDefault();
            
            const kode = document.getElementById('edit_kode_vessel').value;
            const nama = document.getElementById('edit_nama_kapal').value;
            const perusahaanSelect = document.getElementById('edit_id_perusahaan');
            const perusahaanId = perusahaanSelect.value;
            const namaPerusahaanBaru = document.getElementById('edit_nama_perusahaan_baru').value;
            const idFtit = $('#edit_id_ftit').val();
            
            if (!kode.trim()) {
                showToast('Kode Vessel wajib diisi!', 'danger');
                return;
            }
            if (!perusahaanId) {
                showToast('Nama Perusahaan wajib dipilih!', 'danger');
                return;
            }
            if (perusahaanId === 'lainnya' && !namaPerusahaanBaru.trim()) {
                showToast('Nama Perusahaan Baru wajib diisi!', 'danger');
                return;
            }
            if (!idFtit || idFtit.length === 0) {
                showToast('Depot / Terminal FTIT wajib dipilih!', 'danger');
                return;
            }
            if (!nama.trim()) {
                showToast('Nama Kapal wajib diisi!', 'danger');
                return;
            }
            
            fetch(`{{ url('/dashboard/pertamina/kapal/edit') }}/${originalVesselCode}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify({
                    kode_vessel: kode,
                    nama_kapal: nama,
                    id_perusahaan: perusahaanId,
                    nama_perusahaan_baru: namaPerusahaanBaru,
                    id_ftit: idFtit
                })
            })
            .then(response => response.json().then(data => {
                if (!response.ok) {
                    let errMsg = 'Gagal mengubah kapal';
                    if (data.errors) {
                        errMsg = Object.values(data.errors).flat().join(', ');
                    } else if (data.message) {
                        errMsg = data.message;
                    }
                    throw new Error(errMsg);
                }
                return data;
            }))
            .then(data => {
                if (data.success) {
                    let ftitNama = '—';
                    let ftitIds = '';
                    if (data.data.depots && data.data.depots.length > 0) {
                        ftitNama = data.data.depots.map(d => d.nama_ftit).join(', ');
                        ftitIds = data.data.depots.map(d => d.id_ftit).join(',');
                    }
                    
                    // Add new company option dynamically to Select2 if it was added manually
                    if (perusahaanId === 'lainnya' && data.data.id_perusahaan) {
                        const newOptionEdit = new Option(dynamicCompany, data.data.id_perusahaan, false, false);
                        $('#edit_id_perusahaan').prepend(newOptionEdit).trigger('change');
                        const newOptionAdd = new Option(dynamicCompany, data.data.id_perusahaan, false, false);
                        $('#id_perusahaan').prepend(newOptionAdd).trigger('change');
                    }

                    // Update Row in table
                    const row = document.getElementById(`vessel-row-${originalVesselCode}`);
                    if (row) {
                        row.id = `vessel-row-${data.data.kode_vessel}`;
                        row.querySelector('.vessel-nama').textContent = nama;
                        row.querySelector('.vessel-kode').textContent = data.data.kode_vessel;
                        
                        const cellPerusahaan = row.querySelector('.vessel-perusahaan');
                        cellPerusahaan.textContent = dynamicCompany;
                        cellPerusahaan.setAttribute('data-id-perusahaan', data.data.id_perusahaan);
                        
                        const cellFtit = row.querySelector('.vessel-ftit');
                        cellFtit.textContent = ftitNama;
                        cellFtit.setAttribute('data-id-ftit', ftitIds);

                        // Update edit buttons data attrs
                        const editBtn = row.querySelector('.btn-edit-kapal');
                        editBtn.setAttribute('data-kode', data.data.kode_vessel);
                        editBtn.setAttribute('data-nama', nama);
                        editBtn.setAttribute('data-perusahaan', data.data.id_perusahaan);
                        editBtn.setAttribute('data-ftit', ftitIds);

                        // Update delete button data attrs
                        const deleteBtn = row.querySelector('.btn-delete-kapal');
                        if (deleteBtn) {
                            deleteBtn.setAttribute('data-kode', data.data.kode_vessel);
                            deleteBtn.setAttribute('data-nama', nama);
                        }
                    }
                    
                    // Hide Modal
                    const modalEl = document.getElementById('editKapalModal');
                    const modal = bootstrap.Modal.getInstance(modalEl);
                    modal.hide();
                    
                    // Reset edit form
                    editForm.reset();
                    $('#edit_id_perusahaan').val(null).trigger('change');
                    
                    showToast('Data Kapal berhasil diubah!', 'success');
                }
            })
            .catch(error => {
                showToast(error.message, 'danger');
            });
        });

        // Handle Delete Click
        $(document).on('click', '.btn-delete-kapal', function() {
            const kode = $(this).attr('data-kode');
            const nama = $(this).attr('data-nama');
            
            if (confirm(`Apakah Anda yakin ingin menghapus kapal "${nama}" (${kode})? Seluruh riwayat logbook terkait kapal ini juga akan terhapus.`)) {
                fetch(`{{ url('/dashboard/pertamina/kapal/delete') }}/${kode}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const row = document.getElementById(`vessel-row-${kode}`);
                        if (row) {
                            row.style.transition = 'all 0.4s ease';
                            row.style.opacity = '0';
                            row.style.transform = 'translateY(-10px)';
                            setTimeout(() => {
                                row.remove();
                                // If table body is empty, show empty message
                                const tbody = document.getElementById('kapalTableBody');
                                if (tbody.children.length === 0) {
                                    tbody.innerHTML = `<tr><td colspan="5" class="text-center text-muted">Tidak ada data kapal.</td></tr>`;
                                }
                            }, 400);
                        }
                        showToast('Kapal berhasil dihapus!', 'success');
                    } else {
                        showToast('Gagal menghapus kapal', 'danger');
                    }
                })
                .catch(error => {
                    showToast('Gagal menghubungi server', 'danger');
                });
            }
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
