@extends('layouts.dashboard')

@section('title', 'Laporan')
@section('navbar') @include('partials.navbar-pertamina') @endsection

@section('content')
<div class="page-header">
    <h4><i class="bi bi-file-earmark-bar-graph me-2 text-pertamina-blue"></i>Laporan Konsumsi BBM</h4>
    <p>Generate dan export laporan operasional kapal</p>
</div>

<div class="card-modern filter-card">
    <form class="row g-3 align-items-end">
        <div class="col-md-3">
            <label class="form-label">Tanggal Mulai</label>
            <input type="date" class="form-control" value="2026-07-01">
        </div>
        <div class="col-md-3">
            <label class="form-label">Tanggal Akhir</label>
            <input type="date" class="form-control" value="2026-07-14">
        </div>
        <div class="col-md-4">
            <label class="form-label">Kapal</label>
            <select class="form-select">
                <option value="">Semua Kapal</option>
                <option>KM Nusantara Jaya</option>
                <option>KM Samudra Indah</option>
                <option>KM Pelangi Nusantara</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-pertamina w-100"><i class="bi bi-search me-1"></i>Filter</button>
        </div>
    </form>
</div>

<div class="row g-3 mb-4 align-items-stretch">
    <div class="col-md-4">
        <div class="card-modern stat-card h-100">
            <div class="stat-label">Total Konsumsi BBM</div>
            <div class="stat-value stat-value-animate" data-target="58.420">0 <small class="text-muted" style="font-size:0.8rem">L</small></div>
            <small class="text-muted">Periode 1–14 Juli 2026</small>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-modern stat-card stat-red h-100">
            <div class="stat-label">Kapal Paling Banyak Konsumsi</div>
            <div class="stat-value" style="font-size:1.25rem; font-weight: 800; line-height: 1.2; margin: 0.5rem 0;">KM Citra Lautan</div>
            <small class="text-muted"><span class="stat-value-animate" data-target="5.740">0</span> L total</small>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-modern stat-card stat-green h-100">
            <div class="stat-label">Rata-rata Konsumsi</div>
            <div class="stat-value stat-value-animate" data-target="3.246">0 <small class="text-muted" style="font-size:0.8rem">L/kapal</small></div>
            <small class="text-muted">18 kapal aktif</small>
        </div>
    </div>
</div>

<div class="card-modern chart-card mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <div>
            <div class="chart-title">Grafik Konsumsi BBM per Kapal</div>
            <div class="chart-subtitle mb-0" id="laporanChartSubtitle">Periode Juli 2026</div>
        </div>
        <div class="d-flex gap-1 flex-wrap">
            <select class="form-select form-select-sm filter-laporan-month border-primary" style="width: 110px; font-size: 0.72rem; border-radius: 6px;">
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
            <select class="form-select form-select-sm filter-laporan-year border-primary" style="width: 85px; font-size: 0.72rem; border-radius: 6px;">
                <option value="all">Semua Tahun</option>
                <option value="2026" selected>2026</option>
                <option value="2025">2025</option>
            </select>
        </div>
    </div>
    <div class="chart-container"><canvas id="laporanChart"></canvas></div>
</div>

<div class="d-flex gap-2 mb-4 flex-wrap">
    <button class="btn btn-pertamina-red"><i class="bi bi-file-earmark-pdf me-2"></i>Export PDF</button>
    <button class="btn btn-pertamina"><i class="bi bi-file-earmark-excel me-2"></i>Export Excel</button>
</div>

