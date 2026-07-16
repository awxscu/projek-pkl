@extends('layouts.dashboard')

@section('title', 'Tambah Jadwal Perjalanan')
@section('navbar') @include('partials.navbar-awak') @endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card-modern logbook-form-card p-4">
            <div class="mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <h5 class="fw-bold text-pertamina-blue mb-1">
                        <i class="bi bi-calendar-plus me-2"></i>Tambah Jadwal Perjalanan Kapal
                    </h5>
                    <p class="text-muted mb-0 small">Masukkan rencana pelayaran kapal secara lengkap dan akurat</p>
                </div>
                <a href="{{ route('awak.perjalanan') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i>Kembali
                </a>
            </div>

            <!-- Toast Success Container -->
            <div id="toastContainer" style="display: none; background: #ecfdf5; border: 1px solid #059669; color: #065f46; border-radius: 8px; padding: 1rem; margin-bottom: 1.5rem;" class="align-items-center gap-2">
                <i class="bi bi-check-circle-fill fs-5 text-emerald-600 text-success me-2"></i>
                <div>
                    <strong>Berhasil!</strong> Jadwal perjalanan kapal telah berhasil didaftarkan.
                </div>
            </div>

            <form id="perjalananForm">
                @csrf
                <div class="row g-3 mb-4">
                    <div class="col-md-12">
                        <label for="kapal" class="form-label fw-semibold">Kapal</label>
                        <select class="form-select" id="kapal" name="kapal" required>
                            <option value="VSL-001" selected>KM Nusantara Jaya (VSL-001)</option>
                            <option value="VSL-002">KM Samudra Indah (VSL-002)</option>
                            <option value="VSL-003">KM Pelangi Nusantara (VSL-003)</option>
                            <option value="VSL-004">KM Bahari Sejahtera (VSL-004)</option>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label for="no_surat_jalan" class="form-label fw-semibold">No Surat Jalan Kapal</label>
                        <input type="text" class="form-control" id="no_surat_jalan" name="no_surat_jalan" placeholder="Contoh: SPK-2026-0045" required>
                    </div>
                    <div class="col-md-6">
                        <label for="pelabuhan_asal" class="form-label fw-semibold">Pelabuhan Asal</label>
                        <select class="form-select" id="pelabuhan_asal" name="pelabuhan_asal" required>
                            <option value="" disabled selected>Pilih Pelabuhan Asal</option>
                            <option value="Surabaya">Surabaya</option>
                            <option value="Balikpapan">Balikpapan</option>
                            <option value="Jakarta">Jakarta</option>
                            <option value="Semarang">Semarang</option>
                            <option value="Makassar">Makassar</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="pelabuhan_tujuan" class="form-label fw-semibold">Pelabuhan Tujuan</label>
                        <select class="form-select" id="pelabuhan_tujuan" name="pelabuhan_tujuan" required>
                            <option value="" disabled selected>Pilih Pelabuhan Tujuan</option>
                            <option value="Surabaya">Surabaya</option>
                            <option value="Balikpapan">Balikpapan</option>
                            <option value="Jakarta">Jakarta</option>
                            <option value="Semarang">Semarang</option>
                            <option value="Makassar">Makassar</option>
                            <option value="Baubau">Baubau</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="tanggal_mulai" class="form-label fw-semibold">Tanggal Mulai Perjalanan</label>
                        <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required>
                    </div>
                    <div class="col-md-6">
                        <label for="tanggal_selesai" class="form-label fw-semibold">Tanggal Selesai Perjalanan</label>
                        <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" required>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 border-top pt-3">
                    <a href="{{ route('awak.perjalanan') }}" class="btn btn-outline-secondary" style="border-radius: 10px; font-weight: 600; padding: 0.65rem 1.6rem; transition: all 0.3s ease;">
                        <i class="bi bi-x-lg me-1"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-pertamina" style="border-radius: 10px; font-weight: 600; padding: 0.65rem 1.6rem; transition: all 0.3s ease;">
                        <i class="bi bi-save me-1"></i>Simpan Jadwal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Autofill dates for demonstration
    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('tanggal_mulai').value = today;
        
        const nextTwoDays = new Date();
        nextTwoDays.setDate(nextTwoDays.getDate() + 2);
        document.getElementById('tanggal_selesai').value = nextTwoDays.toISOString().split('T')[0];
    });

    document.getElementById('perjalananForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const kapalSelect = document.getElementById('kapal');
        const kapalText = kapalSelect.options[kapalSelect.selectedIndex].text;
        const kapalVal = kapalSelect.value;
        const asal = document.getElementById('pelabuhan_asal').value;
        const tujuan = document.getElementById('pelabuhan_tujuan').value;
        const tglMulai = document.getElementById('tanggal_mulai').value;
        const tglSelesai = document.getElementById('tanggal_selesai').value;
        
        // Retrieve existing voyages
        let voyages = localStorage.getItem('voyages');
        if (voyages) {
            voyages = JSON.parse(voyages);
        } else {
            voyages = [
                {
                    rute: "Surabaya &rarr; Balikpapan",
                    asal: "Tanjung Perak (SUB)",
                    tujuan: "Semayang (BPN)",
                    mulai: "2026-07-14",
                    selesai: "2026-07-15",
                    status: "Berlangsung"
                },
                {
                    rute: "Balikpapan &rarr; Surabaya",
                    asal: "Semayang (BPN)",
                    tujuan: "Tanjung Perak (SUB)",
                    mulai: "2026-07-17",
                    selesai: "2026-07-18",
                    status: "Terjadwal"
                },
                {
                    rute: "Surabaya &rarr; Makassar",
                    asal: "Tanjung Perak (SUB)",
                    tujuan: "Soekarno-Hatta (MAK)",
                    mulai: "2026-07-20",
                    selesai: "2026-07-21",
                    status: "Terjadwal"
                },
                {
                    rute: "Balikpapan &rarr; Surabaya",
                    asal: "Semayang (BPN)",
                    tujuan: "Tanjung Perak (SUB)",
                    mulai: "2026-07-12",
                    selesai: "2026-07-13",
                    status: "Selesai"
                },
                {
                    rute: "Surabaya &rarr; Balikpapan",
                    asal: "Tanjung Perak (SUB)",
                    tujuan: "Semayang (BPN)",
                    mulai: "2026-07-10",
                    selesai: "2026-07-11",
                    status: "Selesai"
                },
                {
                    rute: "Surabaya &rarr; Banjarmasin",
                    asal: "Tanjung Perak (SUB)",
                    tujuan: "Trisakti (BDJ)",
                    mulai: "2026-07-08",
                    selesai: "2026-07-09",
                    status: "Batal"
                }
            ];
        }
        
        function getCode(name) {
            switch (name) {
                case 'Surabaya': return 'SUB';
                case 'Balikpapan': return 'BPN';
                case 'Jakarta': return 'JKT';
                case 'Semarang': return 'SRG';
                case 'Makassar': return 'MAK';
                case 'Baubau': return 'WUB';
                case 'Banjarmasin': return 'BDJ';
                default: return 'PRT';
            }
        }
        
        // Add new voyage to the beginning of the list
        voyages.unshift({
            no_surat_jalan: document.getElementById('no_surat_jalan').value,
            rute: `${asal} &rarr; ${tujuan}`,
            asal: `${asal} (${getCode(asal)})`,
            tujuan: `${tujuan} (${getCode(tujuan)})`,
            mulai: tglMulai,
            selesai: tglSelesai,
            status: "Terjadwal"
        });
        
        // Save back to localStorage
        localStorage.setItem('voyages', JSON.stringify(voyages));
        
        // Show Success Toast
        const toast = document.getElementById('toastContainer');
        toast.style.display = 'flex';
        
        // Disable submit button to prevent double submit
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Menyimpan...';

        // Redirect after delay
        setTimeout(() => {
            window.location.href = "{{ route('awak.perjalanan') }}";
        }, 1500);
    });
</script>
@endpush
