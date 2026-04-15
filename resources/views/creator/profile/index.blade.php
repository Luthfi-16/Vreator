@extends(auth()->user()->role === 'creator' ? 'layouts.creator' : 'layouts.user')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Lora:wght@400;600&family=Outfit:wght@300;400;500;600&display=swap');

    :root {
        --vr-blue: #3B5BDB;
        --vr-blue-mid: #4C6EF5;
        --vr-blue-light: #748FFC;
        --vr-blue-pale: #EEF2FF;
        --vr-blue-border: rgba(59, 91, 219, 0.14);
        --vr-bg: #EEF2FF;
        --vr-dark: #0F1E4A;
        --vr-muted: #7A8AB0;
        --vr-white: #ffffff;
    }

    .creator-profile-wrap {
        min-height: 100vh;
        display: flex;
        align-items: flex-start;
        justify-content: center;
        padding: 48px 20px 80px;
        font-family: 'Outfit', sans-serif;
    }

    .creator-profile-outer {
        width: 100%;
        max-width: 500px;
    }

    /* ── Card ── */
    .cp-card {
        background: var(--vr-white);
        border-radius: 28px;
        overflow: hidden;
        box-shadow:
            0 2px 4px rgba(59,91,219,0.06),
            0 20px 50px rgba(59,91,219,0.12);
        animation: cpFadeUp 0.5s cubic-bezier(.22,.68,0,1.2) both;
    }

    @keyframes cpFadeUp {
        from { opacity: 0; transform: translateY(28px) scale(0.98); }
        to   { opacity: 1; transform: translateY(0) scale(1); }
    }

    /* ── Banner ── */
    .cp-banner {
        height: 108px;
        background: linear-gradient(135deg, var(--vr-blue) 0%, var(--vr-blue-mid) 55%, var(--vr-blue-light) 100%);
        position: relative;
        overflow: hidden;
    }

    /* Geometric accent shapes */
    .cp-banner::before {
        content: '';
        position: absolute;
        width: 200px;
        height: 200px;
        border-radius: 50%;
        background: rgba(255,255,255,0.07);
        top: -80px;
        right: -40px;
    }

    .cp-banner::after {
        content: '';
        position: absolute;
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: rgba(255,255,255,0.05);
        bottom: -60px;
        left: 30px;
    }

    .cp-role-badge {
        position: absolute;
        top: 16px;
        right: 20px;
        z-index: 2;
        background: rgba(255,255,255,0.18);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255,255,255,0.28);
        border-radius: 20px;
        padding: 4px 13px;
        font-size: 10.5px;
        font-weight: 600;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: #fff;
    }

    /* ── Avatar ── */
    .cp-avatar-wrap {
        display: flex;
        justify-content: center;
        margin-top: -28px;
        position: relative;
        z-index: 3;
    }

    .cp-avatar-shell {
        padding: 8px;
        border-radius: 999px;
        background: rgba(255,255,255,0.88);
        box-shadow: 0 14px 28px rgba(59,91,219,0.16);
    }

    .cp-avatar-btn {
        width: 76px;
        height: 76px;
        border: 0;
        border-radius: 50%;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        background: linear-gradient(135deg, var(--vr-blue) 0%, var(--vr-blue-mid) 100%);
        color: #fff;
        font-size: 1.15rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        box-shadow: inset 0 0 0 3px #fff;
    }

    .cp-avatar-btn img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    /* ── Body ── */
    .cp-body {
        padding: 18px 36px 36px;
        text-align: center;
    }

    .cp-name {
        font-family: 'Lora', serif;
        font-size: 24px;
        font-weight: 600;
        color: var(--vr-dark);
        margin: 0 0 5px;
        letter-spacing: -0.2px;
    }

    .cp-email {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 13px;
        color: var(--vr-muted);
        font-weight: 400;
        margin-bottom: 22px;
    }

    .cp-divider {
        height: 1px;
        background: var(--vr-blue-border);
        border: none;
        margin: 0 0 22px;
    }

    /* ── Info Grid ── */
    .cp-info-grid {
        display: flex;
        flex-direction: column;
        gap: 11px;
        margin-bottom: 26px;
    }

    .cp-info-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        background: var(--vr-blue-pale);
        border: 1px solid var(--vr-blue-border);
        border-radius: 14px;
        padding: 13px 16px;
        text-align: left;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .cp-info-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(59,91,219,0.10);
    }

    .cp-info-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: var(--vr-blue);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        color: #fff;
    }

    .cp-info-label {
        font-size: 10px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: var(--vr-blue);
        margin-bottom: 2px;
    }

    .cp-info-value {
        font-size: 13.5px;
        font-weight: 500;
        color: var(--vr-dark);
        line-height: 1.4;
    }

    .cp-info-value.is-empty {
        color: var(--vr-muted);
        font-style: italic;
        font-weight: 400;
    }

    /* ── Button ── */
    .btn-cp-edit {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        padding: 13px 28px;
        border-radius: 14px;
        background: linear-gradient(135deg, var(--vr-blue) 0%, var(--vr-blue-mid) 100%);
        color: #fff;
        font-family: 'Outfit', sans-serif;
        font-size: 14.5px;
        font-weight: 600;
        letter-spacing: 0.2px;
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 16px rgba(59,91,219,0.38);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        text-decoration: none;
    }

    .btn-cp-edit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 28px rgba(59,91,219,0.48);
        color: #fff;
    }

    .btn-cp-edit:active {
        transform: translateY(0);
        box-shadow: 0 2px 8px rgba(59,91,219,0.28);
    }
