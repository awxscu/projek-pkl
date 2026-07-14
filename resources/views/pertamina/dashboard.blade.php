@extends('layouts.dashboard')

@section('title', 'Dashboard Pertamina')
@section('navbar') @include('partials.navbar-pertamina') @endsection

@section('content')
<div class="welcome-banner">
    <h4><i class="bi bi-hand-wave me-2"></i>Selamat Datang, Pertamina Patra Niaga</h4>
    <p>Pantau aktivitas logbook kapal penumpang dan konsumsi BBM secara real-time</p>
</div>

<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card-modern stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div><div class="stat-label">Total Kapal</div><div class="stat-value">18</div></div>
                <div class="stat-icon bg-pertamina-blue text-white"><i class="bi bi-ship"></i></div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card-modern stat-card stat-green">
            <div class="d-flex justify-content-between align-items-center">
                <div><div class="stat-label">Logbook Hari Ini</div><div class="stat-value">14</div></div>
                <div class="stat-icon" style="background:#dcfce7;color:#15803d"><i class="bi bi-journal-check"></i></div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card-modern stat-card stat-yellow">
            <div class="d-flex justify-content-between align-items-center">
                <div><div class="stat-label">Belum Verifikasi</div><div class="stat-value">5</div></div>
                <div class="stat-icon" style="background:#fef3c7;color:#b45309"><i class="bi bi-hourglass-split"></i></div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card-modern stat-card stat-orange">
            <div class="d-flex justify-content-between align-items-center">
                <div><div class="stat-label">Total Konsumsi BBM</div><div class="stat-value">4.280 <small class="text-muted" style="font-size:0.8rem">L</small></div></div>
                <div class="stat-icon" style="background:#fef3c7;color:#b45309"><i class="bi bi-fuel-pump"></i></div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-lg-6">
        <div class="card-modern chart-card">
            <div class="chart-title"><i class="bi bi-bar-chart me-1 text-pertamina-blue"></i> Pemakaian BBM Berdasarkan Kapal</div>
            <div class="chart-subtitle">Konsumsi harian (liter) — 14 Juli 2026</div>
            <div class="chart-container"><canvas id="barChartBBM"></canvas></div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card-modern chart-card">
            <div class="chart-title"><i class="bi bi-graph-up me-1 text-pertamina-blue"></i> Tren Konsumsi BBM Harian</div>
            <div class="chart-subtitle">7 hari terakhir (liter)</div>
            <div class="chart-container"><canvas id="lineChartTrend"></canvas></div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-lg-4">
        <div class="card-modern chart-card">
            <div class="chart-title"><i class="bi bi-pie-chart me-1 text-pertamina-blue"></i> Status Pengisian Logbook</div>
            <div class="chart-subtitle">Hari ini</div>
            <div class="chart-container"><canvas id="pieChartStatus"></canvas></div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card-modern chart-card">
            <div class="chart-title"><i class="bi bi-droplet me-1 text-pertamina-blue"></i> Stok BBM Kapal</div>
            <div class="chart-subtitle">Sisa stok Diesel Oil (liter)</div>
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
    const blue = '#0057B8', red = '#E31E24', blueLight = 'rgba(0,87,184,0.15)';
    Chart.defaults.font.family = "'Segoe UI', system-ui, sans-serif";

    new Chart(document.getElementById('barChartBBM'), {
        type: 'bar',
        data: {
            labels: ['VSL-001','VSL-002','VSL-004','VSL-005','VSL-006','VSL-007'],
            datasets: [{ label: 'BBM (L)', data: [320,285,198,410,175,230], backgroundColor: blue, borderRadius: 6 }]
        },
        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, grid: { color: '#f1f5f9' } }, x: { grid: { display: false } } } }
    });

    new Chart(document.getElementById('lineChartTrend'), {
        type: 'line',
        data: {
            labels: ['8 Jul','9 Jul','10 Jul','11 Jul','12 Jul','13 Jul','14 Jul'],
            datasets: [{ data: [3800,3950,4100,3850,4200,4050,4280], borderColor: blue, backgroundColor: blueLight, fill: true, tension: 0.4, pointRadius: 4 }]
        },
        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { grid: { color: '#f1f5f9' } }, x: { grid: { display: false } } } }
    });

    new Chart(document.getElementById('pieChartStatus'), {
        type: 'pie',
        data: {
            labels: ['Verified','Pending','Belum Mengisi'],
            datasets: [{ data: [9,5,4], backgroundColor: ['#22c55e','#eab308',red], borderWidth: 0 }]
        },
        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom', labels: { padding: 12, usePointStyle: true } } } }
    });

    new Chart(document.getElementById('barChartStok'), {
        type: 'bar',
        data: {
            labels: ['VSL-001','VSL-002','VSL-003','VSL-004','VSL-005','VSL-006'],
            datasets: [{ label: 'Stok DO (L)', data: [1250,980,1450,720,1100,890], backgroundColor: ['#0057B8','#0057B8','#E31E24','#0057B8','#0057B8','#0057B8'], borderRadius: 6 }]
        },
        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, grid: { color: '#f1f5f9' } }, x: { grid: { display: false } } } }
    });
</script>
@endpush
