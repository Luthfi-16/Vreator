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
                            <h5 class="fw-bold mb-2">Saya Editor</h5>
                            <p class="text-muted small mb-0">Kelola template, profil, dan karya digital Anda</p>
                        </div>

                        <div class="role-option" onclick="goToRegister('user')">
                            <div class="role-icon">
                                <i class="bi bi-bag-fill"></i>
                            </div>
                            <h5 class="fw-bold mb-2">Saya Pembeli</h5>
                            <p class="text-muted small mb-0">Cari template, lihat creator, dan lanjutkan checkout</p>
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
                    Temukan Template<br>
                    <span class="gradient-text">Siap Pakai untuk Kontenmu</span>
                </h1>
                <p class="lead text-muted mb-5 mx-auto" style="max-width: 700px;">
                    Jelajahi template digital dari para creator, kelola transaksi dengan aman, dan temukan profil creator di satu platform.
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
                        <div class="stats-number">{{ number_format($creatorCount) }}+</div>
                        <div class="stats-label">Creator Terdaftar</div>
                    </div>
                    <div class="col-md-4 stats-item mb-4 mb-md-0">
                        <div class="stats-number">{{ number_format($templateCount) }}+</div>
                        <div class="stats-label">Total Template</div>
                    </div>
                    <div class="col-md-4 stats-item">
                        <div class="stats-number">{{ number_format($serviceCount) }}+</div>
                        <div class="stats-label">Jasa Aktif</div>
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
                <p class="lead text-muted">Vreator mendukung creator yang ingin mengunggah karya dan user yang ingin membeli template</p>
            </div>

            <div class="row g-4 align-items-stretch">
                <!-- Creator Section -->
                <div class="col-lg-6">
                    <div class="feature-card h-100">
                        <div class="feature-icon">
                            <i class="bi bi-camera-video-fill"></i>
                        </div>
                        <h3 class="fw-bold mb-3">Untuk Creator / Editor</h3>
                        <p class="text-muted mb-4">Kelola template, profil creator, dan karya digital dari dashboard Anda</p>
                        
                        <div class="d-flex align-items-start mb-3">
                            <i class="bi bi-check-circle-fill text-success me-3 mt-1"></i>
                            <div>
                                <h6 class="fw-bold mb-1">Kelola layanan dari dashboard</h6>
                                <p class="text-muted small mb-0">Area creator sudah menyiapkan pengelolaan jasa, template, dan profil dalam satu tempat</p>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-start mb-3">
                            <i class="bi bi-check-circle-fill text-success me-3 mt-1"></i>
                            <div>
                                <h6 class="fw-bold mb-1">Upload Template & Preset</h6>
                                <p class="text-muted small mb-0">Unggah template digital dan tampilkan preview untuk calon pembeli</p>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-start mb-3">
                            <i class="bi bi-check-circle-fill text-success me-3 mt-1"></i>
                            <div>
                                <h6 class="fw-bold mb-1">Kelola Portofolio</h6>
                                <p class="text-muted small mb-0">Perbarui profil, bio, dan identitas creator agar lebih mudah dikenali</p>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-start mb-3">
                            <i class="bi bi-check-circle-fill text-success me-3 mt-1"></i>
                            <div>
                                <h6 class="fw-bold mb-1">Transaksi Template Lebih Rapi</h6>
                                <p class="text-muted small mb-0">Template berbayar diproses lewat checkout dan riwayat transaksi yang jelas</p>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-start">
                            <i class="bi bi-check-circle-fill text-success me-3 mt-1"></i>
                            <div>
                                <h6 class="fw-bold mb-1">Tampilkan Karya Terbaik Anda</h6>
                                <p class="text-muted small mb-0">Preview template membantu user memahami kualitas karya sebelum membeli</p>
                            </div>
                        </div>
                        @auth
                            
                        @else
                        <button class="btn btn-gradient rounded-pill px-4 mt-4" onclick="goToRegister('creator')">
                            Mulai Jadi Creator
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
                        <p class="text-muted mb-4">Cari template yang sesuai, cek profil creator, lalu download setelah checkout</p>
                        
                        <div class="d-flex align-items-start mb-3">
                            <i class="bi bi-check-circle-fill text-success me-3 mt-1"></i>
                            <div>
                                <h6 class="fw-bold mb-1">Temukan Creator dari Karyanya</h6>
                                <p class="text-muted small mb-0">User bisa mengenal creator lewat template yang mereka jual dan profil yang mereka tampilkan</p>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-start mb-3">
                            <i class="bi bi-check-circle-fill text-success me-3 mt-1"></i>
                            <div>
                                <h6 class="fw-bold mb-1">Beli Template & Preset</h6>
                                <p class="text-muted small mb-0">Pilih template gratis maupun berbayar untuk kebutuhan konten Anda</p>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-start mb-3">
                            <i class="bi bi-check-circle-fill text-success me-3 mt-1"></i>
                            <div>
                                <h6 class="fw-bold mb-1">Jelajahi dengan Filter</h6>
                                <p class="text-muted small mb-0">Gunakan filter, kategori, dan sorting untuk menemukan template lebih cepat</p>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-start mb-3">
                            <i class="bi bi-check-circle-fill text-success me-3 mt-1"></i>
                            <div>
                                <h6 class="fw-bold mb-1">Checkout dan Resume Pembayaran</h6>
                                <p class="text-muted small mb-0">Pantau pembayaran pending dan lanjutkan checkout dari riwayat transaksi</p>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-start">
                            <i class="bi bi-check-circle-fill text-success me-3 mt-1"></i>
                            <div>
                                <h6 class="fw-bold mb-1">Lihat Rating & Portfolio</h6>
                                <p class="text-muted small mb-0">Lihat profil creator dan beri rating setelah template berhasil diunduh</p>
                            </div>
                        </div>
                        @auth
                        @else
                        <button class="btn btn-outline-secondary rounded-pill px-4 mt-4" onclick="goToRegister('user')">
                            Cari Template Sekarang
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
                <p class="lead text-muted">Fitur yang sudah tersedia untuk creator, buyer, dan pengelolaan template</p>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card bg-white">
                        <div class="feature-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Checkout Template</h4>
                        <p class="text-muted mb-0">Template gratis bisa langsung diunduh, sementara template berbayar diproses lewat checkout dan riwayat transaksi</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card bg-white">
                        <div class="feature-icon">
                            <i class="bi bi-lightning-charge-fill"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Filter & Jelajah Cepat</h4>
                        <p class="text-muted mb-0">User dapat mencari template berdasarkan kata kunci, kategori, harga, dan urutan yang paling relevan</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card bg-white">
                        <div class="feature-icon">
                            <i class="bi bi-wallet2"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Download & Rating</h4>
                        <p class="text-muted mb-0">Setelah membeli atau mengunduh template, user bisa memberi rating untuk membantu creator membangun reputasi</p>
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
                        Platform ini dirancang untuk memudahkan creator menjual template dan user menemukan aset digital yang siap dipakai.
                    </p>
                    <div class="check-item">
                        <div class="check-icon">
                            <i class="bi bi-check-lg"></i>
                        </div>
                        <span class="fw-semibold">Template gratis dan berbayar dalam satu katalog</span>
                    </div>
                    <div class="check-item">
                        <div class="check-icon">
                            <i class="bi bi-check-lg"></i>
                        </div>
                        <span class="fw-semibold">Profil creator bisa dilihat langsung dari detail template</span>
                    </div>
                    <div class="check-item">
                        <div class="check-icon">
                            <i class="bi bi-check-lg"></i>
                        </div>
                        <span class="fw-semibold">Filter kategori, harga, dan urutan pencarian yang praktis</span>
                    </div>
                    <div class="check-item">
                        <div class="check-icon">
                            <i class="bi bi-check-lg"></i>
                        </div>
                        <span class="fw-semibold">Riwayat transaksi dan download tersimpan rapi</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Editors Section -->
    <section id="editor" class="py-5" style="background: #FAF6F0;">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold mb-3">Template Terbaru</h2>
                <p class="lead text-muted">Konten ini menampilkan template yang aktif di project Anda</p>
            </div>

            <div class="row g-4">
                @forelse($featuredTemplates as $template)
                <div class="col-lg-3 col-md-6">
                    <div class="card editor-card border-0">
                        <div class="editor-img-wrapper">
                            <img src="{{ asset('storage/' . $template->preview) }}" class="card-img-top editor-img" alt="{{ $template->title }}">
                        </div>
                        <div class="card-body p-4">
                            <h5 class="card-title fw-bold mb-1">{{ $template->title }}</h5>
                            <p class="card-text text-muted small mb-3"><b>Creator :</b> {{ $template->user->name ?? 'Creator Vreator' }}</p>
                            <div class="d-flex justify-content-between align-items-center small">
                                <div>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <span class="fw-bold">{{ number_format($template->average_rating ?? 0, 1) }}</span>
                                </div>
                                <span class="text-muted">{{ $template->price == 0 ? 'Gratis' : 'IDR' . number_format($template->price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="text-center text-muted">
                        Template akan tampil di sini setelah creator mengunggah karya.
                    </div>
                </div>
                @endforelse
            </div>

            <div id="harga" class="text-center mt-5">
                @guest
                    <button class="btn btn-outline-secondary btn-lg rounded-pill px-5" onclick="goToRegister('user')">Masuk sebagai buyer untuk Lihat Template</button>
                @else
                    <a href="{{ route('user.listtemplate') }}" class="btn btn-outline-secondary btn-lg rounded-pill px-5">Lihat Semua Template</a>
                @endguest
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="text-center">
                <h2 class="display-4 fw-bold mb-4">Siap Tingkatkan Kontenmu?</h2>
                <p class="lead mb-5" style="opacity: 0.8;">
                    Masuk sekarang untuk mulai jual template atau jelajahi karya dari creator lain
                </p>
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    @auth
                        <a href="{{ auth()->user()->role === 'creator' ? route('creator.dashboard') : route('user.home') }}" class="btn btn-gradient btn-lg rounded-pill px-5">
                                Masuk Dashboard
                        </a>
                    @else
                    <button class="btn btn-gradient btn-lg rounded-pill px-5" data-bs-toggle="modal" data-bs-target="#loginModal">Daftar Gratis</button>
                    <a href="#fitur" class="btn btn-light btn-lg rounded-pill px-5">Pelajari Fitur</a>
                    @endauth
                </div>
                <p class="mt-4 small" style="opacity: 0.6;">Gratis untuk memulai dan creator bisa langsung mengelola template dari dashboard</p>
            </div>
        </div>
    </section>
@endsection
