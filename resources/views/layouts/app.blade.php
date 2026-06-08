<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rupia | @yield('title', 'Manajemen Keuangan')</title>
    <meta name="description" content="@yield('meta_description', 'Rupia membantu kamu mengelola keuangan harian, menabung, merencanakan masa depan, dan memantau transaksi dengan mudah.')">
    <meta name="theme-color" content="#00A550">
    <meta name="robots" content="index,follow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,400;0,14..32,500;0,14..32,600;0,14..32,700;1,14..32,400&display=swap');

        :root {
            --sidebar-bg: #1A2744;
            --sidebar-text: #8FA3C0;
            --sidebar-active-bg: rgba(255,255,255,0.1);
            --sidebar-active-text: #FFFFFF;
            --sidebar-hover-bg: rgba(255,255,255,0.06);
            --topbar-bg: #FFFFFF;
            --bg-page: #F4F6FA;
            --card-bg: #FFFFFF;
            --primary: #00A550;
            --primary-light: #E6F7EE;
            --primary-dark: #007A3B;
            --accent: #3B82F6;
            --danger: #EF4444;
            --danger-light: rgba(239, 68, 68, 0.12);
            --warning: #F59E0B;
            --warning-light: rgba(245, 158, 11, 0.14);
            --text-main: #1A2744;
            --text-muted: #6B7280;
            --border-color: #E5E7EB;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.08);
            --shadow-md: 0 4px 16px rgba(0,0,0,0.08);
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --sidebar-w: 220px;
            --topbar-h: 60px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { font-family: 'Inter', sans-serif; background: var(--bg-page); color: var(--text-main); display: flex; min-height: 100vh; -webkit-font-smoothing: antialiased; }

        /* Accessibility helpers */
        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }
        :focus-visible {
            outline: 3px solid color-mix(in oklab, var(--accent) 70%, white);
            outline-offset: 2px;
        }

        /* ── SIDEBAR ── */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--sidebar-bg);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 100;
            overflow-y: auto;
        }

        .sidebar-brand { padding: 1.5rem 1.25rem 1rem; border-bottom: 1px solid rgba(255,255,255,0.07); }
        .sidebar-brand a { font-size: 1.4rem; font-weight: 700; color: #FFFFFF; text-decoration: none; letter-spacing: -0.5px; }
        .sidebar-brand span { color: var(--primary); }

        .sidebar-section-label {
            font-size: 0.65rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1.2px; color: rgba(143,163,192,0.5); padding: 1.25rem 1.25rem 0.5rem;
        }

        .sidebar-nav { padding: 0.5rem 0.75rem; flex: 1; }
        .nav-item {
            display: flex; align-items: center; gap: 0.75rem; padding: 0.7rem 0.75rem; border-radius: var(--radius-sm); color: var(--sidebar-text); text-decoration: none; font-size: 0.875rem; font-weight: 500; transition: all 0.18s ease; margin-bottom: 2px;
        }
        .nav-item:hover { background: var(--sidebar-hover-bg); color: #FFFFFF; }
        .nav-item.active { background: var(--sidebar-active-bg); color: var(--sidebar-active-text); font-weight: 600; }
        .nav-item.active .nav-icon { color: var(--primary); }
        .nav-icon { width: 18px; height: 18px; flex-shrink: 0; }

        .sidebar-bottom { padding: 1rem 0.75rem; border-top: 1px solid rgba(255,255,255,0.07); }
        .sidebar-user { display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem; border-radius: var(--radius-sm); }
        .sidebar-avatar {
            width: 34px; height: 34px; background: var(--primary); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.85rem; flex-shrink: 0;
        }
        .sidebar-user-info { flex: 1; min-width: 0; }
        .sidebar-user-name { font-size: 0.8rem; font-weight: 600; color: #fff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .sidebar-user-role { font-size: 0.7rem; color: var(--sidebar-text); }

        .btn-logout-sidebar {
            width: 100%; margin-top: 0.5rem; background: rgba(239,68,68,0.12); color: #FC8181; border: none; padding: 0.6rem 0.75rem; border-radius: var(--radius-sm); font-size: 0.8rem; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 0.5rem; transition: 0.2s;
        }
        .btn-logout-sidebar:hover { background: rgba(239,68,68,0.2); }

        /* ── MAIN AREA ── */
        .main-area { margin-left: var(--sidebar-w); flex: 1; display: flex; flex-direction: column; min-height: 100vh; }

        /* ── TOPBAR ── */
        .topbar {
            height: var(--topbar-h); background: var(--topbar-bg); border-bottom: 1px solid var(--border-color); display: flex; align-items: center; justify-content: space-between; padding: 0 1.75rem; position: sticky; top: 0; z-index: 50; box-shadow: var(--shadow-sm);
        }
        .topbar-left h1 { font-size: 1rem; font-weight: 600; color: var(--text-main); }
        .topbar-left p { font-size: 0.75rem; color: var(--text-muted); margin-top: 1px; }

        .topbar-right { display: flex; align-items: center; gap: 1rem; }

        .topbar-user {
            display: flex; align-items: center; gap: 0.6rem; padding: 0.35rem 0.75rem 0.35rem 0.35rem; border-radius: 999px; border: 1px solid var(--border-color); background: var(--bg-page); cursor: pointer;
        }
        .topbar-avatar {
            width: 28px; height: 28px; background: var(--primary); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.75rem;
        }
        .topbar-name { font-size: 0.8rem; font-weight: 600; }

        .btn-icon-top {
            width: 34px; height: 34px; border-radius: 50%; border: 1px solid var(--border-color); background: transparent; display: flex; align-items: center; justify-content: center; cursor: pointer; color: var(--text-muted); transition: 0.2s;
        }
        .btn-icon-top:hover { background: var(--bg-page); color: var(--text-main); }

        /* ── PAGE CONTENT ── */
        .page-content { padding: 1.75rem; flex: 1; }

        /* General Utilities */
        .panel { background: var(--card-bg); border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 1.25rem; margin-bottom: 1.25rem; box-shadow: var(--shadow-sm); }
        .panel-title { font-size: 0.8rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.6px; color: var(--text-muted); margin-bottom: 1rem; }
        
        .btn { padding: 0.5rem 1rem; border-radius: var(--radius-sm); font-weight: 600; font-size: 0.8rem; cursor: pointer; text-decoration: none; transition: 0.18s; display: inline-flex; align-items: center; gap: 0.4rem; border: none; }
        .btn-primary { background: var(--primary); color: white; }
        .btn-primary:hover { background: var(--primary-dark); }
        .btn-outline { background: transparent; border: 1px solid var(--border-color); color: var(--text-main); }
        .btn-outline:hover { border-color: var(--primary); color: var(--primary); }
        .btn-danger { background: var(--danger); color: white; }
        .btn-danger:hover { background: #DC2626; }

        /* Forms */
        .form-group { margin-bottom: 1rem; }
        .form-label { display: block; font-size: 0.8rem; font-weight: 600; margin-bottom: 0.4rem; color: var(--text-main); }
        .form-control { width: 100%; padding: 0.6rem 0.8rem; border-radius: var(--radius-sm); border: 1px solid var(--border-color); background: var(--bg-page); color: var(--text-main); font-family: 'Inter', sans-serif; outline: none; transition: 0.2s; }
        .form-control:focus { border-color: var(--primary); }

        /* Alerts */
        .alert { padding: 1rem; border-radius: var(--radius-sm); margin-bottom: 1rem; font-size: 0.85rem; display: flex; align-items: center; gap: 0.5rem; }
        .alert-success { background: var(--primary-light); color: var(--primary-dark); border: 1px solid var(--primary); }
        .alert-error { background: var(--danger-light); color: var(--danger); border: 1px solid var(--danger); }

        /* ── RESPONSIVE ── */
        .topbar-menu { display: none; }
        .sidebar-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.45);
            backdrop-filter: blur(2px);
            z-index: 90;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s ease;
        }

        @media (max-width: 900px) {
            :root { --sidebar-w: 210px; }
            .page-content { padding: 1.25rem; }
            .topbar { padding: 0 1.25rem; }
        }

        @media (max-width: 768px) {
            body { display: block; }
            .topbar-menu { display: inline-flex; }
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.22s ease;
            }
            body.sidebar-open .sidebar { transform: translateX(0); }
            body.sidebar-open .sidebar-backdrop { opacity: 1; pointer-events: auto; }
            .main-area { margin-left: 0; }
            .topbar { padding: 0 1rem; }
            .topbar-right form { display: none !important; }
            .chat-panel { right: 1rem !important; width: calc(100vw - 2rem) !important; max-width: 420px; }
            .chatbot-fab { right: 1rem !important; bottom: 1rem !important; }
        }
        
        @yield('styles')
    </style>
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    @yield('head')
</head>
<body>
    <aside class="sidebar">
        <div class="sidebar-brand">
            <a href="{{ url('/') }}">Rupia<span>.</span></a>
        </div>

        <div class="sidebar-section-label">Menu Utama</div>
        <nav class="sidebar-nav">
            <a href="{{ url('/') }}" class="nav-item {{ request()->is('/') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Beranda
            </a>
            <a href="{{ url('/saving') }}" class="nav-item {{ request()->is('saving*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                Tabungan
            </a>
            <a href="{{ url('/budgets') }}" class="nav-item {{ request()->is('budgets*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                Budget
            </a>
            <a href="{{ url('/planner') }}" class="nav-item {{ request()->is('planner*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                Planner
            </a>

            <div class="sidebar-section-label" style="padding-left:0; padding-top:1.25rem;">Transaksi</div>
            <a href="{{ url('/history') }}" class="nav-item {{ request()->is('history*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Riwayat Transaksi
            </a>
            <a href="{{ url('/topup') }}" class="nav-item {{ request()->is('topup*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Catat Pemasukan
            </a>
            <a href="{{ url('/transaction/create') }}" class="nav-item {{ request()->is('transaction/create*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/></svg>
                Catat Pengeluaran
            </a>
            <a href="{{ url('/transfer') }}" class="nav-item {{ request()->is('transfer*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                Transfer
            </a>
            <a href="{{ url('/pay') }}" class="nav-item {{ request()->is('pay*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                Pembayaran
            </a>
            
            <div class="sidebar-section-label" style="padding-left:0; padding-top:1.25rem;">Lainnya</div>
            <a href="{{ url('/wallets') }}" class="nav-item {{ request()->is('wallets*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                Dompet Saya
            </a>
            <a href="{{ url('/categories') }}" class="nav-item {{ request()->is('categories*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                Kategori
            </a>
            <a href="{{ url('/statistik') }}" class="nav-item {{ request()->is('statistik*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                Statistik
            </a>
            <a href="{{ url('/calendar') }}" class="nav-item {{ request()->is('calendar*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                Kalender
            </a>
            <a href="{{ url('/reminders') }}" class="nav-item {{ request()->is('reminders*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Pengingat
            </a>
            <div style="padding: 0.5rem 0.75rem;">
                <a href="{{ url('/export/csv') }}" class="btn btn-outline" style="width:100%; justify-content:center; font-size:0.75rem; padding:0.4rem; margin-bottom:0.4rem;">⬇️ Export CSV</a>
                <a href="{{ url('/export/json') }}" class="btn btn-outline" style="width:100%; justify-content:center; font-size:0.75rem; padding:0.4rem;">💾 Backup JSON</a>
            </div>
            <a href="{{ url('/education') }}" class="nav-item {{ request()->is('education*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                Edukasi
            </a>
            <a href="{{ url('/achievements') }}" class="nav-item {{ request()->is('achievements*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                Pencapaian
            </a>
        </nav>

        <div class="sidebar-bottom">
            <div class="sidebar-user">
                <div class="sidebar-avatar">{{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}</div>
                <div class="sidebar-user-info">
                    <div class="sidebar-user-name">{{ Auth::user()->name ?? 'Pengguna' }}</div>
                    <div class="sidebar-user-role">Member Aktif</div>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                @csrf
                <button type="submit" class="btn-logout-sidebar">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>
    <div class="sidebar-backdrop" id="sidebarBackdrop" aria-hidden="true"></div>

    <div class="main-area">
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
                <form action="{{ url('/history') }}" method="GET" style="margin:0; display:flex; align-items:center; background:var(--bg-page); border:1px solid var(--border-color); border-radius:999px; padding:0.2rem 0.6rem;">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="color:var(--text-muted);"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <label class="sr-only" for="globalSearch">Cari catatan</label>
                    <input id="globalSearch" type="text" name="search" placeholder="Cari catatan..." autocomplete="off" style="border:none; background:transparent; outline:none; font-size:0.8rem; padding:0.3rem 0.5rem; width:150px; color:var(--text-main);" aria-label="Cari catatan">
                </form>
                <button id="themeToggle" class="btn-icon-top" type="button" aria-label="Ganti tema">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/></svg>
                </button>
                <div class="topbar-user">
                    <div class="topbar-avatar">{{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}</div>
                    <span class="topbar-name">{{ Auth::user()->name ?? 'Pengguna' }}</span>
                </div>
            </div>
        </header>

        <main class="page-content">
            @if(session('success'))
                <div class="alert alert-success">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-error">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Chatbot FAB (Global) -->
    <div class="chatbot-fab" id="chatbotFab" role="button" tabindex="0" aria-label="Buka chat Rupia AI" title="Tanya AI" style="position:fixed; bottom:2rem; right:2.5rem; width:56px; height:56px; background:var(--primary); color:white; border-radius:50%; display:flex; align-items:center; justify-content:center; box-shadow:0 4px 16px rgba(0,165,80,0.3); cursor:pointer; z-index:1000; transition:0.3s;">
        <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
    </div>

    <!-- Chat Panel -->
    <div class="chat-panel" id="chatPanel" role="dialog" aria-label="Rupia AI Chat" aria-modal="false" style="position:fixed; bottom:6rem; right:2.5rem; width:340px; height:480px; background:var(--card-bg); border:1px solid var(--border-color); border-radius:var(--radius-lg); box-shadow:var(--shadow-md); display:flex; flex-direction:column; z-index:1001; display:none;">
        <div style="background:var(--sidebar-bg); padding:0.85rem 1rem; border-top-left-radius:calc(var(--radius-lg) - 1px); border-top-right-radius:calc(var(--radius-lg) - 1px); display:flex; align-items:center; justify-content:space-between;">
            <div style="display:flex; align-items:center; gap:0.6rem;">
                <div style="width:30px; height:30px; background:var(--primary); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:0.75rem; font-weight:700; color:#fff;">AI</div>
                <div>
                    <h4 style="margin:0; font-size:0.85rem; font-weight:600; color:#fff;">Rupia AI</h4>
                    <span style="font-size:0.65rem; color:rgba(255,255,255,0.65); display:block;">Online</span>
                </div>
            </div>
            <button id="closeChatBtn" type="button" aria-label="Tutup chat" style="background:none; border:none; color:#fff; cursor:pointer;">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div id="chatMessages" style="flex:1; padding:1rem; overflow-y:auto; display:flex; flex-direction:column; gap:0.75rem; background:var(--bg-page);">
            <div style="max-width:80%; padding:0.65rem 0.85rem; border-radius:var(--radius-md); font-size:0.825rem; line-height:1.4; background:var(--card-bg); color:var(--text-main); align-self:flex-start; border-bottom-left-radius:4px; border:1px solid var(--border-color);">Halo! Ada yang bisa saya bantu seputar keuangan?</div>
        </div>
        <div style="padding:0.75rem; background:var(--card-bg); border-top:1px solid var(--border-color); display:flex; gap:0.5rem; border-bottom-left-radius:calc(var(--radius-lg) - 1px); border-bottom-right-radius:calc(var(--radius-lg) - 1px);">
            <label class="sr-only" for="chatInput">Ketik pesan untuk Rupia AI</label>
            <input type="text" id="chatInput" placeholder="Ketik pesan..." autocomplete="off" style="flex:1; border:1px solid var(--border-color); background:var(--bg-page); color:var(--text-main); padding:0.55rem 0.75rem; border-radius:var(--radius-sm); font-size:0.825rem; outline:none;">
            <button id="sendChatBtn" type="button" aria-label="Kirim pesan" style="background:var(--primary); color:white; border:none; padding:0 0.85rem; border-radius:var(--radius-sm); cursor:pointer;">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </button>
        </div>
    </div>

    @yield('scripts')
    
    <script>
        // Theme logic
        const savedTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-theme', savedTheme);
        const themeBtn = document.getElementById('themeToggle');
        const moonSVG = `<svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/></svg>`;
        const sunSVG  = `<svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>`;
        if(themeBtn) {
            themeBtn.innerHTML = savedTheme === 'dark' ? sunSVG : moonSVG;
            themeBtn.addEventListener('click', () => {
                const next = document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
                document.documentElement.setAttribute('data-theme', next);
                localStorage.setItem('theme', next);
                themeBtn.innerHTML = next === 'dark' ? sunSVG : moonSVG;
                window.dispatchEvent(new Event('themeChanged'));
            });
        }

        // Mobile sidebar toggle
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarBackdrop = document.getElementById('sidebarBackdrop');

        function closeSidebar() {
            document.body.classList.remove('sidebar-open');
        }
        function toggleSidebar() {
            document.body.classList.toggle('sidebar-open');
        }
        if (sidebarToggle) sidebarToggle.addEventListener('click', toggleSidebar);
        if (sidebarBackdrop) sidebarBackdrop.addEventListener('click', closeSidebar);
        window.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeSidebar();
        });

        // Global Chatbot Logic
        const chatbotFab = document.getElementById('chatbotFab');
        const chatPanel = document.getElementById('chatPanel');
        const closeChatBtn = document.getElementById('closeChatBtn');
        const chatInput = document.getElementById('chatInput');
        const sendChatBtn = document.getElementById('sendChatBtn');
        const chatMessages = document.getElementById('chatMessages');

        if(chatbotFab && chatPanel) {
            function openChat() {
                chatPanel.style.display = 'flex';
                setTimeout(() => chatInput?.focus(), 0);
            }
            function closeChat() {
                chatPanel.style.display = 'none';
                chatbotFab?.focus?.();
            }
            function toggleChat() {
                const isOpen = chatPanel.style.display === 'flex';
                isOpen ? closeChat() : openChat();
            }

            chatbotFab.addEventListener('click', toggleChat);
            chatbotFab.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    toggleChat();
                }
            });
            closeChatBtn?.addEventListener('click', closeChat);
            window.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') closeChat();
            });

            function appendMessage(text, type) {
                const div = document.createElement('div');
                div.style.cssText = type === 'user' 
                    ? 'max-width:80%; padding:0.65rem 0.85rem; border-radius:var(--radius-md); font-size:0.825rem; line-height:1.4; background:var(--primary); color:white; align-self:flex-end; border-bottom-right-radius:4px;'
                    : 'max-width:80%; padding:0.65rem 0.85rem; border-radius:var(--radius-md); font-size:0.825rem; line-height:1.4; background:var(--card-bg); color:var(--text-main); align-self:flex-start; border-bottom-left-radius:4px; border:1px solid var(--border-color);';
                div.textContent = text;
                chatMessages.appendChild(div);
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }

            function sendMessage() {
                const text = chatInput.value.trim();
                if(!text) return;
                
                appendMessage(text, 'user');
                chatInput.value = '';
                
                fetch('/send-chat', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ message: text })
                })
                .then(async (res) => {
                    const contentType = res.headers.get('content-type') || '';
                    if (!res.ok) throw new Error(`HTTP ${res.status}`);
                    if (!contentType.includes('application/json')) throw new Error('Non-JSON response');
                    return res.json();
                })
                .then(data => appendMessage(data?.reply ?? 'Maaf, balasan tidak tersedia.', 'bot'))
                .catch(() => appendMessage('Error koneksi AI. Coba lagi nanti.', 'bot'));
            }

            sendChatBtn.addEventListener('click', sendMessage);
            chatInput.addEventListener('keypress', (e) => { if(e.key === 'Enter') sendMessage(); });
        }
    </script>
</body>
</html>
