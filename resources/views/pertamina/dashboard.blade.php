@extends('layouts.dashboard')

@section('title', 'Dashboard Pertamina')
@section('navbar') @include('partials.navbar-pertamina') @endsection

@section('content')
<div class="welcome-banner mb-4">
    <h4 id="welcomeGreetingTitle">Selamat Datang, {{ auth()->user()->nama_user }}</h4>
    <p class="mb-0 mt-2 opacity-90" id="welcomeGreetingSubtitle">Tetap semangat dalam memonitor dan mengoptimalkan energi di setiap lini pelayaran nusantara!</p>
</div>

@php
    $months = [
        '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
        '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
        '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
    ];
@endphp

<!-- STAT CARDS -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card-modern stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div><div class="stat-label">Total Kapal</div><div class="stat-value stat-value-animate" data-target="{{ $totalKapal }}">{{ $totalKapal }}</div></div>
                <div class="stat-icon" style="background:var(--pertamina-blue-light);color:var(--pertamina-blue)">
                    <i class="bi bi-ship fs-4"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card-modern stat-card stat-green">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-label">Logbook Bulan Ini</div>
                    <div class="stat-value text-success" style="font-size: 1.6rem;">{{ $logbookBulanIni }} <small class="text-muted fs-6">/ {{ $totalTargetBulanIni }}</small></div>
                </div>
                <div class="stat-icon" style="background:#dcfce7;color:#15803d"><i class="bi bi-journal-check"></i></div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card-modern stat-card stat-yellow">
            <div class="d-flex justify-content-between align-items-center">
                <div><div class="stat-label">Kapal dengan Selisih</div><div class="stat-value stat-value-animate" data-target="{{ $kapalSelisihCount }}">{{ $kapalSelisihCount }}</div></div>
                <div class="stat-icon" style="background:#fef3c7;color:#b45309"><i class="bi bi-exclamation-triangle-fill"></i></div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card-modern stat-card stat-orange">
            <div class="d-flex justify-content-between align-items-center">
                <div><div class="stat-label">Total Konsumsi FO</div><div class="stat-value stat-value-animate" data-target="{{ $totalKonsumsiFO }}">{{ number_format($totalKonsumsiFO, 0, ',', '.') }} <small class="text-muted" style="font-size:0.8rem">L</small></div></div>
                <div class="stat-icon" style="background:#ffedd5;color:#ea580c"><i class="bi bi-fuel-pump"></i></div>
            </div>
        </div>
    </div>
</div>

