@extends('layouts.app')

@section('title', 'Sistem Monitoring Logbook Kapal - Pertamina Patra Niaga')
@section('body-class', 'landing-page-scroll')

@section('content')
<div class="landing-logo-top">
    @include('partials.logo', ['href' => route('landing'), 'size' => 'logo-xl'])
</div>

<!-- HERO SECTION -->
<section class="hero-section" style="position: relative; min-height: 100vh; display: flex; align-items: center; overflow: hidden;">
    <div id="heroCarousel" class="carousel slide hero-carousel carousel-fade" data-bs-ride="carousel" data-bs-interval="5000" style="position: absolute; inset: 0; z-index: 0;">
        <div class="carousel-inner" style="height: 100vh;">
            <div class="carousel-item active" style="height: 100vh;">
                <img src="https://pertaminapatraniaga.com/file/files/2026/07/pertamina-patra-niaga-datangkan-pertamina-gas-1-bawa-45-9-ribu-metrik-ton-lpg-2.webp" alt="Kapal penumpang" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            <div class="carousel-item" style="height: 100vh;">
                <img src="https://pertaminapatraniaga.com/file/files/2026/06/img-20260619-wa0005.webp" alt="Kapal laut" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            <div class="carousel-item" style="height: 100vh;">
                <img src="https://cdn-jjmn.jawapos.com/images/16/2024/12/14/1000451803-1104496190.jpg" alt="Pelabuhan kapal" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            <div class="carousel-item" style="height: 100vh;">
                <img src="https://pertaminapatraniaga.com/file/files/2026/06/img-20260619-wa0008.webp" alt="Operasi kapal" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
        </div>
    </div>
    <div class="hero-overlay" style="position: absolute; inset: 0; z-index: 1; background: linear-gradient(90deg, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.5) 40%, rgba(0,0,0,0.15) 70%, rgba(0,0,0,0) 100%);"></div>
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
                <div class="d-flex flex-wrap gap-3 mt-2">
                    <a href="{{ route('login') }}" class="btn-gradient-pertamina text-decoration-none d-inline-flex align-items-center justify-content-center"><i class="bi bi-box-arrow-in-right me-2"></i>Masuk ke Sistem</a>
                    <a href="#fitur" class="btn-outline-pertamina-white"><i class="bi bi-info-circle me-2"></i>Pelajari Sistem</a>
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
<section class="about-strip py-5 text-white" id="tentang" style="background: linear-gradient(135deg, #001f3f 0%, #0057B8 50%, #3b82f6 100%);">
    <div class="container py-3">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h3 class="fw-bold mb-2"style="color: #ffffff;">Mengatasi Permasalahan Logbook Manual</h3>
                <p class="mb-0 opacity-90">Sistem ini mendigitalisasi logbook pemakaian BBM kapal penumpang, memungkinkan Pertamina memonitor aktivitas kapal secara real-time, menyediakan laporan konsumsi, dan menyimpan histori penggunaan BBM untuk analisis operasional.</p>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <a href="{{ route('login') }}" class="btn btn-light btn-lg text-pertamina-blue fw-bold"><i class="bi bi-rocket-takeoff me-2"></i>Mulai Sekarang</a>
            </div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="footer-landing py-5 text-white" style="background: #002347; font-size: 0.85rem; line-height: 1.6;">
    <div class="container">
        <div class="row g-4 mb-5">
            <!-- Col 1: Logo & Contact Info -->
            <div class="col-lg-4 col-md-6">
                <div class="mb-3" style="filter: brightness(0) invert(1); display: inline-block;">
                    @include('partials.logo', ['size' => 'logo-lg'])
                </div>
                <p class="mb-4 text-white-50" style="font-size: 0.82rem; max-width: 320px;">
                    Gedung Wisma Tugu II Lt. 2Jl. HR. Rasuna Said Kav. C7-9 Setiabudi, Kuningan, Jakarta Selatan
                </p>
                <p class="mb-1 text-white-50" style="font-size: 0.82rem;">Telepon: 135</p>
                <p class="mb-4 text-white-50" style="font-size: 0.82rem;">Email: <a href="mailto:pcc135@pertamina.com" class="text-white-50 text-decoration-none">pcc135@pertamina.com</a></p>
                <div class="d-flex gap-3 fs-5">
                    <a href="#" class="text-white opacity-75 hover-opacity-100"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="text-white opacity-75 hover-opacity-100"><i class="bi bi-tiktok"></i></a>
                    <a href="#" class="text-white opacity-75 hover-opacity-100"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="text-white opacity-75 hover-opacity-100"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="text-white opacity-75 hover-opacity-100"><i class="bi bi-youtube"></i></a>
                </div>
            </div>
            
            <!-- Col 2: Tautan -->
            <div class="col-lg-2 col-md-6">
                <h6 class="fw-bold mb-3" style="color: #fff; font-size: 0.95rem;">Tautan</h6>
                <ul class="list-unstyled d-flex flex-column gap-2 text-white-50" style="font-size: 0.82rem;">
                    <li><a href="#" class="text-white-50 text-decoration-none hover-text-white">Promosi</a></li>
                    <li><a href="#" class="text-white-50 text-decoration-none hover-text-white">Pengadaan</a></li>
                    <li><a href="#" class="text-white-50 text-decoration-none hover-text-white">Subsidi Tepat</a></li>
                    <li><a href="#" class="text-white-50 text-decoration-none hover-text-white">Laporan Tahunan</a></li>
                    <li><a href="#" class="text-white-50 text-decoration-none hover-text-white">Keberlanjutan</a></li>
                </ul>
            </div>
            
            <!-- Col 3: Situs Terkait -->
            <div class="col-lg-3 col-md-6">
                <h6 class="fw-bold mb-3" style="color: #fff; font-size: 0.95rem;">Situs Terkait</h6>
                <ul class="list-unstyled d-flex flex-column gap-2 text-white-50" style="font-size: 0.82rem;">
                    <li><a href="#" class="text-white-50 text-decoration-none hover-text-white">Pertamina (Persero)</a></li>
                    <li><a href="#" class="text-white-50 text-decoration-none hover-text-white">MyPertamina</a></li>
                    <li><a href="#" class="text-white-50 text-decoration-none hover-text-white">Pertamina Delivery Service</a></li>
                    <li><a href="#" class="text-white-50 text-decoration-none hover-text-white">Pertamina Lubricants</a></li>
                    <li><a href="#" class="text-white-50 text-decoration-none hover-text-white">Pertamina Retail</a></li>
                    <li><a href="#" class="text-white-50 text-decoration-none hover-text-white">Pertamina Petrochemical Trading</a></li>
                </ul>
            </div>
            
            <!-- Col 4: Situs Terkait (Cont.) & CC / WBS -->
            <div class="col-lg-3 col-md-6 d-flex flex-column justify-content-between">
                <ul class="list-unstyled d-flex flex-column gap-2 text-white-50 mb-4" style="font-size: 0.82rem; margin-top: 2.25rem;">
                    <li><a href="#" class="text-white-50 text-decoration-none hover-text-white">Pertamina Trading & Services</a></li>
                    <li><a href="#" class="text-white-50 text-decoration-none hover-text-white">Pertamina Maintenance & Construction</a></li>
                    <li><a href="#" class="text-white-50 text-decoration-none hover-text-white">Pertamina Patra Logistik</a></li>
                    <li><a href="#" class="text-white-50 text-decoration-none hover-text-white">Patra SK</a></li>
                    <li><a href="#" class="text-white-50 text-decoration-none hover-text-white">Pertamina International Timor SA</a></li>
                </ul>
                <div class="d-flex flex-column align-items-lg-end gap-3 mt-auto">
                    <!-- Call Center 135 Badge -->
                    <div class="px-3 py-2 bg-danger text-white fw-bold rounded-pill d-inline-flex align-items-center gap-2" style="font-size: 0.82rem; letter-spacing: 0.5px;">
                        <i class="bi bi-telephone-fill"></i> Call Center 135
                    </div>
                    <!-- Whistle Blowing System Pill -->
                    <a href="https://pertaminaclean.tipoffs.info/" class="d-flex align-items-center gap-2 px-3 py-2 text-decoration-none border border-white border-opacity-25" style="border-radius: 50px; background: rgba(255,255,255,0.05); color: #fff; max-width: 250px;">
                        <div class="bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; font-size: 0.9rem; flex-shrink: 0;">
                            <i class="bi bi-megaphone-fill"></i>
                        </div>
                        <div class="text-start">
                            <div class="fw-bold" style="font-size: 0.72rem; line-height: 1;">Whistle Blowing System</div>
                            <div style="font-size: 0.6rem; color: #cbd5e1;">pertaminaclean.tipoffs.info</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        
        <hr class="border-white border-opacity-20 my-4">
        
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <p class="mb-0 text-white-50" style="font-size: 0.78rem;">
                &copy; Copyright 2026 | Pertamina Patra Niaga. All Rights Reserved. <a href="#" class="text-white-50 text-decoration-none hover-text-white">Kebijakan Privasi</a>
            </p>
            <!-- Slogan Handwritten style -->
            <div class="text-white fw-bold fs-5" style="font-family: 'Georgia', serif; font-style: italic; letter-spacing: 0.5px;">
                Energizing Your Journey
            </div>
        </div>
    </div>
</footer>
@endsection
