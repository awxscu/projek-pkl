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
                    <p class="text-muted mb-0 small">Masukkan pencatatan pemakaian BBM dan pelumas kapal penumpang secara lengkap</p>
                </div>
            </div>

            <form action="#" method="POST" id="logbookForm">
                @csrf
                
                <!-- SECTION 1: DATA UTAMA -->
                <div class="form-section-title">
                    <i class="bi bi-card-heading me-2"></i>1. Data Utama
                </div>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="kapal" class="form-label">Kapal</label>
                        <select class="form-select" id="kapal" name="kapal" required>
                            <option value="VSL-001" selected>KM Nusantara Jaya (VSL-001)</option>
                            <option value="VSL-002">KM Samudra Indah (VSL-002)</option>
                            <option value="VSL-003">KM Pelangi Nusantara (VSL-003)</option>
                            <option value="VSL-004">KM Bahari Sejahtera (VSL-004)</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="tanggal" class="form-label">Tanggal Pencatatan</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" value="2026-07-14" required>
                    </div>
                </div>

                <!-- SECTION 2: DETAIL PEMAKAIAN BBM (TAB LAYOUT) -->
                <div class="form-section-title">
                    <i class="bi bi-fuel-pump me-2"></i>2. Detail Pemakaian BBM & Pelumas
                </div>
                
                <p class="text-muted small mb-3">Masukkan rincian pemakaian untuk masing-masing jenis bahan bakar / pelumas di bawah ini. Sisa sekarang dihitung secara otomatis.</p>

                <ul class="nav nav-tabs mb-3" id="bbmTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="do-tab" data-bs-toggle="tab" data-bs-target="#do-content" type="button" role="tab" aria-selected="true">
                            <i class="bi bi-droplet-fill text-pertamina-blue me-1"></i>Diesel Oil (DO)
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="fo-tab" data-bs-toggle="tab" data-bs-target="#fo-content" type="button" role="tab" aria-selected="false">
                            <i class="bi bi-droplet-half text-pertamina-red me-1"></i>Fuel Oil (FO)
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="lube-tab" data-bs-toggle="tab" data-bs-target="#lube-content" type="button" role="tab" aria-selected="false">
                            <i class="bi bi-oil-barrel text-warning me-1"></i>Lube Oil
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="cylinder-tab" data-bs-toggle="tab" data-bs-target="#cylinder-content" type="button" role="tab" aria-selected="false">
                            <i class="bi bi-gear-wide-connected text-secondary me-1"></i>Cylinder Oil
                        </button>
                    </li>
                </ul>

                <div class="tab-content border p-3 rounded bg-white mb-4" id="bbmTabsContent">
                    <!-- DIESEL OIL (DO) TAB -->
                    <div class="tab-pane fade show active" id="do-content" role="tabpanel" aria-labelledby="do-tab">
                        <div class="row g-3">
                            <div class="col-md-6 col-lg-4">
                                <label for="do_sisa_kemarin" class="form-label">Sisa Kemarin (L)</label>
                                <input type="number" class="form-control calc-input" id="do_sisa_kemarin" name="do_sisa_kemarin" value="1250" min="0">
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <label for="do_motor_induk" class="form-label">Motor Induk (L)</label>
                                <input type="number" class="form-control calc-input" id="do_motor_induk" name="do_motor_induk" value="200" min="0">
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <label for="do_motor_bantu" class="form-label">Motor Bantu (L)</label>
                                <input type="number" class="form-control calc-input" id="do_motor_bantu" name="do_motor_bantu" value="80" min="0">
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <label for="do_lain_lain" class="form-label">Lain-lain (L)</label>
                                <input type="number" class="form-control calc-input" id="do_lain_lain" name="do_lain_lain" value="40" min="0">
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <label for="do_ditambah" class="form-label">Ditambah (L)</label>
                                <input type="number" class="form-control calc-input" id="do_ditambah" name="do_ditambah" value="0" min="0">
                            </div>
                            <div class="col-md-12 col-lg-4">
                                <label class="form-label fw-bold text-pertamina-blue">Sisa Sekarang (L)</label>
                                <div class="calc-result border-primary py-2 px-3">
                                    <div class="calc-value text-pertamina-blue" id="do_sisa_sekarang_display">930</div>
                                    <input type="hidden" id="do_sisa_sekarang" name="do_sisa_sekarang" value="930">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FUEL OIL (FO) TAB -->
                    <div class="tab-pane fade" id="fo-content" role="tabpanel" aria-labelledby="fo-tab">
                        <div class="row g-3">
                            <div class="col-md-6 col-lg-4">
                                <label for="fo_sisa_kemarin" class="form-label">Sisa Kemarin (L)</label>
                                <input type="number" class="form-control calc-input" id="fo_sisa_kemarin" name="fo_sisa_kemarin" value="800" min="0">
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <label for="fo_motor_induk" class="form-label">Motor Induk (L)</label>
                                <input type="number" class="form-control calc-input" id="fo_motor_induk" name="fo_motor_induk" value="0" min="0">
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <label for="fo_motor_bantu" class="form-label">Motor Bantu (L)</label>
                                <input type="number" class="form-control calc-input" id="fo_motor_bantu" name="fo_motor_bantu" value="0" min="0">
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <label for="fo_lain_lain" class="form-label">Lain-lain (L)</label>
                                <input type="number" class="form-control calc-input" id="fo_lain_lain" name="fo_lain_lain" value="0" min="0">
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <label for="fo_ditambah" class="form-label">Ditambah (L)</label>
                                <input type="number" class="form-control calc-input" id="fo_ditambah" name="fo_ditambah" value="0" min="0">
                            </div>
                            <div class="col-md-12 col-lg-4">
                                <label class="form-label fw-bold text-pertamina-red">Sisa Sekarang (L)</label>
                                <div class="calc-result border-danger py-2 px-3" style="background:#fee2e2;border-color:var(--pertamina-red)">
                                    <div class="calc-value text-pertamina-red" id="fo_sisa_sekarang_display">800</div>
                                    <input type="hidden" id="fo_sisa_sekarang" name="fo_sisa_sekarang" value="800">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- LUBE OIL TAB -->
                    <div class="tab-pane fade" id="lube-content" role="tabpanel" aria-labelledby="lube-tab">
                        <div class="row g-3">
                            <div class="col-md-6 col-lg-4">
                                <label for="lube_sisa_kemarin" class="form-label">Sisa Kemarin (L)</label>
                                <input type="number" class="form-control calc-input" id="lube_sisa_kemarin" name="lube_sisa_kemarin" value="300" min="0">
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <label for="lube_motor_induk" class="form-label">Motor Induk (L)</label>
                                <input type="number" class="form-control calc-input" id="lube_motor_induk" name="lube_motor_induk" value="10" min="0">
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <label for="lube_motor_bantu" class="form-label">Motor Bantu (L)</label>
                                <input type="number" class="form-control calc-input" id="lube_motor_bantu" name="lube_motor_bantu" value="5" min="0">
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <label for="lube_lain_lain" class="form-label">Lain-lain (L)</label>
                                <input type="number" class="form-control calc-input" id="lube_lain_lain" name="lube_lain_lain" value="2" min="0">
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <label for="lube_ditambah" class="form-label">Ditambah (L)</label>
                                <input type="number" class="form-control calc-input" id="lube_ditambah" name="lube_ditambah" value="0" min="0">
                            </div>
                            <div class="col-md-12 col-lg-4">
                                <label class="form-label fw-bold text-warning">Sisa Sekarang (L)</label>
                                <div class="calc-result py-2 px-3" style="background:#fef3c7;border-color:#f59e0b">
                                    <div class="calc-value text-warning" id="lube_sisa_sekarang_display">283</div>
                                    <input type="hidden" id="lube_sisa_sekarang" name="lube_sisa_sekarang" value="283">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- CYLINDER OIL TAB -->
                    <div class="tab-pane fade" id="cylinder-content" role="tabpanel" aria-labelledby="cylinder-tab">
                        <div class="row g-3">
                            <div class="col-md-6 col-lg-4">
                                <label for="cylinder_sisa_kemarin" class="form-label">Sisa Kemarin (L)</label>
                                <input type="number" class="form-control calc-input" id="cylinder_sisa_kemarin" name="cylinder_sisa_kemarin" value="150" min="0">
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <label for="cylinder_motor_induk" class="form-label">Motor Induk (L)</label>
                                <input type="number" class="form-control calc-input" id="cylinder_motor_induk" name="cylinder_motor_induk" value="5" min="0">
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <label for="cylinder_motor_bantu" class="form-label">Motor Bantu (L)</label>
                                <input type="number" class="form-control calc-input" id="cylinder_motor_bantu" name="cylinder_motor_bantu" value="2" min="0">
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <label for="cylinder_lain_lain" class="form-label">Lain-lain (L)</label>
                                <input type="number" class="form-control calc-input" id="cylinder_lain_lain" name="cylinder_lain_lain" value="1" min="0">
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <label for="cylinder_ditambah" class="form-label">Ditambah (L)</label>
                                <input type="number" class="form-control calc-input" id="cylinder_ditambah" name="cylinder_ditambah" value="0" min="0">
                            </div>
                            <div class="col-md-12 col-lg-4">
                                <label class="form-label fw-bold text-secondary">Sisa Sekarang (L)</label>
                                <div class="calc-result py-2 px-3" style="background:#f1f5f9;border-color:#64748b">
                                    <div class="calc-value text-secondary" id="cylinder_sisa_sekarang_display">142</div>
                                    <input type="hidden" id="cylinder_sisa_sekarang" name="cylinder_sisa_sekarang" value="142">
                                </div>
                            </div>
                        </div>
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
        // Independent Date inputs and Port dropdown selection (no route select code needed)

        // Auto-calculation logic for fuel types
        const types = ['do', 'fo', 'lube', 'cylinder'];

        function hitungSisaSekarang(type) {
            const kemarin = parseFloat(document.getElementById(type + '_sisa_kemarin').value) || 0;
            const induk = parseFloat(document.getElementById(type + '_motor_induk').value) || 0;
            const bantu = parseFloat(document.getElementById(type + '_motor_bantu').value) || 0;
            const lain = parseFloat(document.getElementById(type + '_lain_lain').value) || 0;
            const tambah = parseFloat(document.getElementById(type + '_ditambah').value) || 0;

            // sisa_sekarang = sisa_kemarin - (motor_induk + motor_bantu + lain_lain) + ditambah
            const sekarang = kemarin - (induk + bantu + lain) + tambah;

            const displayEl = document.getElementById(type + '_sisa_sekarang_display');
            const hiddenEl = document.getElementById(type + '_sisa_sekarang');

            if (displayEl && hiddenEl) {
                displayEl.textContent = sekarang.toLocaleString('id-ID', { maximumFractionDigits: 2 });
                hiddenEl.value = sekarang;
            }
        }

        // Add event listeners to all calculation inputs
        types.forEach(type => {
            const inputs = [
                type + '_sisa_kemarin',
                type + '_motor_induk',
                type + '_motor_bantu',
                type + '_lain_lain',
                type + '_ditambah'
            ];
            inputs.forEach(id => {
                const el = document.getElementById(id);
                if (el) {
                    el.addEventListener('input', () => hitungSisaSekarang(type));
                }
            });
            // Initial calculations
            hitungSisaSekarang(type);
        });

        // Recalculate on reset
        const formEl = document.getElementById('logbookForm');
        formEl.addEventListener('reset', function () {
            // Wait for call stack to clear so inputs get reset values first
            setTimeout(() => {
                types.forEach(type => hitungSisaSekarang(type));
            }, 50);
        });

        // Form submission demo response
        formEl.addEventListener('submit', function (e) {
            e.preventDefault();
            sessionStorage.setItem('logbook_filled_today', 'true');
            alert('Logbook Kapal berhasil disimpan ke dalam sistem!');
            window.location.href = "{{ route('dashboard.awak') }}";
        });
    });
</script>
@endpush
