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
                <div class="col-12 col-sm-6 col-lg-3 template-card-grid-item">
                    <a href="{{ route('user.template.show', $template) }}" class="editor-card template-card">
                        
                        <!-- IMAGE -->
                        <div class="editor-img-wrapper template-card-media">
                            <img src="{{ asset('storage/' . $template->preview) }}" class="editor-img">

                            @if ($template->average_rating >= 4.8)
                                <span class="editor-badge">Top Rated</span>
                            @elseif ($template->average_rating >= 4.5)
                                <span class="editor-badge">Recommended</span>
                            @endif
                        </div>

                        <!-- BODY -->
                        <div class="editor-card-body template-card-body">

                            <h3 class="editor-name template-card-title">
                                {{ $template->title }}
                            </h3>

                            <p class="template-card-creator">
                                Creator : {{ $template->user->name ?? 'Creator Vreator' }}
                            </p>

                            <div class="template-card-footer">
                                <div class="template-card-rating">
                                    <i class="bi bi-star-fill"></i>
                                    <span>{{ number_format($template->average_rating, 1) }}</span>
                                </div>

                                <span class="template-card-price">
                                    {{ $template->price == 0 ? 'Gratis' : 'IDR' . number_format($template->price, 0, ',', '.') }}
                                </span>
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
