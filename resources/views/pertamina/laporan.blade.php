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
    <button class="btn btn-pertamina-red" id="btnExportPDFAll"><i class="bi bi-file-earmark-pdf me-2"></i>Export PDF Keseluruhan</button>
    <button class="btn btn-pertamina" id="btnExportExcelAll"><i class="bi bi-file-earmark-excel me-2"></i>Export Excel Keseluruhan</button>
</div>

<div class="card-modern">
    <div class="p-3 border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h6 class="mb-0 fw-bold"><i class="bi bi-list-stars me-1 text-pertamina-blue"></i> Ringkasan Laporan Kapal (Per Perjalanan)</h6>
    </div>
    <div class="table-responsive">
        <table class="table table-modern">
            <thead>
                <tr>
                    <th>Kapal</th>
                    <th>Vessel Code</th>
                    <th>Rute Pelayaran</th>
                    <th>Jadwal Pelayaran</th>
                    <th class="text-end">Total Konsumsi BBM</th>
                    <th style="width: 200px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr data-kapal="KM Nusantara Jaya" data-vessel="VSL-001" data-rute="Surabaya → Balikpapan" data-jadwal="14/07/2026 - 15/07/2026" data-voyage="VYG-001">
                    <td><strong>KM Nusantara Jaya</strong></td>
                    <td><span class="badge bg-light text-dark">VSL-001</span></td>
                    <td>Surabaya → Balikpapan</td>
                    <td>14/07/2026 - 15/07/2026</td>
                    <td class="text-end fw-bold text-pertamina-blue">4.275 L</td>
                    <td class="text-center">
                        <div class="d-flex gap-1 justify-content-center">
                            <button class="btn btn-sm btn-outline-primary px-2 btn-recap-logbook" title="Rekapan Logbook (Mata)" data-vessel="VSL-001" data-kapal="KM Nusantara Jaya" data-rute="Surabaya → Balikpapan" data-jadwal="14/07/2026 - 15/07/2026" data-voyage="VYG-001">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger px-2 btn-export-pdf-vessel" title="Export PDF" data-kapal="KM Nusantara Jaya" data-rute="Surabaya → Balikpapan" data-jadwal="14/07/2026 - 15/07/2026">
                                <i class="bi bi-file-earmark-pdf"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-success px-2 btn-export-excel-vessel" title="Export Excel" data-kapal="KM Nusantara Jaya" data-rute="Surabaya → Balikpapan" data-jadwal="14/07/2026 - 15/07/2026">
                                <i class="bi bi-file-earmark-excel"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr data-kapal="KM Nusantara Jaya" data-vessel="VSL-001" data-rute="Balikpapan → Surabaya" data-jadwal="17/07/2026 - 18/07/2026" data-voyage="VYG-002">
                    <td><strong>KM Nusantara Jaya</strong></td>
                    <td><span class="badge bg-light text-dark">VSL-001</span></td>
                    <td>Balikpapan → Surabaya</td>
                    <td>17/07/2026 - 18/07/2026</td>
                    <td class="text-end fw-bold text-pertamina-blue">4.118 L</td>
                    <td class="text-center">
                        <div class="d-flex gap-1 justify-content-center">
                            <button class="btn btn-sm btn-outline-primary px-2 btn-recap-logbook" title="Rekapan Logbook (Mata)" data-vessel="VSL-001" data-kapal="KM Nusantara Jaya" data-rute="Balikpapan → Surabaya" data-jadwal="17/07/2026 - 18/07/2026" data-voyage="VYG-002">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger px-2 btn-export-pdf-vessel" title="Export PDF" data-kapal="KM Nusantara Jaya" data-rute="Balikpapan → Surabaya" data-jadwal="17/07/2026 - 18/07/2026">
                                <i class="bi bi-file-earmark-pdf"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-success px-2 btn-export-excel-vessel" title="Export Excel" data-kapal="KM Nusantara Jaya" data-rute="Balikpapan → Surabaya" data-jadwal="17/07/2026 - 18/07/2026">
                                <i class="bi bi-file-earmark-excel"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr data-kapal="KM Samudra Indah" data-vessel="VSL-002" data-rute="Jakarta → Semarang" data-jadwal="14/07/2026 - 15/07/2026" data-voyage="VYG-003">
                    <td><strong>KM Samudra Indah</strong></td>
                    <td><span class="badge bg-light text-dark">VSL-002</span></td>
                    <td>Jakarta → Semarang</td>
                    <td>14/07/2026 - 15/07/2026</td>
                    <td class="text-end fw-bold text-pertamina-blue">2.618 L</td>
                    <td class="text-center">
                        <div class="d-flex gap-1 justify-content-center">
                            <button class="btn btn-sm btn-outline-primary px-2 btn-recap-logbook" title="Rekapan Logbook (Mata)" data-vessel="VSL-002" data-kapal="KM Samudra Indah" data-rute="Jakarta → Semarang" data-jadwal="14/07/2026 - 15/07/2026" data-voyage="VYG-003">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger px-2 btn-export-pdf-vessel" title="Export PDF" data-kapal="KM Samudra Indah" data-rute="Jakarta → Semarang" data-jadwal="14/07/2026 - 15/07/2026">
                                <i class="bi bi-file-earmark-pdf"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-success px-2 btn-export-excel-vessel" title="Export Excel" data-kapal="KM Samudra Indah" data-rute="Jakarta → Semarang" data-jadwal="14/07/2026 - 15/07/2026">
                                <i class="bi bi-file-earmark-excel"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr data-kapal="KM Citra Lautan" data-vessel="VSL-005" data-rute="Pontianak → Ketapang" data-jadwal="14/07/2026 - 15/07/2026" data-voyage="VYG-004">
                    <td><strong>KM Citra Lautan</strong></td>
                    <td><span class="badge bg-light text-dark">VSL-005</span></td>
                    <td>Pontianak → Ketapang</td>
                    <td>14/07/2026 - 15/07/2026</td>
                    <td class="text-end fw-bold text-pertamina-blue">3.722 L</td>
                    <td class="text-center">
                        <div class="d-flex gap-1 justify-content-center">
                            <button class="btn btn-sm btn-outline-primary px-2 btn-recap-logbook" title="Rekapan Logbook (Mata)" data-vessel="VSL-005" data-kapal="KM Citra Lautan" data-rute="Pontianak → Ketapang" data-jadwal="14/07/2026 - 15/07/2026" data-voyage="VYG-004">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger px-2 btn-export-pdf-vessel" title="Export PDF" data-kapal="KM Citra Lautan" data-rute="Pontianak → Ketapang" data-jadwal="14/07/2026 - 15/07/2026">
                                <i class="bi bi-file-earmark-pdf"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-success px-2 btn-export-excel-vessel" title="Export Excel" data-kapal="KM Citra Lautan" data-rute="Pontianak → Ketapang" data-jadwal="14/07/2026 - 15/07/2026">
                                <i class="bi bi-file-earmark-excel"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Rekapan Logbook Harian Kapal -->
