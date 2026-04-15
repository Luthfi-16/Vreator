@extends('layouts.user')
@section('content')
@php
    $paidTransaction = \App\Models\Transaction::where('user_id', auth()->id())
        ->where('template_id', $template->id)
        ->where('status', 'paid')
        ->exists();
@endphp
<div class="main-content">
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if (session('info'))
            <div class="alert alert-info">{{ session('info') }}</div>
        @endif
        
        <div class="row g-4">
            
            <!-- Left Side - Preview Image -->
            <div class="col-lg-6">
                <div class="welcome-section" style="padding: 0; overflow: hidden;">
                    @if ($template->type === 'video' && $template->preview_video)
                        <video controls playsinline style="width: 100%; height: auto; display: block;">
                            <source src="{{ asset('storage/' . $template->preview_video) }}">
                            Browser Anda tidak mendukung preview video.
                        </video>
                    @else
                        <img src="{{ asset ('storage/'.$template->preview)}}" 
                             alt="Preset - Sency" 
                             style="width: 100%; height: auto; display: block;">
                    @endif
                </div>
            </div>

            <!-- Right Side - Template Info -->
            <div class="col-lg-6">
                <div class="welcome-section">
                    
                    <!-- Title -->
                    <h1 style="font-size: 2.5rem; font-weight: 700; color: #2c3e50; margin-bottom: 15px;">
                        {{ $template->title }}
                    </h1>

                    <!-- Price -->
                    <h2 style="font-size: 2rem; font-weight: 700; color: #27ae60; margin-bottom: 25px;">
                        {{ $template->price == 0 ? 'Gratis' : 'IDR'.number_format($template->price) }}
                    </h2>
                    @if($template->rating_count > 0)
                        <div style="margin-bottom: 20px;">
                            <span style="color:#e67e22; font-size:1.2rem;">
                                ★ {{ number_format($template->average_rating, 1) }}
                            </span>
                            <span style="color:#6c757d;">
                                ({{ $template->rating_count }} review)
                            </span>
                        </div>
                    @endif

                    {{-- Action Button --}}
                    @if($template->price == 0 || $paidTransaction)

                        <a href="{{ route('user.template.download', $template) }}"
                        class="btn-gradient w-100 mb-3 text-center"
                        style="padding: 18px; font-size: 1.1rem;">
                            Download Template
                        </a>

                    @elseif($pendingTransaction)

                        <button id="pay-button"
                            class="btn-gradient w-100 mb-2"
                            data-checkout-url="{{ route('user.transactions.resume', $pendingTransaction) }}"
                            style="padding: 18px; font-size: 1.1rem;">
                            Lanjutkan Pembayaran
                        </button>

                    @else

                        <button id="pay-button"
                            class="btn-gradient w-100 mb-3"
                            data-checkout-url="{{ route('user.checkout.template', $template) }}"
                            style="padding: 18px; font-size: 1.1rem;">
                            Beli Sekarang
                        </button>

                    @endif
                    @if($hasDownloaded)
                        <button type="button"
                            class="w-100 mb-3"
                            data-bs-toggle="modal"
                            data-bs-target="#ratingModal"
                            style="
                                background: rgba(230, 126, 34, 0.08);
                                color: #e67e22;
                                border: 1.5px solid rgba(230, 126, 34, 0.3);
                                padding: 14px;
                                border-radius: 14px;
                                font-weight: 600;
                                transition: 0.3s;
                            "
                            onmouseover="this.style.background='rgba(230,126,34,0.15)'"
                            onmouseout="this.style.background='rgba(230,126,34,0.08)'"
                        >
                            ⭐ Beri Rating
                        </button>
                    @endif  
                    <!-- Description -->
                    <p style="color: #6c757d; font-size: 1.05rem; line-height: 1.6; margin-bottom: 25px;">
                        {{ $template->description}}
                    </p>
                    <!-- Meta Info -->
                    <div style="margin-bottom: 20px; font-size: 0.95rem; color: #6c757d;">

                        <!-- Type -->
                        <div>
                            <strong>Tipe Template:</strong> 
                            {{ ucfirst($template->type) }}
                        </div>

                        <!-- Software -->
                        <div>
                            <strong>Software yang digunakan:</strong> 
                            {{ $template->software->name ?? '-' }}
                        </div>

                        <!-- Category -->
                        <div>
                            <strong>Kategori:</strong> 
                            {{ $template->category->name ?? '-' }}
                        </div>

                    </div>

                    <!-- Cara Pembelian -->
                    <div style="background: linear-gradient(135deg, rgba(217, 111, 50, 0.1), rgba(248, 178, 89, 0.1)); padding: 25px; border-radius: 16px; margin-bottom: 25px;">
                        <h3 style="font-size: 1.3rem; font-weight: 700; color: #2c3e50; margin-bottom: 15px;">
                            Cara Pembelian
                        </h3>
                        <ol style="margin: 0; padding-left: 20px; color: #2c3e50; line-height: 1.8;">
                            <li>Klik tombol "Beli"</li>
                            <li>Lakukan pembayaran</li>
                            <li>Langsung download template anda</li>
                        </ol>
                    </div>

                    <!-- Creator Profile -->
                    <div style="border-top: 2px solid #e9ecef; padding-top: 25px;">
                        <h4 style="font-size: 0.9rem; color: #6c757d; margin-bottom: 15px; text-transform: uppercase; letter-spacing: 0.5px;">
                            Dibuat oleh
                        </h4>
                        <a href="{{ route('user.creator-profile', $template->user ) }}" style="text-decoration: none;">
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <!-- Creator Avatar -->
                                <img src="{{ asset ('storage/'. $template->user->profile_photo) }}" alt="" style="width: 60px; height: 60px; border-radius: 50%;">
                            
                            <!-- Creator Info -->
                            <div>
                                <h5 style="font-size: 1.15rem; font-weight: 700; color: #2c3e50; margin: 0;">
                                    {{ $template->user->name }}
                                </h5>
                                <p style="color: #6c757d; font-size: 0.9rem; margin: 5px 0 0 0;">
                                    {{ $template->user->bio}}
                                </p>
                            </div>
                        </div>
                        </a>
                    </div>

                </div>
            </div>

        </div>

        <!-- Related Templates / More from Creator -->
        <div style="margin-top: 60px;">
            <h2 class="section-title">Template Lainnya dari Creator Ini</h2>
            
            <div class="row g-4">
                @foreach($relatedTemplates as $relatedTemplate)
                    

                <!-- Related Template 1 -->
                <div class="col-12 col-sm-6 col-lg-3 template-card-grid-item">
                    <a href="{{ route('user.template.show', $relatedTemplate) }}" class="editor-card template-card">
                        <div class="editor-img-wrapper template-card-media">
                            <img src="{{ asset ('storage/'.$relatedTemplate->preview)}}"
                                class="editor-img"
                                alt="{{ $relatedTemplate->title }}">
                            {{-- <span class="editor-badge">Popular</span> --}}
                        </div>

                        <div class="editor-card-body template-card-body">
                            <h3 class="editor-name template-card-title">
                                {{ $relatedTemplate->title }}
                            </h3>

                            <p class="template-card-creator">
                                Creator : {{ $relatedTemplate->user->name ?? 'Creator Vreator' }}
                            </p>

                            <div class="template-card-footer">
                                <div class="template-card-rating">
                                    <i class="bi bi-star-fill"></i>
                                    <span>{{ number_format($relatedTemplate->average_rating ?? 0, 1) }}</span>
                                </div>

                                <span class="template-card-price">
                                    {{ $relatedTemplate->price == 0 ? 'Gratis' : 'IDR' . number_format($relatedTemplate->price, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach


            </div>
        </div>

    </div>
</div>
@if($hasDownloaded)
<div class="modal fade" id="ratingModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; border: none; box-shadow: 0 20px 50px rgba(0,0,0,0.1);">


            <form action="{{ route('user.template.rate', $template) }}" method="POST">
                @csrf

                <div class="modal-header border-0"
                    style="background: linear-gradient(135deg, #e67e22, #f39c12);">
                    <h5 class="modal-title text-white fw-bold">
                        Beri Rating
                    </h5>
                    <button type="button"
                            class="btn-close btn-close-white"
                            data-bs-dismiss="modal"></button>
                </div>


                <div class="modal-body text-center p-4">

                    <!-- ⭐ Interactive Stars -->
                    <div class="mb-4">
                        <div id="starRating" style="font-size: 2.5rem; cursor: pointer;">
                            <span data-value="1">☆</span>
                            <span data-value="2">☆</span>
                            <span data-value="3">☆</span>
                            <span data-value="4">☆</span>
                            <span data-value="5">☆</span>
                        </div>
                        <p id="ratingText" class="mt-2 text-muted">
                            Pilih rating anda
                        </p>
                        <input type="hidden" name="rating" id="ratingInput" required>
                    </div>

                </div>

                <div class="modal-footer border-0">
                    <button type="submit"
                            class="w-100"
                            style="
                                background: linear-gradient(135deg, #e67e22, #f39c12);
                                border: none;
                                color: white;
                                font-weight: 600;
                                padding: 14px;
                                border-radius: 12px;
                                transition: 0.3s;
                            "
                            onmouseover="this.style.opacity='0.85'"
                            onmouseout="this.style.opacity='1'">
                        Kirim Rating
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>

@endif
<script src="{{ config('midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
    data-client-key="{{ config('midtrans.client_key') }}">
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {

    const payBtn = document.getElementById('pay-button');
    if (!payBtn) return;

    payBtn.addEventListener('click', function (e) {

        e.preventDefault();

        fetch(payBtn.dataset.checkoutUrl, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            }
        })
        .then(async res => {
            const data = await res.json();

            if (!res.ok) {
                throw new Error(data.message || "Gagal memulai pembayaran");
            }

            return data;
        })
        .then(data => {

            if (!data.snap_token) {
                alert("Snap token tidak ada");
                return;
            }

            snap.pay(data.snap_token, {
                onSuccess: function(result){
                    window.location.href = "/user/payment/success?order_id=" + result.order_id;
                },
                onPending: function(result){
                    window.location.href = "/user/payment/success?order_id=" + result.order_id;
                },
                onClose: function() {
                    alert("Pembayaran belum selesai. Kamu bisa lanjutkan lagi dari halaman ini atau riwayat transaksi selama timer Midtrans masih aktif.");
                    window.location.reload();
                },
                onError: function(result){
                    alert("Pembayaran gagal");
                }
            });

        })
        .catch(err => alert(err.message || "Terjadi kesalahan saat memulai pembayaran"));

    });

});
</script>


<script>
document.addEventListener("DOMContentLoaded", function () {
    const stars = document.querySelectorAll("#starRating span");
    const ratingInput = document.getElementById("ratingInput");
    const ratingText = document.getElementById("ratingText");

    const texts = {
        1: "Sangat Buruk 😞",
        2: "Kurang 😐",
        3: "Lumayan 🙂",
        4: "Bagus 😍",
        5: "Sangat Bagus 🔥"
    };

    stars.forEach(star => {
        star.addEventListener("click", function () {
            const value = this.getAttribute("data-value");
            ratingInput.value = value;

            stars.forEach(s => {
                s.textContent = s.getAttribute("data-value") <= value ? "★" : "☆";
                s.style.color = s.getAttribute("data-value") <= value ? "#e67e22" : "#ccc";
            });

            ratingText.textContent = texts[value];
        });

        star.addEventListener("mouseover", function () {
            const value = this.getAttribute("data-value");

            stars.forEach(s => {
                s.textContent = s.getAttribute("data-value") <= value ? "★" : "☆";
            });
        });

        star.addEventListener("mouseout", function () {
            const currentValue = ratingInput.value;

            stars.forEach(s => {
                s.textContent = s.getAttribute("data-value") <= currentValue ? "★" : "☆";
            });
        });
    });
});
</script>




<script>
function copyLink() {
    const linkInput = document.getElementById('downloadLink');
    linkInput.select();
    linkInput.setSelectionRange(0, 99999); // For mobile devices
    
    navigator.clipboard.writeText(linkInput.value).then(function() {
        // Change button text temporarily
        const btn = event.target;
        const originalText = btn.textContent;
        btn.textContent = 'Tersalin!';
        
        setTimeout(function() {
            btn.textContent = originalText;
        }, 2000);
    }, function(err) {
        console.error('Could not copy text: ', err);
    });
}
</script>

@endsection
