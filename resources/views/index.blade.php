<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rupia | Beranda</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            --warning: #F59E0B;
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
        body { font-family: 'Inter', sans-serif; background: var(--bg-page); color: var(--text-main); display: flex; min-height: 100vh; -webkit-font-smoothing: antialiased; }

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

        .sidebar-brand {
            padding: 1.5rem 1.25rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.07);
        }
        .sidebar-brand a {
            font-size: 1.4rem;
            font-weight: 700;
            color: #FFFFFF;
            text-decoration: none;
            letter-spacing: -0.5px;
        }
        .sidebar-brand span { color: var(--primary); }

        .sidebar-section-label {
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: rgba(143,163,192,0.5);
            padding: 1.25rem 1.25rem 0.5rem;
        }

        .sidebar-nav { padding: 0.5rem 0.75rem; flex: 1; }
        .nav-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.7rem 0.75rem;
            border-radius: var(--radius-sm);
            color: var(--sidebar-text);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.18s ease;
            margin-bottom: 2px;
            cursor: pointer;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
        }
        .nav-item:hover { background: var(--sidebar-hover-bg); color: #FFFFFF; }
        .nav-item.active { background: var(--sidebar-active-bg); color: var(--sidebar-active-text); font-weight: 600; }
        .nav-item.active .nav-icon { color: var(--primary); }
        .nav-icon { width: 18px; height: 18px; flex-shrink: 0; }

        .sidebar-bottom {
            padding: 1rem 0.75rem;
            border-top: 1px solid rgba(255,255,255,0.07);
        }
        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem;
            border-radius: var(--radius-sm);
        }
        .sidebar-avatar {
            width: 34px; height: 34px;
            background: var(--primary);
            color: #fff;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 0.85rem;
            flex-shrink: 0;
        }
        .sidebar-user-info { flex: 1; min-width: 0; }
        .sidebar-user-name { font-size: 0.8rem; font-weight: 600; color: #fff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .sidebar-user-role { font-size: 0.7rem; color: var(--sidebar-text); }

        .btn-logout-sidebar {
            width: 100%;
            margin-top: 0.5rem;
            background: rgba(239,68,68,0.12);
            color: #FC8181;
            border: none;
            padding: 0.6rem 0.75rem;
            border-radius: var(--radius-sm);
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: 0.2s;
        }
        .btn-logout-sidebar:hover { background: rgba(239,68,68,0.2); }

        /* ── MAIN AREA ── */
        .main-area {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* ── TOPBAR ── */
        .topbar {
            height: var(--topbar-h);
            background: var(--topbar-bg);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.75rem;
            position: sticky; top: 0; z-index: 50;
            box-shadow: var(--shadow-sm);
        }
        .topbar-left h1 { font-size: 1rem; font-weight: 600; color: var(--text-main); }
        .topbar-left p { font-size: 0.75rem; color: var(--text-muted); margin-top: 1px; }

        .topbar-right { display: flex; align-items: center; gap: 1rem; }

        .badge-verified {
            display: flex; align-items: center; gap: 0.4rem;
            background: var(--primary-light);
            color: var(--primary-dark);
            font-size: 0.72rem;
            font-weight: 600;
            padding: 0.3rem 0.75rem;
            border-radius: 999px;
        }
        .badge-verified svg { width: 12px; height: 12px; }

        .topbar-user {
            display: flex; align-items: center; gap: 0.6rem;
            padding: 0.35rem 0.75rem 0.35rem 0.35rem;
            border-radius: 999px;
            border: 1px solid var(--border-color);
            background: var(--bg-page);
            cursor: pointer;
        }
        .topbar-avatar {
            width: 28px; height: 28px;
            background: var(--primary);
            color: #fff;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 0.75rem;
        }
        .topbar-name { font-size: 0.8rem; font-weight: 600; }

        .btn-icon-top {
            width: 34px; height: 34px;
            border-radius: 50%;
            border: 1px solid var(--border-color);
            background: transparent;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            color: var(--text-muted);
            transition: 0.2s;
        }
        .btn-icon-top:hover { background: var(--bg-page); color: var(--text-main); }

        /* ── PAGE CONTENT ── */
        .page-content { padding: 1.75rem; flex: 1; }

        /* ── TOGGLE ROW ── */
        .toggle-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 0.9rem 1.25rem;
            margin-bottom: 1.5rem;
            box-shadow: var(--shadow-sm);
        }
        .toggle-info h4 { font-size: 0.875rem; font-weight: 600; color: var(--text-main); }
        .toggle-info p { font-size: 0.75rem; color: var(--text-muted); margin-top: 2px; }

        .switch { width: 36px; height: 20px; position: relative; display: inline-block; }
        .switch input { opacity: 0; width: 0; height: 0; }
        .slider { position: absolute; cursor: pointer; inset: 0; background: var(--border-color); transition: .3s; border-radius: 20px; }
        .slider:before { position: absolute; content: ""; height: 14px; width: 14px; left: 3px; bottom: 3px; background: white; transition: .3s; border-radius: 50%; box-shadow: 0 1px 3px rgba(0,0,0,0.15); }
        input:checked + .slider { background: var(--primary); }
        input:checked + .slider:before { transform: translateX(16px); }

        /* ── GRID ── */
        .main-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; }
        @media (max-width: 960px) { .main-grid { grid-template-columns: 1fr; } }

        /* ── BALANCE CARD ── */
        .balance-card {
            background: linear-gradient(135deg, #00A550 0%, #0077B6 100%);
            color: #FFFFFF;
            border-radius: var(--radius-lg);
            padding: 1.75rem;
            margin-bottom: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 8px 24px rgba(0,165,80,0.25);
            position: relative;
            overflow: hidden;
        }
        .balance-card::before {
            content: '';
            position: absolute;
            top: -40px; right: -40px;
            width: 160px; height: 160px;
            border-radius: 50%;
            background: rgba(255,255,255,0.07);
        }
        .balance-card::after {
            content: '';
            position: absolute;
            bottom: -60px; right: 60px;
            width: 200px; height: 200px;
            border-radius: 50%;
            background: rgba(255,255,255,0.05);
        }

        .balance-label { font-size: 0.7rem; font-weight: 500; letter-spacing: 1px; color: rgba(255,255,255,0.7); margin-bottom: 0.4rem; display: block; text-transform: uppercase; }
        .balance-amount { font-size: 2.2rem; font-weight: 700; letter-spacing: -1px; margin-bottom: 1.25rem; line-height: 1; }

        .health-badge { display: flex; flex-direction: column; align-items: flex-end; position: relative; z-index: 1; }
        .health-score { font-size: 2rem; font-weight: 700; color: rgba(255,255,255,0.95); line-height: 1; }
        .health-text { font-size: 0.65rem; color: rgba(255,255,255,0.6); letter-spacing: 0.5px; text-transform: uppercase; margin-top: 0.2rem; }

        /* ── BUTTONS ── */
        .btn-group { display: flex; gap: 0.6rem; }
        .btn { padding: 0.5rem 1rem; border-radius: var(--radius-sm); font-weight: 600; font-size: 0.8rem; cursor: pointer; text-decoration: none; transition: 0.18s; display: inline-flex; align-items: center; gap: 0.4rem; border: none; }
        .btn-white { background: #FFFFFF; color: var(--primary-dark); }
        .btn-white:hover { background: #f0fdf4; }
        .btn-ghost-white { background: rgba(255,255,255,0.15); color: #FFFFFF; border: 1px solid rgba(255,255,255,0.3); }
        .btn-ghost-white:hover { background: rgba(255,255,255,0.25); }

        /* ── SHORTCUT GRID ── */
        .section-title { font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.8px; color: var(--text-muted); margin-bottom: 0.875rem; }

        .shortcut-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 0.875rem; }
        .shortcut-item {
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            padding: 1.1rem 0.75rem;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            text-decoration: none; color: var(--text-main);
            transition: all 0.18s ease;
            text-align: center;
            box-shadow: var(--shadow-sm);
        }
        .shortcut-item:hover { border-color: var(--primary); box-shadow: 0 4px 12px rgba(0,165,80,0.12); transform: translateY(-2px); }
        .shortcut-icon-wrap {
            width: 40px; height: 40px;
            background: var(--primary-light);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 0.6rem;
            color: var(--primary);
        }
        .shortcut-icon-wrap svg { width: 18px; height: 18px; }
        .shortcut-label { font-size: 0.75rem; font-weight: 600; color: var(--text-main); }

        /* ── PANEL ── */
        .panel { background: var(--card-bg); border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 1.25rem; margin-bottom: 1.25rem; box-shadow: var(--shadow-sm); }
        .panel-title { font-size: 0.8rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.6px; color: var(--text-muted); margin-bottom: 1rem; }

        /* ── LIST ITEMS ── */
        .list-item { display: flex; justify-content: space-between; align-items: center; padding: 0.7rem 0; border-bottom: 1px solid var(--border-color); }
        .list-item:last-child { border-bottom: none; padding-bottom: 0; }
        .list-label { font-size: 0.825rem; font-weight: 500; color: var(--text-muted); }
        .list-value { font-size: 0.875rem; font-weight: 700; color: var(--text-main); }
        .list-value.accent { color: var(--primary); }

        /* ── CHATBOT FAB ── */
        .chatbot-fab {
            position: fixed;
            bottom: 2rem;
            right: 2.5rem;
            width: 56px;
            height: 56px;
            background: var(--primary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 16px rgba(0,165,80,0.3);
            cursor: pointer;
            transition: 0.3s;
            z-index: 1000;
        }
        .chatbot-fab:hover {
            transform: translateY(-4px) scale(1.05);
            background: var(--primary-dark);
        }

        /* ── INTERACTIVE AI CHAT CONTAINER ── */
        .chat-panel {
            position: fixed;
            bottom: 6rem;
            right: 2.5rem;
            width: 360px;
            height: 480px;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-md);
            display: flex;
            flex-direction: column;
            z-index: 1001;
            opacity: 0;
            transform: translateY(20px) scale(0.95);
            pointer-events: none;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .chat-panel.show {
            opacity: 1;
            transform: translateY(0) scale(1);
            pointer-events: auto;
        }
        .chat-header {
            background: var(--sidebar-bg);
            padding: 0.85rem 1rem;
            border-top-left-radius: calc(var(--radius-lg) - 1px);
            border-top-right-radius: calc(var(--radius-lg) - 1px);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .chat-avatar-ai {
            width: 30px; height: 30px;
            background: var(--primary);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.75rem; font-weight: 700; color: #fff;
        }
        .chat-messages {
            flex: 1;
            padding: 1rem;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            background: var(--bg-page);
        }
        .msg-bot, .msg-user {
            max-width: 80%;
            padding: 0.65rem 0.85rem;
            border-radius: var(--radius-md);
            font-size: 0.825rem;
            line-height: 1.4;
        }
        .msg-bot {
            background: var(--card-bg);
            color: var(--text-main);
            align-self: flex-start;
            border-bottom-left-radius: 4px;
            border: 1px solid var(--border-color);
        }
        .msg-user {
            background: var(--primary);
            color: white;
            align-self: flex-end;
            border-bottom-right-radius: 4px;
        }
        .chat-footer {
            padding: 0.75rem;
            background: var(--card-bg);
            border-top: 1px solid var(--border-color);
            display: flex;
            gap: 0.5rem;
            border-bottom-left-radius: calc(var(--radius-lg) - 1px);
            border-bottom-right-radius: calc(var(--radius-lg) - 1px);
        }
        .chat-footer input {
            flex: 1;
            border: 1px solid var(--border-color);
            background: var(--bg-page);
            color: var(--text-main);
            padding: 0.55rem 0.75rem;
            border-radius: var(--radius-sm);
            font-size: 0.825rem;
            outline: none;
        }
        .chat-footer input:focus { border-color: var(--primary); }
        .chat-footer button {
            background: var(--primary);
            color: white;
            border: none;
            padding: 0 0.85rem;
            border-radius: var(--radius-sm);
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            transition: 0.2s;
        }
        .chat-footer button:hover { background: var(--primary-dark); }
    </style>
<link rel="stylesheet" href="{{ asset('css/theme.css') }}">
</head>
<body>
    <aside class="sidebar">
        <div class="sidebar-brand">
            <a href="{{ url('/') }}">Rupia<span>.</span></a>
        </div>

        <div class="sidebar-section-label">Menu Utama</div>
        <nav class="sidebar-nav">
            <a href="{{ url('/') }}" class="nav-item active">
                <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Beranda
            </a>
            <a href="{{ url('/saving') }}" class="nav-item">
                <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                Tabungan
            </a>
            <a href="{{ url('/education') }}" class="nav-item">
                <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                Edukasi
            </a>
            <a href="{{ url('/planner') }}" class="nav-item">
                <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                Planner
            </a>

            <div class="sidebar-section-label" style="padding-left:0; padding-top:1.25rem;">Transaksi</div>
            <a href="{{ url('/topup') }}" class="nav-item">
                <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Catat Pemasukan
            </a>
            <a href="{{ url('/transfer') }}" class="nav-item">
                <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                Transfer
            </a>
            <a href="{{ url('/transaction/create') }}" class="nav-item">
                <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/></svg>
                Catat Keluar
            </a>
            <a href="{{ url('/pay') }}" class="nav-item">
                <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                Pembayaran
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

    <div class="main-area">
        <header class="topbar">
            <div class="topbar-left">
                <h1>Halo, {{ Auth::user()->name ?? 'Abdan' }} 👋</h1>
                <p>Ringkasan finansialmu hari ini</p>
            </div>
            <div class="topbar-right">
                <div class="badge-verified">
                    <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Akun Terverifikasi
                </div>
                <button id="themeToggle" class="btn-icon-top">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/></svg>
                </button>
                <div class="topbar-user">
                    <div class="topbar-avatar">{{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}</div>
                    <span class="topbar-name">{{ Auth::user()->name ?? 'Pengguna' }}</span>
                </div>
            </div>
        </header>

        <main class="page-content">

            <div class="toggle-row">
                <div class="toggle-info">
                    <h4>Mode Anti-Impuls</h4>
                    <p>Verifikasi tambahan sebelum transaksi non-esensial.</p>
                </div>
                <label class="switch">
                    <input type="checkbox" id="impulseToggle">
                    <span class="slider"></span>
                </label>
            </div>

            <div class="main-grid">
                <section>
                    <div class="balance-card">
                        <div style="position:relative;z-index:1;">
                            <span class="balance-label">Total Saldo</span>
                            <h2 class="balance-amount">Rp {{ number_format($totalBalance ?? 0, 0, ',', '.') }}</h2>
                            <div class="btn-group">
                                <a href="{{ url('/topup') }}" class="btn btn-white">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                                    Catat Pemasukan
                                </a>
                                <a href="{{ url('/transaction/create') }}" class="btn btn-ghost-white">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4"/></svg>
                                    Catat Keluar
                                </a>
                            </div>
                        </div>
                        <div class="health-badge">
                            <div class="health-score">85</div>
                            <div class="health-text">Skor Finansial</div>
                        </div>
                    </div>

                    <p class="section-title" style="margin-top:1.75rem;">Aksi Cepat</p>
                    <div class="shortcut-grid">
                        <a href="{{ url('/transfer') }}" class="shortcut-item">
                            <div class="shortcut-icon-wrap">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                            </div>
                            <span class="shortcut-label">Transfer</span>
                        </a>
                        <a href="{{ url('/pay') }}" class="shortcut-item">
                            <div class="shortcut-icon-wrap">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                            </div>
                            <span class="shortcut-label">Pulsa</span>
                        </a>
                        <a href="{{ url('/pay') }}" class="shortcut-item">
                            <div class="shortcut-icon-wrap">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            </div>
                            <span class="shortcut-label">Token PLN</span>
                        </a>
                        <a href="{{ url('/pay') }}" class="shortcut-item">
                            <div class="shortcut-icon-wrap">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                            </div>
                            <span class="shortcut-label">Lainnya</span>
                        </a>
                    </div>

                    <p class="section-title" style="margin-top:1.75rem;">Arus Kas</p>
                    <div class="panel">
                        <div style="position: relative; height: 220px; width: 100%;">
                            <canvas id="cashflowChart"></canvas>
                        </div>
                    </div>

                    <div style="display:flex; justify-content:space-between; align-items:center; margin-top:1.75rem; margin-bottom:0.875rem;">
                        <p class="section-title" style="margin:0;">Berita Keuangan</p>
                    </div>
                    
                    <div style="display:grid; grid-template-columns:1fr; gap:1rem;">
                        @forelse($newsList ?? [] as $news)
                            <a href="{{ $news['link'] }}" target="_blank" style="text-decoration:none; display:flex; gap:1rem; background:var(--card-bg); padding:1rem; border-radius:var(--radius-md); border:1px solid var(--border-color); transition:0.2s; box-shadow:var(--shadow-sm);" onmouseover="this.style.borderColor='var(--primary)'; this.style.transform='translateY(-2px)'" onmouseout="this.style.borderColor='var(--border-color)'; this.style.transform='translateY(0)'">
                                <img src="{{ $news['thumbnail'] }}" alt="News" style="width:100px; height:80px; object-fit:cover; border-radius:8px; flex-shrink:0;">
                                <div style="display:flex; flex-direction:column; justify-content:center;">
                                    <h4 style="font-size:0.85rem; font-weight:600; color:var(--text-main); margin-bottom:0.4rem; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">{{ $news['title'] }}</h4>
                                    <p style="font-size:0.75rem; color:var(--text-muted);">{{ \Carbon\Carbon::parse($news['pubDate'])->diffForHumans() }}</p>
                                </div>
                            </a>
                        @empty
                            <div class="panel" style="text-align:center; padding:2rem; margin:0;">
                                <p style="color:var(--text-muted); font-size:0.85rem;">Belum ada berita terkini.</p>
                            </div>
                        @endforelse
                    </div>
                </section>

                <aside>
                    <div class="panel">
                        <p class="panel-title">Live Market</p>
                        <div class="list-item">
                            <span class="list-label">USD / IDR</span>
                            <span class="list-value">Rp {{ number_format($usdToIdr ?? 0, 0, ',', '.') }}</span>
                        </div>
                        <div class="list-item">
                            <span class="list-label">Bitcoin (BTC)</span>
                            <span class="list-value accent">Rp {{ number_format($btcToIdr ?? 0, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="panel">
                        <p class="panel-title">Analisis Mood</p>
                        <div style="position: relative; height: 180px; width: 100%;">
                            <canvas id="moodChart"></canvas>
                        </div>
                    </div>
                </aside>
            </div>
        </main>
    </div>

    <div class="chatbot-fab" id="chatbotFab" title="Tanya AI">
        <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
    </div>

    <div class="chat-panel" id="chatPanel">
        <div class="chat-header">
            <div style="display: flex; align-items: center; gap: 0.6rem;">
                <div class="chat-avatar-ai">AI</div>
                <div>
                    <h4 style="margin:0; font-size:0.85rem; font-weight:600; color:#fff;">Rupia AI Assistant</h4>
                    <span style="font-size:0.65rem; color:rgba(255,255,255,0.65); display:block; margin-top:1px;">Online</span>
                </div>
            </div>
            <button id="closeChatBtn" style="background:none; border:none; color:#fff; cursor:pointer; display:flex; align-items:center;">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="chat-messages" id="chatMessages">
            <div class="msg-bot">Halo! Ada yang bisa saya bantu seputar keuangan atau penggunaan aplikasi Rupia hari ini?</div>
        </div>
        <div class="chat-footer">
            <input type="text" id="chatInput" placeholder="Ketik pesan Anda...">
            <button id="sendChatBtn">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </button>
        </div>
    </div>

    <script>
        // Theme logic
        const savedTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-theme', savedTheme);
        const themeBtn = document.getElementById('themeToggle');
        const moonSVG = `<svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/></svg>`;
        const sunSVG  = `<svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>`;
        themeBtn.innerHTML = savedTheme === 'dark' ? sunSVG : moonSVG;
        themeBtn.addEventListener('click', () => {
            const next = document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', next);
            localStorage.setItem('theme', next);
            themeBtn.innerHTML = next === 'dark' ? sunSVG : moonSVG;
        });

        // Anti-Impuls
        const impulseToggle = document.getElementById('impulseToggle');
        impulseToggle.checked = localStorage.getItem('antiImpulse') === 'true';
        impulseToggle.addEventListener('change', e => localStorage.setItem('antiImpulse', e.target.checked));

        // Mood Chart
        const ctx = document.getElementById('moodChart').getContext('2d');
        const chartData = @json($chartData ?? []);
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Happy', 'Stress', 'Bored', 'FOMO'],
                datasets: [{
                    data: [chartData['Happy'] || 0, chartData['Stress'] || 0, chartData['Bored'] || 0, chartData['FOMO'] || 0],
                    backgroundColor: ['#00A550', '#3B82F6', '#F59E0B', '#EF4444'],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '78%',
                plugins: {
                    legend: {
                        position: 'right',
                        labels: { usePointStyle: true, boxWidth: 6, color: '#6B7280', font: { family: "'Inter', sans-serif", size: 11 } }
                    }
                }
            }
        });

        // Cashflow Chart
        const cashCtx = document.getElementById('cashflowChart').getContext('2d');
        new Chart(cashCtx, {
            type: 'bar',
            data: {
                labels: ['Pemasukan', 'Pengeluaran'],
                datasets: [{
                    label: 'Total (Rp)',
                    data: [{{ $income ?? 0 }}, {{ $expense ?? 0 }}],
                    backgroundColor: ['#00A550', '#EF4444'],
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } },
                    x: { grid: { display: false } }
                }
            }
        });

        // ── INTERACTIVE AI CHAT LOGIC ──
        const chatbotFab = document.getElementById('chatbotFab');
        const chatPanel = document.getElementById('chatPanel');
        const closeChatBtn = document.getElementById('closeChatBtn');
        const chatInput = document.getElementById('chatInput');
        const sendChatBtn = document.getElementById('sendChatBtn');
        const chatMessages = document.getElementById('chatMessages');

        // Buka Panel Chat
        chatbotFab.addEventListener('click', (e) => {
            e.preventDefault();
            chatPanel.classList.toggle('show');
        });

        // Tutup Panel Chat
        closeChatBtn.addEventListener('click', () => {
            chatPanel.classList.remove('show');
        });

        // Fungsi Kirim Pesan (UI Simulasi)
       // Fungsi Kirim Pesan
function handleSendMessage() {
    const messageText = chatInput.value.trim();
    if (messageText === '') return;

    // 1. Munculin pesan kamu di layar chat
    const userMessageDiv = document.createElement('div');
    userMessageDiv.className = 'msg-user';
    userMessageDiv.textContent = messageText;
    chatMessages.appendChild(userMessageDiv);

    chatInput.value = '';
    chatMessages.scrollTop = chatMessages.scrollHeight;

    // 2. Kirim ke Laravel
    fetch('/send-chat', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ message: messageText })
    })
    .then(response => response.json())
    .then(data => {
        // 3. Munculin balasan dari Laravel di layar chat
        const botMessageDiv = document.createElement('div');
        botMessageDiv.className = 'msg-bot';
        botMessageDiv.textContent = data.reply;
        chatMessages.appendChild(botMessageDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    })
    .catch(error => console.error('Error:', error));
}

// KODE INI WAJIB ADA BIAR TOMBOL BISA DIKLIK / ENTER:
sendChatBtn.addEventListener('click', handleSendMessage);
chatInput.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') {
        handleSendMessage();
    }
});
    </script>
</body>
</html>