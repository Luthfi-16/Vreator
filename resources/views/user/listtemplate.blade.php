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
            
            @foreach ($templates as $template)
            <div class="col-lg-3 col-md-4 col-6">
                <a href="{{ route('user.template.show', $template) }}" class="editor-card">
                    <div class="editor-img-wrapper" style="height: 280px;">
                        <img src="{{ asset('storage/'.$template->preview) }}"
                            class="editor-img"
                            alt="{{ $template->title }}">

                        @if($template->price == 0)
                            <span class="editor-badge">Free</span>
                        @endif
                    </div>

                    <div class="editor-card-body">
                        <h3 class="editor-name" style="font-size: 1rem;">
                            {{ $template->title }}
                        </h3>

                        <p style="font-size: 1.2rem; font-weight: 700; color: #27ae60;">
                            {{ $template->price == 0 ? 'Gratis' : 'IDR '.number_format($template->price) }}
                        </p>

                        <div class="editor-stats">
                            <div class="text-muted" style="font-size: .85rem">
                                by {{ $template->user->name }}
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach


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