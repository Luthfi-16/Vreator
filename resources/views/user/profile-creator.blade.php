@extends('layouts.user')

@section('content')
@php
    $profilePhoto = $creator->profile_photo ? asset('storage/' . $creator->profile_photo) : null;
    $initials = collect(explode(' ', trim($creator->name)))
        ->filter()
        ->take(2)
        ->map(fn ($part) => strtoupper(substr($part, 0, 1)))
        ->implode('');
    $initials = $initials ?: strtoupper(substr($creator->name, 0, 2));
    $templateCount = $templates->count();
    $serviceCount = $services->count();
    $freeCount = $templates->where('price', 0)->count();
    $paidCount = $templateCount - $freeCount;
    $categories = $templates
        ->map(fn ($template) => optional($template->category)->name)
        ->filter()
        ->unique()
        ->sort()
        ->values();
@endphp
<link rel="stylesheet" href="{{ asset('user/css/profile-creator.css')}}">
<div class="pc-page">
    <div class="pc-shell">
        <section class="pc-hero">
            <div class="pc-hero-content">
                <div>
                    <div class="pc-profile-head">
                        <div class="pc-avatar">
                            @if($profilePhoto)
                                <img src="{{ $profilePhoto }}" alt="{{ $creator->name }}">
                            @else
                                <span class="pc-avatar-fallback">{{ $initials }}</span>
                            @endif
                        </div>

                        <div>
                            <span class="pc-badge">Creator Profile</span>
                            <h1 class="pc-name">{{ $creator->name }}</h1>
                            <p class="pc-bio">{{ $creator->bio ?: 'Creator ini belum menambahkan bio, tapi karya-karyanya sudah bisa kamu lihat di bawah.' }}</p>

                            <div class="pc-actions">
                                @if($creator->whatsapp)
                                    <a
                                        class="pc-button"
                                        href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/\D+/', '', $creator->whatsapp)) }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                    >
                                        Hubungi Creator
                                    </a>
                                @endif

                                <a class="pc-button-secondary" href="#creator-templates">
                                    Lihat Template
                                </a>

                                @if($serviceCount > 0)
                                    <a class="pc-button-secondary" href="#creator-services">
                                        Lihat Jasa
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pc-stats">
                    <div class="pc-stat">
                        <div class="pc-stat-label">Total Template</div>
                        <div class="pc-stat-value">{{ $templateCount }}</div>
                    </div>
                    <div class="pc-stat">
                        <div class="pc-stat-label">Template Gratis</div>
                        <div class="pc-stat-value">{{ $freeCount }}</div>
                    </div>
                    <div class="pc-stat">
                        <div class="pc-stat-label">Template Berbayar</div>
                        <div class="pc-stat-value">{{ $paidCount }}</div>
                    </div>
                    <div class="pc-stat">
                        <div class="pc-stat-label">Total Jasa</div>
                        <div class="pc-stat-value">{{ $serviceCount }}</div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @if($templateCount > 0)
        <div class="pc-toolbar" id="creator-templates">
            <input type="text" class="pc-search" id="templateSearch" placeholder="Cari template creator ini...">

            <select class="pc-select" id="categoryFilter">
                <option value="">Semua kategori</option>
                @foreach($categories as $categoryName)
                    <option value="{{ $categoryName }}">{{ $categoryName }}</option>
                @endforeach
            </select>

            <select class="pc-select" id="priceFilter">
                <option value="">Semua harga</option>
                <option value="free">Gratis</option>
                <option value="paid">Berbayar</option>
            </select>

            <select class="pc-select" id="sortFilter">
                <option value="latest">Terbaru</option>
                <option value="price_asc">Harga terendah</option>
                <option value="price_desc">Harga tertinggi</option>
                <option value="name_asc">Nama A-Z</option>
            </select>
        </div>

        <div class="row g-4 pc-grid" id="templateGrid">
            @foreach($templates as $index => $template)
                @php
                    $categoryName = optional($template->category)->name;
                    $preview = $template->preview ? asset('storage/' . $template->preview) : null;
                @endphp
                <div
                    class="pc-template-item col-12 col-sm-6 col-lg-3 template-card-grid-item"
                    data-title="{{ strtolower($template->title) }}"
                    data-category="{{ strtolower($categoryName ?? '') }}"
                    data-price="{{ (int) $template->price }}"
                    data-order="{{ $index }}"
                >
                    <a href="{{ route('user.template.show', $template) }}" class="editor-card template-card pc-card-link">
                        <div class="editor-img-wrapper pc-card-thumb template-card-media">
                            @if($preview)
                                <img src="{{ $preview }}" alt="{{ $template->title }}" loading="lazy" class="editor-img">
                            @endif

                            @if($categoryName)
                                <span class="pc-category-badge">{{ $categoryName }}</span>
                            @endif

                            @if((int) $template->price === 0)
                                <span class="pc-pill-free">Gratis</span>
                            @endif
                        </div>

                        <div class="editor-card-body template-card-body">
                            <h3 class="editor-name template-card-title pc-card-title">
                                {{ $template->title }}
                            </h3>

                            <p class="pc-card-creator">
                                Creator : {{ $creator->name }}
                            </p>

                            <div class="pc-card-footer">
                                <div class="pc-card-rating">
                                    <i class="bi bi-star-fill"></i>
                                    <span>{{ number_format($template->average_rating ?? 0, 1) }}</span>
                                </div>

                                <span class="pc-card-price">
                                    {{ (int) $template->price === 0 ? 'Gratis' : 'IDR' . number_format($template->price, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <div class="pc-empty" id="templateEmpty" hidden>
            <h3>Template tidak ditemukan</h3>
            <p>Coba ubah kata kunci atau filter yang sedang dipakai.</p>
        </div>
    @else
        <div class="pc-empty">
            <h3>Creator ini belum punya template aktif</h3>
            <p>Nanti kalau sudah ada karya yang dipublikasikan, daftar template akan muncul di halaman ini.</p>
        </div>
    @endif

    @if($serviceCount > 0)
        <div class="pc-service-shell" id="creator-services">
            <div class="pc-service-head">
                <div>
                    <span class="pc-badge">Creator Services</span>
                    <h2 class="pc-section-title">Jasa dari {{ $creator->name }}</h2>
                </div>
                <div class="pc-service-count">{{ $serviceCount }} layanan aktif</div>
            </div>

            <div class="row g-4">
                @foreach($services as $service)
                    <div class="col-lg-4 col-md-6">
                        <div class="pc-service-card">
                            <div class="pc-service-top">
                                <span class="pc-service-status">{{ ucfirst($service->status) }}</span>
                                <div class="pc-service-price">Rp {{ number_format($service->price, 0, ',', '.') }}</div>
                            </div>

                            <h3 class="pc-service-title">{{ $service->title }}</h3>
                            <p class="pc-service-desc">{{ \Illuminate\Support\Str::limit($service->description, 120) }}</p>

                            @if($creator->whatsapp)
                                <a
                                    class="pc-button"
                                    href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/\D+/', '', $creator->whatsapp)) }}?text={{ urlencode('Halo kak, saya tertarik dengan jasa ( ' . $service->title .' )' ) }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                >
                                    Tanya Jasa Ini
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

@if($templateCount > 0)
<script>
    (function () {
        const grid = document.getElementById('templateGrid');
        const emptyState = document.getElementById('templateEmpty');
        const cards = Array.from(grid.querySelectorAll('.pc-template-item'));
        const searchInput = document.getElementById('templateSearch');
        const categoryFilter = document.getElementById('categoryFilter');
        const priceFilter = document.getElementById('priceFilter');
        const sortFilter = document.getElementById('sortFilter');

        function applyFilters() {
            const query = searchInput.value.trim().toLowerCase();
            const category = categoryFilter.value.trim().toLowerCase();
            const price = priceFilter.value;
            const sort = sortFilter.value;

            let visibleCards = cards.filter((card) => {
                const title = card.dataset.title;
                const cardCategory = card.dataset.category;
                const cardPrice = Number(card.dataset.price);

                const matchesQuery = !query || title.includes(query);
                const matchesCategory = !category || cardCategory === category;
                const matchesPrice =
                    !price ||
                    (price === 'free' && cardPrice === 0) ||
                    (price === 'paid' && cardPrice > 0);

                return matchesQuery && matchesCategory && matchesPrice;
            });

            visibleCards.sort((left, right) => {
                if (sort === 'price_asc') {
                    return Number(left.dataset.price) - Number(right.dataset.price);
                }

                if (sort === 'price_desc') {
                    return Number(right.dataset.price) - Number(left.dataset.price);
                }

                if (sort === 'name_asc') {
                    return left.dataset.title.localeCompare(right.dataset.title);
                }

                return Number(left.dataset.order) - Number(right.dataset.order);
            });

            const visibleSet = new Set(visibleCards);
            cards.forEach((card) => {
                card.hidden = !visibleSet.has(card);
            });

            visibleCards.forEach((card) => {
                grid.appendChild(card);
            });

            emptyState.hidden = visibleCards.length > 0;
        }

        [searchInput, categoryFilter, priceFilter, sortFilter].forEach((element) => {
            element.addEventListener('input', applyFilters);
            element.addEventListener('change', applyFilters);
        });
    })();
</script>
@endif

@endsection
