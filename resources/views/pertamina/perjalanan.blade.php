@extends('layouts.dashboard')

@section('title', 'Jadwal Perjalanan')
@section('navbar') @include('partials.navbar-pertamina') @endsection

@section('content')
<div class="page-header">
    <h4><i class="bi bi-signpost-split me-2 text-pertamina-blue"></i>Jadwal Perjalanan Kapal</h4>
    <p>Monitoring jadwal perjalanan seluruh kapal penumpang</p>
</div>

<div class="card-modern filter-card">
    <form class="row g-3 align-items-end">
        <div class="col-md-4">
            <label class="form-label">Kapal</label>
            <select class="form-select" id="filter_kapal">
                <option value="">Semua Kapal</option>
                <option>KM Nusantara Jaya</option>
                <option>KM Samudra Indah</option>
                <option>KM Pelangi Nusantara</option>
                <option>KM Bahari Sejahtera</option>
                <option>KM Citra Lautan</option>
                <option>KM Lautan Biru</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Status</label>
            <select class="form-select" id="filter_status">
                <option value="">Semua</option>
                <option>Terjadwal</option>
                <option>Berlangsung</option>
                <option>Selesai</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Tanggal</label>
            <input type="date" class="form-control" id="filter_tanggal" value="2026-07-14">
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-pertamina w-100" id="btn_filter_perjalanan"><i class="bi bi-search me-1"></i>Filter</button>
        </div>
    </form>
</div>

<div class="card-modern">
    <div class="table-responsive">
        <table class="table table-modern">
            <thead>
                <tr>
                    <th>Kapal</th>
                    <th>Vessel Code</th>
                    <th>Pelabuhan Asal</th>
                    <th>Pelabuhan Tujuan</th>
                    <th>Berangkat</th>
                    <th>Tiba</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>KM Nusantara Jaya</td>
                    <td>VSL-001</td>
                    <td>Surabaya</td>
                    <td>Balikpapan</td>
                    <td>14/07/2026</td>
                    <td>15/07/2026</td>
                    <td><span class="badge" style="background:#dbeafe;color:#1d4ed8">Berlangsung</span></td>
                </tr>
                <tr>
                    <td>KM Samudra Indah</td>
                    <td>VSL-002</td>
                    <td>Jakarta</td>
                    <td>Semarang</td>
                    <td>14/07/2026</td>
                    <td>14/07/2026</td>
                    <td><span class="badge" style="background:#dbeafe;color:#1d4ed8">Berlangsung</span></td>
                </tr>
                <tr>
                    <td>KM Pelangi Nusantara</td>
                    <td>VSL-003</td>
                    <td>Makassar</td>
                    <td>Baubau</td>
                    <td>16/07/2026</td>
                    <td>17/07/2026</td>
                    <td><span class="badge badge-pending">Terjadwal</span></td>
                </tr>
                <tr>
                    <td>KM Bahari Sejahtera</td>
                    <td>VSL-004</td>
                    <td>Denpasar</td>
                    <td>Lombok</td>
                    <td>13/07/2026</td>
                    <td>13/07/2026</td>
                    <td><span class="badge badge-verified">Selesai</span></td>
                </tr>
                <tr>
                    <td>KM Citra Lautan</td>
                    <td>VSL-005</td>
                    <td>Pontianak</td>
                    <td>Ketapang</td>
                    <td>15/07/2026</td>
                    <td>15/07/2026</td>
                    <td><span class="badge badge-pending">Terjadwal</span></td>
                </tr>
                <tr>
                    <td>KM Lautan Biru</td>
                    <td>VSL-006</td>
                    <td>Balikpapan</td>
                    <td>Tarakan</td>
                    <td>12/07/2026</td>
                    <td>13/07/2026</td>
                    <td><span class="badge badge-verified">Selesai</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnFilter = document.getElementById('btn_filter_perjalanan');
        if (btnFilter) {
            btnFilter.addEventListener('click', function() {
                const kapalVal = document.getElementById('filter_kapal').value.toLowerCase().trim();
                const statusVal = document.getElementById('filter_status').value.toLowerCase().trim();
                const tanggalVal = document.getElementById('filter_tanggal').value;
                
                let formattedTanggal = '';
                if (tanggalVal) {
                    const parts = tanggalVal.split('-');
                    if (parts.length === 3) {
                        formattedTanggal = `${parts[2]}/${parts[1]}/${parts[0]}`;
                    }
                }

                document.querySelectorAll('tbody tr').forEach(row => {
                    const kapalCell = row.cells[0];
                    const kapalText = kapalCell ? kapalCell.textContent.toLowerCase() : '';
                    
                    const berangkatCell = row.cells[4];
                    const berangkatText = berangkatCell ? berangkatCell.textContent.trim() : '';

                    const tibaCell = row.cells[5];
                    const tibaText = tibaCell ? tibaCell.textContent.trim() : '';
                    
                    const statusCell = row.cells[6];
                    const statusText = statusCell ? statusCell.textContent.toLowerCase().trim() : '';

                    let visible = true;
                    if (kapalVal && !kapalText.includes(kapalVal)) visible = false;
                    if (statusVal && statusText !== statusVal) visible = false;
                    if (formattedTanggal && berangkatText !== formattedTanggal && tibaText !== formattedTanggal) visible = false;

                    row.style.display = visible ? '' : 'none';
                });
            });
        }
    });
</script>
@endpush
