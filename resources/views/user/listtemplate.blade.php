@extends('layouts.user')
@section('content')
<style>
    .lt-card-link {
        position: relative;
    }

    .lt-category-badge,
    .lt-free-badge {
        position: absolute;
        top: 12px;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        z-index: 2;
    }

    .lt-category-badge {
        left: 12px;
        max-width: calc(100% - 120px);
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        background: rgba(255, 255, 255, 0.92);
        color: #1d1a16;
    }

    .lt-free-badge {
        right: 12px;
        background: linear-gradient(135deg, var(--orange-primary, #D96F32), var(--orange-light, #F8B259));
        color: #fff;
    }

    .lt-search-wrapper {
    position: relative;
    flex: 1 1 260px;
    }

    .lt-search {
        width: 100%;
        padding-right: 45px; /* kasih space buat icon */
    }

    .lt-search-btn {
        position: absolute;
        right: 8px;
        top: 50%;
        transform: translateY(-50%);
        border: none;
        background: transparent;
        font-size: 1.2rem;
        cursor: pointer;
        color: #888;
        transition: 0.2s;
    }

    .lt-search-btn:hover {
        color: #e67e22;
    }
    .lt-toolbar {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
        align-items: center;
        margin-bottom: 30px;
        padding: 18px;
        border-radius: 22px;
        background: rgba(255, 255, 255, 0.88);
        border: 1px solid rgba(255, 255, 255, 0.58);
        box-shadow: 0 16px 38px rgba(76, 53, 23, 0.08);
        backdrop-filter: blur(14px);
    }

    .lt-search,
    .lt-select {
        min-height: 46px;
        border-radius: 14px;
        border: 1px solid rgba(43, 37, 28, 0.1);
        background: #fff;
        color: #1d1a16;
        padding: 0 14px;
        font-size: 0.92rem;
        outline: none;
    }

    .lt-search {
        flex: 1 1 260px;
    }

    .lt-select {
        flex: 0 0 220px;
    }

    .lt-submit {
        min-height: 46px;
        padding: 0 22px;
        border: none;
        flex-shrink: 0;
    }

    .lt-reset {
        min-height: 46px;
        padding: 0 22px;
        border-radius: 14px;
        flex-shrink: 0;
    }

    @media (max-width: 720px) {
        .lt-select,
        .lt-search,
        .lt-submit,
        .lt-reset {
            flex-basis: 100%;
            width: 100%;
        }
    }
</style>

        <div class="welcome-section">
            <h1>Jelajahi Template</h1>
            <p>Temukan template video terbaik untuk konten Anda</p>
        </div>

        <form method="GET" action="{{ route('user.listtemplate') }}" class="lt-toolbar" id="templateFilterForm">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                class="lt-search"
                placeholder="Cari template atau creator..."
            >

            <select name="category" class="lt-select" id="categoryFilter">
                <option value="">Semua kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->slug }}" @selected(request('category') === $category->slug)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <select name="price" class="lt-select" id="priceFilter">
                <option value="">Semua harga</option>
                <option value="free" @selected(request('price') === 'free')>Gratis</option>
                <option value="paid" @selected(request('price') === 'paid')>Berbayar</option>
            </select>

            <select name="sort" class="lt-select" id="sortFilter">
                <option value="latest" @selected(request('sort', 'latest') === 'latest')>Terbaru</option>
                <option value="price_asc" @selected(request('sort') === 'price_asc')>Harga terendah</option>
                <option value="price_desc" @selected(request('sort') === 'price_desc')>Harga tertinggi</option>
                <option value="name_asc" @selected(request('sort') === 'name_asc')>Nama A-Z</option>
            </select>

            <button type="submit" class="btn-gradient lt-submit">
                Terapkan
            </button>
        </form>

        @if ($templates->count() > 0)
            <div class="row g-4 mb-5">
                @foreach ($templates as $template)
                <div class="col-lg-3 col-md-4 col-6">
                    <a href="{{ route('user.template.show', $template) }}" class="editor-card lt-card-link">
                        <div class="editor-img-wrapper" style="height: 280px;">
                            <img src="{{ asset('storage/'.$template->preview) }}"
                                class="editor-img"
                                alt="{{ $template->title }}">

                            @if($template->category)
                                <span class="lt-category-badge">{{ $template->category->name }}</span>
                            @endif

                            @if($template->price == 0)
                                <span class="lt-free-badge">Gratis</span>
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
                                    Tipe Template: {{ $template->type }}
                                </div>

                                <div class="text-muted" style="font-size: .85rem">
                                    {{ $template->download_count }} download
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        @else
            <div class="welcome-section text-center">
                <h2 class="section-title" style="font-size: 1.6rem;">Template tidak ditemukan</h2>
                <p style="margin-bottom: 0;">Coba ubah filter atau kata kunci pencarian yang sedang dipakai.</p>
            </div>
        @endif

        @if ($templates->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $templates->links() }}
            </div>
        @endif

<script>
    (function () {
        const form = document.getElementById('templateFilterForm');

        if (!form) {
            return;
        }

        ['category', 'price', 'sort'].forEach((name) => {
            const field = form.elements.namedItem(name);

            if (!field) {
                return;
            }

            field.addEventListener('change', function () {
                form.submit();
            });
        });
    })();
</script>

@endsection
