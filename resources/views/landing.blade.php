@extends('layouts.app')

@section('title', 'Sistem Monitoring Logbook Kapal - Pertamina Patra Niaga')
@section('body-class', 'landing-page-scroll')

@section('content')
<!-- LOGO POSITIONED TOP-RIGHT absolutely, since the navbar is removed -->
<div class="landing-logo-top" style="position: absolute; top: 2rem; right: 2rem; z-index: 10; background: rgba(255, 255, 255, 0.95); padding: 0.75rem 1.5rem; border-radius: 16px; box-shadow: var(--shadow-md);">
    @include('partials.logo', ['href' => route('landing')])
</div>

<!-- HERO SECTION -->
<section class="hero-section" style="position: relative; min-height: 100vh; display: flex; align-items: center; overflow: hidden;">
    <div id="heroCarousel" class="carousel slide hero-carousel carousel-fade" data-bs-ride="carousel" data-bs-interval="5000" style="position: absolute; inset: 0; z-index: 0;">
        <div class="carousel-inner" style="height: 100vh;">
            <div class="carousel-item active" style="height: 100vh;">
                <img src="https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=1920&q=80" alt="Kapal penumpang" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            <div class="carousel-item" style="height: 100vh;">
                <img src="https://images.unsplash.com/photo-1569263979104-865ab7cd8d13?w=1920&q=80" alt="Kapal laut" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            <div class="carousel-item" style="height: 100vh;">
                <img src="https://images.unsplash.com/photo-1494412519320-aa4fbab0a6e5?w=1920&q=80" alt="Pelabuhan kapal" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            <div class="carousel-item" style="height: 100vh;">
                <img src="https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=1920&q=80" alt="Operasi kapal" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
        </div>
    </div>
    <div class="hero-overlay" style="position: absolute; inset: 0; z-index: 1; background: linear-gradient(135deg, rgba(0,87,184,0.8) 0%, rgba(15,23,42,0.85) 50%, rgba(227,30,36,0.65) 100%);"></div>
    <div class="container hero-content" style="position: relative; z-index: 2; color: #fff;">
        <div class="row">
            <div class="col-lg-9">
                <span class="badge bg-white text-pertamina-blue mb-3 px-3 py-2 fw-bold" style="border-radius: 30px;">
                    <i class="bi bg-pertamina-red text-white p-1 rounded-circle bi-shield-check me-1"></i> Pertamina Patra Niaga
                </span>
                <h1 class="hero-title fw-bold text-white mb-3" style="font-family: 'Poppins', sans-serif; font-size: clamp(1.8rem, 4.5vw, 3rem); line-height: 1.2;">
                    Sistem Monitoring dan Pengelolaan Logbook Kapal
                </h1>
                <p class="hero-subtitle mb-4 text-white-50" style="font-size: clamp(0.95rem, 2vw, 1.15rem); max-width: 650px;">
                    Digitalisasi pencatatan konsumsi BBM kapal untuk monitoring operasional yang lebih efektif
                </p>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('login') }}" class="btn btn-gradient-pertamina btn-lg"><i class="bi bi-box-arrow-in-right me-2"></i>Masuk ke Sistem</a>
                    <a href="#fitur" class="btn btn-light btn-lg text-pertamina-blue"><i class="bi bi-info-circle me-2"></i>Pelajari Sistem</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FEATURES SECTION -->
<section class="features-section py-5" id="fitur" style="background: #fff;">
    <div class="container py-4">
        <div class="text-center mb-5">
            <h2 class="section-title fw-bold text-pertamina-blue mb-2">Fitur Sistem</h2>
            <p class="section-subtitle text-muted">Solusi digital untuk pengawasan aktivitas kapal penumpang</p>
        </div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="card-modern feature-card text-center p-4">
                    <div class="feature-icon mx-auto mb-3" style="width:68px; height:68px; border-radius:50%; background:linear-gradient(135deg, var(--pertamina-blue), var(--pertamina-blue-dark)); color:#fff; display:flex; align-items:center; justify-content:center; font-size:1.6rem;"><i class="bi bi-journal-text"></i></div>
                    <h5 class="fw-bold mb-2">Digital Logbook</h5>
                    <p class="text-muted small mb-0">Input konsumsi BBM kapal secara digital</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card-modern feature-card text-center p-4">
                    <div class="feature-icon mx-auto mb-3" style="width:68px; height:68px; border-radius:50%; background:linear-gradient(135deg, var(--pertamina-red), #c4191f); color:#fff; display:flex; align-items:center; justify-content:center; font-size:1.6rem;"><i class="bi bi-broadcast"></i></div>
                    <h5 class="fw-bold mb-2">Real-time Monitoring</h5>
                    <p class="text-muted small mb-0">Pertamina dapat memantau aktivitas kapal</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card-modern feature-card text-center p-4">
                    <div class="feature-icon mx-auto mb-3" style="width:68px; height:68px; border-radius:50%; background:linear-gradient(135deg, var(--pertamina-blue), var(--pertamina-blue-dark)); color:#fff; display:flex; align-items:center; justify-content:center; font-size:1.6rem;"><i class="bi bi-fuel-pump"></i></div>
                    <h5 class="fw-bold mb-2">Fuel Management</h5>
                    <p class="text-muted small mb-0">Monitoring konsumsi dan stok bahan bakar</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card-modern feature-card text-center p-4">
                    <div class="feature-icon mx-auto mb-3" style="width:68px; height:68px; border-radius:50%; background:linear-gradient(135deg, var(--pertamina-red), #c4191f); color:#fff; display:flex; align-items:center; justify-content:center; font-size:1.6rem;"><i class="bi bi-file-earmark-bar-graph"></i></div>
                    <h5 class="fw-bold mb-2">Reporting</h5>
                    <p class="text-muted small mb-0">Laporan operasional kapal</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ABOUT STRIP -->
<section class="about-strip py-5 text-white" id="tentang" style="background: linear-gradient(90deg, var(--pertamina-blue), var(--pertamina-red));">
    <div class="container py-3">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h3 class="fw-bold mb-2">Mengatasi Permasalahan Logbook Manual</h3>
                <p class="mb-0 opacity-90">Sistem ini mendigitalisasi logbook pemakaian BBM kapal penumpang, memungkinkan Pertamina memonitor aktivitas kapal secara real-time, menyediakan laporan konsumsi, dan menyimpan histori penggunaan BBM untuk analisis operasional.</p>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <a href="{{ route('login') }}" class="btn btn-light btn-lg text-pertamina-blue fw-bold"><i class="bi bi-rocket-takeoff me-2"></i>Mulai Sekarang</a>
            </div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="footer-landing py-5 text-muted" style="background: #0f172a;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 mb-3 mb-md-0 d-flex align-items-center gap-3">
                @include('partials.logo', ['href' => route('landing'), 'size' => 'logo-lg'])
                <div>
                    <p class="mb-0 small text-white-50">Sistem Monitoring dan Pengelolaan Logbook Kapal Berbasis Web</p>
                </div>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="{{ route('login') }}" class="me-3 text-muted text-decoration-none">Login</a>
                <a href="#fitur" class="me-3 text-muted text-decoration-none">Fitur</a>
                <a href="#tentang" class="text-muted text-decoration-none">Tentang</a>
            </div>
        </div>
        <hr class="border-secondary my-4">
        <p class="text-center mb-0 small">&copy; {{ date('Y') }} PT Pertamina Patra Niaga. All rights reserved.</p>
    </div>
</footer>
@endsection
