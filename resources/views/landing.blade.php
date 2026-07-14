@extends('layouts.app')

@section('title', 'Sistem Monitoring Logbook Kapal - Pertamina Patra Niaga')
@section('body-class', 'landing-page')

@section('content')
<nav class="navbar navbar-expand-lg navbar-landing" id="mainNavbar">
    <div class="container">
        <a class="system-title" href="{{ route('landing') }}">
            <i class="bi bi-journal-bookmark-fill"></i>
            Logbook Kapal
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navLanding">
            <i class="bi bi-list text-white" id="togglerIcon"></i>
        </button>
        <div class="collapse navbar-collapse" id="navLanding">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#tentang">Tentang Sistem</a></li>
                <li class="nav-item"><a class="nav-link" href="#fitur">Fitur</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
            </ul>
            <div class="ms-lg-3">
                @include('partials.logo', ['href' => route('landing')])
            </div>
        </div>
    </div>
</nav>

<section class="hero-section">
    <div id="heroCarousel" class="carousel slide hero-carousel carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=1920&q=80" alt="Kapal penumpang">
            </div>
            <div class="carousel-item">
                <img src="https://images.unsplash.com/photo-1569263979104-865ab7cd8d13?w=1920&q=80" alt="Kapal laut">
            </div>
            <div class="carousel-item">
                <img src="https://images.unsplash.com/photo-1494412519320-aa4fbab0a6e5?w=1920&q=80" alt="Pelabuhan kapal">
            </div>
            <div class="carousel-item">
                <img src="https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=1920&q=80" alt="Operasi kapal">
            </div>
        </div>
    </div>
    <div class="hero-overlay"></div>
    <div class="container hero-content">
        <div class="row">
            <div class="col-lg-9">
                <span class="badge bg-white text-pertamina-blue mb-3 px-3 py-2">
                    <i class="bi bi-shield-check me-1"></i> Pertamina Patra Niaga
                </span>
                <h1 class="hero-title">Sistem Monitoring dan Pengelolaan Logbook Kapal</h1>
                <p class="hero-subtitle">Digitalisasi pencatatan konsumsi BBM kapal untuk monitoring operasional yang lebih efektif</p>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('login') }}" class="btn btn-pertamina btn-lg"><i class="bi bi-box-arrow-in-right me-2"></i>Login</a>
                    <a href="#fitur" class="btn btn-light btn-lg"><i class="bi bi-info-circle me-2"></i>Pelajari Sistem</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="features-section" id="fitur">
    <div class="container">
        <div class="text-center">
            <h2 class="section-title">Fitur Sistem</h2>
            <p class="section-subtitle">Solusi digital untuk pengawasan aktivitas kapal penumpang</p>
        </div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="card-modern feature-card">
                    <div class="feature-icon"><i class="bi bi-journal-text"></i></div>
                    <h5>Digital Logbook</h5>
                    <p>Input konsumsi BBM kapal secara digital</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card-modern feature-card">
                    <div class="feature-icon" style="background:linear-gradient(135deg,#E31E24,#c4191f)"><i class="bi bi-broadcast"></i></div>
                    <h5>Real-time Monitoring</h5>
                    <p>Pertamina dapat memantau aktivitas kapal</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card-modern feature-card">
                    <div class="feature-icon"><i class="bi bi-fuel-pump"></i></div>
                    <h5>Fuel Management</h5>
                    <p>Monitoring konsumsi dan stok bahan bakar</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card-modern feature-card">
                    <div class="feature-icon" style="background:linear-gradient(135deg,#E31E24,#c4191f)"><i class="bi bi-file-earmark-bar-graph"></i></div>
                    <h5>Reporting</h5>
                    <p>Laporan operasional kapal</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="about-strip" id="tentang">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h3 class="fw-bold mb-2">Mengatasi Permasalahan Logbook Manual</h3>
                <p class="mb-0 opacity-90">Sistem ini mendigitalisasi logbook pemakaian BBM kapal penumpang, memungkinkan Pertamina memonitor aktivitas kapal secara real-time, menyediakan laporan konsumsi, dan menyimpan histori penggunaan BBM untuk analisis operasional.</p>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <a href="{{ route('login') }}" class="btn btn-light btn-lg"><i class="bi bi-rocket-takeoff me-2"></i>Mulai Sekarang</a>
            </div>
        </div>
    </div>
</section>

<footer class="footer-landing">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 mb-3 mb-md-0 d-flex align-items-center gap-3">
                @include('partials.logo', ['href' => route('landing'), 'size' => 'logo-lg'])
                <div>
                    <p class="mb-0 small">Sistem Monitoring dan Pengelolaan Logbook Kapal Berbasis Web</p>
                </div>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="{{ route('login') }}" class="me-3">Login</a>
                <a href="#fitur" class="me-3">Fitur</a>
                <a href="#tentang">Tentang</a>
            </div>
        </div>
        <hr class="border-secondary my-3">
        <p class="text-center mb-0 small">&copy; {{ date('Y') }} PT Pertamina Patra Niaga. All rights reserved.</p>
    </div>
</footer>
@endsection

@push('scripts')
<script>
    window.addEventListener('scroll', function () {
        const navbar = document.getElementById('mainNavbar');
        const toggler = document.getElementById('togglerIcon');
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
            if (toggler) toggler.classList.replace('text-white', 'text-pertamina-blue');
        } else {
            navbar.classList.remove('scrolled');
            if (toggler) toggler.classList.replace('text-pertamina-blue', 'text-white');
        }
    });
</script>
@endpush