</style>

<div class="creator-profile-wrap">
    <div class="creator-profile-outer">
        <div class="cp-card">

            {{-- Banner --}}
            <div class="cp-banner">
                <span class="cp-role-badge">Creator</span>
            </div>

            {{-- Avatar --}}
            <div class="cp-avatar-wrap">
                <div class="cp-avatar-shell">
                    <div class="cp-avatar-btn" aria-label="{{ auth()->user()->name }}">
                        @if (auth()->user()->profile_photo)
                            <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}"
                                alt="{{ auth()->user()->name }}">
                        @else
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}{{ strtoupper(substr(explode(' ', auth()->user()->name)[1] ?? '', 0, 1)) }}
                        @endif
                    </div>
                </div>
            </div>

            {{-- Body --}}
            <div class="cp-body">

                <h1 class="cp-name">{{ auth()->user()->name }}</h1>

                <p class="cp-email">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="4" width="20" height="16" rx="2"/>
                        <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                    </svg>
                    {{ auth()->user()->email }}
                </p>

                <hr class="cp-divider">

                <div class="cp-info-grid">

                    {{-- Bio --}}
                    <div class="cp-info-item">
                        <div class="cp-info-icon">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                        </div>
                        <div>
                            <p class="cp-info-label">Bio</p>
                            @if(auth()->user()->bio)
                                <p class="cp-info-value">{{ auth()->user()->bio }}</p>
                            @else
                                <p class="cp-info-value is-empty">Belum ada bio</p>
                            @endif
                        </div>
                    </div>

                    {{-- WhatsApp --}}
                    <div class="cp-info-item">
                        <div class="cp-info-icon">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.15 12a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.06 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.09 9.91a16 16 0 0 0 5 5l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="cp-info-label">WhatsApp</p>
                            @if(auth()->user()->whatsapp)
                                <p class="cp-info-value">{{ auth()->user()->whatsapp }}</p>
                            @else
                                <p class="cp-info-value is-empty">Belum ditambahkan</p>
                            @endif
                        </div>
                    </div>

                </div>

                {{-- Edit Button --}}
                <button class="btn-cp-edit"
                        data-bs-toggle="modal"
                        data-bs-target="#editProfileModal">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                    Edit Profil
                </button>

            </div>
        </div>
    </div>
</div>

{{-- MODAL --}}
@include('creator.profile.modal-edit')
@endsection