<div class="card-modern">
    <div class="table-responsive">
        <table class="table table-modern">
            <thead>
                <tr>
                    <th>Kapal</th>
                    <th>Vessel Code</th>
                    <th>Total Konsumsi DO</th>
                    <th>Total Konsumsi FO</th>
                    <th>Total Lube Oil</th>
                    <th>Total Cylinder Oil</th>
                    <th>Grand Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>KM Nusantara Jaya</td>
                    <td>VSL-001</td>
                    <td>4.200 L</td>
                    <td>800 L</td>
                    <td>120 L</td>
                    <td>150 L</td>
                    <td><strong>5.270 L</strong></td>
                </tr>
                <tr>
                    <td>KM Samudra Indah</td>
                    <td>VSL-002</td>
                    <td>3.850 L</td>
                    <td>650 L</td>
                    <td>95 L</td>
                    <td>142 L</td>
                    <td><strong>4.737 L</strong></td>
                </tr>
                <tr>
                    <td>KM Citra Lautan</td>
                    <td>VSL-005</td>
                    <td>5.100 L</td>
                    <td>520 L</td>
                    <td>120 L</td>
                    <td>90 L</td>
                    <td><strong>5.830 L</strong></td>
                </tr>
                <tr>
                    <td>KM Bahari Sejahtera</td>
                    <td>VSL-004</td>
                    <td>2.980 L</td>
                    <td>400 L</td>
                    <td>80 L</td>
                    <td>130 L</td>
                    <td><strong>3.590 L</strong></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    const tooltipConfig = {
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
                    label += context.parsed.y.toLocaleString('id-ID') + ' L';
                }
                return ' ' + label;
            }
        }
    };

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

    const laporanChart = new Chart(document.getElementById('laporanChart'), {
        type: 'bar',
        data: {
            labels: ['VSL-001','VSL-002','VSL-003','VSL-004','VSL-005','VSL-006'],
            datasets: [
                { label: 'Diesel Oil (DO)', data: [4200,3850,3100,2980,5100,2800], backgroundColor: '#0057B8', borderRadius: 4 },
                { label: 'Fuel Oil (FO)', data: [800,650,500,400,520,350], backgroundColor: '#E31E24', borderRadius: 4 },
                { label: 'Lube Oil', data: [120,95,70,80,120,60], backgroundColor: '#64748b', borderRadius: 4 },
                { label: 'Cylinder Oil', data: [150,142,160,130,90,75], backgroundColor: '#eab308', borderRadius: 4 }
            ]
        },
        options: { 
            responsive: true, 
            maintainAspectRatio: false, 
            animation: progressiveAnimation,
            scales: { 
                x: { stacked: true, grid: { display: false } }, 
                y: { stacked: true, grid: { color: '#f1f5f9' } } 
            }, 
            plugins: { 
                legend: { position: 'bottom', labels: { padding: 12, usePointStyle: true, font: { size: 11, weight: '600' } } },
                tooltip: tooltipConfig
            } 
        }
    });

    const monthSelect = document.querySelector('.filter-laporan-month');
    const yearSelect = document.querySelector('.filter-laporan-year');
    const subtitleEl = document.getElementById('laporanChartSubtitle');
    
    function getMonthName(val) {
        switch(val) {
            case 'all': return 'Semua Bulan';
            case '01': return 'Januari';
            case '02': return 'Februari';
            case '03': return 'Maret';
            case '04': return 'April';
            case '05': return 'Mei';
            case '06': return 'Juni';
            case '07': return 'Juli';
            case '08': return 'Agustus';
            case '09': return 'September';
            case '10': return 'Oktober';
            case '11': return 'November';
            case '12': return 'Desember';
            default: return '';
        }
    }
    
    function updateLaporanChart() {
        const m = monthSelect.value;
        const y = yearSelect.value;
        
        let periodText = 'Periode ';
        if (m === 'all' && y === 'all') {
            periodText += 'Semua Waktu';
        } else if (m === 'all') {
            periodText += 'Tahun ' + y;
        } else if (y === 'all') {
            periodText += getMonthName(m) + ' (Semua Tahun)';
        } else {
            periodText += getMonthName(m) + ' ' + y;
        }
        subtitleEl.textContent = periodText;
        
        let factor = 1.0;
        if (m === '06') factor = 0.85;
        if (m === '05') factor = 0.7;
        if (m === '01' || m === '02') factor = 0.4;
        if (m === 'all') factor = 3.5;
        if (y === '2025') factor *= 0.8;
        if (y === 'all') factor *= 1.8;
        
        const baseDO = [4200, 3850, 3100, 2980, 5100, 2800];
        const baseFO = [800, 650, 500, 400, 520, 350];
        const baseLube = [120, 95, 70, 80, 120, 60];
        const baseCylinder = [150, 142, 160, 130, 90, 75];
        
        laporanChart.data.datasets[0].data = baseDO.map(v => Math.round(v * factor));
        laporanChart.data.datasets[1].data = baseFO.map(v => Math.round(v * factor));
        laporanChart.data.datasets[2].data = baseLube.map(v => Math.round(v * factor));
        laporanChart.data.datasets[3].data = baseCylinder.map(v => Math.round(v * factor));
        
        laporanChart.update();
    }
    
    monthSelect.addEventListener('change', updateLaporanChart);
    yearSelect.addEventListener('change', updateLaporanChart);
</script>
@endpush
