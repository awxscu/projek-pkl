@extends('layouts.dashboard')

@section('title', 'Upload PDF Logbook')
@section('navbar') @include('partials.navbar-awak') @endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-start flex-wrap gap-2 mb-4">
    <div>
        <h4><i class="bi bi-file-earmark-pdf me-2 text-pertamina-blue"></i>Upload PDF Logbook</h4>
        <p class="text-muted mb-0 small">Unggah salinan dokumen PDF logbook resmi kapal Anda</p>
    </div>
    <button class="btn btn-pertamina btn-sm" data-bs-toggle="modal" data-bs-target="#uploadPdfModal">
        <i class="bi bi-upload me-1"></i>Unggah PDF Baru
    </button>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert" style="border-radius: 12px; border-left: 5px solid #198754;">
        <div class="d-flex align-items-center">
            <i class="bi bi-check-circle-fill text-success fs-5 me-2"></i>
            <div class="fw-semibold text-dark">{{ session('success') }}</div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert" style="border-radius: 12px; border-left: 5px solid #dc3545;">
        <div class="d-flex align-items-center">
            <i class="bi bi-exclamation-triangle-fill text-danger fs-5 me-2"></i>
            <div class="fw-semibold text-dark">{{ $errors->first() }}</div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- TABLE CARD -->
<div class="card-modern">
    <div class="table-responsive">
        <table class="table table-modern">
            <thead>
                <tr>
                    <th>Nama File</th>
                    <th>Nama Kapal</th>
                    <th>Bulan Logbook</th>
                    <th>Catatan</th>
                    <th>Tanggal Diunggah</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($dokumen as $dok)
                    <tr>
                        <td>
                            <a href="{{ asset($dok->file_path) }}" target="_blank" class="text-pertamina-blue fw-semibold text-decoration-none">
                                <i class="bi bi-filetype-pdf text-danger fs-5 me-2"></i>{{ $dok->nama_file_original }}
                            </a>
                        </td>
                        <td><i class="bi bi-ship me-1 text-muted"></i> {{ $dok->kapal->nama_kapal ?? '—' }} ({{ $dok->kode_vessel }})</td>
                        <td><i class="bi bi-calendar3 me-1 text-muted"></i> {{ \Carbon\Carbon::parse($dok->tanggal_logbook)->translatedFormat('F Y') }}</td>
                        <td><span class="text-muted" style="font-size: 0.85rem;">{{ $dok->catatan ?: '—' }}</span></td>
                        <td>{{ $dok->created_at->diffForHumans() }}</td>
                        <td class="text-center">
                            <form action="{{ route('awak.upload-pdf.delete', $dok->id_dokumen) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus file PDF logbook ini?');" style="display:inline-block;">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-xs" title="Hapus Dokumen" style="padding: 0.25rem 0.5rem; border-radius: 6px; font-size: 0.75rem;">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Belum ada dokumen PDF logbook yang diunggah.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- UPLOAD PDF MODAL -->
<div class="modal fade" id="uploadPdfModal" tabindex="-1" aria-labelledby="uploadPdfModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 20px; overflow: hidden;">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold text-pertamina-blue" id="uploadPdfModalLabel">
                    <i class="bi bi-upload me-2"></i>Unggah PDF Logbook
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('awak.upload-pdf.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <!-- PILIH KAPAL -->
                    <div class="mb-3">
                        <label for="kode_vessel" class="form-label fw-bold">Pilih Kapal</label>
                        <select name="kode_vessel" id="kode_vessel" class="form-select select2-vessel" required style="width:100%;">
                            <option value="">-- Pilih Kapal --</option>
                            @foreach ($vessels as $v)
                                <option value="{{ $v->kode_vessel }}">{{ $v->nama_kapal }} ({{ $v->kode_vessel }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- BULAN & TAHUN LOGBOOK -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="bulan_logbook" class="form-label fw-bold">Bulan Logbook</label>
                            <select name="bulan_logbook" id="bulan_logbook" class="form-select" required>
                                @php
                                    $months = [
                                        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                                    ];
                                    $currentMonth = date('n');
                                @endphp
                                @foreach ($months as $num => $name)
                                    <option value="{{ $num }}" {{ $currentMonth == $num ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="tahun_logbook" class="form-label fw-bold">Tahun Logbook</label>
                            <select name="tahun_logbook" id="tahun_logbook" class="form-select" required>
                                @php
                                    $currentYear = date('Y');
                                @endphp
                                @for ($y = 2024; $y <= 2028; $y++)
                                    <option value="{{ $y }}" {{ $currentYear == $y ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <!-- FILE PDF -->
                    <div class="mb-3">
                        <label for="pdf_file" class="form-label fw-bold">File PDF Logbook</label>
                        <input type="file" name="pdf_file" id="pdf_file" class="form-control" accept=".pdf" required>
                        <div class="form-text text-muted" style="font-size: 0.75rem;">Hanya file PDF dengan ukuran maksimal 20 MB.</div>
                    </div>

                    <!-- CATATAN -->
                    <div class="mb-3">
                        <label for="catatan" class="form-label fw-bold">Catatan (Opsional)</label>
                        <textarea name="catatan" id="catatan" class="form-control" rows="3" placeholder="Tambahkan catatan singkat mengenai dokumen logbook ini..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light px-4 py-3 d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-outline-secondary px-4 py-2 fw-semibold" style="font-size: 0.85rem; border-radius: 8px;" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-pertamina px-4 py-2 fw-semibold" style="font-size: 0.85rem; border-radius: 8px;">Unggah File</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container {
        width: 100% !important;
    }
    .select2-container--default .select2-selection--single {
        border: 1.5px solid var(--gray-border, #cbd5e1) !important;
        border-radius: 10px !important;
        height: auto !important;
        padding: 0.65rem 0.95rem !important;
        background-color: #fff !important;
        display: flex !important;
        align-items: center !important;
        position: relative !important;
        transition: all 0.2s !important;
    }
    .select2-container--default .select2-selection--single:focus,
    .select2-container--default.select2-container--focus .select2-selection--single {
        border-color: var(--pertamina-blue, #0057b8) !important;
        box-shadow: 0 0 0 4px rgba(0, 87, 184, 0.12) !important;
        outline: none !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #475569 !important;
        padding-left: 0 !important;
        padding-right: 20px !important;
        font-size: 0.92rem !important;
        line-height: normal !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__placeholder {
        color: #94a3b8 !important;
    }
    .select2-dropdown {
        border: 1.5px solid var(--gray-border, #cbd5e1) !important;
        border-radius: 10px !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08) !important;
        z-index: 99999 !important;
    }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        $('.select2-vessel').select2({
            dropdownParent: $('#uploadPdfModal'),
            placeholder: '-- Pilih Kapal --'
        });
    });
</script>
@endpush
