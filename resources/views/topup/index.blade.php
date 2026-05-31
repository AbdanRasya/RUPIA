<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rupia | Catat Pemasukan</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,400;0,14..32,500;0,14..32,600;0,14..32,700;1,14..32,400&display=swap');
        :root {
            --sidebar-bg: #1A2744; --sidebar-text: #8FA3C0; --sidebar-active-bg: rgba(255,255,255,0.1); --sidebar-active-text: #FFFFFF; --sidebar-hover-bg: rgba(255,255,255,0.06);
            --topbar-bg: #FFFFFF; --bg-page: #F4F6FA; --card-bg: #FFFFFF;
            --primary: #00A550; --primary-light: #E6F7EE; --primary-dark: #007A3B;
            --accent: #3B82F6; --danger: #EF4444; --text-main: #1A2744; --text-muted: #6B7280; --border-color: #E5E7EB;
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

        /* ── Catat Pemasukan FORM ── */
        .main-layout { display: grid; grid-template-columns: 1.5fr 1fr; gap: 1.5rem; max-width: 880px; }
        @media (max-width: 768px) { .main-layout { grid-template-columns: 1fr; } }
        .panel { background: var(--card-bg); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 1.75rem; box-shadow: var(--shadow-sm); }

        .nominal-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 0.75rem; margin-top: 1.25rem; }
        .nominal-btn { background: var(--bg-page); border: 2px solid var(--border-color); color: var(--text-main); padding: 0.875rem; border-radius: var(--radius-md); font-weight: 700; font-size: 0.9rem; cursor: pointer; transition: 0.18s; text-align: center; font-family: 'Inter', sans-serif; }
        .nominal-btn:hover, .nominal-btn.selected { border-color: var(--accent); background: rgba(59,130,246,0.08); color: var(--accent); }

        .custom-input { width: 100%; padding: 1rem; font-size: 1.4rem; font-weight: 800; border-radius: var(--radius-md); border: 2px solid var(--border-color); background: var(--bg-page); color: var(--text-main); margin-top: 0.875rem; outline: none; transition: 0.2s; font-family: 'Inter', sans-serif; }
        .custom-input:focus { border-color: var(--accent); }

        .method-item { display: flex; align-items: center; gap: 0.875rem; padding: 0.875rem 1rem; border: 2px solid var(--border-color); border-radius: var(--radius-md); margin-bottom: 0.75rem; cursor: pointer; transition: 0.18s; }
        .method-item:hover, .method-item.selected { border-color: var(--primary); background: var(--primary-light); }
        .method-icon { font-size: 1.6rem; flex-shrink: 0; }
        .method-name { font-size: 0.9rem; font-weight: 700; margin-bottom: 2px; }
        .method-desc { font-size: 0.75rem; color: var(--text-muted); }

        .btn-pay { width: 100%; background: var(--accent); color: white; padding: 1rem; border-radius: var(--radius-md); border: none; font-weight: 700; font-size: 0.95rem; cursor: pointer; margin-top: 1.25rem; transition: 0.2s; font-family: 'Inter', sans-serif; box-shadow: 0 4px 12px rgba(59,130,246,0.25); }
        .btn-pay:hover { background: #2563EB; transform: translateY(-1px); }

        /* Alerts */
        .alert { padding: 0.875rem 1.25rem; border-radius: var(--radius-md); font-size: 0.875rem; font-weight: 600; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.75rem; }
        .alert-error { background: #FEF2F2; color: #991B1B; border: 1px solid #FECACA; }
        .alert-success { background: var(--primary-light); color: var(--primary-dark); border: 1px solid rgba(0,165,80,0.2); }
    </style>
    <script>
        const savedTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-theme', savedTheme);
    </script>
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
            <a href="{{ url('/planner') }}" class="nav-item">
                <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                Planner
            </a>
            <div class="sidebar-section-label" style="padding-left:0;padding-top:1.25rem;">Transaksi</div>
            <a href="{{ url('/topup') }}" class="nav-item active">
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
                <h1>Catat Pemasukan</h1>
                <p>Isi saldo untuk transaksi lebih mudah</p>
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
            @if(session('error'))
                <div class="alert alert-error"><span>🛑</span> {{ session('error') }}</div>
            @endif
            @if(session('success'))
                <div class="alert alert-success"><span>✅</span> {{ session('success') }}</div>
            @endif

            <form action="{{ url('/topup/process') }}" method="POST" class="main-layout">
                @csrf
                <div class="panel">
                    <h2 style="font-size:1rem;font-weight:700;margin-bottom:0.375rem;">Mau isi berapa?</h2>
                    <p style="font-size:0.8rem;color:var(--text-muted);">Pilih nominal cepat atau ketik sendiri.</p>
                    <div class="nominal-grid">
                        <div class="nominal-btn" onclick="setNominal(50000, this)">Rp 50.000</div>
                        <div class="nominal-btn" onclick="setNominal(100000, this)">Rp 100.000</div>
                        <div class="nominal-btn" onclick="setNominal(250000, this)">Rp 250.000</div>
                        <div class="nominal-btn" onclick="setNominal(500000, this)">Rp 500.000</div>
                    </div>
                    <div style="margin-top:1.5rem;">
                        <p style="font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:var(--text-muted);margin-bottom:0.5rem;">Atau Ketik Nominal Lain</p>
                        <input type="number" name="amount" id="customAmount" class="custom-input" placeholder="Rp 0" required oninput="clearSelection()">
                    </div>
                </div>

                <div class="panel">
                    <h2 style="font-size:1rem;font-weight:700;margin-bottom:1.25rem;">Metode Pembayaran</h2>
                    <input type="hidden" name="payment_method" id="selectedMethod" value="qris" required>
                    <div class="method-item selected" onclick="selectMethod('qris', this)">
                        <div class="method-icon">📱</div>
                        <div>
                            <div class="method-name">QRIS (Rekomendasi)</div>
                            <div class="method-desc">Bebas admin, langsung masuk.</div>
                        </div>
                    </div>
                    <div class="method-item" onclick="selectMethod('va_bca', this)">
                        <div class="method-icon">🏦</div>
                        <div>
                            <div class="method-name">BCA Virtual Account</div>
                            <div class="method-desc">Biaya admin Rp 1.000</div>
                        </div>
                    </div>
                    <div class="method-item" onclick="selectMethod('minimarket', this)">
                        <div class="method-icon">🏪</div>
                        <div>
                            <div class="method-name">Indomaret / Alfamart</div>
                            <div class="method-desc">Biaya admin Rp 2.500</div>
                        </div>
                    </div>
                    <button type="submit" class="btn-pay">Lanjut Bayar 🚀</button>
                </div>
            </form>
        </main>
    </div>

    <script>
        const themeBtn = document.getElementById('themeToggle');
        themeBtn.innerHTML = savedTheme === 'dark'
            ? `<svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>`
            : `<svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/></svg>`;
        themeBtn.addEventListener('click', () => {
            const next = document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', next);
            localStorage.setItem('theme', next);
        });
        function setNominal(amount, element) {
            document.getElementById('customAmount').value = amount;
            document.querySelectorAll('.nominal-btn').forEach(btn => btn.classList.remove('selected'));
            element.classList.add('selected');
        }
        function clearSelection() { document.querySelectorAll('.nominal-btn').forEach(btn => btn.classList.remove('selected')); }
        function selectMethod(method, element) {
            document.getElementById('selectedMethod').value = method;
            document.querySelectorAll('.method-item').forEach(item => item.classList.remove('selected'));
            element.classList.add('selected');
        }
    </script>
</body>
</html>

