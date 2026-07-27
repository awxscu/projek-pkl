@extends('layouts.dashboard')

@section('title', 'Jadwal Perjalanan')
@section('navbar') @include('partials.navbar-awak') @endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
    <div>
        <h4><i class="bi bi-calendar-event me-2 text-pertamina-blue"></i>Jadwal Perjalanan Kapal</h4>
        <p>Kelola rute pelayaran aktif dan status pengisian logbook harian</p>
    </div>
    <div class="d-flex gap-2 align-items-center">
        <a href="{{ route('perjalanan.create') }}" class="btn btn-pertamina px-3 py-2 fw-semibold d-inline-flex align-items-center" style="font-size: 0.85rem; border-radius: 8px; height: 38px;"><i class="bi bi-plus-lg me-1"></i>Tambah Jadwal</a>
        <span class="badge bg-pertamina-blue px-3 py-2 d-inline-flex align-items-center fw-semibold" style="font-size: 0.85rem; border-radius: 8px; height: 38px;"><i class="bi bi-ship me-1"></i> Kapal Aktif: {{ $vessel->nama_kapal }} ({{ $vessel->kode_vessel }})</span>
    </div>
</div>

<!-- INFO STRIP -->
<div class="row g-3 mb-4">
    <div class="col-md-6 col-lg-3">
        <div class="card-modern stat-card">
            <div class="stat-label">Total Pelayaran</div>
            <div class="stat-value">{{ $perjalanan->count() }}</div>
            <small class="text-muted">Total penugasan</small>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card-modern stat-card stat-green">
            <div class="stat-label">Selesai</div>
            <div class="stat-value">{{ $perjalanan->where('statusPerjalanan.nama_status', 'Selesai')->count() }}</div>
            <small class="text-muted">Pelayaran selesai</small>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card-modern stat-card stat-blue">
            <div class="stat-label">Berlangsung</div>
            <div class="stat-value">{{ $perjalanan->where('statusPerjalanan.nama_status', 'Berlangsung')->count() }}</div>
            <small class="text-muted">Pelayaran aktif</small>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card-modern stat-card stat-yellow">
            <div class="stat-label">Terjadwal</div>
            <div class="stat-value">{{ $perjalanan->where('statusPerjalanan.nama_status', 'Terjadwal')->count() }}</div>
            <small class="text-muted">Pelayaran mendatang</small>
        </div>
    </div>
</div>

<!-- SCHEDULE TABLE -->
<div class="card-modern">
    <div class="p-3 border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h6 class="mb-0 fw-bold">Jadwal Penugasan Pelayaran</h6>
        <div class="d-flex gap-2">
            <select class="form-select form-select-sm" style="width: auto;">
                <option value="">Semua Status</option>
                <option>Berlangsung</option>
                <option>Selesai</option>
            </select>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-modern">
            <thead>
                <tr>
                    <th>Rute Pelayaran</th>
                    <th>Pelabuhan Asal</th>
                    <th>Pelabuhan Tujuan</th>
                    <th>Jadwal Berangkat</th>
                    <th>Jadwal Kedatangan</th>
                    <th>Status</th>
                    <th style="width: 160px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody id="voyageTableBody">
                @forelse ($perjalanan as $voyage)
                    @php
                        $statusText = $voyage->statusPerjalanan ? $voyage->statusPerjalanan->nama_status : 'Terjadwal';
                        if ($statusText === 'Berlangsung') {
                            $statusBadge = '<span class="badge" style="background:#dbeafe;color:#1d4ed8"><i class="bi bi-arrow-right-circle-fill me-1"></i>Berlangsung</span>';
                            $actionBtn = '<a href="' . route('logbook.create', ['voyage_id' => $voyage->id_perjalanan]) . '" class="btn btn-sm btn-pertamina btn-action-table"><i class="bi bi-pencil-square me-1"></i>Tulis Logbook</a>';
                        } elseif ($statusText === 'Terjadwal') {
                            $statusBadge = '<span class="badge badge-pending"><i class="bi bi-calendar-check-fill me-1"></i>Terjadwal</span>';
                            $actionBtn = '<button class="btn btn-sm btn-outline-secondary btn-action-table" disabled><i class="bi bi-lock-fill"></i> Logbook</button>';
                        } elseif ($statusText === 'Selesai') {
                            $statusBadge = '<span class="badge badge-verified"><i class="bi bi-check-circle-fill me-1"></i>Selesai</span>';
                            $actionBtn = '<a href="' . route('awak.riwayat') . '" class="btn btn-sm btn-outline-primary btn-action-table"><i class="bi bi-eye-fill"></i> Lihat Log</a>';
                        } else {
                            $statusBadge = '<span class="badge badge-empty"><i class="bi bi-x-circle-fill me-1"></i>Batal</span>';
                            $actionBtn = '<button class="btn btn-sm btn-light text-danger btn-action-table" disabled><i class="bi bi-x-circle me-1"></i>Dibatalkan</button>';
                        }
                    @endphp
                    <tr data-status="{{ $statusText }}">
                        <td>
                            <strong>{{ $voyage->pelabuhanAsal->nama_pelabuhan }} &rarr; {{ $voyage->pelabuhanTujuan->nama_pelabuhan }}</strong><br>
                            <span class="text-muted small d-block"><i class="bi bi-ship me-1"></i>{{ $voyage->kapal->nama_kapal }} ({{ $voyage->kode_vessel }})</span>
                        </td>
                        <td>{{ $voyage->pelabuhanAsal->nama_pelabuhan }}</td>
                        <td>{{ $voyage->pelabuhanTujuan->nama_pelabuhan }}</td>
                        <td>{{ $voyage->jadwal_berangkat->format('d/m/Y') }}</td>
                        <td>{{ $voyage->jadwal_tiba->format('d/m/Y') }}</td>
                        <td>{!! $statusBadge !!}</td>
                        <td class="text-center">{!! $actionBtn !!}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Belum ada penugasan pelayaran.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter handling
    const selectFilter = document.querySelector('.form-select');
    if (selectFilter) {
        selectFilter.addEventListener('change', function() {
            const filterVal = this.value;
            document.querySelectorAll('#voyageTableBody tr').forEach(row => {
                const status = row.getAttribute('data-status');
                if (!filterVal || status === filterVal) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
});
</script>
@endpush
@endsection
