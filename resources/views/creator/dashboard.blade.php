@extends('layouts.creator')

@section('content')
<style>
    .creator-dashboard {
        --creator-accent: #d96f32;
        --creator-accent-soft: rgba(217, 111, 50, 0.12);
        --creator-ink: #1f2937;
        --creator-muted: #6b7280;
    }

    .creator-dashboard .dashboard-hero,
    .creator-dashboard .metric-card,
    .creator-dashboard .profile-card,
    .creator-dashboard .templates-card {
        border: 0;
        border-radius: 1.25rem;
        box-shadow: 0 18px 40px rgba(31, 41, 55, 0.08);
        overflow: hidden;
    }

    .creator-dashboard .dashboard-hero {
        background:
            radial-gradient(circle at top right, rgba(255, 255, 255, 0.18), transparent 28%),
            linear-gradient(135deg, #1f2937 0%, #243349 52%, #d96f32 100%);
        color: #fff;
    }

    .creator-dashboard .dashboard-hero .hero-copy {
        padding: 2rem;
    }

    .creator-dashboard .eyebrow {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        padding: .45rem .8rem;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.12);
        font-size: .8rem;
        font-weight: 600;
        letter-spacing: .03em;
    }

    .creator-dashboard .hero-title {
        margin: 1rem 0 .75rem;
        font-weight: 800;
        font-size: clamp(1.8rem, 2.4vw, 2.6rem);
        line-height: 1.1;
    }

    .creator-dashboard .hero-text {
        max-width: 56ch;
        color: rgba(255, 255, 255, 0.8);
        margin-bottom: 1.5rem;
    }

    .creator-dashboard .hero-pills {
        display: flex;
        flex-wrap: wrap;
        gap: .75rem;
    }

    .creator-dashboard .hero-pill {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        padding: .7rem .95rem;
        border-radius: .9rem;
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
        font-size: .9rem;
        font-weight: 600;
    }

    .creator-dashboard .hero-aside {
        padding: 2rem;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .creator-dashboard .hero-panel {
        width: 100%;
        max-width: 300px;
        padding: 1.25rem;
        border-radius: 1rem;
        background: rgba(255, 255, 255, 0.12);
        backdrop-filter: blur(10px);
    }

    .creator-dashboard .hero-panel h6 {
        color: rgba(255, 255, 255, 0.72);
        margin-bottom: .85rem;
        font-size: .85rem;
        text-transform: uppercase;
        letter-spacing: .06em;
    }

    .creator-dashboard .hero-panel-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: .75rem 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .creator-dashboard .hero-panel-item:last-child {
        border-bottom: 0;
        padding-bottom: 0;
    }

    .creator-dashboard .hero-panel-label {
        color: rgba(255, 255, 255, 0.75);
        font-size: .9rem;
    }

    .creator-dashboard .hero-panel-value {
        font-weight: 700;
        color: #fff;
    }

    .creator-dashboard .metric-card .card-body {
        padding: 1.2rem 1.25rem;
        min-height: 154px;
    }

    .creator-dashboard .metric-card .metric-label {
        color: var(--creator-muted);
        font-size: .85rem;
        font-weight: 600;
        margin-bottom: .45rem;
    }

    .creator-dashboard .metric-card .metric-value {
        color: var(--creator-ink);
        font-size: clamp(1.5rem, 2vw, 1.9rem);
        font-weight: 800;
        line-height: 1.15;
        margin-bottom: .2rem;
    }

    .creator-dashboard .metric-card .metric-note {
        color: var(--creator-muted);
        font-size: .82rem;
        margin: 0;
        max-width: 18ch;
        line-height: 1.45;
    }

    .creator-dashboard .metric-icon {
        width: 3rem;
        height: 3rem;
        border-radius: 1rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.24);
    }

    .creator-dashboard .metric-icon.orange {
        background: rgba(217, 111, 50, 0.12);
        color: #d96f32;
    }

    .creator-dashboard .metric-icon.blue {
        background: rgba(37, 99, 235, 0.12);
        color: #2563eb;
    }

    .creator-dashboard .metric-icon.green {
        background: rgba(5, 150, 105, 0.12);
        color: #059669;
    }

    .creator-dashboard .metric-icon.gold {
        background: rgba(245, 158, 11, 0.14);
        color: #d97706;
    }

    .creator-dashboard .section-title {
        color: var(--creator-ink);
        font-size: 1.05rem;
        font-weight: 700;
        margin: 0;
    }

    .creator-dashboard .section-subtitle {
        color: var(--creator-muted);
        font-size: .9rem;
        margin: .3rem 0 0;
    }

    .creator-dashboard .profile-card .card-body {
        padding: 1.5rem;
    }

    .creator-dashboard .profile-card {
        position: sticky;
        top: 1.5rem;
    }

    .creator-dashboard .profile-avatar {
        width: 88px;
        height: 88px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        background: linear-gradient(135deg, #3b5bdb 0%, #4c6ef5 100%);
        color: #fff;
        font-size: 1.25rem;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
        border: 4px solid rgba(255, 255, 255, 0.9);
        box-shadow: 0 12px 30px rgba(59, 91, 219, 0.18);
        margin-inline: auto;
    }

    .creator-dashboard .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .creator-dashboard .profile-name {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--creator-ink);
        margin-bottom: .35rem;
    }

    .creator-dashboard .profile-bio {
        color: var(--creator-muted);
        font-size: .92rem;
        line-height: 1.6;
        margin-bottom: 1rem;
    }

    .creator-dashboard .profile-meta {
        display: grid;
        gap: .8rem;
        margin-bottom: 1.1rem;
    }

    .creator-dashboard .profile-meta-item {
        padding: .85rem .95rem;
        border-radius: 1rem;
        background: #f8fafc;
    }

    .creator-dashboard .profile-meta-label {
        display: block;
        color: var(--creator-muted);
        font-size: .75rem;
        text-transform: uppercase;
        letter-spacing: .06em;
        margin-bottom: .2rem;
    }

    .creator-dashboard .profile-meta-value {
        color: var(--creator-ink);
        font-size: .95rem;
        font-weight: 700;
    }

    .creator-dashboard .templates-card .card-header {
        background: transparent;
        border-bottom: 1px solid #eef2f7;
        padding: 1.25rem 1.35rem 1rem;
    }

    .creator-dashboard .templates-card .card-body {
        padding: 1rem 1.35rem 1.25rem;
    }

    .creator-dashboard .template-table {
        margin-bottom: 0;
    }

    .creator-dashboard .template-table thead th {
        font-size: .78rem;
        letter-spacing: .05em;
        text-transform: uppercase;
        color: var(--creator-muted);
        border-bottom-color: #edf2f7;
        white-space: nowrap;
    }

    .creator-dashboard .template-table tbody td {
        vertical-align: middle;
        border-bottom-color: #f3f4f6;
    }

    .creator-dashboard .template-preview {
        width: 64px;
        height: 64px;
        border-radius: 1rem;
        overflow: hidden;
        background: #f3f4f6;
        flex-shrink: 0;
    }

    .creator-dashboard .template-preview img,
    .creator-dashboard .template-preview video {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .creator-dashboard .template-title {
        font-weight: 700;
        color: var(--creator-ink);
        margin-bottom: .2rem;
    }

    .creator-dashboard .template-subtitle {
        color: var(--creator-muted);
        font-size: .85rem;
        margin: 0;
    }

    .creator-dashboard .chip {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .35rem .7rem;
        border-radius: 999px;
        font-size: .75rem;
        font-weight: 700;
    }

    .creator-dashboard .chip.free {
        background: rgba(5, 150, 105, 0.12);
        color: #047857;
    }

    .creator-dashboard .chip.paid {
        background: rgba(37, 99, 235, 0.12);
        color: #1d4ed8;
    }

    .creator-dashboard .chip.type {
        background: rgba(217, 111, 50, 0.1);
        color: #c95f29;
    }

    .creator-dashboard .table-stat {
        font-weight: 700;
        color: var(--creator-ink);
    }

    .creator-dashboard .table-stat-sub {
        display: block;
        color: var(--creator-muted);
        font-size: .78rem;
        margin-top: .15rem;
    }

    .creator-dashboard .empty-state {
        padding: 2.2rem 1rem;
        text-align: center;
        color: var(--creator-muted);
    }

    @media (max-width: 991.98px) {
        .creator-dashboard .hero-copy,
        .creator-dashboard .hero-aside {
            padding: 1.4rem;
        }

        .creator-dashboard .metric-card .card-body {
            min-height: auto;
        }

        .creator-dashboard .profile-card {
            position: static;
        }
    }
</style>

<div class="creator-dashboard">
    <div class="page-heading mb-4">
        <h3>Dashboard Creator</h3>
    </div>

    <div class="page-content">
        <section class="row g-4">
            <div class="col-12 col-xl-8 col-xxl-9">
                <div class="row g-4 mb-4">
                    <div class="col-12 col-md-6 col-xl-6 col-xxl-3">
                        <div class="card metric-card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start gap-3">
                                    <div>
                                        <div class="metric-label">Total Template</div>
                                        <div class="metric-value">{{ $totalTemplates }}</div>
                                        <p class="metric-note">Karya yang sudah Anda unggah</p>
                                    </div>
                                        <i class="iconly-boldCategory" style="color: orange;"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-xl-6 col-xxl-3">
                        <div class="card metric-card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start gap-3">
                                    <div>
                                        <div class="metric-label">Total Download</div>
                                        <div class="metric-value">{{ $totalDownloads }}</div>
                                        <p class="metric-note">Total unduhan semua template</p>
                                    </div>
                                        <i class="iconly-boldDownload" style="color: rgb(67, 139, 255)"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-xl-6 col-xxl-3">
                        <div class="card metric-card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start gap-3">
                                    <div>
                                        <div class="metric-label">Total Sales</div>
                                        <div class="metric-value">Rp {{ number_format($totalSales, 0, ',', '.') }}</div>
                                        <p class="metric-note">Total transaksi dari template</p>
                                    </div>
                                        <i class="iconly-boldWallet" style="color: green"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-xl-6 col-xxl-3">
                        <div class="card metric-card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start gap-3">
                                    <div>
                                        <div class="metric-label">Rating</div>
                                        <div class="metric-value">{{ number_format($averageRating ?? 0, 1) }}</div>
                                        <p class="metric-note">Rerata penilaian dari pengguna</p>
                                    </div>
                                        <i class="iconly-boldStar" style="color: gold"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card templates-card">
                    <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                        <div>
                            <h4 class="section-title">Template Terbaru Anda</h4>
                            <p class="section-subtitle">Lima template terbaru ditampilkan untuk memudahkan pemantauan performa.</p>
                        </div>
                        <a href="{{ route('creator.template.index') }}" class="btn btn-outline-primary btn-sm">
                            Kelola Semua Template
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table template-table">
                                <thead>
                                    <tr>
                                        <th>Template</th>
                                        <th>Tipe</th>
                                        <th>Harga</th>
                                        <th>Download</th>
                                        <th>Terjual</th>
                                        <th>Rating</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($templates as $template)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="template-preview">
                                                            <img src="{{ asset('storage/' . $template->preview) }}" alt="{{ $template->title }}">
                                                    </div>
                                                    <div>
                                                        <div class="template-title">{{ $template->title }}</div>
                                                        <p class="template-subtitle">
                                                            {{ \Illuminate\Support\Str::limit($template->description, 58) }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="chip type">
                                                    {{ ucfirst($template->type) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($template->price == 0)
                                                    <span class="chip free">Gratis</span>
                                                @else
                                                    <span class="chip paid">Rp {{ number_format($template->price, 0, ',', '.') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="table-stat">{{ $template->download_count ?? 0 }}</span>
                                                <span class="table-stat-sub">total unduhan</span>
                                            </td>
                                            <td>
                                                <span class="table-stat">{{ $template->soldCount }}</span>
                                                <span class="table-stat-sub">transaksi paid</span>
                                            </td>
                                            <td>
                                                <span class="table-stat">{{ number_format($template->average_rating ?? 0, 1) }}</span>
                                                <span class="table-stat-sub">dari user</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6">
                                                <div class="empty-state">
                                                    Belum ada template yang ditambahkan. Mulai unggah karya pertama Anda agar dashboard ini terisi.
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-4 col-xxl-3">
                <div class="card profile-card">
                    <div class="card-body text-center">
                        <div class="profile-avatar mb-3" aria-label="{{ Auth::user()->name }}">
                            @if (Auth::user()->profile_photo)
                                <img
                                    src="{{ asset('storage/' . Auth::user()->profile_photo) }}"
                                    alt="{{ Auth::user()->name }}">
                            @else
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}{{ strtoupper(substr(explode(' ', Auth::user()->name)[1] ?? '', 0, 1)) }}
                            @endif
                        </div>
                        <div class="profile-name">{{ Auth::user()->name }}</div>
                        <p class="profile-bio">
                            {{ \Illuminate\Support\Str::limit(Auth::user()->bio, 95) ?: 'Tambahkan bio singkat agar profil creator Anda terlihat lebih meyakinkan.' }}
                        </p>

                        <div class="profile-meta text-start">
                            <div class="profile-meta-item">
                                <span class="profile-meta-label">Template aktif</span>
                                <span class="profile-meta-value">{{ $totalTemplates }} karya</span>
                            </div>
                            <div class="profile-meta-item">
                                <span class="profile-meta-label">Performa terbaik</span>
                                <span class="profile-meta-value">{{ number_format($averageRating ?? 0, 1) }} rating rata-rata</span>
                            </div>
                            <div class="profile-meta-item">
                                <span class="profile-meta-label">Aksi cepat</span>
                                <span class="profile-meta-value">Perbarui profile dan portofolio</span>
                            </div>
                        </div>

                        <a href="{{ route('creator.profile.index') }}" class="btn btn-outline-primary w-100">
                            Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
