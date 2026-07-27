@extends('layouts.dashboard')

@section('title', 'Laporan')
@section('navbar') @include('partials.navbar-pertamina') @endsection

@section('content')
<div class="page-header">
    <h4><i class="bi bi-file-earmark-bar-graph me-2 text-pertamina-blue"></i>Laporan Konsumsi BBM</h4>
    <p>Generate dan export laporan operasional kapal</p>
</div>

<div class="card-modern filter-card p-3 mb-4">
    <form method="GET" action="{{ route('pertamina.laporan') }}" class="row g-2 align-items-end">
        <div class="col-md-1">
            <label class="form-label fw-semibold mb-1" style="font-size: 0.85rem;">Tahun</label>
            <select class="form-select" name="year" style="height: 38px; font-size: 0.875rem;">
                @for ($y = 2024; $y <= 2026; $y++)
                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label fw-semibold mb-1" style="font-size: 0.85rem;">Bulan</label>
            <select class="form-select" name="month" style="height: 38px; font-size: 0.875rem;">
                <option value="">Semua Bulan</option>
                @foreach ([1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'] as $num => $name)
                    <option value="{{ $num }}" {{ $month == $num ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label fw-semibold mb-1" style="font-size: 0.85rem;">Perusahaan</label>
            <select class="form-select" name="id_perusahaan" style="height: 38px; font-size: 0.875rem;">
                <option value="">Semua Perusahaan</option>
                @foreach ($companies as $comp)
                    <option value="{{ $comp->id_perusahaan }}" {{ $id_perusahaan == $comp->id_perusahaan ? 'selected' : '' }}>{{ $comp->nama_perusahaan }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label fw-semibold mb-1" style="font-size: 0.85rem;">FT/IT Depot</label>
            <select class="form-select" name="ft_it" style="height: 38px; font-size: 0.875rem;">
                <option value="">Semua FT/IT</option>
                @foreach ($depots as $depot)
                    <option value="{{ $depot->id_ftit }}" {{ $ft_it == $depot->id_ftit ? 'selected' : '' }}>{{ $depot->nama_ftit }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label fw-semibold mb-1" style="font-size: 0.85rem;">Nama Kapal</label>
            <input type="text" class="form-control" name="search_kapal" value="{{ $search_kapal }}" placeholder="Cari nama kapal..." style="height: 38px; font-size: 0.875rem;">
        </div>
        <div class="col-md-3">
            <label class="form-label d-block mb-1">&nbsp;</label>
            <div class="d-flex gap-2">
                <button type="button" onclick="window.location.href='{{ route('pertamina.laporan') }}'" class="btn btn-outline-secondary w-50 d-flex align-items-center justify-content-center gap-1" style="height: 38px; font-size: 0.875rem; font-weight: 500;">
                    <i class="bi bi-x-circle"></i> Reset
                </button>
                <button type="submit" class="btn btn-pertamina w-50 d-flex align-items-center justify-content-center gap-1" style="height: 38px; font-size: 0.875rem; font-weight: 500;">
                    <i class="bi bi-search"></i> Filter
                </button>
            </div>
        </div>
    </form>
</div>


<div class="d-flex gap-2 mb-4 flex-wrap">
    <button class="btn btn-pertamina-red" id="btnExportPDFAll"><i class="bi bi-file-earmark-pdf me-2"></i>Export PDF Keseluruhan</button>
    <button class="btn btn-pertamina" id="btnExportExcelAll"><i class="bi bi-file-earmark-excel me-2"></i>Export Excel Keseluruhan</button>
</div>

<style>
    .card-tabs .nav-link {
        border: none;
        border-bottom: 3px solid transparent;
        background: transparent;
        transition: all 0.3s;
        color: #475569 !important;
    }
    .card-tabs .nav-link.active {
        border-bottom: 3px solid var(--pertamina-blue, #0057b8) !important;
        color: var(--pertamina-blue, #0057b8) !important;
    }
    .card-tabs .nav-link:hover {
        border-bottom: 3px solid var(--gray-border, #cbd5e1);
        color: #0f172a !important;
    }
</style>

<ul class="nav nav-tabs card-tabs mb-4" id="reportTabs" role="tablist" style="border-bottom: 2px solid #e2e8f0;">
    <li class="nav-item" role="presentation">
        <button class="nav-link active fw-bold px-4 py-3" id="tahunan-tab" data-bs-toggle="tab" data-bs-target="#tahunan-pane" type="button" role="tab" aria-controls="tahunan-pane" aria-selected="true">
            <i class="bi bi-calendar-check me-2"></i>Laporan Tahunan
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link fw-bold px-4 py-3" id="bulanan-tab" data-bs-toggle="tab" data-bs-target="#bulanan-pane" type="button" role="tab" aria-controls="bulanan-pane" aria-selected="false">
            <i class="bi bi-calendar3 me-2"></i>Laporan Bulanan
        </button>
    </li>
</ul>

<div class="tab-content" id="reportTabsContent">
    <!-- TAB TAHUNAN -->
    <div class="tab-pane fade show active" id="tahunan-pane" role="tabpanel" aria-labelledby="tahunan-tab">
        <div class="card-modern">
            <div class="p-3 border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h6 class="mb-0 fw-bold"><i class="bi bi-list-stars me-1 text-pertamina-blue"></i> Ringkasan Laporan Kapal (Tahunan)</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-modern">
                    <thead>
                        <tr>
                            <th>Nama Perusahaan</th>
                            <th>Nama Kapal</th>
                            <th>FT/IT</th>
                            <th class="text-end">Total Konsumsi BBM (FO)</th>
                            <th style="width: 200px; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($ships as $ship)
                            <tr data-kapal="{{ $ship->nama_kapal }}" data-vessel="{{ $ship->kode_vessel }}" data-perusahaan="{{ $ship->pt_name }}" data-ftit="{{ $ship->depot_name }}">
                                <td><strong>{{ $ship->pt_name }}</strong></td>
                                <td>
                                    <span class="fw-semibold text-pertamina-blue">{{ $ship->nama_kapal }}</span>
                                    <br><small class="badge bg-light text-dark mt-1">{{ $ship->kode_vessel }}</small>
                                </td>
                                <td>{{ $ship->depot_name }}</td>
                                <td class="text-end fw-bold text-pertamina-red">{{ number_format($ship->fo_total, 0, ',', '.') }} L</td>
                                <td class="text-center">
                                    <div class="d-flex gap-1 justify-content-center">
                                        <button class="btn btn-sm btn-outline-primary px-2 btn-recap-logbook" title="Rekapan Logbook (Mata)" data-vessel="{{ $ship->kode_vessel }}" data-kapal="{{ $ship->nama_kapal }}" data-perusahaan="{{ $ship->pt_name }}" data-ftit="{{ $ship->depot_name }}">
                                            <i class="bi bi-eye"></i> Detail
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger px-2 btn-export-pdf-vessel" title="Export PDF" data-kapal="{{ $ship->nama_kapal }}" data-perusahaan="{{ $ship->pt_name }}" data-ftit="{{ $ship->depot_name }}">
                                            <i class="bi bi-file-earmark-pdf"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-success px-2 btn-export-excel-vessel" title="Export Excel" data-kapal="{{ $ship->nama_kapal }}" data-perusahaan="{{ $ship->pt_name }}" data-ftit="{{ $ship->depot_name }}">
                                            <i class="bi bi-file-earmark-excel"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">Tidak ada data rekapitulasi kapal.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- TAB BULANAN -->
    <div class="tab-pane fade" id="bulanan-pane" role="tabpanel" aria-labelledby="bulanan-tab">
        <div class="card-modern">
            <div class="p-3 border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h6 class="mb-0 fw-bold"><i class="bi bi-list-stars me-1 text-pertamina-red"></i> Ringkasan Laporan Kapal (Bulanan)</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-modern">
                    <thead>
                        <tr>
                            <th>Bulan</th>
                            <th>Nama Perusahaan</th>
                            <th>Nama Kapal</th>
                            <th>FT/IT</th>
                            <th class="text-end">Konsumsi BBM (FO)</th>
                            <th class="text-center" style="min-width: 150px;">Dokumen PDF</th>
                            <th style="width: 200px; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($monthlyReportData as $row)
                            <tr data-kapal="{{ $row['nama_kapal'] }}" data-vessel="{{ $row['vessel_code'] }}" data-perusahaan="{{ $row['pt_name'] }}" data-ftit="{{ $row['depot_name'] }}">
                                <td><strong>{{ $row['month_name'] }} {{ $year }}</strong></td>
                                <td>{{ $row['pt_name'] }}</td>
                                <td>
                                    <span class="fw-semibold text-pertamina-blue">{{ $row['nama_kapal'] }}</span>
                                    <br><small class="badge bg-light text-dark mt-1">{{ $row['vessel_code'] }}</small>
                                </td>
                                <td>{{ $row['depot_name'] }}</td>
                                <td class="text-end fw-bold text-pertamina-red">{{ number_format($row['total_fo'], 0, ',', '.') }} L</td>
                                <td class="text-center">
                                    @if ($row['pdf'])
                                        <div class="d-flex justify-content-center gap-1">
                                            <button type="button" class="btn btn-outline-primary btn-xs" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#previewPdfModal" 
                                                    data-pdf-url="{{ asset($row['pdf']->file_path) }}"
                                                    title="Pratinjau PDF"
                                                    style="padding: 0.25rem 0.5rem; border-radius: 6px; font-size: 0.72rem;">
                                                <i class="bi bi-eye"></i> Lihat
                                            </button>
                                            <a href="{{ route('pertamina.dokumen-pdf.download', $row['pdf']->id_dokumen) }}" 
                                               class="btn btn-pertamina btn-xs" 
                                               title="Unduh PDF"
                                               style="padding: 0.25rem 0.5rem; border-radius: 6px; font-size: 0.72rem;">
                                                <i class="bi bi-download"></i> Unduh
                                            </a>
                                        </div>
                                    @else
                                        <span class="text-muted" style="font-size: 0.8rem;">— Belum Diunggah —</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex gap-1 justify-content-center">
                                        <button class="btn btn-sm btn-outline-primary px-2 btn-recap-logbook" title="Rekapan Logbook (Mata)" data-vessel="{{ $row['vessel_code'] }}" data-kapal="{{ $row['nama_kapal'] }}" data-perusahaan="{{ $row['pt_name'] }}" data-ftit="{{ $row['depot_name'] }}" data-month="{{ $row['month_num'] }}">
                                            <i class="bi bi-eye"></i> Detail
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger px-2 btn-export-pdf-vessel" title="Export PDF" data-kapal="{{ $row['nama_kapal'] }}" data-perusahaan="{{ $row['pt_name'] }}" data-ftit="{{ $row['depot_name'] }}" data-month="{{ $row['month_num'] }}">
                                            <i class="bi bi-file-earmark-pdf"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-success px-2 btn-export-excel-vessel" title="Export Excel" data-kapal="{{ $row['nama_kapal'] }}" data-perusahaan="{{ $row['pt_name'] }}" data-ftit="{{ $row['depot_name'] }}" data-month="{{ $row['month_num'] }}">
                                            <i class="bi bi-file-earmark-excel"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">Tidak ada data rekapitulasi kapal bulanan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Rekapan Logbook Harian Kapal -->
<div class="modal fade" id="recapLogbookModal" tabindex="-1" aria-labelledby="recapLogbookModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content" style="border-radius: 20px; overflow: hidden;">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold text-pertamina-blue" id="recapLogbookModalLabel">
                    <i class="bi bi-journal-album me-2"></i>Rekapan Logbook — <span id="recap_nama_kapal">-</span> (Tahun {{ $year }})
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Recap Stats row -->
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="p-3 bg-light rounded d-flex align-items-center justify-content-between">
                            <div>
                                <small class="text-muted d-block">Nama Kapal</small>
                                <span class="fw-bold fs-5 text-pertamina-blue" id="recap_vessel_code">-</span>
                            </div>
                            <i class="bi bi-ship fs-2 text-primary opacity-50"></i>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-light rounded d-flex align-items-center justify-content-between">
                            <div>
                                <small class="text-muted d-block">Perusahaan / FTIT</small>
                                <span class="fw-bold fs-6 text-dark d-block" id="recap_perusahaan" style="font-size: 0.85rem; max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">-</span>
                                <small class="text-muted" id="recap_ftit">-</small>
                            </div>
                            <i class="bi bi-building fs-2 text-info opacity-50"></i>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-light rounded d-flex align-items-center justify-content-between">
                            <div>
                                <small class="text-muted d-block">Total Hari Terisi ({{ $year }})</small>
                                <span class="fw-bold fs-5 text-success" id="recap_stat_hari">0 Hari</span>
                            </div>
                            <i class="bi bi-calendar-check fs-2 text-success opacity-50"></i>
                        </div>
                    </div>
                </div>

                <!-- Daily logs list table -->
                <div class="table-responsive">
                    <table class="table table-bordered table-sm small align-middle">
                        <thead class="table-light text-center align-middle" style="background-color: #f8f9fa;">
                            <tr>
                                <th rowspan="3" class="align-middle" style="min-width: 80px; font-size: 0.72rem; border-bottom: 2px solid #ccc;">Tgl</th>
                                <th colspan="8" class="align-middle bg-primary-subtle text-primary fw-bold" style="font-size: 0.75rem; border-bottom: 2px solid #0057B8;">Logbook Asli / Manual</th>
                                <th colspan="5" class="align-middle bg-success-subtle text-success fw-bold" style="font-size: 0.75rem; border-bottom: 2px solid #198754;">Logbook Seharusnya (Sistem)</th>
                            </tr>
                            <tr>
                                <th rowspan="2" class="align-middle" style="min-width: 85px; font-size: 0.7rem;">Sisa Kemarin</th>
                                <th colspan="3" class="align-middle" style="font-size: 0.7rem;">Penggunaan</th>
                                <th rowspan="2" class="align-middle" style="min-width: 85px; font-size: 0.7rem;">Total Penggunaan</th>
                                <th rowspan="2" class="align-middle" style="min-width: 85px; font-size: 0.7rem;">Sisa Sekarang</th>
                                <th rowspan="2" class="align-middle" style="min-width: 80px; font-size: 0.7rem;">Ditambah</th>
                                <th rowspan="2" class="align-middle" style="min-width: 85px; font-size: 0.7rem;">Jumlah Sekarang</th>
                                
                                <th rowspan="2" class="align-middle" style="min-width: 85px; font-size: 0.7rem;">Sisa Kemarin</th>
                                <th rowspan="2" class="align-middle" style="min-width: 85px; font-size: 0.7rem;">Total Penggunaan</th>
                                <th rowspan="2" class="align-middle" style="min-width: 85px; font-size: 0.7rem;">Sisa Sekarang</th>
                                <th rowspan="2" class="align-middle" style="min-width: 80px; font-size: 0.7rem;">Ditambah</th>
                                <th rowspan="2" class="align-middle" style="min-width: 85px; font-size: 0.7rem;">Jumlah Sekarang</th>
                            </tr>
                            <tr>
                                <th style="min-width: 75px; font-size: 0.68rem;">Mesin Induk</th>
                                <th style="min-width: 75px; font-size: 0.68rem;">Mesin Bantu</th>
                                <th style="min-width: 75px; font-size: 0.68rem;">Lain-Lain</th>
                            </tr>
                        </thead>
                        <tbody id="recapTableBody" class="text-center align-middle">
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

<!-- MODAL PREVIEW PDF -->
<div class="modal fade" id="previewPdfModal" tabindex="-1" aria-labelledby="previewPdfModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; overflow: hidden; height: 85vh;">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold text-pertamina-blue" id="previewPdfModalLabel">
                    <i class="bi bi-file-earmark-pdf-fill me-2"></i>Pratinjau Dokumen PDF
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0" style="height: calc(85vh - 56px);">
                <iframe id="pdfPreviewIframe" src="" style="width: 100%; height: 100%; border: none;"></iframe>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Recap logbook data keyed by Vessel Code
    const dailyLogsData = @json($dailyLogsData);

    const recapModal = new bootstrap.Modal(document.getElementById('recapLogbookModal'));
    
    document.querySelectorAll('.btn-recap-logbook').forEach(btn => {
        btn.addEventListener('click', function() {
            const vesselCode = this.getAttribute('data-vessel');
            const kapalNama = this.getAttribute('data-kapal');
            const perusahaan = this.getAttribute('data-perusahaan');
            const ftit = this.getAttribute('data-ftit');
            const month = this.getAttribute('data-month'); // 1-12 or null
            
            document.getElementById('recap_nama_kapal').textContent = kapalNama;
            document.getElementById('recap_vessel_code').textContent = kapalNama;
            document.getElementById('recap_perusahaan').textContent = perusahaan;
            document.getElementById('recap_ftit').textContent = ftit;
            
            let logs = dailyLogsData[vesselCode] || [];
            if (month) {
                logs = logs.filter(log => {
                    const parts = log.tanggal.split('/');
                    return parseInt(parts[1], 10) === parseInt(month, 10);
                });
            }
            
            // Set stats
            document.getElementById('recap_stat_hari').textContent = logs.length + ' Hari';
            
            const tbody = document.getElementById('recapTableBody');
            tbody.innerHTML = '';
            
            if (logs.length === 0) {
                const periodLabel = month ? 'bulan ini' : 'tahun {{ $year }}';
                tbody.innerHTML = `<tr><td colspan="14" class="text-center text-muted py-3">Tidak ada data logbook harian untuk kapal ini di ${periodLabel}.</td></tr>`;
            } else {
                logs.forEach(log => {
                    const tr = document.createElement('tr');
                    
                    const classDiscrepancyKemarin = log.has_discrepancy_kemarin ? 'bg-danger-subtle text-danger fw-bold' : '';
                    const classDiscrepancySisa = log.has_discrepancy_sisa ? 'bg-danger-subtle text-danger fw-bold' : '';
                    const classDiscrepancyJumlah = log.has_discrepancy_jumlah ? 'bg-danger-subtle text-danger fw-bold' : '';
                    
                    const sysSisaTextClass = log.has_discrepancy_sisa ? 'text-danger fw-bold' : 'text-success fw-semibold';
                    const sysJumlahTextClass = log.has_discrepancy_jumlah ? 'text-danger fw-bold' : 'text-success fw-semibold';
                    
                    const exclamationIconSisa = log.has_discrepancy_sisa ? '<i class="bi bi-exclamation-circle-fill ms-1" style="font-size: 0.75rem;"></i>' : '';
                    const exclamationIconJumlah = log.has_discrepancy_jumlah ? '<i class="bi bi-exclamation-circle-fill ms-1" style="font-size: 0.75rem;"></i>' : '';

                    tr.innerHTML = `
                        <td class="text-center fw-semibold" style="background-color: #fdfdfd; font-size: 0.72rem;">${log.tanggal}</td>
                        
                        <!-- MANUAL -->
                        <td class="text-end ${classDiscrepancyKemarin}" style="font-size: 0.72rem;">${log.manual_kemarin.toLocaleString('id-ID')} L</td>
                        <td class="text-end text-muted" style="font-size: 0.72rem;">${log.manual_induk > 0 ? log.manual_induk.toLocaleString('id-ID') + ' L' : '—'}</td>
                        <td class="text-end text-muted" style="font-size: 0.72rem;">${log.manual_bantu > 0 ? log.manual_bantu.toLocaleString('id-ID') + ' L' : '—'}</td>
                        <td class="text-end text-muted" style="font-size: 0.72rem;">${log.manual_lain > 0 ? log.manual_lain.toLocaleString('id-ID') + ' L' : '—'}</td>
                        <td class="text-end fw-semibold text-dark" style="font-size: 0.72rem;">${log.manual_total_penggunaan.toLocaleString('id-ID')} L</td>
                        <td class="text-end ${classDiscrepancySisa}" style="font-size: 0.72rem;">${log.manual_sekarang.toLocaleString('id-ID')} L</td>
                        <td class="text-end text-muted" style="font-size: 0.72rem;">${log.manual_tambah.toLocaleString('id-ID')} L</td>
                        <td class="text-end ${classDiscrepancyJumlah}" style="font-size: 0.72rem;">${log.manual_jumlah.toLocaleString('id-ID')} L</td>
                        
                        <!-- SYSTEM -->
                        <td class="text-end bg-success-subtle text-success fw-semibold" style="font-size: 0.72rem;">${log.sys_kemarin.toLocaleString('id-ID')} L</td>
                        <td class="text-end bg-success-subtle text-success fw-semibold" style="font-size: 0.72rem;">${log.sys_total_penggunaan.toLocaleString('id-ID')} L</td>
                        <td class="text-end bg-success-subtle ${sysSisaTextClass}" style="font-size: 0.72rem;">${log.sys_sisa_sekarang.toLocaleString('id-ID')} L ${exclamationIconSisa}</td>
                        <td class="text-end bg-success-subtle text-success fw-semibold" style="font-size: 0.72rem;">${log.sys_tambah.toLocaleString('id-ID')} L</td>
                        <td class="text-end bg-success-subtle ${sysJumlahTextClass}" style="font-size: 0.72rem;">${log.sys_jumlah_sekarang.toLocaleString('id-ID')} L ${exclamationIconJumlah}</td>
                    `;
                    tbody.appendChild(tr);
                });
            }
            
            recapModal.show();
        });
    });

    // Helper to trigger file downloads
    function downloadCSV(csvContent, fileName) {
        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement("a");
        if (link.download !== undefined) {
            const url = URL.createObjectURL(blob);
            link.setAttribute("href", url);
            link.setAttribute("download", fileName);
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    }

    // Individual Excel (CSV) download
    function exportVesselToCSV(vesselCode, kapalNama, perusahaan, ftit, month) {
        const logs = dailyLogsData[vesselCode] || [];
        
        let filteredLogs = logs;
        let periodText = 'Tahun ' + {{ $year }};
        if (month) {
            filteredLogs = logs.filter(log => {
                const parts = log.tanggal.split('/');
                return parseInt(parts[1], 10) === parseInt(month, 10);
            });
            const monthsName = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            periodText = 'Bulan ' + monthsName[parseInt(month, 10) - 1] + ' ' + {{ $year }};
        }
        
        let csv = 'Laporan Rekapitulasi Logbook ' + periodText + '\n';
        csv += 'Nama Kapal: ' + kapalNama + '\n';
        csv += 'Perusahaan: ' + perusahaan + '\n';
        csv += 'FT/IT: ' + ftit + '\n\n';
        
        csv += 'Tgl,Logbook Asli / Manual,,,,,,,,Logbook Seharusnya (Sistem),,,,\n';
        csv += ',Sisa Kemarin,Penggunaan,,,Total Penggunaan,Sisa Sekarang,Ditambah,Jumlah Sekarang,Sisa Kemarin,Total Penggunaan,Sisa Sekarang,Ditambah,Jumlah Sekarang\n';
        csv += ',,Mesin Induk,Mesin Bantu,Lain-Lain,,,,,,,,\n';
        
        filteredLogs.forEach(log => {
            csv += `"${log.tanggal}",${log.manual_kemarin},${log.manual_induk},${log.manual_bantu},${log.manual_lain},${log.manual_total_penggunaan},${log.manual_sekarang},${log.manual_tambah},${log.manual_jumlah},${log.sys_kemarin},${log.sys_total_penggunaan},${log.sys_sisa_sekarang},${log.sys_tambah},${log.sys_jumlah_sekarang}\n`;
        });
        
        const fileSuffix = month ? `Bulan_${month}` : `Tahun_${ {{ $year }} }`;
        downloadCSV(csv, `Laporan_${kapalNama.replace(/\s+/g, '_')}_${fileSuffix}.csv`);
    }

    // Individual PDF download
    function exportVesselToPDF(vesselCode, kapalNama, perusahaan, ftit, month) {
        const logs = dailyLogsData[vesselCode] || [];
        
        let filteredLogs = logs;
        let periodText = 'Tahunan ' + {{ $year }};
        if (month) {
            filteredLogs = logs.filter(log => {
                const parts = log.tanggal.split('/');
                return parseInt(parts[1], 10) === parseInt(month, 10);
            });
            const monthsName = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            periodText = 'Bulanan ' + monthsName[parseInt(month, 10) - 1] + ' ' + {{ $year }};
        }
        
        const printWindow = window.open('', '_blank');
        
        let html = `
        <html>
        <head>
            <title>Laporan Rekapitulasi - ${kapalNama}</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
            <style>
                body { padding: 30px; font-family: sans-serif; }
                table { font-size: 10px; }
                th, td { padding: 4px !important; text-align: center; vertical-align: middle; }
                .text-end { text-align: right !important; }
                .bg-success-subtle { background-color: #d1e7dd !important; }
                .bg-danger-subtle { background-color: #f8d7da !important; }
                .fw-bold { font-weight: bold; }
                @media print {
                    .no-print { display: none; }
                    body { padding: 0; }
                }
            </style>
        </head>
        <body>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="fw-bold text-primary">PERTAMINA</h3>
                    <h5 class="fw-semibold text-secondary">Laporan Rekapitulasi Logbook ${periodText}</h5>
                </div>
                <button class="btn btn-primary no-print" onclick="window.print()">Cetak / Simpan PDF</button>
            </div>
            
            <div class="row g-3 mb-4">
                <div class="col-4">
                    <strong>Nama Kapal:</strong> ${kapalNama}
                </div>
                <div class="col-4">
                    <strong>Perusahaan:</strong> ${perusahaan}
                </div>
                <div class="col-4">
                    <strong>FT/IT Depot:</strong> ${ftit}
                </div>
            </div>
            
            <table class="table table-bordered table-sm table-striped">
                <thead class="table-light">
                    <tr>
                        <th rowspan="3" class="align-middle">Tgl</th>
                        <th colspan="8" class="bg-primary text-white">Logbook Manual (Kru)</th>
                        <th colspan="5" class="bg-success text-white">Logbook Seharusnya (Sistem)</th>
                    </tr>
                    <tr>
                        <th rowspan="2" class="align-middle">Sisa Kemarin</th>
                        <th colspan="3">Penggunaan</th>
                        <th rowspan="2" class="align-middle">Total</th>
                        <th rowspan="2" class="align-middle">Sisa Sekarang</th>
                        <th rowspan="2" class="align-middle">Ditambah</th>
                        <th rowspan="2" class="align-middle">Jumlah</th>
                        <th rowspan="2" class="align-middle">Sisa Kemarin</th>
                        <th rowspan="2" class="align-middle">Total</th>
                        <th rowspan="2" class="align-middle">Sisa Sekarang</th>
                        <th rowspan="2" class="align-middle">Ditambah</th>
                        <th rowspan="2" class="align-middle">Jumlah</th>
                    </tr>
                    <tr>
                        <th>Induk</th>
                        <th>Bantu</th>
                        <th>Lain</th>
                    </tr>
                </thead>
                <tbody>
        `;
        
        if (filteredLogs.length === 0) {
            html += `<tr><td colspan="14" class="text-center text-muted py-3">Tidak ada data logbook.</td></tr>`;
        } else {
            filteredLogs.forEach(log => {
                html += `
                    <tr>
                        <td>${log.tanggal}</td>
                        <td class="text-end">${log.manual_kemarin.toLocaleString('id-ID')} L</td>
                        <td class="text-end">${log.manual_induk > 0 ? log.manual_induk.toLocaleString('id-ID') : '—'}</td>
                        <td class="text-end">${log.manual_bantu > 0 ? log.manual_bantu.toLocaleString('id-ID') : '—'}</td>
                        <td class="text-end">${log.manual_lain > 0 ? log.manual_lain.toLocaleString('id-ID') : '—'}</td>
                        <td class="text-end fw-semibold">${log.manual_total_penggunaan.toLocaleString('id-ID')} L</td>
                        <td class="text-end">${log.manual_sekarang.toLocaleString('id-ID')} L</td>
                        <td class="text-end">${log.manual_tambah.toLocaleString('id-ID')} L</td>
                        <td class="text-end">${log.manual_jumlah.toLocaleString('id-ID')} L</td>
                        
                        <td class="text-end">${log.sys_kemarin.toLocaleString('id-ID')} L</td>
                        <td class="text-end">${log.sys_total_penggunaan.toLocaleString('id-ID')} L</td>
                        <td class="text-end">${log.sys_sisa_sekarang.toLocaleString('id-ID')} L</td>
                        <td class="text-end">${log.sys_tambah.toLocaleString('id-ID')} L</td>
                        <td class="text-end">${log.sys_jumlah_sekarang.toLocaleString('id-ID')} L</td>
                    </tr>
                `;
            });
        }
        
        html += `
                </tbody>
            </table>
            <script>
                window.onload = function() {
                    window.print();
                }
            <\/script>
        </body>
        </html>
        `;
        
        printWindow.document.write(html);
        printWindow.document.close();
    }

    // Alert handling for individual downloads
    document.querySelectorAll('.btn-export-pdf-vessel').forEach(btn => {
        btn.addEventListener('click', function() {
            const vesselCode = this.closest('tr').getAttribute('data-vessel');
            const kapal = this.getAttribute('data-kapal');
            const perusahaan = this.getAttribute('data-perusahaan');
            const ftit = this.getAttribute('data-ftit');
            const month = this.getAttribute('data-month'); // 1-12 or null
            exportVesselToPDF(vesselCode, kapal, perusahaan, ftit, month);
        });
    });

    document.querySelectorAll('.btn-export-excel-vessel').forEach(btn => {
        btn.addEventListener('click', function() {
            const vesselCode = this.closest('tr').getAttribute('data-vessel');
            const kapal = this.getAttribute('data-kapal');
            const perusahaan = this.getAttribute('data-perusahaan');
            const ftit = this.getAttribute('data-ftit');
            const month = this.getAttribute('data-month'); // 1-12 or null
            exportVesselToCSV(vesselCode, kapal, perusahaan, ftit, month);
        });
    });

    // Link global export buttons
    const btnPDFAll = document.getElementById('btnExportPDFAll');
    if (btnPDFAll) {
        btnPDFAll.addEventListener('click', function() {
            const printWindow = window.open('', '_blank');
            const originalTable = document.querySelector('table.table-modern').outerHTML;
            
            let html = `
            <html>
            <head>
                <title>Rekapitulasi Laporan Tahunan - ${ {{ $year }} }</title>
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
                <style>
                    body { padding: 30px; font-family: sans-serif; }
                    table { font-size: 12px; }
                    th, td { padding: 8px !important; vertical-align: middle; }
                    .no-print { display: none; }
                    @media print {
                        .no-print { display: none; }
                        body { padding: 0; }
                    }
                </style>
            </head>
            <body>
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h3 class="fw-bold text-primary">PERTAMINA</h3>
                        <h5 class="fw-semibold text-secondary">Rekapitulasi Laporan Tahunan ${ {{ $year }} }</h5>
                    </div>
                    <button class="btn btn-primary no-print" onclick="window.print()">Cetak / Simpan PDF</button>
                </div>
                
                ${originalTable}
                
                <script>
                    // Remove action columns
                    document.querySelectorAll('table tbody tr').forEach(tr => {
                        if(tr.cells.length > 4) tr.cells[4].remove();
                    });
                    document.querySelectorAll('table thead tr').forEach(tr => {
                        if(tr.cells.length > 4) tr.cells[4].remove();
                    });
                    window.onload = function() {
                        window.print();
                    }
                <\/script>
            </body>
            </html>
            `;
            printWindow.document.write(html);
            printWindow.document.close();
        });
    }

    const btnExcelAll = document.getElementById('btnExportExcelAll');
    if (btnExcelAll) {
        btnExcelAll.addEventListener('click', function() {
            let csv = 'Laporan Rekapitulasi Tahunan Seluruh Kapal - ' + {{ $year }} + '\n\n';
            csv += 'Nama Perusahaan,Nama Kapal,Vessel Code,FT/IT,Total Pemakaian FO\n';
            
            document.querySelectorAll('table.table-modern tbody tr').forEach(tr => {
                const company = tr.getAttribute('data-perusahaan');
                const name = tr.getAttribute('data-kapal');
                const code = tr.getAttribute('data-vessel');
                const ftit = tr.getAttribute('data-ftit');
                const total = tr.cells[3] ? tr.cells[3].textContent.trim() : '0 L';
                if (company) {
                    csv += `"${company}","${name}","${code}","${ftit}","${total}"\n`;
                }
            });
            
            downloadCSV(csv, `Rekapitulasi_Laporan_Tahunan_${ {{ $year }} }.csv`);
        });
    }

    // PDF Preview Modal Handler
    const previewModal = document.getElementById('previewPdfModal');
    if (previewModal) {
        previewModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const pdfUrl = button.getAttribute('data-pdf-url');
            const iframe = document.getElementById('pdfPreviewIframe');
            if (iframe) {
                iframe.src = pdfUrl;
            }
        });
        previewModal.addEventListener('hidden.bs.modal', function () {
            const iframe = document.getElementById('pdfPreviewIframe');
            if (iframe) {
                iframe.src = '';
            }
        });
    }
</script>
@endpush
