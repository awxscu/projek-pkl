@extends('layouts.app')

@section('title', 'Login - Logbook Kapal Pertamina')
@section('body-class', '')

@section('content')
<div class="login-page">
    <div class="login-body">
        <div class="login-card">
            <div class="login-logo" style="margin-bottom: 2rem;">
                @include('partials.logo', ['href' => '#', 'size' => 'logo-xl'])
            </div>

            <form id="loginForm">
                <div class="mb-3">
                    <label class="form-label"><i class="bi bi-envelope me-1"></i> Email</label>
                    <input type="email" class="form-control" id="email" placeholder="nama@pertamina.com" required>
                </div>
                <div class="mb-3">
                    <label class="form-label"><i class="bi bi-lock me-1"></i> Password</label>
                    <input type="password" class="form-control" id="password" placeholder="Masukkan password" required>
                </div>
                <div class="mb-4">
                    <label class="form-label"><i class="bi bi-person-badge me-1"></i> Role</label>
                    <select class="form-select" id="role" required>
                        <option value="" disabled selected>Pilih role</option>
                        <option value="pertamina">Pertamina</option>
                        <option value="awak">Awak Kapal</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-pertamina w-100 py-2 mb-3">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                </button>
                <div class="text-center">
                    <a href="{{ route('landing') }}" class="text-decoration-none text-pertamina-blue small">
                        <i class="bi bi-arrow-left me-1"></i>Kembali ke halaman utama
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('loginForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const role = document.getElementById('role').value;
        window.location.href = role === 'pertamina'
            ? '{{ route("dashboard.pertamina") }}'
            : '{{ route("dashboard.awak") }}';
    });
</script>
@endpush
