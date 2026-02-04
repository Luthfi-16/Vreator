@extends('layouts.landing')
@section('content')
    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Bergabung dengan Vreator</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- Step 1: Choose Role -->
                    <div id="step1" class="tab-content active">
                        <p class="text-muted mb-4">Pilih peran Anda untuk memulai</p>
                        
                        <div class="role-option" onclick="goToRegister('creator')">
                            <div class="role-icon">
                                <i class="bi bi-camera-video-fill"></i>
                            </div>
                            <h5 class="fw-bold mb-2">Saya Editor / Creator</h5>
                            <p class="text-muted small mb-0">Jual jasa editing video</p>
                        </div>

                        <div class="role-option" onclick="goToRegister('user')">
                            <div class="role-icon">
                                <i class="bi bi-bag-fill"></i>
                            </div>
                            <h5 class="fw-bold mb-2">Saya Butuh Editor</h5>
                            <p class="text-muted small mb-0">Cari editor profesional</p>
                        </div>

                        <div>
                            <p align="center">Sudah Punya Akun?</p>
                           <a href="{{ route('login') }}" type="submit" class="btn btn-gradient w-100 py-2 rounded-pill fw-semibold">Login</a>
                        </div>
                    </div>

                    <!-- Step 2: Login Form -->
                    <div id="step2" class="tab-content">
                        <button class="btn btn-link text-decoration-none mb-3" onclick="backToStep1()">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </button>
                        
                        <div class="text-center mb-4">
                            <div class="role-icon d-inline-flex" id="selectedRoleIcon">
                                <i class="bi bi-person-fill"></i>
                            </div>
                            <h5 class="fw-bold mt-3" id="selectedRoleText">Masuk sebagai...</h5>
                        </div>

                        <form>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" placeholder="nama@email.com" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control" placeholder="Minimal 8 karakter" required>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="remember">
                                <label class="form-check-label" for="remember">Ingat saya</label>
                            </div>
                            <button type="submit" class="btn btn-gradient w-100 py-2 rounded-pill fw-semibold">Masuk</button>
                        </form>

                        <div class="text-center mt-4">
                            <p class="text-muted small mb-2">Belum punya akun? <a href="#" class="text-decoration-none fw-semibold" style="color: var(--orange-primary)">Daftar Sekarang</a></p>
                            <a href="#" class="text-muted small text-decoration-none">Lupa password?</a>
                        </div>

                        <div class="position-relative my-4">
                            <hr>
                            <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-muted small">atau</span>
                        </div>

                        <button class="btn btn-outline-dark w-100 rounded-pill mb-2">
                            <i class="bi bi-google me-2"></i> Lanjut dengan Google
                        </button>
                        <button class="btn btn-outline-dark w-100 rounded-pill">
                            <i class="bi bi-facebook me-2"></i> Lanjut dengan Facebook
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="text-center">
                <span class="badge-custom">Platform #1 untuk Content Creator</span>
                <h1 class="display-3 fw-bold mt-4 mb-3">
                    Wujudkan Konten<br>
                    <span class="gradient-text">Impianmu di Sini</span>
                </h1>
                <p class="lead text-muted mb-5 mx-auto" style="max-width: 700px;">
                    Temukan editor video profesional atau jual kemampuan editingmu. Semua dalam satu platform.
                </p>
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    @auth
                        <div class="d-flex gap-3 justify-content-center flex-wrap">
                            <a href="{{ auth()->user()->role === 'creator' ? route('creator.dashboard') : route('user.home') }}" class="btn btn-gradient btn-lg rounded-pill px-5">
                                Masuk Dashboard
                            </a>
                        </div>
                    @else
                        <div class="d-flex gap-3 justify-content-center flex-wrap">

                            <button class="btn btn-gradient btn-lg rounded-pill px-5" data-bs-toggle="modal" data-bs-target="#loginModal">
                                Mulai Sekarang
                            </button>
                        </div>
                    @endauth

                </div>

                <!-- Stats -->
                <div class="row mt-5 pt-5">
                    <div class="col-md-4 stats-item mb-4 mb-md-0">
                        <div class="stats-number">5000+</div>
                        <div class="stats-label">Editor Aktif</div>
                    </div>
                    <div class="col-md-4 stats-item mb-4 mb-md-0">
                        <div class="stats-number">25k+</div>
                        <div class="stats-label">Proyek Selesai</div>
                    </div>
                    <div class="col-md-4 stats-item">
                        <div class="stats-number">4.9/5</div>
                        <div class="stats-label">Rating Rata-rata</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Role Explanation Section -->
    <section class="py-5" style="background: #FAF6F0;">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold mb-3">Pilih Peran yang Sesuai untuk Anda</h2>
                <p class="lead text-muted">Vreator hadir untuk dua jenis pengguna dengan kebutuhan berbeda</p>
            </div>

            <div class="row g-4 align-items-stretch">
                <!-- Creator Section -->
                <div class="col-lg-6">
                    <div class="feature-card h-100">
                        <div class="feature-icon">
                            <i class="bi bi-camera-video-fill"></i>
                        </div>
                        <h3 class="fw-bold mb-3">Untuk Creator / Editor</h3>
                        <p class="text-muted mb-4">Jadikan skill editing Anda sebagai sumber penghasilan</p>
                        
                        <div class="d-flex align-items-start mb-3">
                            <i class="bi bi-check-circle-fill text-success me-3 mt-1"></i>
                            <div>
                                <h6 class="fw-bold mb-1">Jual Jasa Editing Video</h6>
                                <p class="text-muted small mb-0">Tawarkan layanan editing untuk YouTube, TikTok, Instagram Reels, dan lainnya</p>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-start mb-3">
                            <i class="bi bi-check-circle-fill text-success me-3 mt-1"></i>
                            <div>
                                <h6 class="fw-bold mb-1">Upload Template & Preset</h6>
                                <p class="text-muted small mb-0">Jual template video, preset warna, dan aset digital lainnya</p>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-start mb-3">
                            <i class="bi bi-check-circle-fill text-success me-3 mt-1"></i>
                            <div>
                                <h6 class="fw-bold mb-1">Kelola Portofolio</h6>
                                <p class="text-muted small mb-0">Tampilkan karya terbaik Anda dan bangun reputasi profesional</p>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-start mb-3">
                            <i class="bi bi-check-circle-fill text-success me-3 mt-1"></i>
                            <div>
                                <h6 class="fw-bold mb-1">Terima Pembayaran Aman</h6>
                                <p class="text-muted small mb-0">Sistem escrow melindungi setiap transaksi Anda</p>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-start">
                            <i class="bi bi-check-circle-fill text-success me-3 mt-1"></i>
                            <div>
                                <h6 class="fw-bold mb-1">Tampilkan Karya Terbaik Anda</h6>
                                <p class="text-muted small mb-0">Perlihatkan hasil editing dan template untuk menarik lebih banyak klien</p>
                            </div>
                        </div>
                        @auth
                            
                        @else
                        <button class="btn btn-gradient rounded-pill px-4 mt-4" onclick="goToRegister('creator')">
                            Mulai Jual Jasa
                        </button>
                        @endauth
                    </div>
                </div>

                <!-- Buyer Section -->
                <div class="col-lg-6">
                    <div class="feature-card h-100">
                        <div class="feature-icon">
                            <i class="bi bi-bag-fill"></i>
                        </div>
                        <h3 class="fw-bold mb-3">Untuk Buyer / Content Creator</h3>
                        <p class="text-muted mb-4">Temukan editor profesional untuk konten Anda</p>
                        
                        <div class="d-flex align-items-start mb-3">
                            <i class="bi bi-check-circle-fill text-success me-3 mt-1"></i>
                            <div>
                                <h6 class="fw-bold mb-1">Cari Editor Profesional</h6>
                                <p class="text-muted small mb-0">Pilih dari ribuan editor terverifikasi dengan berbagai spesialisasi</p>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-start mb-3">
                            <i class="bi bi-check-circle-fill text-success me-3 mt-1"></i>
                            <div>
                                <h6 class="fw-bold mb-1">Beli Template & Preset</h6>
                                <p class="text-muted small mb-0">Akses ribuan template siap pakai untuk mempercepat produksi konten</p>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-start mb-3">
                            <i class="bi bi-check-circle-fill text-success me-3 mt-1"></i>
                            <div>
                                <h6 class="fw-bold mb-1">Pesan Jasa dengan Mudah</h6>
                                <p class="text-muted small mb-0">Sistem pemesanan yang simpel dengan harga transparan</p>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-start mb-3">
                            <i class="bi bi-check-circle-fill text-success me-3 mt-1"></i>
                            <div>
                                <h6 class="fw-bold mb-1">Revisi Gratis</h6>
                                <p class="text-muted small mb-0">Dapatkan revisi hingga hasil sesuai ekspektasi Anda</p>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-start">
                            <i class="bi bi-check-circle-fill text-success me-3 mt-1"></i>
                            <div>
                                <h6 class="fw-bold mb-1">Lihat Rating & Portfolio</h6>
                                <p class="text-muted small mb-0">Pilih editor berdasarkan review dan karya sebelumnya</p>
                            </div>
                        </div>
                        @auth
                        @else
                        <button class="btn btn-outline-secondary rounded-pill px-4 mt-4" onclick="goToRegister('user')">
                            Cari Editor Sekarang
                        </button>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="fitur" class="py-5" style="background: #F3E9DC;">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold mb-3">Fitur Platform</h2>
                <p class="lead text-muted">Teknologi yang mendukung kolaborasi Creator dan Buyer</p>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card bg-white">
                        <div class="feature-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Sistem Pemesanan Aman</h4>
                        <p class="text-muted mb-0">Transaksi terpercaya dengan sistem escrow dan rating untuk melindungi buyer dan creator</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card bg-white">
                        <div class="feature-icon">
                            <i class="bi bi-lightning-charge-fill"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Proses Cepat</h4>
                        <p class="text-muted mb-0">Mayoritas proyek selesai dalam 24-48 jam dengan komunikasi real-time</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card bg-white">
                        <div class="feature-icon">
                            <i class="bi bi-wallet2"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Harga Transparan</h4>
                        <p class="text-muted mb-0">Tidak ada biaya tersembunyi, harga jelas dari awal mulai dari 50rb</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="benefits-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <h2 class="display-5 fw-bold mb-4">Kenapa Pilih Vreator?</h2>
                    <p class="lead mb-4" style="opacity: 0.9;">
                        Kami hadir untuk membuat proses editing video jadi lebih mudah, cepat, dan terpercaya.
                    </p>
                    <div class="check-item">
                        <div class="check-icon">
                            <i class="bi bi-check-lg"></i>
                        </div>
                        <span class="fw-semibold">Proses cepat dalam 24 jam</span>
                    </div>
                    <div class="check-item">
                        <div class="check-icon">
                            <i class="bi bi-check-lg"></i>
                        </div>
                        <span class="fw-semibold">Harga transparan mulai 50rb</span>
                    </div>
                    <div class="check-item">
                        <div class="check-icon">
                            <i class="bi bi-check-lg"></i>
                        </div>
                        <span class="fw-semibold">Revisi gratis hingga puas</span>
                    </div>
                    <div class="check-item">
                        <div class="check-icon">
                            <i class="bi bi-check-lg"></i>
                        </div>
                        <span class="fw-semibold">Editor terverifikasi</span>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="video-placeholder">
                        <i class="bi bi-play-circle-fill"></i>
                    </div>
                    <p class="text-center text-white mt-4 fw-semibold">Lihat bagaimana Vreator bekerja</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Editors Section -->
    <section id="editor" class="py-5" style="background: #FAF6F0;">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold mb-3">Editor Terpopuler</h2>
                <p class="lead text-muted">Dipilih oleh ribuan content creator</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="card editor-card border-0">
                        <div class="editor-img-wrapper">
                            <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=400&h=300&fit=crop" class="card-img-top editor-img" alt="Sarah K.">
                        </div>
                        <div class="card-body p-4">
                            <h5 class="card-title fw-bold mb-1">Sarah K.</h5>
                            <p class="card-text text-muted small mb-3">YouTube Editor</p>
                            <div class="d-flex justify-content-between align-items-center small">
                                <div>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <span class="fw-bold">4.9</span>
                                </div>
                                <span class="text-muted">127 proyek</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="card editor-card border-0">
                        <div class="editor-img-wrapper">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=300&fit=crop" class="card-img-top editor-img" alt="Fikri M.">
                        </div>
                        <div class="card-body p-4">
                            <h5 class="card-title fw-bold mb-1">Fikri M.</h5>
                            <p class="card-text text-muted small mb-3">TikTok Specialist</p>
                            <div class="d-flex justify-content-between align-items-center small">
                                <div>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <span class="fw-bold">5.0</span>
                                </div>
                                <span class="text-muted">89 proyek</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="card editor-card border-0">
                        <div class="editor-img-wrapper">
                            <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=400&h=300&fit=crop" class="card-img-top editor-img" alt="Dini R.">
                        </div>
                        <div class="card-body p-4">
                            <h5 class="card-title fw-bold mb-1">Dini R.</h5>
                            <p class="card-text text-muted small mb-3">Reels Expert</p>
                            <div class="d-flex justify-content-between align-items-center small">
                                <div>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <span class="fw-bold">4.8</span>
                                </div>
                                <span class="text-muted">156 proyek</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="card editor-card border-0">
                        <div class="editor-img-wrapper">
                            <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=400&h=300&fit=crop" class="card-img-top editor-img" alt="Reza A.">
                        </div>
                        <div class="card-body p-4">
                            <h5 class="card-title fw-bold mb-1">Reza A.</h5>
                            <p class="card-text text-muted small mb-3">Vlog Editor</p>
                            <div class="d-flex justify-content-between align-items-center small">
                                <div>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <span class="fw-bold">4.9</span>
                                </div>
                                <span class="text-muted">98 proyek</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5">
                <button class="btn btn-outline-secondary btn-lg rounded-pill px-5">Lihat Semua Editor</button>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="text-center">
                <h2 class="display-4 fw-bold mb-4">Siap Tingkatkan Kontenmu?</h2>
                <p class="lead mb-5" style="opacity: 0.8;">
                    Gabung bersama ribuan creator yang sudah mempercayai Vreator
                </p>
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <button class="btn btn-gradient btn-lg rounded-pill px-5" data-bs-toggle="modal" data-bs-target="#loginModal">Daftar Gratis</button>
                    <button class="btn btn-light btn-lg rounded-pill px-5">Pelajari Lebih Lanjut</button>
                </div>
                <p class="mt-4 small" style="opacity: 0.6;">Gratis untuk memulai • Tidak perlu kartu kredit</p>
            </div>
        </div>
    </section>
@endsection