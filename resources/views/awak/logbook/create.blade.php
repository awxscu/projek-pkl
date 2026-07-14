@extends('layouts.dashboard')

@section('title', 'Tambah Logbook')
@section('page-title', 'Tambah Logbook')
@section('page-subtitle', 'Form pencatatan pemakaian bahan bakar & pelumas')
@section('user-initial', 'AK')
@section('user-name', 'Budi Santoso')
@section('user-role', 'Nakhoda')

@section('sidebar')
    @include('partials.sidebar-awak')
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card-modern logbook-form-card">
                <div class="mb-4">
                    <h5 class="fw-bold text-pertamina-blue mb-1">
                        <i class="bi bi-journal-plus me-2"></i>Form Input Logbook
                    </h5>
                    <p class="text-muted mb-0 small">Lengkapi data pemakaian bahan bakar dan pelumas kapal</p>
                </div>

                <form action="#" method="POST" id="logbookForm">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="tanggal" class="form-label">
                                <i class="bi bi-calendar3 me-1"></i>Tanggal Pencatatan
                            </label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" value="2026-07-14" required>
                        </div>
                        <div class="col-md-6">
                            <label for="kapal" class="form-label">
                                <i class="bi bi-ship me-1"></i>Pilih Kapal
                            </label>
                            <select class="form-select" id="kapal" name="kapal" required>
                                <option value="" disabled>Pilih kapal</option>
                                <option value="PTS-001" selected>MT Pertamina Satu (PTS-001)</option>
                                <option value="PTS-002">MT Pertamina Dua (PTS-002)</option>
                                <option value="PTS-003">MT Pertamina Tiga (PTS-003)</option>
                                <option value="PTS-004">MT Pertamina Empat (PTS-004)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="jenis_bbm" class="form-label">
                                <i class="bi bi-fuel-pump me-1"></i>Jenis Bahan Bakar
                            </label>
                            <select class="form-select" id="jenis_bbm" name="jenis_bbm" required>
                                <option value="" disabled>Pilih jenis</option>
                                <option value="do" selected>Diesel Oil (DO)</option>
                                <option value="bbm">Bahan Bakar Minyak (BBM)</option>
                                <option value="pelumas">Pelumas Mesin</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="sisa_kemarin" class="form-label">
                                <i class="bi bi-droplet me-1"></i>Sisa Kemarin (L)
                            </label>
                            <input type="number" class="form-control calc-input" id="sisa_kemarin" name="sisa_kemarin" placeholder="0" value="970" min="0" step="0.01" required>
                        </div>

                        <div class="col-12">
                            <hr class="my-1">
                            <p class="text-muted small mb-0 fw-semibold">
                                <i class="bi bi-gear me-1"></i>Detail Pemakaian
                            </p>
                        </div>

                        <div class="col-md-4">
                            <label for="motor_induk" class="form-label">Motor Induk (L)</label>
                            <input type="number" class="form-control calc-input" id="motor_induk" name="motor_induk" placeholder="0" value="80" min="0" step="0.01" required>
                        </div>
                        <div class="col-md-4">
                            <label for="motor_bantu" class="form-label">Motor Bantu (L)</label>
                            <input type="number" class="form-control calc-input" id="motor_bantu" name="motor_bantu" placeholder="0" value="30" min="0" step="0.01" required>
                        </div>
                        <div class="col-md-4">
                            <label for="lain_lain" class="form-label">Lain-lain (L)</label>
                            <input type="number" class="form-control calc-input" id="lain_lain" name="lain_lain" placeholder="0" value="10" min="0" step="0.01" required>
                        </div>
                        <div class="col-md-6">
                            <label for="ditambah" class="form-label">
                                <i class="bi bi-plus-circle me-1"></i>Ditambah (L)
                            </label>
                            <input type="number" class="form-control calc-input" id="ditambah" name="ditambah" placeholder="0" value="0" min="0" step="0.01" required>
                            <small class="text-muted">Jumlah BBM yang ditambahkan/diisi ulang</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">
                                <i class="bi bi-calculator me-1"></i>Jumlah Sekarang (L)
                            </label>
                            <div class="calc-result">
                                <div class="small text-muted mb-1">Hasil perhitungan otomatis:</div>
                                <div class="calc-value" id="jumlah_sekarang_display">850</div>
                                <input type="hidden" id="jumlah_sekarang" name="jumlah_sekarang" value="850">
                                <small class="text-muted d-block mt-1">
                                    = Sisa Kemarin − (Motor Induk + Motor Bantu + Lain-lain) + Ditambah
                                </small>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="catatan" class="form-label">
                                <i class="bi bi-chat-left-text me-1"></i>Catatan
                            </label>
                            <textarea class="form-control" id="catatan" name="catatan" rows="3" placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                        </div>

                        <div class="col-12 mt-2">
                            <div class="d-flex gap-2 flex-wrap">
                                <button type="submit" class="btn btn-pertamina px-4">
                                    <i class="bi bi-save me-2"></i>Simpan Logbook
                                </button>
                                <a href="{{ route('dashboard.awak') }}" class="btn btn-outline-secondary px-4">
                                    <i class="bi bi-arrow-left me-2"></i>Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function hitungJumlahSekarang() {
        const sisaKemarin = parseFloat(document.getElementById('sisa_kemarin').value) || 0;
        const motorInduk = parseFloat(document.getElementById('motor_induk').value) || 0;
        const motorBantu = parseFloat(document.getElementById('motor_bantu').value) || 0;
        const lainLain = parseFloat(document.getElementById('lain_lain').value) || 0;
        const ditambah = parseFloat(document.getElementById('ditambah').value) || 0;

        const jumlahSekarang = sisaKemarin - (motorInduk + motorBantu + lainLain) + ditambah;

        document.getElementById('jumlah_sekarang_display').textContent = jumlahSekarang.toLocaleString('id-ID', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 2
        });
        document.getElementById('jumlah_sekarang').value = jumlahSekarang;
    }

    document.querySelectorAll('.calc-input').forEach(function (input) {
        input.addEventListener('input', hitungJumlahSekarang);
    });

    hitungJumlahSekarang();

    document.getElementById('logbookForm').addEventListener('submit', function (e) {
        e.preventDefault();
        alert('Logbook berhasil disimpan! (Demo — data belum tersimpan ke database)');
        window.location.href = '{{ route("dashboard.awak") }}';
    });
</script>
@endpush
