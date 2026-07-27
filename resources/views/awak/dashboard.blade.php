@extends('layouts.dashboard')

@section('title', 'Dashboard Awak Kapal')
@section('navbar') @include('partials.navbar-awak') @endsection

@section('content')
<div class="welcome-banner mb-4">
    <h4 class="mb-0" id="welcomeGreetingTitle">Selamat Datang, {{ $user->nama_user }}</h4>
    <p class="mb-0 mt-2 opacity-90" id="welcomeGreetingSubtitle">Semoga pelayaran kapal <strong>{{ $vessel->nama_kapal }}</strong> hari ini berjalan aman, lancar, dan selalu mengutamakan keselamatan kerja!</p>
</div>

<div class="row g-4 mb-4">
    <!-- LEFT SIDE: STAT CARDS & QUICK ACTION -->
    <div class="col-lg-8">
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <div class="card-modern stat-card h-100">
                    <div class="d-flex justify-content-between align-items-center">
                        <div><div class="stat-label">Logbook Terisi Sampai {{ $todayFormatted }}</div><div class="stat-value stat-value-animate" data-target="{{ $logbookYearCount }}">{{ $logbookYearCount }} <small class="text-muted" style="font-size:0.8rem">/ {{ $totalDaysSinceJan1 }}</small></div></div>
                        <div class="stat-icon bg-pertamina-blue text-white"><i class="bi bi-journal-text"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card-modern stat-card stat-orange h-100">
                    <div class="d-flex justify-content-between align-items-center">
                        <div><div class="stat-label">Total Pemakaian BBM</div><div class="stat-value stat-value-animate" data-target="{{ $totalBBM }}">{{ $totalBBM }} <small class="text-muted" style="font-size:0.8rem">L</small></div></div>
                        <div class="stat-icon" style="background:#ffedd5;color:#ea580c"><i class="bi bi-fuel-pump"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-12">
                <a href="{{ route('logbook.create') }}" class="quick-action-card d-flex align-items-center justify-content-between p-4 text-decoration-none">
                    <div class="d-flex align-items-center gap-3">
                        <i class="bi bi-pencil-square fs-3 text-white"></i>
                        <div class="text-start">
                            <h5 class="mb-1 fw-bold text-white">Tulis Logbook Baru</h5>
                            <p class="mb-0 text-white opacity-80 small">Input pemakaian BBM hari ini</p>
                        </div>
                    </div>
                    <i class="bi bi-chevron-right text-white opacity-85"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- RIGHT SIDE: DONUT CHART -->
    <div class="col-lg-4">
        <div class="card-modern chart-card h-100 p-3 d-flex flex-column justify-content-center text-center">
            <div class="mb-2">
                <div class="chart-title fw-bold" style="font-size: 0.9rem;"><i class="bi bi-pie-chart-fill me-1 text-pertamina-blue"></i> Persentase Kepatuhan</div>
                <div class="chart-subtitle text-muted mb-0" style="font-size: 0.72rem; line-height: 1.2;">Rasio keterisian logbook </div>
            </div>
            <div class="chart-container position-relative" style="width: 100%; height: 130px; margin: 0 auto;">
                <canvas id="crewDonutChart"></canvas>
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
                    <th>Nama Kapal</th>
                    <th>Konsumsi Fuel Oil (FO)</th>
                    <th>Jumlah Sekarang (FO)</th>
                    <th>Catatan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($latestLogbooks as $log)
                    @php
                        $fo = $log->detailPemakaians->where('id_jenis', 2)->first() ?? new \App\Models\DetailPemakaian();
                        $fo_cons = $fo->motor_induk + $fo->motor_bantu + $fo->lain_lain;
                    @endphp
                    <tr>
                        <td>{{ $log->tanggal_pencataan->format('d/m/Y') }}</td>
                        <td><strong>{{ $log->kapal->nama_kapal ?? $log->kode_vessel }}</strong></td>
                        <td>
                            <span class="badge bg-danger">FO: {{ $fo_cons }} L</span>
                        </td>
                        <td>
                            <strong>{{ $fo->jumlah_sekarang ?: 0 }} L</strong>
                        </td>
                        <td>{{ $log->catatan ?: '—' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Belum ada riwayat logbook.</td>
                    </tr>
                @endforelse
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
                    Sistem mendeteksi bahwa Anda belum mengisi logbook <strong>{{ $missingRangeText }}</strong>. Silakan segera isi untuk menjaga keakuratan data logbook Anda.
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
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const isFilledDb = {{ $logbookTodayCount }};
    const filledToday = sessionStorage.getItem('logbook_filled_today');
    
    if (isFilledDb === 0 && filledToday !== 'true') {
        const reminderModal = new bootstrap.Modal(document.getElementById('logbookReminderModal'));
        setTimeout(() => {
            reminderModal.show();
        }, 800); // Slight delay for premium feel
    }

    // Crew Donut Chart
    const crewStatusData = @json($crewStatusPercentages);
    new Chart(document.getElementById('crewDonutChart'), {
        type: 'doughnut',
        data: {
            labels: ['Sudah Mengisi', 'Belum Mengisi'],
            datasets: [{ 
                data: crewStatusData, 
                backgroundColor: ['#0057B8', '#cbd5e1'], 
                borderWidth: 0, 
                hoverOffset: 6 
            }]
        },
        options: { 
            responsive: true, 
            maintainAspectRatio: false, 
            cutout: '70%',
            plugins: { 
                legend: { position: 'bottom', labels: { boxWidth: 10, padding: 8, font: { size: 10, weight: '600' } } },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return ' ' + context.label + ': ' + context.raw + '%';
                        }
                    }
                }
            } 
        },
        plugins: [{
            id: 'textCenter',
            beforeDraw: function(chart) {
                var width = chart.width,
                    height = chart.height,
                    ctx = chart.ctx;
                ctx.restore();
                
                ctx.font = "bold 20px sans-serif";
                ctx.textBaseline = "middle";
                ctx.fillStyle = "#0057B8";
                
                var text = chart.data.datasets[0].data[0] + "%";
                var chartArea = chart.chartArea;
                if (chartArea) {
                    var textX = Math.round((chartArea.left + chartArea.right - ctx.measureText(text).width) / 2);
                    var textY = Math.round((chartArea.top + chartArea.bottom) / 2);
                    ctx.fillText(text, textX, textY);
                }
                ctx.save();
            }
        }]
    });
});
</script>
@endpush
@endsection
