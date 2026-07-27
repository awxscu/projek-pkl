@extends('layouts.dashboard')

@section('title', 'Tambah Logbook')
@section('navbar') @include('partials.navbar-awak') @endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card-modern logbook-form-card p-4">
            <div class="mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <h5 class="fw-bold text-pertamina-blue mb-1">
                        <i class="bi bi-journal-plus me-2"></i>Sistem Monitoring Logbook — Input Baru
                    </h5>
                    <p class="text-muted mb-0 small">Masukkan pencatatan pemakaian Fuel Oil (FO) kapal secara lengkap</p>
                </div>
            </div>

            <form action="#" method="POST" id="logbookForm">
                @csrf
                
                <!-- SECTION 1: DATA UTAMA -->
                <div class="form-section-title">
                    <i class="bi bi-card-heading me-2"></i>1. Data Utama
                </div>
                <div class="row g-3 mb-4">
                    <!-- NAMA PERUSAHAAN -->
                    <div class="col-md-4">
                        <label class="form-label fw-bold"><i class="bi bi-building me-2"></i>Nama Perusahaan</label>
                        <div class="dropdown" id="searchableCompanyDropdown">
                            <input type="text" class="form-select text-start" id="companySelectBtn" data-bs-toggle="dropdown" aria-expanded="false" readonly placeholder="Pilih Perusahaan..." style="cursor: pointer;">
                            <input type="hidden" name="company" id="company">
                            <div class="dropdown-menu p-3" style="width: 100%; min-width: 250px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.15);">
                                <input type="text" class="form-control form-control-sm mb-2" id="companySearchInput" placeholder="Cari perusahaan...">
                                <div style="max-height: 200px; overflow-y: auto;" id="companyOptionsList">
                                    @foreach ($companies as $company)
                                        <button class="dropdown-item company-option-item text-start py-2" type="button" data-value="{{ $company->nama_perusahaan }}">{{ $company->nama_perusahaan }}</button>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- KAPAL -->
                    <div class="col-md-4">
                        <label for="kapal" class="form-label fw-bold"><i class="bi bi-ship me-2"></i>Kapal</label>
                        <div class="dropdown" id="searchableShipDropdown">
                            <input type="text" class="form-select text-start" id="kapalSelectBtn" data-bs-toggle="dropdown" aria-expanded="false" readonly placeholder="Pilih Kapal..." style="cursor: pointer;">
                            <input type="hidden" name="kapal" id="kapal" required>
                            <div class="dropdown-menu p-3" style="width: 100%; min-width: 250px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.15);">
                                <input type="text" class="form-control form-control-sm mb-2" id="shipSearchInput" placeholder="Cari kapal...">
                                <div style="max-height: 200px; overflow-y: auto;" id="shipOptionsList">
                                    @foreach ($vessels as $v)
                                        @php
                                            $shipCompany = $v->perusahaan->nama_perusahaan ?? 'PT Pelayaran Nasional';
                                        @endphp
                                        <button class="dropdown-item ship-option-item text-start py-2" type="button" data-value="{{ $v->kode_vessel }}" data-company="{{ $shipCompany }}">{{ $v->nama_kapal }} ({{ $v->kode_vessel }})</button>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- TANGGAL PENCATATAN -->
                    <div class="col-md-4">
                        <label for="tanggal" class="form-label fw-bold"><i class="bi bi-calendar-event me-2"></i>Tanggal Pencatatan</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" value="2026-07-20" required>
                    </div>
                </div>

                <!-- SECTION 2: DETAIL PEMAKAIAN FUEL OIL (FO) -->
                <div class="form-section-title">
                    <i class="bi bi-fuel-pump me-2"></i>2. Detail Pemakaian Fuel Oil (FO)
                </div>
                
                <p class="text-muted small mb-4">Masukkan rincian pemakaian Fuel Oil (FO) secara manual pada kolom di bawah ini.</p>
                <div class="mb-4">
                    <!-- SISA KEMARIN -->
                    <div class="mb-4">
                        <label for="fo_sisa_kemarin" class="form-label fw-bold"><i class="bi bi-arrow-left me-1"></i>Sisa Kemarin (L)</label>
                        <input type="number" class="form-control" id="fo_sisa_kemarin" name="fo_sisa_kemarin" value="0" min="0" required>
                    </div>

                    <!-- PENGGUNAAN -->
                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark d-block"><i class="bi bi-activity me-1"></i>Penggunaan (L)</label>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="fo_motor_induk" class="form-label small text-muted">Mesin Induk</label>
                                <input type="number" class="form-control" id="fo_motor_induk" name="fo_motor_induk" value="0" min="0" required>
                            </div>
                            <div class="col-md-3">
                                <label for="fo_motor_bantu" class="form-label small text-muted">Mesin Bantu</label>
                                <input type="number" class="form-control" id="fo_motor_bantu" name="fo_motor_bantu" value="0" min="0" required>
                            </div>
                            <div class="col-md-3">
                                <label for="fo_lain_lain" class="form-label small text-muted">Lain-lain</label>
                                <input type="number" class="form-control" id="fo_lain_lain" name="fo_lain_lain" value="0" min="0" required>
                            </div>
                            <div class="col-md-3">
                                <label for="fo_total_penggunaan" class="form-label small text-muted">Total</label>
                                <input type="number" class="form-control" id="fo_total_penggunaan" name="fo_total_penggunaan" value="0" min="0" required>
                            </div>
                        </div>
                    </div>

                    <!-- SISA SEKARANG -->
                    <div class="mb-4">
                        <label for="fo_sisa_sekarang" class="form-label fw-bold"><i class="bi bi-clock me-1"></i>Sisa Sekarang (L)</label>
                        <input type="number" class="form-control" id="fo_sisa_sekarang" name="fo_sisa_sekarang" value="0" min="0" required>
                    </div>

                    <!-- DITAMBAH -->
                    <div class="mb-4">
                        <label for="fo_ditambah" class="form-label fw-bold"><i class="bi bi-plus-circle me-1"></i>Ditambah (L)</label>
                        <input type="number" class="form-control" id="fo_ditambah" name="fo_ditambah" value="0" min="0" required>
                    </div>

                    <!-- JUMLAH SEKARANG -->
                    <div class="mb-4">
                        <label for="fo_jumlah_sekarang" class="form-label fw-bold text-pertamina-red"><i class="bi bi-check2-circle me-1"></i>Jumlah Sekarang (L)</label>
                        <input type="number" class="form-control fw-bold" id="fo_jumlah_sekarang" name="fo_jumlah_sekarang" value="0" min="0" required>
                    </div>
                </div>

                <!-- SECTION 3: CATATAN -->
                <div class="mb-4">
                    <label for="catatan" class="form-label fw-bold"><i class="bi bi-chat-left-text me-2"></i>Catatan Operasional / Tambahan</label>
                    <textarea class="form-control" id="catatan" name="catatan" rows="3" placeholder="Masukkan catatan opsional mengenai perjalanan atau konsumsi bahan bakar..."></textarea>
                </div>

                <!-- ACTIONS -->
                <div class="d-flex gap-2 justify-content-end border-top pt-3">
                    <button type="reset" class="btn btn-outline-secondary px-4" id="btnReset">
                        <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
                    </button>
                    <button type="submit" class="btn btn-pertamina px-5">
                        <i class="bi bi-save me-1"></i>Simpan Logbook
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Searchable Company Dropdown Logic
        const companySearchInput = document.getElementById('companySearchInput');
        const companyOptionsList = document.getElementById('companyOptionsList');
        const companySelectBtn = document.getElementById('companySelectBtn');
        const companyHiddenInput = document.getElementById('company');

        // Searchable Ship Dropdown Logic
        const shipSearchInput = document.getElementById('shipSearchInput');
        const shipOptionsList = document.getElementById('shipOptionsList');
        const kapalSelectBtn = document.getElementById('kapalSelectBtn');
        const kapalHiddenInput = document.getElementById('kapal');

        if (companySearchInput && companyOptionsList && companySelectBtn) {
            companySearchInput.addEventListener('input', function() {
                const query = this.value.toLowerCase();
                companyOptionsList.querySelectorAll('.company-option-item').forEach(item => {
                    if (item.textContent.toLowerCase().includes(query)) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });

            companyOptionsList.addEventListener('click', function(e) {
                const button = e.target.closest('.company-option-item');
                if (button) {
                    const value = button.getAttribute('data-value');
                    companySelectBtn.value = value;
                    companyHiddenInput.value = value;

                    // Filter ship options based on selected company
                    const shipOptions = shipOptionsList.querySelectorAll('.ship-option-item');
                    shipOptions.forEach(opt => {
                        const optCompany = opt.getAttribute('data-company');
                        if (optCompany === value) {
                            opt.style.display = '';
                        } else {
                            opt.style.display = 'none';
                        }
                    });

                    // Clear currently selected ship if it doesn't match the new company
                    if (kapalHiddenInput.value) {
                        const currentShipOpt = shipOptionsList.querySelector(`.ship-option-item[data-value="${kapalHiddenInput.value}"]`);
                        if (currentShipOpt && currentShipOpt.getAttribute('data-company') !== value) {
                            kapalHiddenInput.value = '';
                            kapalSelectBtn.value = '';
                        }
                    }
                }
            });
        }

        if (shipSearchInput && shipOptionsList && kapalSelectBtn && kapalHiddenInput) {
            shipSearchInput.addEventListener('input', function() {
                const query = this.value.toLowerCase();
                const selectedCompany = companyHiddenInput.value;
                shipOptionsList.querySelectorAll('.ship-option-item').forEach(item => {
                    const text = item.textContent.toLowerCase();
                    const optCompany = item.getAttribute('data-company');
                    
                    // Match query and company constraint
                    const matchesQuery = text.includes(query);
                    const matchesCompany = !selectedCompany || optCompany === selectedCompany;

                    if (matchesQuery && matchesCompany) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });

            shipOptionsList.addEventListener('click', function(e) {
                const button = e.target.closest('.ship-option-item');
                if (button) {
                    const value = button.getAttribute('data-value');
                    const text = button.textContent;
                    
                    kapalHiddenInput.value = value;
                    kapalSelectBtn.value = text;

                    // Auto-fill company if not selected yet
                    const optCompany = button.getAttribute('data-company');
                    if (optCompany && (!companyHiddenInput.value || companyHiddenInput.value !== optCompany)) {
                        companyHiddenInput.value = optCompany;
                        companySelectBtn.value = optCompany;
                    }
                }
            });
        }



        // Form submission AJAX response
        const formEl = document.getElementById('logbookForm');
        formEl.addEventListener('submit', function (e) {
            e.preventDefault();
            
            const formData = new FormData(formEl);
            
            fetch("{{ route('logbook.store') }}", {
                method: "POST",
                body: formData,
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                }
            })
            .then(response => {
                if (!response.ok) throw new Error('Gagal menyimpan logbook');
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    sessionStorage.setItem('logbook_filled_today', 'true');
                    alert('Logbook Kapal berhasil disimpan ke dalam sistem!');
                    window.location.reload();
                }
            })
            .catch(error => {
                alert(error.message);
            });
        });
    });
</script>
@endpush
