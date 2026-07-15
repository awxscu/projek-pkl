@extends('layouts.dashboard')

@section('title', 'Dashboard Pertamina')
@section('navbar') @include('partials.navbar-pertamina') @endsection

@section('content')
<div class="welcome-banner">
    <h4 id="welcomeGreetingTitle">Selamat Datang, Pertamina Patra Niaga</h4>
    <p class="mb-0 mt-2 opacity-90" id="welcomeGreetingSubtitle">Tetap semangat dalam memonitor dan mengoptimalkan energi di setiap lini pelayaran nusantara!</p>
</div>

<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card-modern stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div><div class="stat-label">Total Kapal</div><div class="stat-value stat-value-animate" data-target="18">0</div></div>
                <div class="stat-icon" style="background:var(--pertamina-blue-light);color:var(--pertamina-blue)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-ship" viewBox="0 0 16 16">
                        <path d="M11.782.002a.5.5 0 0 1 .37.171l2.5 3a.5.5 0 0 1-.37.827h-.132l-.248 1.488a.5.5 0 0 1-.036.115l-1.6 3A.5.5 0 0 1 11 9H5a.5.5 0 0 1-.4-.8l-1.6-3a.5.5 0 0 1-.036-.115l-.248-1.488h-.132a.5.5 0 0 1-.37-.827l2.5-3a.5.5 0 0 1 .37-.171h6.982zM2.085 4.708l.228 1.368H3.5a.5.5 0 0 1 .424.237L5.39 8.784A.5.5 0 0 1 5 9.5H3a.5.5 0 0 1-.4-.8l-1.2-2.25a.5.5 0 0 1-.036-.115L1.085 4.708H2.085zm11.83 0h1.002l-.279 1.674a.5.5 0 0 1-.036.115l-1.2 2.25a.5.5 0 0 1-.4.8H11a.5.5 0 0 1-.39-.716l1.465-2.547A.5.5 0 0 1 12.5 6.076h1.187l.228-1.368zM12 10a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm-5 0a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM8 12a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm6 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card-modern stat-card stat-green">
            <div class="d-flex justify-content-between align-items-center">
                <div><div class="stat-label">Logbook Hari Ini</div><div class="stat-value stat-value-animate" data-target="14">0</div></div>
                <div class="stat-icon" style="background:#dcfce7;color:#15803d"><i class="bi bi-journal-check"></i></div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card-modern stat-card stat-yellow">
            <div class="d-flex justify-content-between align-items-center">
                <div><div class="stat-label">Belum Verifikasi</div><div class="stat-value stat-value-animate" data-target="5">0</div></div>
                <div class="stat-icon" style="background:#fef3c7;color:#b45309"><i class="bi bi-hourglass-split"></i></div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card-modern stat-card stat-orange">
            <div class="d-flex justify-content-between align-items-center">
                <div><div class="stat-label">Total Konsumsi BBM</div><div class="stat-value stat-value-animate" data-target="4.280">0 <small class="text-muted" style="font-size:0.8rem">L</small></div></div>
                <div class="stat-icon" style="background:#ffedd5;color:#ea580c"><i class="bi bi-fuel-pump"></i></div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-lg-6">
        <div class="card-modern chart-card h-100">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <div>
                    <div class="chart-title"><i class="bi bi-bar-chart-line me-1 text-pertamina-blue"></i> Pemakaian BBM Berdasarkan Kapal</div>
                    <div class="chart-subtitle mb-0" id="bbmChartSubtitle">Konsumsi Diesel Oil (liter)</div>
                </div>
                <div class="d-flex gap-1 flex-wrap">
                    <select class="form-select form-select-sm filter-bbm-fuel border-primary" style="width: 120px; font-size: 0.72rem; border-radius: 6px;">
                        <option value="do" selected>Diesel Oil (DO)</option>
                        <option value="fo">Fuel Oil (FO)</option>
                        <option value="lube">Lube Oil</option>
                        <option value="cylinder">Cylinder Oil</option>
                    </select>
                    <select class="form-select form-select-sm filter-bbm-date" style="width: 75px; font-size: 0.72rem; border-radius: 6px; border-color: var(--pertamina-blue);">
                        <option value="all" selected>All</option>
                        @for ($d = 1; $d <= 31; $d++)
                            <option value="{{ $d }}">{{ $d }}</option>
                        @endfor
                    </select>
                    <select class="form-select form-select-sm filter-bbm-month" style="width: 110px; font-size: 0.72rem; border-radius: 6px; border-color: var(--pertamina-blue);">
                        <option value="all">Semua Bulan</option>
                        <option value="01">Januari</option>
                        <option value="02">Februari</option>
                        <option value="03">Maret</option>
                        <option value="04">April</option>
                        <option value="05">Mei</option>
                        <option value="06">Juni</option>
                        <option value="07" selected>Juli</option>
                        <option value="08">Agustus</option>
                        <option value="09">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                    </select>
                    <select class="form-select form-select-sm filter-bbm-year" style="width: 75px; font-size: 0.72rem; border-radius: 6px; border-color: var(--pertamina-blue);">
                        <option value="all">Semua Tahun</option>
                        <option value="2026" selected>2026</option>
                        <option value="2025">2025</option>
                    </select>
                </div>
            </div>
            <div class="chart-container"><canvas id="barChartBBM"></canvas></div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card-modern chart-card h-100">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <div>
                    <div class="chart-title"><i class="bi bi-graph-up me-1 text-pertamina-blue"></i> Tren Konsumsi BBM Harian</div>
                    <div class="chart-subtitle mb-0">Total pemakaian harian (liter)</div>
                </div>
                <div class="d-flex gap-1">
                    <select class="form-select form-select-sm filter-trend-date" style="width: 75px; font-size: 0.72rem; border-radius: 6px; border-color: var(--pertamina-blue);">
                        <option value="all" selected>All</option>
                        @for ($d = 1; $d <= 31; $d++)
                            <option value="{{ $d }}">{{ $d }}</option>
                        @endfor
                    </select>
                    <select class="form-select form-select-sm filter-trend-month" style="width: 110px; font-size: 0.72rem; border-radius: 6px; border-color: var(--pertamina-blue);">
                        <option value="all">Semua Bulan</option>
                        <option value="01">Januari</option>
                        <option value="02">Februari</option>
                        <option value="03">Maret</option>
                        <option value="04">April</option>
                        <option value="05">Mei</option>
                        <option value="06">Juni</option>
                        <option value="07" selected>Juli</option>
                        <option value="08">Agustus</option>
                        <option value="09">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                    </select>
                    <select class="form-select form-select-sm filter-trend-year" style="width: 75px; font-size: 0.72rem; border-radius: 6px; border-color: var(--pertamina-blue);">
                        <option value="all">Semua Tahun</option>
                        <option value="2026" selected>2026</option>
                        <option value="2025">2025</option>
                    </select>
                </div>
            </div>
            <div class="chart-container"><canvas id="lineChartTrend"></canvas></div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-lg-4">
        <div class="card-modern chart-card h-100">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <div>
                    <div class="chart-title"><i class="bi bi-pie-chart me-1 text-pertamina-blue"></i> Status Pengisian Logbook</div>
                    <div class="chart-subtitle mb-0">Persentase verifikasi harian</div>
                </div>
                <div class="d-flex gap-1">
                    <select class="form-select form-select-sm filter-status-date" style="width: 70px; font-size: 0.7rem; padding: 0.25rem; border-radius: 6px; border-color: var(--pertamina-blue);">
                        <option value="all" selected>All</option>
                        @for ($d = 1; $d <= 31; $d++)
                            <option value="{{ $d }}">{{ $d }}</option>
                        @endfor
                    </select>
                    <select class="form-select form-select-sm filter-status-month" style="width: 110px; font-size: 0.7rem; padding: 0.25rem; border-radius: 6px; border-color: var(--pertamina-blue);">
                        <option value="all">Semua Bulan</option>
                        <option value="01">Januari</option>
                        <option value="02">Februari</option>
                        <option value="03">Maret</option>
                        <option value="04">April</option>
                        <option value="05">Mei</option>
                        <option value="06">Juni</option>
                        <option value="07" selected>Juli</option>
                        <option value="08">Agustus</option>
                        <option value="09">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                    </select>
                    <select class="form-select form-select-sm filter-status-year" style="width: 70px; font-size: 0.7rem; padding: 0.25rem; border-radius: 6px; border-color: var(--pertamina-blue);">
                        <option value="all">Semua Thn</option>
                        <option value="2026" selected>2026</option>
                        <option value="2025">2025</option>
                    </select>
                </div>
            </div>
            <div class="chart-container"><canvas id="pieChartStatus"></canvas></div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card-modern chart-card h-100">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <div>
                    <div class="chart-title"><i class="bi bi-droplet me-1 text-pertamina-blue"></i> Stok BBM Kapal</div>
                    <div class="chart-subtitle mb-0" id="stokChartSubtitle">Sisa stok Diesel Oil (liter)</div>
                </div>
                <div style="width: 180px;">
                    <select class="form-select form-select-sm border-primary" id="fuelTypeFilter" style="border-radius: 8px;">
                        <option value="do">Diesel Oil (DO)</option>
                        <option value="fo">Fuel Oil (FO)</option>
                        <option value="lube">Lube Oil</option>
                        <option value="cylinder">Cylinder Oil</option>
                    </select>
                </div>
            </div>
            <div class="chart-container"><canvas id="barChartStok"></canvas></div>
        </div>
    </div>
