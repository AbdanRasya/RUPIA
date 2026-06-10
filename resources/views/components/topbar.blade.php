<header class="topbar">
    <div class="topbar-left">
        <button id="sidebarToggle" class="btn-icon-top topbar-menu" type="button" aria-label="Buka menu">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
        <h1>@yield('header_title', 'Dashboard')</h1>
        <p>@yield('header_subtitle', 'Ringkasan finansialmu')</p>
    </div>
    <div class="topbar-right">
        <form action="{{ url('/history') }}" method="GET" class="topbar-search" style="margin:0; display:flex; align-items:center; background:var(--bg-page); border-radius:20px; padding:0.4rem 0.8rem;">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="color:var(--text-muted);"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            <label class="sr-only" for="globalSearch">Cari catatan</label>
            <input id="globalSearch" type="text" name="search" placeholder="Cari catatan..." autocomplete="off" style="border:none; background:transparent; outline:none; font-size:0.8rem; padding:0 0.5rem; width:150px; color:var(--text-main);" aria-label="Cari catatan">
        </form>
        <button id="themeToggle" class="btn-icon-top" type="button" aria-label="Ganti tema">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/></svg>
        </button>
        <div class="topbar-user dropdown-container" style="position: relative;">
            <div style="display: flex; align-items: center; gap: 0.6rem;">
                <div class="topbar-avatar">{{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}</div>
                <span class="topbar-name">{{ Auth::user()->name ?? 'Pengguna' }}</span>
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
            </div>
            <div class="dropdown-menu">
                <a href="{{ url('/wallets') }}">Dompet Saya</a>
                <a href="{{ url('/categories') }}">Kategori</a>
                <a href="{{ url('/statistik') }}">Statistik</a>
                <a href="{{ url('/calendar') }}">Aktifitas Bulanan</a>
                <a href="{{ url('/reminders') }}">Pengingat</a>
                <a href="{{ url('/achievements') }}">Pencapaian</a>
                <div class="dropdown-divider"></div>
                <a href="{{ url('/export/csv') }}">⬇️ Export CSV</a>
                <a href="{{ url('/export/json') }}">💾 Backup JSON</a>
                <div class="dropdown-divider"></div>
                <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                    @csrf
                    <button type="submit" style="width:100%; text-align:left; background:none; border:none; padding:0.5rem 1rem; cursor:pointer; color:var(--danger); font-size:0.8rem; font-weight:600;">Keluar</button>
                </form>
            </div>
        </div>
    </div>
</header>
