@extends('layouts.user')
@section('content')

            <!-- Welcome Section -->
            <div class="welcome-section">
                <h1>Selamat Datang, {{ $auth->name }}!</h1>
                <p>Temukan editor terbaik untuk konten Anda atau jelajahi template yang tersedia</p>
                <a href="{{ route('user.listtemplate') }}" class="btn-gradient">
                    Cari Template Sekarang
                </a>
            </div>

            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-receipt"></i>
                    </div>
                    <div class="stat-info">
                        <h4>{{ $completedOrders }}</h4>
                        <p>Pesanan Selesai</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <div class="stat-info">
                        <h4>{{ $pendingOrders }}</h4>
                        <p>Pembayaran Pending</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-download"></i>
                    </div>
                    <div class="stat-info">
                        <h4>{{ $totalDownloads }}</h4>
                        <p>Template Diunduh</p>
                    </div>
                </div>
            </div>

            <!-- Editor Section -->
            <h2 class="section-title">Top Rated Template</h2>
            <div class="row g-4 mb-4">

                @if($topTemplates->isEmpty())
                    <div class="text-center w-100">
                        <p style="color: #6c757d;">
                            Belum ada template dengan rating tinggi.
                        </p>
                    </div>
                @else

                @foreach($topTemplates as $template)
                <div class="col-lg-3 col-md-4 col-6">
                    <a href="{{ route('user.template.show', $template) }}" class="editor-card">
                        
                        <!-- IMAGE -->
                        <div class="editor-img-wrapper" style="height: 280px;">
                            <img src="{{ asset('storage/' . $template->preview) }}" class="editor-img">

                            @if ($template->average_rating >= 4.8)
                                <span class="editor-badge">Top Rated</span>
                            @elseif ($template->average_rating >= 4.5)
                                <span class="editor-badge">Recommended</span>
                            @endif
                        </div>

                        <!-- BODY -->
                        <div class="editor-card-body">

                            <h3 class="editor-name" style="font-size: 1rem; margin-bottom: 8px;">
                                {{ $template->title }}
                            </h3>

                            <p style="font-size: 1.2rem; font-weight: 700; color: #27ae60; margin: 0;">
                                @if($template->price == 0)
                                    Free
                                @else
                                    IDR{{ number_format($template->price, 0, ',', '.') }}
                                @endif
                            </p>

                            <div class="editor-stats">
                                <div style="display: flex; align-items: center; gap: 5px; color: #6c757d; font-size: 0.85rem;">
                                    <i class="bi bi-download"></i>
                                    <span>{{ $template->download_count }}</span>
                                </div>

                                <div class="editor-rating">
                                    <i class="bi bi-star-fill"></i>
                                    <span>{{ number_format($template->average_rating, 1) }}</span>
                                </div>
                            </div>

                        </div>
                    </a>
                </div>
                @endforeach

                @endif

            </div>

            @if($topTemplates->count() >= 4)
                <div class="text-center mb-5">
                    <a href="{{ route('user.listtemplate') }}" class="btn-gradient">
                        <i class="bi bi-grid"></i>
                        Lihat Semua Template
                    </a>
                </div>
            @endif
    
@endsection