</div>

<div class="card-modern">
    <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
        <div><h6 class="mb-0 fw-bold">Monitoring Kapal</h6><small class="text-muted">Status logbook hari ini</small></div>
        <a href="{{ route('pertamina.monitoring') }}" class="btn btn-pertamina-outline btn-sm">Lihat Semua</a>
    </div>
    <div class="table-responsive">
        <table class="table table-modern">
            <thead>
                <tr>
                    <th>Nama Kapal</th>
                    <th>Vessel Code</th>
                    <th>Tanggal</th>
                    <th>Tujuan</th>
                    <th>Total Pemakaian</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><i class="bi bi-ship me-1 text-pertamina-blue"></i> KM Nusantara Jaya</td>
                    <td>VSL-001</td>
                    <td>14/07/2026</td>
                    <td>Surabaya → Balikpapan</td>
                    <td>320 L</td>
                    <td><span class="badge badge-verified">Verified</span></td>
                </tr>
                <tr>
                    <td><i class="bi bi-ship me-1 text-pertamina-blue"></i> KM Samudra Indah</td>
                    <td>VSL-002</td>
                    <td>14/07/2026</td>
                    <td>Jakarta → Semarang</td>
                    <td>285 L</td>
                    <td><span class="badge badge-verified">Verified</span></td>
                </tr>
                <tr>
                    <td><i class="bi bi-ship me-1 text-pertamina-blue"></i> KM Pelangi Nusantara</td>
                    <td>VSL-003</td>
                    <td>14/07/2026</td>
                    <td>Makassar → Baubau</td>
                    <td>—</td>
                    <td><span class="badge badge-empty">Belum Mengisi</span></td>
                </tr>
                <tr>
                    <td><i class="bi bi-ship me-1 text-pertamina-blue"></i> KM Bahari Sejahtera</td>
                    <td>VSL-004</td>
                    <td>14/07/2026</td>
                    <td>Denpasar → Lombok</td>
                    <td>198 L</td>
                    <td><span class="badge badge-pending">Pending</span></td>
                </tr>
                <tr>
                    <td><i class="bi bi-ship me-1 text-pertamina-blue"></i> KM Citra Lautan</td>
                    <td>VSL-005</td>
                    <td>14/07/2026</td>
                    <td>Pontianak → Ketapang</td>
                    <td>410 L</td>
                    <td><span class="badge badge-verified">Verified</span></td>
                </tr>
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

    // Chart Tooltip Styling Helper
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
                if (context.parsed.y !== undefined) {
                    label += context.parsed.y.toLocaleString('id-ID') + suffix;
                } else if (context.parsed !== undefined) {
                    label += context.parsed.toLocaleString('id-ID') + suffix;
                }
                return ' ' + label;
            }
        }
    });

    // Progressive Draw Animation Config
    const progressiveAnimation = {
        delay: (context) => {
            let delay = 0;
            if (context.type === 'data' && context.mode === 'default') {
                delay = context.dataIndex * 120;
            }
            return delay;
        },
        duration: 1200,
        easing: 'easeOutQuart'
    };

    // Chart 1: Pemakaian BBM Berdasarkan Kapal
    const bbmCanvas = document.getElementById('barChartBBM');
    const bbmCtx = bbmCanvas.getContext('2d');
    const bbmGradient = bbmCtx.createLinearGradient(0, 0, 0, 200);
    bbmGradient.addColorStop(0, '#0057B8');
    bbmGradient.addColorStop(1, '#002651');

    const bbmChart = new Chart(bbmCanvas, {
        type: 'bar',
        data: {
            labels: ['VSL-001','VSL-002','VSL-004','VSL-005','VSL-006','VSL-007'],
            datasets: [{ label: 'Konsumsi', data: [320,285,198,410,175,230], backgroundColor: bbmGradient, borderRadius: 6, hoverBackgroundColor: '#002651' }]
        },
        options: { 
            responsive: true, 
            maintainAspectRatio: false, 
            animation: progressiveAnimation,
            plugins: { 
                legend: { display: false },
                tooltip: tooltipConfig(' L')
            }, 
            scales: { 
                y: { beginAtZero: true, grid: { color: '#f1f5f9' } }, 
                x: { grid: { display: false } } 
            } 
        }
    });

    // Interactive Fuel Datasets for BBM Consumption Chart
    const bbmFuelData = {
        do: {
            subtitle: 'Konsumsi Diesel Oil (liter)',
            data: [320, 285, 198, 410, 175, 230],
            gradientStart: '#0057B8',
            gradientEnd: '#002651'
        },
        fo: {
            subtitle: 'Konsumsi Fuel Oil (liter)',
            data: [210, 245, 180, 310, 150, 195],
            gradientStart: '#E31E24',
            gradientEnd: '#7a1013'
        },
        lube: {
            subtitle: 'Konsumsi Lube Oil (liter)',
            data: [45, 38, 29, 52, 22, 35],
            gradientStart: '#64748b',
            gradientEnd: '#334155'
        },
        cylinder: {
            subtitle: 'Konsumsi Cylinder Oil (liter)',
            data: [35, 42, 28, 48, 19, 30],
            gradientStart: '#eab308',
            gradientEnd: '#a17a06'
        }
    };

    // Chart 1 Event Listeners
    const bbmFuelSelect = document.querySelector('.filter-bbm-fuel');
    const bbmDateSelect = document.querySelector('.filter-bbm-date');
    const bbmMonthSelect = document.querySelector('.filter-bbm-month');
    const bbmYearSelect = document.querySelector('.filter-bbm-year');

    function handleBBMFilter() {
        const f = bbmFuelSelect.value;
        const d = bbmDateSelect.value;
        const m = bbmMonthSelect.value;
        const y = bbmYearSelect.value;
        
        const fuelInfo = bbmFuelData[f];
        
        // Update subtitle text
        document.getElementById('bbmChartSubtitle').textContent = fuelInfo.subtitle;
        
        // Update gradient background
        const newGradient = bbmCtx.createLinearGradient(0, 0, 0, 200);
        newGradient.addColorStop(0, fuelInfo.gradientStart);
        newGradient.addColorStop(1, fuelInfo.gradientEnd);
        bbmChart.data.datasets[0].backgroundColor = newGradient;
        
        let data = [...fuelInfo.data];
        
        if (d !== 'all') {
            const val = parseInt(d);
            data = data.map(item => Math.round(item * (0.45 + (val % 10) * 0.15)));
        } else if (y === '2025') {
            data = data.map(item => Math.round(item * 0.6));
        } else if (m === '06') {
            data = data.map(item => Math.round(item * 0.95));
        } else if (m === '05') {
            data = data.map(item => Math.round(item * 1.1));
        } else if (m === 'all' || y === 'all') {
            data = data.map(item => Math.round(item * 4.2));
        }
        
        bbmChart.data.datasets[0].data = data;
        bbmChart.update();
    }

    bbmFuelSelect.addEventListener('change', handleBBMFilter);
    bbmDateSelect.addEventListener('change', handleBBMFilter);
    bbmMonthSelect.addEventListener('change', handleBBMFilter);
    bbmYearSelect.addEventListener('change', handleBBMFilter);

    // Chart 2: Tren Konsumsi BBM Harian (with Gradient Fade)
    const trendCanvas = document.getElementById('lineChartTrend');
    const trendCtx = trendCanvas.getContext('2d');
    const trendGradient = trendCtx.createLinearGradient(0, 0, 0, 220);
    trendGradient.addColorStop(0, 'rgba(0, 87, 184, 0.4)');
    trendGradient.addColorStop(1, 'rgba(0, 87, 184, 0.0)');

    const trendChart = new Chart(trendCanvas, {
        type: 'line',
        data: {
            labels: ['8 Jul','9 Jul','10 Jul','11 Jul','12 Jul','13 Jul','14 Jul'],
            datasets: [{ label: 'Tren', data: [3800,3950,4100,3850,4200,4050,4280], borderColor: blue, backgroundColor: trendGradient, fill: true, tension: 0.4, pointRadius: 4, borderWidth: 3, hoverRadius: 6 }]
        },
        options: { 
            responsive: true, 
            maintainAspectRatio: false, 
            animation: {
                duration: 1500,
                easing: 'easeOutQuart'
            },
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

    // Chart 2 Event Listeners
    const trendDateSelect = document.querySelector('.filter-trend-date');
    const trendMonthSelect = document.querySelector('.filter-trend-month');
    const trendYearSelect = document.querySelector('.filter-trend-year');
    function handleTrendFilter() {
        const d = trendDateSelect.value;
        const m = trendMonthSelect.value;
        const y = trendYearSelect.value;
        let data = [3800, 3950, 4100, 3850, 4200, 4050, 4280];
        
        if (d !== 'all') {
            const val = parseInt(d);
            data = [
                3000 + (val * 15) % 1200,
                2900 + (val * 25) % 1300,
                3200 + (val * 35) % 1100,
                3100 + (val * 45) % 1400,
                3300 + (val * 55) % 1000,
                3050 + (val * 65) % 1250,
                3400 + (val * 75) % 900
            ];
        } else if (y === '2025') {
            data = [2800, 2950, 3100, 2850, 3200, 3050, 3280];
        } else if (m === '06') {
            data = [3500, 3600, 3750, 3400, 3800, 3650, 3900];
        } else if (m === '05') {
            data = [3900, 4100, 4000, 4200, 4300, 4150, 4400];
        } else if (m === 'all' || y === 'all') {
            data = [12800, 12950, 13100, 12850, 13200, 13050, 13280];
        }
        trendChart.data.datasets[0].data = data;
        trendChart.update();
    }
    trendDateSelect.addEventListener('change', handleTrendFilter);
    trendMonthSelect.addEventListener('change', handleTrendFilter);
    trendYearSelect.addEventListener('change', handleTrendFilter);

    // Chart 3: Status Pengisian Logbook (Doughnut Chart in Percentages)
    const statusChart = new Chart(document.getElementById('pieChartStatus'), {
        type: 'doughnut',
        data: {
            labels: ['Verified','Pending','Belum Mengisi'],
            datasets: [{ data: [50, 28, 22], backgroundColor: ['#0057B8','#93c5fd',red], borderWidth: 0, hoverOffset: 8 }]
        },
        options: { 
            responsive: true, 
            maintainAspectRatio: false, 
            cutout: '70%',
            animation: {
                duration: 2000,
                animateRotate: true,
                animateScale: true,
                easing: 'easeOutQuart'
            },
            plugins: { 
                legend: { position: 'bottom', labels: { padding: 12, usePointStyle: true, font: { size: 11, weight: '600' } } },
                tooltip: tooltipConfig('%')
            } 
        }
    });

    // Chart 3 Event Listeners
    const statusDateSelect = document.querySelector('.filter-status-date');
    const statusMonthSelect = document.querySelector('.filter-status-month');
    const statusYearSelect = document.querySelector('.filter-status-year');
    function handleStatusFilter() {
        const d = statusDateSelect.value;
        const m = statusMonthSelect.value;
        const y = statusYearSelect.value;
        let data = [50, 28, 22];
        
        if (d !== 'all') {
            const val = parseInt(d);
            const v = (45 + (val * 3)) % 40 + 35;
            const p = (20 + (val * 2)) % 25 + 5;
            const b = 100 - (v + p);
            data = [v, p, b];
        } else if (y === '2025') {
            data = [70, 18, 12];
        } else if (m === '06') {
            data = [60, 25, 15];
        } else if (m === '05') {
            data = [55, 30, 15];
        } else if (m === 'all' || y === 'all') {
            data = [65, 20, 15];
        }
        statusChart.data.datasets[0].data = data;
        statusChart.update();
    }
    statusDateSelect.addEventListener('change', handleStatusFilter);
    statusMonthSelect.addEventListener('change', handleStatusFilter);
    statusYearSelect.addEventListener('change', handleStatusFilter);

    // Chart 4: Stok BBM Kapal (Interactive Filterable)
    const stokChart = new Chart(document.getElementById('barChartStok'), {
        type: 'bar',
        data: {
            labels: ['VSL-001','VSL-002','VSL-003','VSL-004','VSL-005','VSL-006'],
            datasets: [{ 
                label: 'Stok DO (L)', 
                data: [1250,980,1450,720,1100,890], 
                backgroundColor: ['#0057B8','#0057B8','#0057B8','#E31E24','#0057B8','#0057B8'], 
                borderRadius: 6,
                hoverBackgroundColor: ['#002651','#002651','#002651','#c4191f','#002651','#002651']
            }]
        },
        options: { 
            responsive: true, 
            maintainAspectRatio: false, 
            animation: progressiveAnimation,
            plugins: { 
                legend: { display: false },
                tooltip: tooltipConfig(' L')
            }, 
            scales: { 
                y: { beginAtZero: true, grid: { color: '#f1f5f9' } }, 
                x: { grid: { display: false } } 
            } 
        }
    });

    // Interactive Fuel Stock Filter Dataset (including Cylinder Oil)
    const fuelStockData = {
        do: {
            subtitle: 'Sisa stok Diesel Oil (liter)',
            label: 'Stok DO (L)',
            data: [1250, 980, 1450, 720, 1100, 890],
            colors: ['#0057B8','#0057B8','#0057B8','#E31E24','#0057B8','#0057B8'],
            hoverColors: ['#002651','#002651','#002651','#c4191f','#002651','#002651']
        },
        fo: {
            subtitle: 'Sisa stok Fuel Oil (liter)',
            label: 'Stok FO (L)',
            data: [850, 710, 990, 1100, 520, 900],
            colors: ['#0057B8','#0057B8','#0057B8','#0057B8','#E31E24','#0057B8'],
            hoverColors: ['#002651','#002651','#002651','#002651','#c4191f','#002651']
        },
        lube: {
            subtitle: 'Sisa stok Lube Oil (liter)',
            label: 'Stok Lube (L)',
            data: [120, 95, 140, 70, 110, 50],
            colors: ['#0057B8','#0057B8','#0057B8','#E31E24','#0057B8','#E31E24'],
            hoverColors: ['#002651','#002651','#002651','#c4191f','#002651','#c4191f']
        },
        cylinder: {
            subtitle: 'Sisa stok Cylinder Oil (liter)',
            label: 'Stok Cylinder (L)',
            data: [150, 142, 160, 130, 90, 75],
            colors: ['#0057B8','#0057B8','#0057B8','#0057B8','#E31E24','#E31E24'],
            hoverColors: ['#002651','#002651','#002651','#002651','#c4191f','#c4191f']
        }
    };

    document.getElementById('fuelTypeFilter').addEventListener('change', function() {
        const type = this.value;
        const info = fuelStockData[type];
        
        // Update subtitle text
        document.getElementById('stokChartSubtitle').textContent = info.subtitle;
        
        // Update chart dataset
        stokChart.data.datasets[0].label = info.label;
        stokChart.data.datasets[0].data = info.data;
        stokChart.data.datasets[0].backgroundColor = info.colors;
        stokChart.data.datasets[0].hoverBackgroundColor = info.hoverColors;
        stokChart.update();
    });
</script>
@endpush
