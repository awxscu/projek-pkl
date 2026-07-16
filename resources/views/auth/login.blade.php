@extends('layouts.app')

@push('styles')
<style>
    /* Force login page background to soft light grey */
    .login-page {
        background: #f1f5f9 !important;
    }
    
    /* Make login card stand out with a beautiful premium shadow and border */
    .login-card {
        border: 1px solid #edf2f7;
        box-shadow: 0 20px 50px rgba(15, 23, 42, 0.08), 0 4px 15px rgba(0, 0, 0, 0.03) !important;
        transition: all 0.3s ease;
    }
    .login-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 25px 60px rgba(15, 23, 42, 0.12), 0 4px 20px rgba(0, 0, 0, 0.04) !important;
    }
    
    /* Enlarge logo on the login page */
    .logo-pertamina.logo-xl img {
        height: 125px !important; /* Enlarged from 96px */
    }
</style>
@endpush

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
