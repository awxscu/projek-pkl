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

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card-modern stat-card">
            <div class="stat-label">Total Konsumsi BBM</div>
            <div class="stat-value">58.420 <small class="text-muted" style="font-size:0.8rem">L</small></div>
            <small class="text-muted">Periode 1–14 Juli 2026</small>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-modern stat-card stat-red">
            <div class="stat-label">Kapal Paling Banyak Konsumsi</div>
            <div class="stat-value" style="font-size:1.2rem">KM Citra Lautan</div>
            <small class="text-muted">5.740 L total</small>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-modern stat-card stat-green">
            <div class="stat-label">Rata-rata Konsumsi</div>
            <div class="stat-value">3.246 <small class="text-muted" style="font-size:0.8rem">L/kapal</small></div>
            <small class="text-muted">18 kapal aktif</small>
        </div>
    </div>
</div>

<div class="card-modern chart-card mb-4">
    <div class="chart-title">Grafik Konsumsi BBM per Kapal</div>
    <div class="chart-subtitle">Periode Juli 2026</div>
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
                    <th>Total Pelumas</th>
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
                    <td><strong>5.120 L</strong></td>
                </tr>
                <tr>
                    <td>KM Samudra Indah</td>
                    <td>VSL-002</td>
                    <td>3.850 L</td>
                    <td>650 L</td>
                    <td>95 L</td>
                    <td><strong>4.595 L</strong></td>
                </tr>
                <tr>
                    <td>KM Citra Lautan</td>
                    <td>VSL-005</td>
                    <td>5.100 L</td>
                    <td>520 L</td>
                    <td>120 L</td>
                    <td><strong>5.740 L</strong></td>
                </tr>
                <tr>
                    <td>KM Bahari Sejahtera</td>
                    <td>VSL-004</td>
                    <td>2.980 L</td>
                    <td>400 L</td>
                    <td>80 L</td>
                    <td><strong>3.460 L</strong></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    new Chart(document.getElementById('laporanChart'), {
        type: 'bar',
        data: {
            labels: ['VSL-001','VSL-002','VSL-003','VSL-004','VSL-005','VSL-006'],
            datasets: [
                { label: 'DO', data: [4200,3850,3100,2980,5100,2800], backgroundColor: '#0057B8', borderRadius: 4 },
                { label: 'FO', data: [800,650,500,400,520,350], backgroundColor: '#E31E24', borderRadius: 4 },
                { label: 'Pelumas', data: [120,95,70,80,120,60], backgroundColor: '#64748b', borderRadius: 4 }
            ]
        },
        options: { responsive: true, maintainAspectRatio: false, scales: { x: { stacked: true, grid: { display: false } }, y: { stacked: true, grid: { color: '#f1f5f9' } } }, plugins: { legend: { position: 'bottom' } } }
    });
</script>
@endpush
