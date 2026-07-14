<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Logbook Kapal Pertamina</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="{{ asset('css/pertamina.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body class="dashboard-body">
    @yield('navbar')

    <main class="dashboard-content">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggle = document.getElementById('navToggle');
            const menu = document.getElementById('navMenu');
            if (toggle && menu) {
                toggle.addEventListener('click', () => menu.classList.toggle('show'));
            }

            // Handle global settings form submission
            const settingsForm = document.getElementById('settingsForm');
            if (settingsForm) {
                settingsForm.addEventListener('submit', function (e) {
                    e.preventDefault();
                    alert('Pengaturan akun berhasil disimpan!');
                    const modalEl = document.getElementById('settingsModal');
                    const modal = bootstrap.Modal.getInstance(modalEl);
                    if (modal) modal.hide();
                });
            }
        });
    </script>
    @stack('scripts')

    <!-- Settings Modal (Global) -->
    <div class="modal fade" id="settingsModal" tabindex="-1" aria-labelledby="settingsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 20px; overflow: hidden;">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold text-pertamina-blue" id="settingsModalLabel">
                        <i class="bi bi-gear-fill me-2"></i>Pengaturan Akun
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="settingsForm">
                    <div class="modal-body p-4">
                        <!-- Password Section -->
                        <h6 class="fw-bold text-pertamina-blue mb-3"><i class="bi bi-shield-lock-fill me-1"></i> Keamanan & Password</h6>
                        <div class="mb-3">
                            <label for="old_password" class="form-label">Password Lama</label>
                            <input type="password" class="form-control" id="old_password" placeholder="Masukkan password saat ini">
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">Password Baru</label>
                            <input type="password" class="form-control" id="new_password" placeholder="Masukkan password baru">
                        </div>
                        <div class="mb-4">
                            <label for="confirm_password" class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" id="confirm_password" placeholder="Ulangi password baru">
                        </div>
                        
                        <hr class="my-3">

                        <!-- Notifications Section -->
                        <h6 class="fw-bold text-pertamina-blue mb-3"><i class="bi bi-bell-fill me-1"></i> Preferensi Notifikasi</h6>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="notify_email" checked>
                            <label class="form-check-label small" for="notify_email">
                                Kirim laporan pemakaian mingguan ke email resmi
                            </label>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="notify_wa" checked>
                            <label class="form-check-label small" for="notify_wa">
                                Kirim status verifikasi logbook via WhatsApp
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-outline-secondary btn-sm px-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-pertamina btn-sm px-4">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
