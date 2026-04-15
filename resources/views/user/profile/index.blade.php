@extends(auth()->user()->role === 'creator' ? 'layouts.creator' : 'layouts.user')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600&family=DM+Sans:wght@300;400;500;600&display=swap');

    :root {
        --vreator-orange: #E8821A;
        --vreator-orange-light: #F5A24B;
        --vreator-orange-pale: #FFF4E8;
        --vreator-cream: #F5F0E8;
        --vreator-dark: #1A1208;
        --vreator-muted: #8A7B6A;
        --vreator-border: rgba(232, 130, 26, 0.15);
    }

    .profile-page-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: flex-start;
        justify-content: center;
        padding: 48px 16px 80px;
        font-family: 'DM Sans', sans-serif;
    }

    .profile-outer {
        width: 100%;
        max-width: 520px;
    }

    /* ── Hero Card ── */
    .profile-hero {
        background: #ffffff;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0,0,0,0.04), 0 20px 50px rgba(232,130,26,0.10);
        position: relative;
    }

    /* Decorative top banner */
    .profile-banner {
        height: 110px;
        background: linear-gradient(135deg, var(--vreator-orange) 0%, var(--vreator-orange-light) 60%, #FBCEA0 100%);
        position: relative;
        overflow: hidden;
    }

    .profile-banner::before {
        content: '';
        position: absolute;
        inset: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.08'%3E%3Ccircle cx='30' cy='30' r='20'/%3E%3Ccircle cx='0' cy='0' r='20'/%3E%3Ccircle cx='60' cy='60' r='20'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    .profile-banner-label {
        position: absolute;
        top: 16px;
        right: 20px;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255,255,255,0.3);
        border-radius: 20px;
        padding: 4px 12px;
        font-size: 11px;
        font-weight: 600;
        color: #fff;
        letter-spacing: 0.8px;
        text-transform: uppercase;
    }

    /* ── Avatar ── */
    .profile-avatar-wrap {
        display: flex;
        justify-content: center;
        margin-top: -28px;
        position: relative;
        z-index: 2;
    }

    .profile-avatar-shell {
        padding: 8px;
        border-radius: 999px;
        background: rgba(255,255,255,0.92);
        box-shadow: 0 14px 28px rgba(232,130,26,0.16);
    }

    .profile-avatar-btn {
        width: 76px;
        height: 76px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        background: linear-gradient(135deg, var(--vreator-orange) 0%, var(--vreator-orange-light) 100%);
        color: #fff;
        font-size: 1.15rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        box-shadow: inset 0 0 0 3px #fff;
    }

    .profile-avatar-btn img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    /* ── Body ── */
    .profile-body {
        padding: 20px 36px 36px;
        text-align: center;
    }

    .profile-name {
        font-size: 26px;
        font-weight: 600;
        color: var(--vreator-dark);
        margin: 0 0 4px;
        letter-spacing: -0.3px;
    }

    .profile-email {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 13.5px;
        color: var(--vreator-muted);
        font-weight: 400;
        margin-bottom: 24px;
    }

    .profile-email svg {
        opacity: 0.6;
    }

    /* ── Divider ── */
    .profile-divider {
        height: 1px;
        background: var(--vreator-border);
        margin: 0 0 24px;
        border: none;
    }

    /* ── Info rows ── */
    .profile-info-grid {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-bottom: 28px;
    }

    .profile-info-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        background: var(--vreator-orange-pale);
        border: 1px solid var(--vreator-border);
        border-radius: 14px;
        padding: 14px 18px;
        text-align: left;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .profile-info-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(232,130,26,0.12);
    }

    .profile-info-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: var(--vreator-orange);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .profile-info-icon svg {
        color: #fff;
    }

    .profile-info-text {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .profile-info-label {
        font-size: 10.5px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.7px;
        color: var(--vreator-orange);
        margin-bottom: 2px;
    }

    .profile-info-value {
        font-size: 14px;
        font-weight: 500;
        color: var(--vreator-dark);
    }

    .profile-info-value.muted {
        color: var(--vreator-muted);
        font-style: italic;
        font-weight: 400;
    }

    /* ── CTA Button ── */
    .btn-edit-profile {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        padding: 14px 28px;
        border-radius: 14px;
        background: linear-gradient(135deg, var(--vreator-orange) 0%, var(--vreator-orange-light) 100%);
        color: #fff;
        font-family: 'DM Sans', sans-serif;
        font-size: 15px;
        font-weight: 600;
        letter-spacing: 0.2px;
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 16px rgba(232,130,26,0.40);
        transition: transform 0.2s ease, box-shadow 0.2s ease, opacity 0.2s ease;
        text-decoration: none;
    }

    .btn-edit-profile:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 28px rgba(232,130,26,0.50);
        color: #fff;
        opacity: 0.95;
    }

    .btn-edit-profile:active {
        transform: translateY(0);
        box-shadow: 0 2px 8px rgba(232,130,26,0.30);
    }

    /* ── Fade-in animation ── */
    @keyframes fadeSlideUp {
        from { opacity: 0; transform: translateY(24px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .profile-hero {
        animation: fadeSlideUp 0.5s ease both;
    }
</style>

<div class="profile-page-wrapper">
    <div class="profile-outer">
        <div class="profile-hero">

            {{-- Banner --}}
            <div class="profile-banner">
            </div>

            {{-- Avatar --}}
            <div class="profile-avatar-wrap">
                <div class="profile-avatar-shell">
                    <div class="profile-avatar-btn" aria-label="{{ auth()->user()->name }}">
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
            <div class="profile-body">

                <h1 class="profile-name">{{ auth()->user()->name }}</h1>

                <p class="profile-email">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                    </svg>
                    {{ auth()->user()->email }}
                </p>

                <hr class="profile-divider">

                <div class="profile-info-grid">

                    {{-- Bio --}}
                    <div class="profile-info-item">
                        <div class="profile-info-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                            </svg>
                        </div>
                        <div class="profile-info-text">
                            <span class="profile-info-label">Bio</span>
                            @if(auth()->user()->bio)
                                <span class="profile-info-value">{{ auth()->user()->bio }}</span>
                            @else
                                <span class="profile-info-value muted">Belum ada bio</span>
                            @endif
                        </div>
                    </div>

                    {{-- WhatsApp --}}
                    <div class="profile-info-item">
                        <div class="profile-info-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.15 12a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.06 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.09 9.91a16 16 0 0 0 5 5l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
                            </svg>
                        </div>
                        <div class="profile-info-text">
                            <span class="profile-info-label">WhatsApp</span>
                            @if(auth()->user()->whatsapp)
                                <span class="profile-info-value">{{ auth()->user()->whatsapp }}</span>
                            @else
                                <span class="profile-info-value muted">Belum ditambahkan</span>
                            @endif
                        </div>
                    </div>

                </div>

                {{-- Edit Button --}}
                <button class="btn-edit-profile"
                        data-bs-toggle="modal"
                        data-bs-target="#editProfileModal">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                    Edit Profile
                </button>

            </div>
        </div>
    </div>
</div>

{{-- MODAL --}}
@include('user.profile.modal-edit')
@endsection
