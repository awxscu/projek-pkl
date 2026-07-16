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
        <span class="badge bg-pertamina-blue px-3 py-2 d-inline-flex align-items-center fw-semibold" style="font-size: 0.85rem; border-radius: 8px; height: 38px;"><i class="bi bi-ship me-1"></i> Kapal Aktif: KM Nusantara Jaya</span>
    </div>
</div>

<!-- INFO STRIP -->
<div class="row g-3 mb-4">
    <div class="col-md-6 col-lg-3">
        <div class="card-modern stat-card">
            <div class="stat-label">Total Pelayaran</div>
            <div class="stat-value">24</div>
            <small class="text-muted">Tahun 2026</small>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card-modern stat-card stat-green">
            <div class="stat-label">Selesai</div>
            <div class="stat-value">18</div>
            <small class="text-muted">Tepat waktu</small>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card-modern stat-card stat-blue">
            <div class="stat-label">Berlangsung</div>
            <div class="stat-value">1</div>
            <small class="text-muted">Rute Surabaya → Balikpapan</small>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card-modern stat-card stat-yellow">
            <div class="stat-label">Terjadwal</div>
            <div class="stat-value">4</div>
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
                <option>Terjadwal</option>
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
                <!-- Dynamically loaded from localStorage -->
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Default voyages data
    const defaultVoyages = [
        {
            no_surat_jalan: "SPK-2026-0045",
            rute: "Surabaya &rarr; Balikpapan",
            asal: "Tanjung Perak (SUB)",
            tujuan: "Semayang (BPN)",
            mulai: "2026-07-14",
            selesai: "2026-07-15",
            status: "Berlangsung"
        },
        {
            no_surat_jalan: "SPK-2026-0044",
            rute: "Balikpapan &rarr; Surabaya",
            asal: "Semayang (BPN)",
            tujuan: "Tanjung Perak (SUB)",
            mulai: "2026-07-17",
            selesai: "2026-07-18",
            status: "Terjadwal"
        },
        {
            no_surat_jalan: "SPK-2026-0043",
            rute: "Surabaya &rarr; Makassar",
            asal: "Tanjung Perak (SUB)",
            tujuan: "Soekarno-Hatta (MAK)",
            mulai: "2026-07-20",
            selesai: "2026-07-21",
            status: "Terjadwal"
        },
        {
            no_surat_jalan: "SPK-2026-0042",
            rute: "Balikpapan &rarr; Surabaya",
            asal: "Semayang (BPN)",
            tujuan: "Tanjung Perak (SUB)",
            mulai: "2026-07-12",
            selesai: "2026-07-13",
            status: "Selesai"
        },
        {
            no_surat_jalan: "SPK-2026-0041",
            rute: "Surabaya &rarr; Balikpapan",
            asal: "Tanjung Perak (SUB)",
            tujuan: "Semayang (BPN)",
            mulai: "2026-07-10",
            selesai: "2026-07-11",
            status: "Selesai"
        },
        {
            no_surat_jalan: "SPK-2026-0040",
            rute: "Surabaya &rarr; Banjarmasin",
            asal: "Tanjung Perak (SUB)",
            tujuan: "Trisakti (BDJ)",
            mulai: "2026-07-08",
            selesai: "2026-07-09",
            status: "Selesai"
        }
    ];

    // Check if voyages in localStorage
    let voyages = localStorage.getItem('voyages');
    if (!voyages) {
        localStorage.setItem('voyages', JSON.stringify(defaultVoyages));
        voyages = defaultVoyages;
    } else {
        voyages = JSON.parse(voyages);
    }

    const tbody = document.getElementById('voyageTableBody');
    tbody.innerHTML = '';

    function formatDate(dateStr) {
        if (!dateStr) return '';
        if (dateStr.indexOf('/') !== -1) return dateStr; // already formatted
        const parts = dateStr.split('-');
        if (parts.length === 3) {
            return `${parts[2]}/${parts[1]}/${parts[0]}`;
        }
        return dateStr;
    }

    // Render each voyage
    voyages.forEach(voyage => {
        let statusBadge = '';
        let actionBtn = '';

        if (voyage.status === 'Berlangsung') {
            statusBadge = `<span class="badge" style="background:#dbeafe;color:#1d4ed8"><i class="bi bi-arrow-right-circle-fill me-1"></i>Berlangsung</span>`;
            actionBtn = `<a href="{{ route('logbook.create') }}" class="btn btn-sm btn-pertamina btn-action-table"><i class="bi bi-pencil-square me-1"></i>Tulis Logbook</a>`;
        } else if (voyage.status === 'Terjadwal') {
            statusBadge = `<span class="badge badge-pending"><i class="bi bi-calendar-check-fill me-1"></i>Terjadwal</span>`;
            actionBtn = `<button class="btn btn-sm btn-outline-secondary btn-action-table" disabled><i class="bi bi-lock-fill"></i> Logbook</button>`;
        } else if (voyage.status === 'Selesai') {
            statusBadge = `<span class="badge badge-verified"><i class="bi bi-check-circle-fill me-1"></i>Selesai</span>`;
            actionBtn = `<a href="{{ route('awak.riwayat') }}" class="btn btn-sm btn-outline-primary btn-action-table"><i class="bi bi-eye-fill"></i> Lihat Log</a>`;
        } else {
            // Batal
            statusBadge = `<span class="badge badge-empty"><i class="bi bi-x-circle-fill me-1"></i>Batal</span>`;
            actionBtn = `<button class="btn btn-sm btn-light text-danger btn-action-table" disabled><i class="bi bi-x-circle me-1"></i>Dibatalkan</button>`;
        }

        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>
                <strong>${voyage.rute}</strong><br>
                <small class="text-muted"><i class="bi bi-file-earmark-text me-1"></i>No. Surat Jalan: ${voyage.no_surat_jalan || '—'}</small>
            </td>
            <td>${voyage.asal}</td>
            <td>${voyage.tujuan}</td>
            <td>${formatDate(voyage.mulai)}</td>
            <td>${formatDate(voyage.selesai)}</td>
            <td>${statusBadge}</td>
            <td class="text-center">${actionBtn}</td>
        `;
        tbody.appendChild(tr);
    });

    // Filter handling
    const selectFilter = document.querySelector('.form-select');
    if (selectFilter) {
        selectFilter.addEventListener('change', function() {
            const filterVal = this.value;
            const rows = tbody.querySelectorAll('tr');
            rows.forEach((row, index) => {
                const voyage = voyages[index];
                if (!filterVal || voyage.status === filterVal) {
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