<div class="modal fade" id="recapLogbookModal" tabindex="-1" aria-labelledby="recapLogbookModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content" style="border-radius: 20px; overflow: hidden;">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold text-pertamina-blue" id="recapLogbookModalLabel">
                    <i class="bi bi-journal-album me-2"></i>Rekapan Logbook — <span id="recap_nama_kapal">-</span> (<span id="recap_rute_jadwal">-</span>)
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Recap Stats row -->
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded d-flex align-items-center justify-content-between">
                            <div>
                                <small class="text-muted d-block">Vessel Code</small>
                                <span class="fw-bold fs-5 text-pertamina-blue" id="recap_vessel_code">-</span>
                            </div>
                            <i class="bi bi-ship fs-2 text-primary opacity-50"></i>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded d-flex align-items-center justify-content-between">
                            <div>
                                <small class="text-muted d-block">Total Hari Perjalanan</small>
                                <span class="fw-bold fs-5 text-success" id="recap_stat_hari">0 Hari</span>
                            </div>
                            <i class="bi bi-calendar-check fs-2 text-success opacity-50"></i>
                        </div>
                    </div>
                </div>

                <!-- Daily logs list table -->
                <div class="table-responsive">
                    <table class="table table-bordered table-sm small">
                        <thead class="table-light text-center">
                            <tr>
                                <th>Tanggal</th>
                                <th>Rute Pelayaran</th>
                                <th>Konsumsi DO (L)</th>
                                <th>Konsumsi FO (L)</th>
                                <th>Konsumsi Lube (L)</th>
                                <th>Konsumsi Cylinder (L)</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="recapTableBody" class="text-center">
                            <!-- Dynamically loaded from JS -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer bg-light px-4 py-3">
                <button type="button" class="btn btn-outline-secondary px-4 py-2 fw-semibold" style="font-size: 0.85rem; border-radius: 8px;" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
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

    // Recap logbook mock data keyed by Voyage ID
    const dailyLogsData = {
        'VYG-001': [
            { tanggal: '14/07/2026', rute: 'Surabaya → Balikpapan', do: 930, fo: 800, lube: 283, cyl: 142, status: 'Verified' },
            { tanggal: '15/07/2026', rute: 'Surabaya → Balikpapan', do: 910, fo: 790, lube: 280, cyl: 140, status: 'Verified' }
        ],
        'VYG-002': [
            { tanggal: '17/07/2026', rute: 'Balikpapan → Surabaya', do: 950, fo: 810, lube: 285, cyl: 145, status: 'Verified' },
            { tanggal: '18/07/2026', rute: 'Balikpapan → Surabaya', do: 940, fo: 805, lube: 284, cyl: 143, status: 'Verified' }
        ],
        'VYG-003': [
            { tanggal: '14/07/2026', rute: 'Jakarta → Semarang', do: 800, fo: 650, lube: 200, cyl: 120, status: 'Verified' },
            { tanggal: '15/07/2026', rute: 'Jakarta → Semarang', do: 790, fo: 640, lube: 198, cyl: 118, status: 'Verified' }
        ],
        'VYG-004': [
            { tanggal: '14/07/2026', rute: 'Pontianak → Ketapang', do: 1090, fo: 500, lube: 277, cyl: 130, status: 'Verified' },
            { tanggal: '15/07/2026', rute: 'Pontianak → Ketapang', do: 1050, fo: 480, lube: 270, cyl: 125, status: 'Verified' }
        ]
    };

    const recapModal = new bootstrap.Modal(document.getElementById('recapLogbookModal'));
    
    document.querySelectorAll('.btn-recap-logbook').forEach(btn => {
        btn.addEventListener('click', function() {
            const voyageCode = this.getAttribute('data-voyage');
            const vesselCode = this.getAttribute('data-vessel');
            const kapalNama = this.getAttribute('data-kapal');
            const rute = this.getAttribute('data-rute');
            const jadwal = this.getAttribute('data-jadwal');
            
            document.getElementById('recap_nama_kapal').textContent = kapalNama;
            document.getElementById('recap_rute_jadwal').textContent = `${rute} | ${jadwal}`;
            document.getElementById('recap_vessel_code').textContent = vesselCode;
            
            const logs = dailyLogsData[voyageCode] || [];
            
            // Set stats
            document.getElementById('recap_stat_hari').textContent = logs.length + ' Hari';
            
            const tbody = document.getElementById('recapTableBody');
            tbody.innerHTML = '';
            
            if (logs.length === 0) {
                tbody.innerHTML = `<tr><td colspan="7" class="text-muted py-3">Tidak ada data logbook harian untuk perjalanan ini.</td></tr>`;
            } else {
                logs.forEach(log => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${log.tanggal}</td>
                        <td>${log.rute}</td>
                        <td>${log.do} L</td>
                        <td>${log.fo} L</td>
                        <td>${log.lube} L</td>
                        <td>${log.cyl} L</td>
                        <td><span class="badge badge-verified"><i class="bi bi-check-circle-fill me-1"></i>${log.status}</span></td>
                    `;
                    tbody.appendChild(tr);
                });
            }
            
            recapModal.show();
        });
    });

    // Alert handling for individual downloads
    document.querySelectorAll('.btn-export-pdf-vessel').forEach(btn => {
        btn.addEventListener('click', function() {
            const kapal = this.getAttribute('data-kapal');
            const rute = this.getAttribute('data-rute');
            const jadwal = this.getAttribute('data-jadwal');
            alert(`Laporan PDF untuk ${kapal} (${rute} | ${jadwal}) berhasil diunduh!`);
        });
    });

    document.querySelectorAll('.btn-export-excel-vessel').forEach(btn => {
        btn.addEventListener('click', function() {
            const kapal = this.getAttribute('data-kapal');
            const rute = this.getAttribute('data-rute');
            const jadwal = this.getAttribute('data-jadwal');
            alert(`Laporan Excel untuk ${kapal} (${rute} | ${jadwal}) berhasil diunduh!`);
        });
    });

    // Link global export buttons
    const btnPDFAll = document.getElementById('btnExportPDFAll');
    if (btnPDFAll) {
        btnPDFAll.addEventListener('click', function() {
            alert('Laporan PDF untuk Seluruh Kapal berhasil diunduh!');
        });
    }

    const btnExcelAll = document.getElementById('btnExportExcelAll');
    if (btnExcelAll) {
        btnExcelAll.addEventListener('click', function() {
            alert('Laporan Excel untuk Seluruh Kapal berhasil diunduh!');
        });
    }
</script>
@endpush
