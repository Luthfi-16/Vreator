@extends('layouts.user')
@section('content')

            <!-- Welcome Section -->
            <div class="welcome-section">
                <h1>Selamat Datang, John! 👋</h1>
                <p>Temukan editor terbaik untuk konten Anda atau jelajahi template yang tersedia</p>
                <a href="#" class="btn-gradient">
                    <i class="bi bi-search"></i>
                    Cari Editor Sekarang
                </a>
            </div>

            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-receipt"></i>
                    </div>
                    <div class="stat-info">
                        <h4>12</h4>
                        <p>Pesanan Selesai</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-heart-fill"></i>
                    </div>
                    <div class="stat-info">
                        <h4>5</h4>
                        <p>Editor Favorit</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-collection-fill"></i>
                    </div>
                    <div class="stat-info">
                        <h4>8</h4>
                        <p>Template Tersimpan</p>
                    </div>
                </div>
            </div>

            <!-- Editor Section -->
            <h2 class="section-title">Template Terlaris</h2>
            <div class="row g-4 mb-4">
                {{-- <div class="col-lg-3 col-md-6">
                    <a href="#" class="editor-card">
                        <div class="editor-img-wrapper">
                            <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=400&h=300&fit=crop" class="editor-img" alt="Sarah K.">
                            <span class="editor-badge">Top Rated</span>
                        </div>
                        <div class="editor-card-body">
                            <div class="editor-name">Sarah K.</div>
                            <div class="editor-specialty">YouTube Editor</div>
                            <div class="editor-stats">
                                <div class="editor-rating">
                                    <i class="bi bi-star-fill"></i>
                                    <span>4.9</span>
                                </div>
                                <div class="editor-projects">127 proyek</div>
                            </div>
                        </div>
                    </a>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <a href="#" class="editor-card">
                        <div class="editor-img-wrapper">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=300&fit=crop" class="editor-img" alt="Fikri M.">
                            <span class="editor-badge">Verified</span>
                        </div>
                        <div class="editor-card-body">
                            <div class="editor-name">Fikri M.</div>
                            <div class="editor-specialty">TikTok Specialist</div>
                            <div class="editor-stats">
                                <div class="editor-rating">
                                    <i class="bi bi-star-fill"></i>
                                    <span>5.0</span>
                                </div>
                                <div class="editor-projects">89 proyek</div>
                            </div>
                        </div>
                    </a>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <a href="#" class="editor-card">
                        <div class="editor-img-wrapper">
                            <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=400&h=300&fit=crop" class="editor-img" alt="Dini R.">
                            <span class="editor-badge">Popular</span>
                        </div>
                        <div class="editor-card-body">
                            <div class="editor-name">Dini R.</div>
                            <div class="editor-specialty">Reels Expert</div>
                            <div class="editor-stats">
                                <div class="editor-rating">
                                    <i class="bi bi-star-fill"></i>
                                    <span>4.8</span>
                                </div>
                                <div class="editor-projects">156 proyek</div>
                            </div>
                        </div>
                    </a>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <a href="#" class="editor-card">
                        <div class="editor-img-wrapper">
                            <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=400&h=300&fit=crop" class="editor-img" alt="Reza A.">
                            <span class="editor-badge">Fast</span>
                        </div>
                        <div class="editor-card-body">
                            <div class="editor-name">Reza A.</div>
                            <div class="editor-specialty">Vlog Editor</div>
                            <div class="editor-stats">
                                <div class="editor-rating">
                                    <i class="bi bi-star-fill"></i>
                                    <span>4.9</span>
                                </div>
                                <div class="editor-projects">98 proyek</div>
                            </div>
                        </div>
                    </a>
                </div> --}}

                            <!-- Template Card 1 -->
            <div class="col-lg-3 col-md-4 col-6">
                <a href="#" class="editor-card">
                    <div class="editor-img-wrapper" style="height: 280px;">
                        <img src="https://images.unsplash.com/photo-1611162617474-5b21e879e113?w=400&h=400&fit=crop" class="editor-img" alt="Preset - Timeless">
                        <span class="editor-badge">Popular</span>
                    </div>
                    <div class="editor-card-body">
                        <h3 class="editor-name" style="font-size: 1rem; margin-bottom: 8px;">Preset - Timeless TheWxCart</h3>
                        <p style="font-size: 1.2rem; font-weight: 700; color: #27ae60; margin: 0;">IDR25,000</p>
                        <div class="editor-stats">
                            <div style="display: flex; align-items: center; gap: 5px; color: #6c757d; font-size: 0.85rem;">
                                <i class="bi bi-download"></i>
                                <span>1.2k</span>
                            </div>
                            <div class="editor-rating">
                                <i class="bi bi-star-fill"></i>
                                <span>4.9</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Template Card 2 -->
            <div class="col-lg-3 col-md-4 col-6">
                <a href="#" class="editor-card">
                    <div class="editor-img-wrapper" style="height: 280px;">
                        <img src="https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?w=400&h=400&fit=crop" class="editor-img" alt="Preset - Sency">
                        <span class="editor-badge">New</span>
                    </div>
                    <div class="editor-card-body">
                        <h3 class="editor-name" style="font-size: 1rem; margin-bottom: 8px;">Preset - Sency</h3>
                        <p style="font-size: 1.2rem; font-weight: 700; color: #27ae60; margin: 0;">IDR20,000</p>
                        <div class="editor-stats">
                            <div style="display: flex; align-items: center; gap: 5px; color: #6c757d; font-size: 0.85rem;">
                                <i class="bi bi-download"></i>
                                <span>856</span>
                            </div>
                            <div class="editor-rating">
                                <i class="bi bi-star-fill"></i>
                                <span>4.8</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Template Card 3 -->
            <div class="col-lg-3 col-md-4 col-6">
                <a href="#" class="editor-card">
                    <div class="editor-img-wrapper" style="height: 280px;">
                        <img src="https://images.unsplash.com/photo-1574169208507-84376144848b?w=400&h=400&fit=crop" class="editor-img" alt="Preset - Ophalite">
                    </div>
                    <div class="editor-card-body">
                        <h3 class="editor-name" style="font-size: 1rem; margin-bottom: 8px;">Preset - Ophalite</h3>
                        <p style="font-size: 1.2rem; font-weight: 700; color: #27ae60; margin: 0;">IDR12,000</p>
                        <div class="editor-stats">
                            <div style="display: flex; align-items: center; gap: 5px; color: #6c757d; font-size: 0.85rem;">
                                <i class="bi bi-download"></i>
                                <span>2.3k</span>
                            </div>
                            <div class="editor-rating">
                                <i class="bi bi-star-fill"></i>
                                <span>5.0</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Template Card 4 -->
            <div class="col-lg-3 col-md-4 col-6">
                <a href="#" class="editor-card">
                    <div class="editor-img-wrapper" style="height: 280px;">
                        <img src="https://images.unsplash.com/photo-1611162616305-c69b3fa7fbe0?w=400&h=400&fit=crop" class="editor-img" alt="Preset - 2025 Recap">
                        <span class="editor-badge">Trending</span>
                    </div>
                    <div class="editor-card-body">
                        <h3 class="editor-name" style="font-size: 1rem; margin-bottom: 8px;">Preset - 2025 Recap</h3>
                        <p style="font-size: 1.2rem; font-weight: 700; color: #27ae60; margin: 0;">IDR20,000</p>
                        <div class="editor-stats">
                            <div style="display: flex; align-items: center; gap: 5px; color: #6c757d; font-size: 0.85rem;">
                                <i class="bi bi-download"></i>
                                <span>3.1k</span>
                            </div>
                            <div class="editor-rating">
                                <i class="bi bi-star-fill"></i>
                                <span>4.9</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            </div>

            <div class="text-center mb-5">
                <a href="{{ route('user.listtemplate')}}" class="btn-gradient">
                    <i class="bi bi-grid"></i>
                    Lihat Semua Template
                </a>
            </div>
    
@endsection