    <!-- Navbar -->
    <nav class="navbar-custom">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center w-100">
                <!-- Logo -->
                <a class="navbar-brand d-flex align-items-center " href="{{ url('user/home')}}">
                    <img src="{{ asset ('landing/img/LandingVreator1.png') }}"
                        alt="Vreator Logo"
                        class="brand-logo">
                    <span class="brand-text">reator</span>
                </a>
                    
                <!-- Right Side -->
                <div class="d-flex align-items-center gap-3">
                    <!-- Profile Dropdown -->
                    <div class="profile-dropdown">
                        <button class="profile-btn" id="profileBtn">
                            @if(Auth::user()->profile_photo)
                                <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}"
                                    alt="Profile"
                                    style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%;">
                            @else
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                {{ strtoupper(substr(explode(' ', Auth::user()->name)[1] ?? '', 0, 1)) }}
                            @endif
                        </button>
                        <div class="profile-menu" id="profileMenu">
                            <a href="{{ route('user.profile.index') }}" class="profile-menu-item">
                                <i class="bi bi-person"></i>
                                <span>Profil Saya</span>
                            </a>
                            <div class="profile-menu-divider"></div>
                            <a href="{{ route('logout') }}" class="profile-menu-item" 
                                onclick="event.preventDefault(); 
                                document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Keluar</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                    
                    <!-- Menu Toggle -->
                    <button class="menu-toggle" id="menuToggle">
                        <i class="bi bi-list"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>