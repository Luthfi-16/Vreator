    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top" style="background-color: #FAF6F0;">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center " href="#">
                <img src="{{ asset ('landing/img/LandingVreator1.png') }}"
                    alt="Vreator Logo"
                    class="brand-logo">
                <span class="brand-text">reator</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#fitur">Fitur</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#editor">Cari Editor</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#harga">Harga</a>
                    </li>
                </ul>
                @auth
                <a href="{{ auth()->user()->role === 'creator' ? route('creator.profile.index') : route('profile.index') }}" class="btn btn-gradient rounded-pill px-4"><i class="bi bi-person-fill"></i></a>
                @else
                <button class="btn btn-gradient rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#loginModal">Daftar Sekarang</button>
                @endauth
            </div>
        </div>
    </nav>