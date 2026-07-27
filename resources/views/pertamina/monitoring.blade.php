@extends('layouts.dashboard')

@section('title', 'Monitoring Logbook')
@section('navbar') @include('partials.navbar-pertamina') @endsection

@section('content')
<div class="page-header">
    <h4><i class="bi bi-eye me-2 text-pertamina-blue"></i>Monitoring Logbook Kapal</h4>
    <p>Pantau status logbook harian kapal, hitung selisih pemakaian BBM secara otomatis, dan analisa keakuratan input.</p>
</div>

<!-- FILTERS CARD -->
<div class="card-modern filter-card p-3 mb-4">
    <form method="GET" action="{{ route('pertamina.monitoring') }}" class="row g-3 align-items-end">
        <div class="col-md-3">
            <label class="form-label fw-semibold mb-1" style="font-size: 0.85rem;">Pilih Bulan</label>
            <select class="form-select" name="month" style="height: 38px; font-size: 0.875rem;">
                @php
                    $months = [
                        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                    ];
                @endphp
                @foreach ($months as $num => $name)
                    <option value="{{ $num }}" {{ $month == $num ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label fw-semibold mb-1" style="font-size: 0.85rem;">Pilih Tahun</label>
            <select class="form-select" name="year" style="height: 38px; font-size: 0.875rem;">
                @for ($y = 2024; $y <= 2026; $y++)
                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label fw-semibold mb-1" style="font-size: 0.85rem;">Pilih FT/IT</label>
            <select class="form-select" name="ft_it" style="height: 38px; font-size: 0.875rem;">
                <option value="">Semua FT/IT</option>
                @foreach ($depots as $depot)
                    <option value="{{ $depot->id_ftit }}" {{ $ft_it == $depot->id_ftit ? 'selected' : '' }}>{{ $depot->nama_ftit }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label fw-semibold mb-1" style="font-size: 0.85rem;">Pilih Perusahaan</label>
            <select class="form-select" name="id_perusahaan" style="height: 38px; font-size: 0.875rem;">
                <option value="">Semua Perusahaan</option>
                @foreach ($companies as $comp)
                    <option value="{{ $comp->id_perusahaan }}" {{ $id_perusahaan == $comp->id_perusahaan ? 'selected' : '' }}>{{ $comp->nama_perusahaan }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="col-md-8">
            <label class="form-label fw-semibold mb-1" style="font-size: 0.85rem;">Nama / Kode Kapal</label>
            <input type="text" class="form-control" name="search_kapal" value="{{ $search_kapal }}" placeholder="Cari nama kapal atau kode vessel..." style="height: 38px; font-size: 0.875rem;">
        </div>
        <div class="col-md-2">
            <label class="form-label d-block mb-1">&nbsp;</label>
            <button type="button" onclick="window.location.href='{{ route('pertamina.monitoring') }}'" class="btn btn-outline-secondary w-100 d-flex align-items-center justify-content-center gap-1" style="height: 38px; font-size: 0.875rem; font-weight: 500;">
                <i class="bi bi-x-circle"></i> Reset
            </button>
        </div>
        <div class="col-md-2">
            <label class="form-label d-block mb-1">&nbsp;</label>
            <button type="submit" class="btn btn-pertamina w-100 d-flex align-items-center justify-content-center gap-1" style="height: 38px; font-size: 0.875rem; font-weight: 500;">
                <i class="bi bi-search"></i> Filter
            </button>
        </div>
    </form>
</div>

<!-- SUMMARY MONITORING TABLE -->
<div class="card-modern">
    <div class="p-3 border-bottom"><h6 class="mb-0 fw-bold">Daftar Kapal & Status Logbook ({{ $months[(int)$month] }} {{ $year }})</h6></div>
    <div class="table-responsive">
        <table class="table table-modern">
            <thead>
                <tr>
                    <th>Nama Perusahaan</th>
                    <th>Nama Kapal</th>
                    <th>FT/IT</th>
                    <th>Status Pengisian</th>
                    <th>Hasil Monitoring (Selisih)</th>
                    <th style="width:120px;" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($ships as $ship)
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
                                <span class="badge bg-warning text-dark"><i class="bi bi-exclamation-circle me-1"></i>Belum Lengkap ({{ $ship->logbooks_count }} / {{ $days_in_month }} Hari)</span>
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
                        <td class="text-center">
                            <button class="btn btn-sm btn-outline-primary px-3" data-bs-toggle="modal" data-bs-target="#detailShipModal{{ $ship->kode_vessel }}">
                                <i class="bi bi-eye"></i> Detail
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Data kapal tidak ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- PAGINATION -->
    <div class="mt-4 d-flex justify-content-center">
        {{ $ships->links('pagination::bootstrap-5') }}
    </div>
</div>

<!-- DAILY DETAILS MODALS -->
@foreach ($ships as $ship)
<div class="modal fade" id="detailShipModal{{ $ship->kode_vessel }}" tabindex="-1" aria-labelledby="detailShipModalLabel{{ $ship->kode_vessel }}" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content" style="border-radius: 20px; overflow: hidden;">
            <div class="modal-header bg-light">
                <div>
                    <h5 class="modal-title fw-bold text-pertamina-blue" id="detailShipModalLabel{{ $ship->kode_vessel }}">
                        <i class="bi bi-ship me-2"></i>Rincian Logbook Harian: {{ $ship->nama_kapal }}
                    </h5>
                    <small class="text-muted">{{ $ship->pt_name }} — Periode {{ $months[(int)$month] }} {{ $year }}</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Info Header -->
                <div class="row g-3 mb-4 border-bottom pb-3">
                    <div class="col-md-4">
                        <small class="text-muted d-block">Nama Kapal</small>
                        <span class="fw-semibold">{{ $ship->nama_kapal }}</span>
                    </div>
                    <div class="col-md-4">
                        <small class="text-muted d-block">Depot</small>
                        <span class="fw-semibold">{{ $ship->depot_name }}</span>
                    </div>
                    <div class="col-md-4">
                        <small class="text-muted d-block">Total Hari Terisi</small>
                        <span class="fw-semibold">{{ $ship->logbooks_count }} Hari</span>
                    </div>
                </div>

                <!-- Daily Logbook Table Grid -->
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
                        <tbody>
                            @php
                                $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                                $sys_kemarin = null;
                            @endphp
                            @for ($day = 1; $day <= $daysInMonth; $day++)
                                @php
                                    $currentDateStr = sprintf('%04d-%02d-%02d', $year, $month, $day);
                                    $log = $ship->logbooks->first(fn($l) => $l->tanggal_pencataan->format('Y-m-d') === $currentDateStr);
                                    $fo = $log ? $log->detailPemakaians->where('id_jenis', 2)->first() : null;
                                @endphp
                                <tr>
                                    <td class="text-center fw-semibold" style="background-color: #fdfdfd; font-size: 0.72rem;">{{ sprintf('%02d/%02d/%04d', $day, $month, $year) }}</td>
                                    @if ($fo)
                                        @php
                                            if ($sys_kemarin === null) {
                                                $sys_kemarin = $fo->sisa_kemarin ?: 0;
                                            }
                                            $total_penggunaan = ($fo->motor_induk ?: 0) + ($fo->motor_bantu ?: 0) + ($fo->lain_lain ?: 0);
                                            $sys_penggunaan = $total_penggunaan;
                                            $sys_sisa_sekarang = $sys_kemarin - $sys_penggunaan;
                                            $sys_jumlah_sekarang = $sys_sisa_sekarang + ($fo->ditambah ?: 0);

                                            $has_discrepancy_kemarin = abs(($fo->sisa_kemarin ?: 0) - $sys_kemarin) > 0;
                                            $has_discrepancy_sisa = abs(($fo->sisa_sekarang ?: 0) - $sys_sisa_sekarang) > 0;
                                            $has_discrepancy_jumlah = abs(($fo->jumlah_sekarang ?: 0) - $sys_jumlah_sekarang) > 0;
                                        @endphp
                                        
                                        <!-- MANUAL COLUMNS -->
                                        <!-- Sisa Kemarin (Manual) -->
                                        <td class="text-end @if($has_discrepancy_kemarin) bg-danger-subtle text-danger fw-bold @endif" style="font-size: 0.72rem;">
                                            {{ number_format($fo->sisa_kemarin ?: 0) }} L
                                        </td>
                                        <!-- Penggunaan (Manual) -->
                                        <td class="text-end text-muted" style="font-size: 0.72rem;">{{ $fo->motor_induk > 0 ? number_format($fo->motor_induk) . ' L' : '—' }}</td>
                                        <td class="text-end text-muted" style="font-size: 0.72rem;">{{ $fo->motor_bantu > 0 ? number_format($fo->motor_bantu) . ' L' : '—' }}</td>
                                        <td class="text-end text-muted" style="font-size: 0.72rem;">{{ $fo->lain_lain > 0 ? number_format($fo->lain_lain) . ' L' : '—' }}</td>
                                        <!-- Total Penggunaan (Manual) -->
                                        <td class="text-end fw-semibold text-dark" style="font-size: 0.72rem;">
                                            {{ number_format($total_penggunaan) }} L
                                        </td>
                                        <!-- Sisa Sekarang (Manual) -->
                                        <td class="text-end @if($has_discrepancy_sisa) bg-danger-subtle text-danger fw-bold @endif" style="font-size: 0.72rem;">
                                            {{ number_format($fo->sisa_sekarang ?: 0) }} L
                                        </td>
                                        <!-- Ditambah (Manual) -->
                                        <td class="text-end text-muted" style="font-size: 0.72rem;">
                                            {{ number_format($fo->ditambah ?: 0) }} L
                                        </td>
                                        <!-- Jumlah Sekarang (Manual) -->
                                        <td class="text-end @if($has_discrepancy_jumlah) bg-danger-subtle text-danger fw-bold @endif" style="font-size: 0.72rem;">
                                            {{ number_format($fo->jumlah_sekarang ?: 0) }} L
                                        </td>

                                        <!-- SYSTEM COLUMNS -->
                                        <!-- Sisa Kemarin (Sistem) -->
                                        <td class="text-end bg-success-subtle text-success fw-semibold" style="font-size: 0.72rem;">
                                            {{ number_format($sys_kemarin) }} L
                                        </td>
                                        <!-- Total Penggunaan (Sistem) -->
                                        <td class="text-end bg-success-subtle text-success fw-semibold" style="font-size: 0.72rem;">
                                            {{ number_format($sys_penggunaan) }} L
                                        </td>
                                        <!-- Sisa Sekarang (Sistem) -->
                                        <td class="text-end bg-success-subtle @if($has_discrepancy_sisa) text-danger fw-bold @else text-success fw-semibold @endif" style="font-size: 0.72rem;">
                                            {{ number_format($sys_sisa_sekarang) }} L
                                            @if($has_discrepancy_sisa)
                                                <i class="bi bi-exclamation-circle-fill ms-1" style="font-size: 0.75rem;"></i>
                                            @endif
                                        </td>
                                        <!-- Ditambah (Sistem) -->
                                        <td class="text-end bg-success-subtle text-success fw-semibold" style="font-size: 0.72rem;">
                                            {{ number_format($fo->ditambah ?: 0) }} L
                                        </td>
                                        <!-- Jumlah Sekarang (Sistem) -->
                                        <td class="text-end bg-success-subtle @if($has_discrepancy_jumlah) text-danger fw-bold @else text-success fw-semibold @endif" style="font-size: 0.72rem;">
                                            {{ number_format($sys_jumlah_sekarang) }} L
                                            @if($has_discrepancy_jumlah)
                                                <i class="bi bi-exclamation-circle-fill ms-1" style="font-size: 0.75rem;"></i>
                                            @endif
                                        </td>

                                        @php
                                            // Update sys_kemarin for next iterations
                                            $sys_kemarin = $sys_jumlah_sekarang;
                                        @endphp
                                    @else
                                        <td colspan="13" class="text-center text-muted py-2 bg-light small"><em>Belum mengisi logbook</em></td>
                                    @endif
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection
