<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rupia | Planner</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,400;0,14..32,500;0,14..32,600;0,14..32,700;1,14..32,400&display=swap');
        :root {
            --sidebar-bg: #1A2744; --sidebar-text: #8FA3C0; --sidebar-active-bg: rgba(255,255,255,0.1); --sidebar-active-text: #FFFFFF; --sidebar-hover-bg: rgba(255,255,255,0.06);
            --topbar-bg: #FFFFFF; --bg-page: #F4F6FA; --card-bg: #FFFFFF;
            --primary: #00A550; --primary-light: #E6F7EE; --primary-dark: #007A3B;
            --danger: #EF4444; --text-main: #1A2744; --text-muted: #6B7280; --border-color: #E5E7EB;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.08); --shadow-md: 0 4px 16px rgba(0,0,0,0.08);
            --radius-sm: 8px; --radius-md: 12px; --radius-lg: 16px;
            --sidebar-w: 220px; --topbar-h: 60px;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: var(--bg-page); color: var(--text-main); display: flex; min-height: 100vh; -webkit-font-smoothing: antialiased; }

        .sidebar { width: var(--sidebar-w); background: var(--sidebar-bg); display: flex; flex-direction: column; position: fixed; top: 0; left: 0; bottom: 0; z-index: 100; overflow-y: auto; }
        .sidebar-brand { padding: 1.5rem 1.25rem 1rem; border-bottom: 1px solid rgba(255,255,255,0.07); }
        .sidebar-brand a { font-size: 1.4rem; font-weight: 700; color: #FFFFFF; text-decoration: none; letter-spacing: -0.5px; }
        .sidebar-brand span { color: var(--primary); }
        .sidebar-section-label { font-size: 0.65rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1.2px; color: rgba(143,163,192,0.5); padding: 1.25rem 1.25rem 0.5rem; }
        .sidebar-nav { padding: 0.5rem 0.75rem; flex: 1; }
        .nav-item { display: flex; align-items: center; gap: 0.75rem; padding: 0.7rem 0.75rem; border-radius: var(--radius-sm); color: var(--sidebar-text); text-decoration: none; font-size: 0.875rem; font-weight: 500; transition: all 0.18s ease; margin-bottom: 2px; }
        .nav-item:hover { background: var(--sidebar-hover-bg); color: #FFFFFF; }
        .nav-item.active { background: var(--sidebar-active-bg); color: var(--sidebar-active-text); font-weight: 600; }
        .nav-item.active .nav-icon { color: var(--primary); }
        .nav-icon { width: 18px; height: 18px; flex-shrink: 0; }
        .sidebar-bottom { padding: 1rem 0.75rem; border-top: 1px solid rgba(255,255,255,0.07); }
        .sidebar-user { display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem; }
        .sidebar-avatar { width: 34px; height: 34px; background: var(--primary); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.85rem; flex-shrink: 0; }
        .sidebar-user-name { font-size: 0.8rem; font-weight: 600; color: #fff; }
        .sidebar-user-role { font-size: 0.7rem; color: var(--sidebar-text); }
        .btn-logout-sidebar { width: 100%; margin-top: 0.5rem; background: rgba(239,68,68,0.12); color: #FC8181; border: none; padding: 0.6rem 0.75rem; border-radius: var(--radius-sm); font-size: 0.8rem; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 0.5rem; transition: 0.2s; }
        .btn-logout-sidebar:hover { background: rgba(239,68,68,0.2); }

        .main-area { margin-left: var(--sidebar-w); flex: 1; display: flex; flex-direction: column; min-height: 100vh; }
        .topbar { height: var(--topbar-h); background: var(--topbar-bg); border-bottom: 1px solid var(--border-color); display: flex; align-items: center; justify-content: space-between; padding: 0 1.75rem; position: sticky; top: 0; z-index: 50; box-shadow: var(--shadow-sm); }
        .topbar-left h1 { font-size: 1rem; font-weight: 600; }
        .topbar-left p { font-size: 0.75rem; color: var(--text-muted); margin-top: 1px; }
        .topbar-right { display: flex; align-items: center; gap: 1rem; }
        .topbar-user { display: flex; align-items: center; gap: 0.6rem; padding: 0.35rem 0.75rem 0.35rem 0.35rem; border-radius: 999px; border: 1px solid var(--border-color); background: var(--bg-page); }
        .topbar-avatar { width: 28px; height: 28px; background: var(--primary); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.75rem; }
        .topbar-name { font-size: 0.8rem; font-weight: 600; }
        .btn-icon-top { width: 34px; height: 34px; border-radius: 50%; border: 1px solid var(--border-color); background: transparent; display: flex; align-items: center; justify-content: center; cursor: pointer; color: var(--text-muted); transition: 0.2s; }
        .page-content { padding: 1.75rem; flex: 1; }
        .main-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; }
        @media (max-width: 960px) { .main-grid { grid-template-columns: 1fr; } }
        .panel { background: var(--card-bg); border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 1.75rem; box-shadow: var(--shadow-sm); }

        /* ── TIMELINE ── */
        .timeline { position: relative; padding-left: 2.25rem; border-left: 2px solid var(--border-color); margin-top: 1rem; }
        .timeline-item { position: relative; margin-bottom: 2.25rem; }
        .timeline-dot { position: absolute; left: calc(-2.25rem - 5px); top: 5px; width: 10px; height: 10px; background: var(--primary); border-radius: 50%; border: 2px solid var(--card-bg); outline: 2px solid var(--primary); }
        .timeline-year { font-size: 0.75rem; font-weight: 700; color: var(--primary); text-transform: uppercase; display: block; margin-bottom: 4px; letter-spacing: 0.5px; }
        .timeline-title { font-size: 0.95rem; font-weight: 600; margin-bottom: 6px; }
        .timeline-desc { font-size: 0.825rem; color: var(--text-muted); line-height: 1.6; }

        /* ── BUTTONS ── */
        .btn { padding: 0.6rem 1.1rem; border-radius: var(--radius-sm); font-weight: 600; font-size: 0.825rem; cursor: pointer; border: none; transition: 0.18s; text-decoration: none; width: 100%; display: block; text-align: center; font-family: 'Inter', sans-serif; }
        .btn-primary { background: var(--primary); color: #FFFFFF; }
        .btn-primary:hover { background: var(--primary-dark); }
        .btn-outline { background: transparent; border: 1px solid var(--border-color); color: var(--text-main); margin-top: 0.5rem; }
        .btn-outline:hover { border-color: var(--primary); color: var(--primary); }

        /* ── MODAL ── */
        .modal { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); backdrop-filter: blur(4px); z-index: 1000; align-items: center; justify-content: center; }
        .modal-content { background: var(--card-bg); padding: 2rem; border-radius: var(--radius-lg); width: 90%; max-width: 400px; border: 1px solid var(--border-color); box-shadow: var(--shadow-md); }
        .modal-input { width: 100%; padding: 0.75rem 1rem; border-radius: var(--radius-sm); border: 1px solid var(--border-color); background: var(--bg-page); color: var(--text-main); margin-bottom: 0.875rem; outline: none; font-size: 0.875rem; font-family: 'Inter', sans-serif; transition: 0.2s; }
        .modal-input:focus { border-color: var(--primary); }

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
    </style>
<link rel="stylesheet" href="{{ asset('css/theme.css') }}">
</head>
<body>
    <aside class="sidebar">
        <div class="sidebar-brand"><a href="{{ url('/') }}">Rupia<span>.</span></a></div>
        <div class="sidebar-section-label">Menu Utama</div>
        <nav class="sidebar-nav">
            <a href="{{ url('/') }}" class="nav-item">
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
            <a href="{{ url('/planner') }}" class="nav-item active">
                <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                Planner
            </a>
            <div class="sidebar-section-label" style="padding-left:0;padding-top:1.25rem;">Transaksi</div>
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
                <div>
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
                <h1>Life Event Planner</h1>
                <p>Visualisasikan target jangka panjangmu</p>
            </div>
            <div class="topbar-right">
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
            <div class="main-grid">
                <div class="panel">
                    <p style="font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:var(--text-muted);margin-bottom:1.5rem;">Timeline Rencana</p>
                    <div class="timeline">
                        @forelse($plans ?? [] as $plan)
                            <div class="timeline-item">
                                <div class="timeline-dot"></div>
                                <span class="timeline-year">{{ $plan->year }}</span>
                                <h3 class="timeline-title">{{ $plan->event_name }}</h3>
                                <p class="timeline-desc">{{ $plan->description }}</p>
                            </div>
                        @empty
                            <p style="color:var(--text-muted);font-size:0.875rem;">Belum ada rencana yang disusun.</p>
                        @endforelse
                    </div>
                </div>

                <aside>
                    <div class="panel">
                        <h3 style="font-size:0.95rem;font-weight:700;margin-bottom:0.4rem;">Aksi</h3>
                        <p style="font-size:0.8rem;color:var(--text-muted);margin-bottom:1.25rem;">Tambah milestone baru untuk hidupmu.</p>
                        <button class="btn btn-primary" onclick="document.getElementById('planModal').style.display='flex'">+ Buat Plan Baru</button>
                    </div>
                </aside>
            </div>
        </main>
    </div>

            <!-- CHATBOT FAB -->
    <a href="#" class="chatbot-fab" title="Tanya AI">
        <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
    </a>

    <div id="planModal" class="modal">
        <form class="modal-content" action="{{ url('/planner/store') }}" method="POST">
            @csrf
            <h2 style="font-size:1.1rem;font-weight:700;margin-bottom:1.25rem;">Rencana Baru</h2>
            <input type="text" name="year" class="modal-input" placeholder="Tahun (contoh: 2027)" required>
            <input type="text" name="event_name" class="modal-input" placeholder="Nama Event" required>
            <textarea name="description" class="modal-input" placeholder="Deskripsi/Budget" style="height:80px;resize:none;"></textarea>
            <button type="submit" class="btn btn-primary">Simpan Rencana</button>
            <button type="button" class="btn btn-outline" onclick="document.getElementById('planModal').style.display='none'">Batal</button>
        </form>
    </div>

    <script>
        let currentTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-theme', currentTheme);
        const themeBtn = document.getElementById('themeToggle');
        const moonSVG = `<svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/></svg>`;
        const sunSVG  = `<svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>`;
        themeBtn.innerHTML = currentTheme === 'dark' ? sunSVG : moonSVG;
        themeBtn.addEventListener('click', () => {
            currentTheme = currentTheme === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', currentTheme);
            localStorage.setItem('theme', currentTheme);
            themeBtn.innerHTML = currentTheme === 'dark' ? sunSVG : moonSVG;
        });
    </script>
</body>
</html>

