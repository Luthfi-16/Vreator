    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h3>Menu</h3>
            <button class="sidebar-close" id="sidebarClose">
                <i class="bi bi-x"></i>
            </button>
        </div>
        <div class="sidebar-menu">
            <a href="{{ route('user.home') }}"
            class="sidebar-menu-item {{ request()->routeIs('user.home') ? 'active' : '' }}">
                <i class="bi bi-house-door-fill"></i>
                <span>Beranda</span>
            </a>

            <a href="{{ route('user.listtemplate') }}"
            class="sidebar-menu-item {{ request()->routeIs('user.listtemplate') ? 'active' : '' }}">
                <i class="bi bi-collection"></i>
                <span>Template</span>
            </a>

            <a href="{{ route('user.transactions.index') }}"
            class="sidebar-menu-item {{ request()->routeIs('user.transactions.*') ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i>
                <span>Riwayat Transaksi</span>
            </a>

        </div>
    </div>