<!-- CHARTS GRID -->
<div class="row g-3 mb-4">
    <!-- Chart 1: Jumlah Pengisian Logbook Tiap Bulannya -->
    <div class="col-lg-6">
        <div class="card-modern chart-card h-100">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <div>
                    <div class="chart-title"><i class="bi bi-calendar-range me-1 text-pertamina-blue"></i> Pengisian Logbook Tiap Bulan</div>
                    <div class="chart-subtitle mb-0">Jumlah pengisian logbook bulanan (Tahun {{ $c1_year }})</div>
                </div>
                <div>
                    <select class="form-select form-select-sm filter-c1-year border-primary" style="width: 85px; font-size: 0.72rem; border-radius: 6px;">
                        @for ($y = 2024; $y <= (int)date('Y') + 1; $y++)
                            <option value="{{ $y }}" {{ $c1_year == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="chart-container"><canvas id="barChartBBM"></canvas></div>
        </div>
    </div>

    <!-- Chart 2: Tren Harian FO -->
    <div class="col-lg-6">
        <div class="card-modern chart-card h-100">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <div>
                    <div class="chart-title"><i class="bi bi-graph-up me-1 text-pertamina-blue"></i> Tren Konsumsi FO Harian</div>
                    <div class="chart-subtitle mb-0">Total pemakaian harian Fuel Oil (Bulan {{ $months[$c2_month] }} {{ $c2_year }})</div>
                </div>
                <div class="d-flex gap-1">
                    <select class="form-select form-select-sm filter-c2-month border-primary" style="width: 100px; font-size: 0.72rem; border-radius: 6px;">
                        @foreach ($months as $num => $name)
                            <option value="{{ $num }}" {{ $c2_month == $num ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                    <select class="form-select form-select-sm filter-c2-year border-primary" style="width: 85px; font-size: 0.72rem; border-radius: 6px;">
                        @for ($y = 2024; $y <= (int)date('Y') + 1; $y++)
                            <option value="{{ $y }}" {{ $c2_year == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="chart-container"><canvas id="lineChartTrend"></canvas></div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <!-- Chart 3: Pengisian Logbook Bulan Ini -->
    <div class="col-lg-4">
        <div class="card-modern chart-card h-100">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <div>
                    <div class="chart-title"><i class="bi bi-pie-chart me-1 text-pertamina-blue"></i> Pengisian Logbook Bulan Ini</div>
                    <div class="chart-subtitle mb-0">Persentase pengisian logbook (Bulan {{ $months[$c3_month] }} {{ $c3_year }})</div>
                </div>
                <div class="d-flex gap-1">
                    <select class="form-select form-select-sm filter-c3-month border-primary" style="width: 90px; font-size: 0.72rem; border-radius: 6px;">
                        @foreach ($months as $num => $name)
                            <option value="{{ $num }}" {{ $c3_month == $num ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                    <select class="form-select form-select-sm filter-c3-year border-primary" style="width: 80px; font-size: 0.72rem; border-radius: 6px;">
                        @for ($y = 2024; $y <= (int)date('Y') + 1; $y++)
                            <option value="{{ $y }}" {{ $c3_year == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="chart-container"><canvas id="pieChartStatus"></canvas></div>
        </div>
    </div>

    <!-- Chart 4: Perangkingan Perusahaan Paling Rajin -->
    <div class="col-lg-8">
        <div class="card-modern chart-card h-100">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <div>
                    <div class="chart-title"><i class="bi bi-award me-1 text-pertamina-blue"></i> Perangkingan Kepatuhan Perusahaan</div>
                    <div class="chart-subtitle mb-0">Rasio kelengkapan pengisian logbook berdasarkan perusahaan (Bulan {{ $months[$c4_month] }} {{ $c4_year }})</div>
                </div>
                <div class="d-flex gap-1">
                    <select class="form-select form-select-sm filter-c4-month border-primary" style="width: 100px; font-size: 0.72rem; border-radius: 6px;">
                        @foreach ($months as $num => $name)
                            <option value="{{ $num }}" {{ $c4_month == $num ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                    <select class="form-select form-select-sm filter-c4-year border-primary" style="width: 85px; font-size: 0.72rem; border-radius: 6px;">
                        @for ($y = 2024; $y <= (int)date('Y') + 1; $y++)
                            <option value="{{ $y }}" {{ $c4_year == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="chart-container"><canvas id="barChartStok"></canvas></div>
        </div>
    </div>
</div>

<!-- LATEST MONITORING TABLE -->
<div class="card-modern">
    <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
        <div><h6 class="mb-0 fw-bold"><i class="bi bi-calendar-check me-2 text-pertamina-blue"></i>Monitoring Status Logbook Harian</h6><small class="text-muted">Ringkasan status logbook dan selisih kapal (Bulan {{ $months[$c2_month] }} {{ $c2_year }})</small></div>
        <a href="{{ route('pertamina.monitoring') }}" class="btn btn-pertamina-outline btn-sm">Buka Detail Monitoring</a>
    </div>
    <div class="table-responsive">
        <table class="table table-modern align-middle">
            <thead>
                <tr>
                    <th>Nama Perusahaan</th>
                    <th>Nama Kapal</th>
                    <th>FT/IT</th>
                    <th>Status Pengisian</th>
                    <th>Hasil Monitoring (Selisih)</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($ships->take(5) as $ship)
                    <tr>
                        <td><strong>{{ $ship->pt_name }}</strong></td>
                        <td>
                            <span class="fw-semibold text-pertamina-blue">{{ $ship->nama_kapal }}</span>
                            <br><small class="text-muted">{{ $ship->kode_vessel }}</small>
                        </td>
                        <td>{{ $ship->depot_name }}</td>
                        <td>
                            @if ($ship->status_pengisian === 'Selesai')
                                <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Selesai ({{ $ship->logbooks_count }} Hari)</span>
                            @elseif ($ship->status_pengisian === 'Belum Lengkap')
                                <span class="badge bg-warning text-dark"><i class="bi bi-exclamation-circle me-1"></i>Belum Lengkap ({{ $ship->logbooks_count }} / {{ $c2_days }} Hari)</span>
                            @else
                                <span class="badge bg-secondary"><i class="bi bi-x-circle me-1"></i>Belum Mengisi</span>
                            @endif
                        </td>
                        <td>
                            @if ($ship->logbooks_count > 0)
                                @if ($ship->total_discrepancy > 0)
                                    <span class="badge bg-danger text-white"><i class="bi bi-exclamation-triangle-fill me-1"></i>Selisih {{ number_format($ship->total_discrepancy) }} L</span>
                                @else
                                    <span class="badge bg-success text-white"><i class="bi bi-patch-check-fill me-1"></i>Sesuai (0 L)</span>
                                  @endif
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Data kapal tidak ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    const blue = '#0057B8', red = '#E31E24';
    Chart.defaults.font.family = "'Segoe UI', system-ui, sans-serif";

    // Tooltip Config Helper
    const tooltipConfig = (suffix = ' L') => ({
        backgroundColor: 'rgba(15, 23, 42, 0.9)',
        titleFont: { size: 12, weight: 'bold', family: "'Poppins', sans-serif" },
        bodyFont: { size: 11, family: "'Segoe UI', sans-serif" },
        padding: 8,
        cornerRadius: 8,
        callbacks: {
            label: function(context) {
                let label = context.dataset.label || '';
                if (label) label += ': ';
                if (context.parsed.x !== undefined && context.chart.options.indexAxis === 'y') {
                    label += context.parsed.x.toLocaleString('id-ID') + suffix;
                } else if (context.parsed.y !== undefined) {
                    label += context.parsed.y.toLocaleString('id-ID') + suffix;
                } else if (context.parsed !== undefined) {
                    label += context.parsed.toLocaleString('id-ID') + suffix;
                }
                return ' ' + label;
            }
        }
    });

    // Chart 1: Jumlah Pengisian Logbook Tiap Bulan (Horizontal Bar Chart)
    const bbmCanvas = document.getElementById('barChartBBM');
    const bbmCtx = bbmCanvas.getContext('2d');
    const bbmGradient = bbmCtx.createLinearGradient(0, 0, 300, 0);
    bbmGradient.addColorStop(0, '#E31E24');
    bbmGradient.addColorStop(1, '#7a1013');

    new Chart(bbmCanvas, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{ label: 'Logbook Terisi', data: @json($monthlyInputs), backgroundColor: bbmGradient, borderRadius: 4, hoverBackgroundColor: '#7a1013' }]
        },
        options: { 
            responsive: true, 
            maintainAspectRatio: false,
            indexAxis: 'y',
            plugins: { 
                legend: { display: false },
                tooltip: tooltipConfig(' Kali')
            }, 
            scales: { 
                x: { beginAtZero: true, grid: { color: '#f1f5f9' } }, 
                y: { grid: { display: false } } 
            } 
        }
    });

    // Chart 2: Tren Harian FO
    const trendCanvas = document.getElementById('lineChartTrend');
    const trendCtx = trendCanvas.getContext('2d');
    const trendGradient = trendCtx.createLinearGradient(0, 0, 0, 220);
    trendGradient.addColorStop(0, 'rgba(227, 30, 36, 0.4)');
    trendGradient.addColorStop(1, 'rgba(227, 30, 36, 0.0)');

    new Chart(trendCanvas, {
        type: 'line',
        data: {
            labels: @json($trendLabels),
            datasets: [{ label: 'Konsumsi FO', data: @json($trendFO), borderColor: red, backgroundColor: trendGradient, fill: true, tension: 0.4, pointRadius: 3, borderWidth: 2, hoverRadius: 5 }]
        },
        options: { 
            responsive: true, 
            maintainAspectRatio: false, 
            plugins: { 
                legend: { display: false },
                tooltip: tooltipConfig(' L')
            }, 
            scales: { 
                y: { grid: { color: '#f1f5f9' } }, 
                x: { grid: { display: false } } 
            } 
        }
    });

    // Chart 3: Pengisian Logbook Bulan Ini
    new Chart(document.getElementById('pieChartStatus'), {
        type: 'doughnut',
        data: {
            labels: ['Sudah Mengisi', 'Belum Mengisi'],
            datasets: [{ data: @json($statusPercentages), backgroundColor: ['#15803d', '#cbd5e1'], borderWidth: 0, hoverOffset: 6 }]
        },
        options: { 
            responsive: true, 
            maintainAspectRatio: false, 
            cutout: '70%',
            plugins: { 
                legend: { position: 'bottom', labels: { padding: 12, usePointStyle: true, font: { size: 11, weight: '600' } } },
                tooltip: tooltipConfig('%')
            } 
        },
        plugins: [{
            id: 'textCenter',
            beforeDraw: function(chart) {
                var width = chart.width,
                    height = chart.height,
                    ctx = chart.ctx;
                ctx.restore();
                
                // Set font style
                ctx.font = "bold 22px sans-serif";
                ctx.textBaseline = "middle";
                ctx.fillStyle = "#15803d";
                
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

    // Chart 4: Perangkingan Kepatuhan Perusahaan
    const stokCanvas = document.getElementById('barChartStok');
    const stokCtx = stokCanvas.getContext('2d');
    const stokGradient = stokCtx.createLinearGradient(0, 0, 0, 200);
    stokGradient.addColorStop(0, '#0057B8');
    stokGradient.addColorStop(1, '#002651');

    new Chart(stokCanvas, {
        type: 'bar',
        data: {
            labels: @json($rankingLabels),
            datasets: [{ label: 'Kepatuhan Pengisian', data: @json($rankingPercentages), backgroundColor: stokGradient, borderRadius: 6, hoverBackgroundColor: '#002651' }]
        },
        options: { 
            responsive: true, 
            maintainAspectRatio: false, 
            plugins: { 
                legend: { display: false },
                tooltip: tooltipConfig('%')
            }, 
            scales: { 
                y: { beginAtZero: true, max: 100, grid: { color: '#f1f5f9' }, title: { display: true, text: 'Persentase (%)', font: { size: 10 } } }, 
                x: { grid: { display: false }, ticks: { font: { size: 9 } } } 
            } 
        }
    });

    // Reload helper when individual filters change
    function reloadWithFilters() {
        const c1_y = document.querySelector('.filter-c1-year').value;
        const c2_m = document.querySelector('.filter-c2-month').value;
        const c2_y = document.querySelector('.filter-c2-year').value;
        const c3_m = document.querySelector('.filter-c3-month').value;
        const c3_y = document.querySelector('.filter-c3-year').value;
        const c4_m = document.querySelector('.filter-c4-month').value;
        const c4_y = document.querySelector('.filter-c4-year').value;
        
        const params = new URLSearchParams({
            c1_year: c1_y,
            c2_month: c2_m,
            c2_year: c2_y,
            c3_month: c3_m,
            c3_year: c3_y,
            c4_month: c4_m,
            c4_year: c4_y
        });
        window.location.search = params.toString();
    }

    // Attach event listeners to all filter elements
    document.querySelectorAll('.filter-c1-year, .filter-c2-month, .filter-c2-year, .filter-c3-month, .filter-c3-year, .filter-c4-month, .filter-c4-year').forEach(el => {
        el.addEventListener('change', reloadWithFilters);
    });
</script>
@endpush
