@extends('layouts.user')
@section('content')

        
        <!-- Page Header -->
        <div class="welcome-section">
            <h1>Jelajahi Template</h1>
            <p>Temukan template video terbaik untuk konten Anda</p>
        </div>

        <!-- Filter Section -->
        <div class="welcome-section" style="margin-bottom: 30px;">
            <div class="d-flex gap-3 flex-wrap align-items-center">
                <span style="font-weight: 600; color: #2c3e50;">Filter:</span>
                
                <select class="form-select" style="width: auto; min-width: 180px;">
                    <option value="">Semua Kategori</option>
                    <option value="preset">Preset</option>
                    <option value="transition">Transition</option>
                    <option value="effect">Effect</option>
                    <option value="overlay">Overlay</option>
                </select>
                
                <select class="form-select" style="width: auto; min-width: 180px;">
                    <option value="">Semua Harga</option>
                    <option value="free">Gratis</option>
                    <option value="0-15000">< 15.000</option>
                    <option value="15000-25000">15.000 - 25.000</option>
                    <option value="25000+">> 25.000</option>
                </select>
                
                <select class="form-select" style="width: auto; min-width: 180px;">
                    <option value="popular">Terpopuler</option>
                    <option value="newest">Terbaru</option>
                    <option value="price-low">Harga Terendah</option>
                    <option value="price-high">Harga Tertinggi</option>
                </select>
                
                <input type="text" class="form-control" placeholder="Cari template..." style="flex: 1; min-width: 250px;">
            </div>
        </div>

        <!-- Templates Grid -->
        <div class="row g-4 mb-5">
            
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

            <!-- Template Card 5 -->
            <div class="col-lg-3 col-md-4 col-6">
                <a href="#" class="editor-card">
                    <div class="editor-img-wrapper" style="height: 280px;">
                        <img src="https://images.unsplash.com/photo-1611162616475-46b635cb6868?w=400&h=400&fit=crop" class="editor-img" alt="Transition - 2026">
                    </div>
                    <div class="editor-card-body">
                        <h3 class="editor-name" style="font-size: 1rem; margin-bottom: 8px;">Transition - 2026</h3>
                        <p style="font-size: 1.2rem; font-weight: 700; color: #27ae60; margin: 0;">IDR18,000</p>
                        <div class="editor-stats">
                            <div style="display: flex; align-items: center; gap: 5px; color: #6c757d; font-size: 0.85rem;">
                                <i class="bi bi-download"></i>
                                <span>945</span>
                            </div>
                            <div class="editor-rating">
                                <i class="bi bi-star-fill"></i>
                                <span>4.7</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Template Card 6 -->
            <div class="col-lg-3 col-md-4 col-6">
                <a href="#" class="editor-card">
                    <div class="editor-img-wrapper" style="height: 280px;">
                        <img src="https://images.unsplash.com/photo-1611162618071-b39a2ec055fb?w=400&h=400&fit=crop" class="editor-img" alt="Effect - Lisanin">
                        <span class="editor-badge">Hot</span>
                    </div>
                    <div class="editor-card-body">
                        <h3 class="editor-name" style="font-size: 1rem; margin-bottom: 8px;">Effect - Lisanin</h3>
                        <p style="font-size: 1.2rem; font-weight: 700; color: #27ae60; margin: 0;">IDR15,000</p>
                        <div class="editor-stats">
                            <div style="display: flex; align-items: center; gap: 5px; color: #6c757d; font-size: 0.85rem;">
                                <i class="bi bi-download"></i>
                                <span>1.8k</span>
                            </div>
                            <div class="editor-rating">
                                <i class="bi bi-star-fill"></i>
                                <span>4.8</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Template Card 7 -->
            <div class="col-lg-3 col-md-4 col-6">
                <a href="#" class="editor-card">
                    <div class="editor-img-wrapper" style="height: 280px;">
                        <img src="https://images.unsplash.com/photo-1614850523459-c2f4c699c52e?w=400&h=400&fit=crop" class="editor-img" alt="Preset - One Day">
                    </div>
                    <div class="editor-card-body">
                        <h3 class="editor-name" style="font-size: 1rem; margin-bottom: 8px;">Preset - One Day</h3>
                        <p style="font-size: 1.2rem; font-weight: 700; color: #27ae60; margin: 0;">IDR22,000</p>
                        <div class="editor-stats">
                            <div style="display: flex; align-items: center; gap: 5px; color: #6c757d; font-size: 0.85rem;">
                                <i class="bi bi-download"></i>
                                <span>1.5k</span>
                            </div>
                            <div class="editor-rating">
                                <i class="bi bi-star-fill"></i>
                                <span>4.9</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Template Card 8 -->
            <div class="col-lg-3 col-md-4 col-6">
                <a href="#" class="editor-card">
                    <div class="editor-img-wrapper" style="height: 280px;">
                        <img src="https://images.unsplash.com/photo-1611162616305-c69b3fa7fbe0?w=400&h=400&fit=crop" class="editor-img" alt="Overlay - Cantik">
                        <span class="editor-badge">Premium</span>
                    </div>
                    <div class="editor-card-body">
                        <h3 class="editor-name" style="font-size: 1rem; margin-bottom: 8px;">Overlay - Cantik Van Luqluqnya</h3>
                        <p style="font-size: 1.2rem; font-weight: 700; color: #27ae60; margin: 0;">IDR28,000</p>
                        <div class="editor-stats">
                            <div style="display: flex; align-items: center; gap: 5px; color: #6c757d; font-size: 0.85rem;">
                                <i class="bi bi-download"></i>
                                <span>672</span>
                            </div>
                            <div class="editor-rating">
                                <i class="bi bi-star-fill"></i>
                                <span>5.0</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-5">
            <nav>
                <ul class="pagination">
                    <li class="page-item disabled">
                        <span class="page-link"><i class="bi bi-chevron-left"></i></span>
                    </li>
                    <li class="page-item active">
                        <span class="page-link">1</span>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">2</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">3</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">4</a>
                    </li>
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">10</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#"><i class="bi bi-chevron-right"></i></a>
                    </li>
                </ul>
            </nav>
        </div>

@endsection