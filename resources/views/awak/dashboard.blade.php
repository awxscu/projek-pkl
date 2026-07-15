@extends('layouts.dashboard')

@section('title', 'Dashboard Awak Kapal')
@section('navbar') @include('partials.navbar-awak') @endsection

@section('content')
<div class="welcome-banner mb-4">
    <h4 class="mb-0" id="welcomeGreetingTitle">Selamat Datang, Budi Santoso</h4>
    <p class="mb-0 mt-2 opacity-90" id="welcomeGreetingSubtitle">Semoga pelayaran hari ini berjalan aman, lancar, dan selalu mengutamakan keselamatan kerja!</p>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card-modern stat-card h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div><div class="stat-label">Logbook Hari Ini</div><div class="stat-value stat-value-animate" data-target="1">0 <small class="text-muted" style="font-size:0.8rem">/ 1</small></div></div>
                <div class="stat-icon bg-pertamina-blue text-white"><i class="bi bi-journal-text"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-modern stat-card stat-orange h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div><div class="stat-label">Total Pemakaian BBM</div><div class="stat-value stat-value-animate" data-target="320">0 <small class="text-muted" style="font-size:0.8rem">L</small></div></div>
                <div class="stat-icon" style="background:#ffedd5;color:#ea580c"><i class="bi bi-fuel-pump"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-modern stat-card stat-green h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-label">Status Verifikasi</div>
                    <div class="stat-value"><span class="badge badge-verified" style="font-size: 1.1rem; padding: 0.4em 0.8em; border-radius: 8px;">Verified</span></div>
                </div>
                <div class="stat-icon" style="background:#dcfce7;color:#15803d"><i class="bi bi-patch-check"></i></div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <a href="{{ route('logbook.create') }}" class="quick-action-card">
            <i class="bi bi-pencil-square"></i>
            <h5>Tulis Logbook Baru</h5>
            <p class="mb-0 small opacity-75">Input pemakaian BBM hari ini</p>
        </a>
    </div>
    <div class="col-md-8">
        <div class="card-modern p-4 h-100 d-flex align-items-center">
            <div class="d-flex align-items-center gap-3 w-100">
                <div class="stat-icon bg-pertamina-blue text-white flex-shrink-0" style="width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem;"><i class="bi bi-calendar-event"></i></div>
                <div class="flex-grow-1">
                    <h5 class="fw-bold mb-2" style="font-size: 1.15rem; color: var(--pertamina-blue);">Jadwal Perjalanan Aktif</h5>
                    <p class="mb-0 text-muted" style="font-size: 0.92rem; line-height: 1.4;">
                        <strong class="text-dark" style="font-size: 1.05rem;">Surabaya &rarr; Balikpapan</strong>
                        <span class="mx-2 text-muted">|</span>
                        <span><i class="bi bi-calendar me-1"></i>Jadwal: 14/07/2026 &ndash; 16/07/2026</span>
                        <span class="badge ms-2" style="background:#dbeafe;color:#1d4ed8;font-size:0.75rem;padding:0.35em 0.7em;">Berlangsung</span>
                    </p>
                </div>
                <a href="{{ route('awak.perjalanan') }}" class="btn btn-pertamina-outline btn-sm flex-shrink-0 px-3">Detail</a>
            </div>
        </div>
    </div>
</div>

<div class="card-modern">
    <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
        <div><h6 class="mb-0 fw-bold">Riwayat Logbook Terbaru</h6><small class="text-muted">5 entri terakhir</small></div>
        <a href="{{ route('awak.riwayat') }}" class="btn btn-pertamina-outline btn-sm">Lihat Semua</a>
    </div>
    <div class="table-responsive">
        <table class="table table-modern">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Vessel</th>
                    <th>Rute</th>
                    <th>Konsumsi BBM</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>14/07/2026</td>
                    <td>VSL-001</td>
                    <td>Surabaya → Balikpapan</td>
                    <td>320 L</td>
                    <td><span class="badge badge-verified">Verified</span></td>
                </tr>
                <tr>
                    <td>13/07/2026</td>
                    <td>VSL-001</td>
                    <td>Surabaya (persiapan)</td>
                    <td>45 L</td>
                    <td><span class="badge badge-verified">Verified</span></td>
                </tr>
                <tr>
                    <td>12/07/2026</td>
                    <td>VSL-001</td>
                    <td>Balikpapan → Surabaya</td>
                    <td>310 L</td>
                    <td><span class="badge badge-verified">Verified</span></td>
                </tr>
                <tr>
                    <td>11/07/2026</td>
                    <td>VSL-001</td>
                    <td>Balikpapan (sandar)</td>
                    <td>25 L</td>
                    <td><span class="badge badge-pending">Pending</span></td>
                </tr>
                <tr>
                    <td>10/07/2026</td>
                    <td>VSL-001</td>
                    <td>Surabaya → Balikpapan</td>
                    <td>295 L</td>
                    <td><span class="badge badge-verified">Verified</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Reminder Modal -->
<div class="modal fade" id="logbookReminderModal" tabindex="-1" aria-labelledby="logbookReminderLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; overflow: hidden; border: none; box-shadow: var(--shadow-lg);">
            <div class="modal-header bg-warning text-dark border-0 px-4 py-3">
                <h5 class="modal-title fw-bold d-flex align-items-center gap-2" id="logbookReminderLabel">
                    <i class="bi bi-exclamation-triangle-fill fs-5"></i> Pengingat Logbook Harian
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <div class="mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 70px; height: 70px; border-radius: 50%; background-color: #fffbeb; color: #d97706; font-size: 2.2rem;">
                    <i class="bi bi-journal-x"></i>
                </div>
                <h5 class="fw-bold mb-2">Anda Belum Mengisi Logbook!</h5>
                <p class="text-muted mb-0 small" style="line-height: 1.5;">
                    Sistem mendeteksi bahwa Anda belum menginput data pemakaian BBM & pelumas kapal untuk hari ini (<strong>{{ date('d F Y') }}</strong>). Silakan segera isi untuk menjaga keakuratan sisa kuota kapal.
                </p>
            </div>
            <div class="modal-footer border-0 bg-light d-flex justify-content-center gap-2 p-3">
                <button type="button" class="btn btn-outline-secondary btn-sm px-4 py-2 fw-semibold" style="border-radius: 8px; font-size: 0.85rem;" data-bs-dismiss="modal">Nanti Saja</button>
                <a href="{{ route('logbook.create') }}" class="btn btn-pertamina btn-sm px-4 py-2 fw-semibold" style="border-radius: 8px; font-size: 0.85rem;">
                    <i class="bi bi-pencil-square me-1"></i>Isi Logbook Sekarang
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Check if logbook has been filled in this session
    const filledToday = sessionStorage.getItem('logbook_filled_today');
    
    if (filledToday !== 'true') {
        const reminderModal = new bootstrap.Modal(document.getElementById('logbookReminderModal'));
        setTimeout(() => {
            reminderModal.show();
        }, 800); // Slight delay for premium feel
    }
});
</script>
@endpush
@endsection
