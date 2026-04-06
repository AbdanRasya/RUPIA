<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rupia | Beranda</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap');
        :root{--bg-main:#f3f4f6;--card-bg:#ffffff;--text-main:#111827;--text-muted:#6b7280;--primary:#00a550;--primary-light:#dcfce7;--danger:#e11d48;--info:#3b82f6;--warning:#f59e0b;--border-color:#e5e7eb;--radius-lg:28px;--shadow-soft:0 10px 40px -10px rgba(0,0,0,0.08);}
        [data-theme="dark"]{--bg-main:#0f172a;--card-bg:#1e293b;--text-main:#f8fafc;--text-muted:#94a3b8;--border-color:#334155;--primary-light:rgba(0,165,80,0.15);--shadow-soft:0 10px 40px -10px rgba(0,0,0,0.5);}
        *{margin:0;padding:0;box-sizing:border-box;font-family:'Plus Jakarta Sans',sans-serif;}
        body{background-color:var(--bg-main);color:var(--text-main);padding:1.5rem;min-height:100vh;transition:0.3s;position:relative;}
        
        /* FIX: BACKGROUND MEGA MENDUNG ASLI */
        .bg-batik {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background-image: url("{{ asset('images/mega-mendung.jpg') }}");
            background-size: cover; background-position: center; background-repeat: no-repeat;
            opacity: 0.12; /* Sedikit lebih tebal agar terlihat jelas indonesianya */
            z-index: -1; pointer-events: none;
        }
        
        .container{max-width:1200px;margin:0 auto;}
        .navbar{display:flex;justify-content:space-between;align-items:center;background:var(--card-bg);border-radius:999px;padding:0.75rem 1.5rem;margin-bottom:2rem;position:sticky;top:1rem;z-index:100;box-shadow:var(--shadow-soft);border:1px solid var(--border-color);transition:0.3s;}
        .nav-left,.nav-links{display:flex;align-items:center;gap:1.5rem;}
        .nav-brand{font-size:1.5rem;font-weight:800;text-decoration:none;color:var(--primary);}
        .nav-link{color:var(--text-muted);text-decoration:none;font-weight:600;font-size:0.9rem;transition:0.3s;padding:0.5rem 1rem;border-radius:999px;}
        .nav-link.active{background:var(--text-main);color:var(--card-bg);}
        .nav-link:hover:not(.active){background:var(--bg-main);color:var(--text-main);}
        .nav-right{display:flex;align-items:center;gap:1rem;}
        .btn-theme{background:none;border:none;font-size:1.2rem;cursor:pointer;padding:0.5rem;border-radius:50%;transition:0.3s;}
        .avatar{width:2.5rem;height:2.5rem;border-radius:50%;background:var(--primary-light);color:var(--primary);display:flex;align-items:center;justify-content:center;font-weight:800;font-size:1.1rem;}
        .btn-logout{background:var(--card-bg);color:var(--text-main);border:2px solid var(--border-color);padding:0.5rem 1rem;border-radius:999px;font-weight:800;cursor:pointer;font-size:0.85rem;transition:0.3s;}
        
        .main-layout { display: grid; grid-template-columns: 1fr; gap: 1.5rem; }
        @media (min-width: 1024px) { .main-layout { grid-template-columns: 1.8fr 1.2fr; } }
        .clean-panel { background: var(--card-bg); border-radius: var(--radius-lg); padding: 2rem; margin-bottom: 1.5rem; box-shadow: var(--shadow-soft); border: 1px solid var(--border-color); transition: 0.3s; position: relative; overflow: hidden; }
        .btn-action { padding: 0.8rem 1.5rem; border-radius: 999px; border: none; font-weight: 800; color: white; cursor: pointer; text-decoration: none; font-size: 0.9rem; transition: 0.3s; display: inline-block; }
        .btn-blue { background: var(--info); }
        .btn-green { background: var(--primary); }
        .quick-pay-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-top: 1rem; }
        .quick-pay-item { background: var(--bg-main); border: 2px solid var(--border-color); padding: 1rem; border-radius: 20px; text-align: center; cursor: pointer; transition: 0.3s; text-decoration: none; color: inherit; display: block; }
        .quick-pay-item:hover { border-color: var(--info); transform: translateY(-3px); }
        .quick-pay-icon { font-size: 1.8rem; margin-bottom: 0.5rem; }
        .quick-pay-label { font-size: 0.8rem; font-weight: 800; }

        .switch { position: relative; display: inline-block; width: 60px; height: 34px; }
        .switch input { opacity: 0; width: 0; height: 0; }
        .slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #ccc; transition: .4s; border-radius: 34px; }
        .slider:before { position: absolute; content: ""; height: 26px; width: 26px; left: 4px; bottom: 4px; background-color: white; transition: .4s; border-radius: 50%; }
        input:checked + .slider { background-color: var(--warning); }
        input:checked + .slider:before { transform: translateX(26px); }
    </style>
</head>
<body>
    <div class="bg-batik"></div>
    <div class="container">
        <nav class="navbar">
            <div class="nav-left">
                <a href="{{ url('/') }}" class="nav-brand">Rupia.</a>
                <div class="nav-links">
                    <a href="{{ url('/') }}" class="nav-link active">Beranda</a>
                    <a href="{{ url('/saving') }}" class="nav-link">Tabungan</a>
                    <a href="{{ url('/education') }}" class="nav-link">Edukasi</a>
                    <a href="{{ url('/planner') }}" class="nav-link">Planner</a>
                </div>
            </div>
            <div class="nav-right">
                <button id="themeToggle" class="btn-theme">🌙</button>
                <div class="avatar">{{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}</div>
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf <button type="submit" class="btn-logout">Keluar</button>
                </form>
            </div>
        </nav>

        <div style="margin-bottom: 2rem;">
            <h1 style="font-size: 2.2rem; font-weight: 800;">Halo, {{ Auth::user()->name ?? 'Abdan' }}! 👋</h1>
            <p style="color: var(--text-muted);">Selamat datang kembali di Rupia.</p>
        </div>

        <div class="main-layout">
            <div>
                <div class="clean-panel" style="display: flex; justify-content: space-between; align-items: center; background: rgba(245, 158, 11, 0.05); border-color: var(--warning);">
                    <div>
                        <h3 style="color: var(--warning);">🛡️ Mode Anti-Impuls</h3>
                        <p style="font-size: 0.85rem;">Ingatkan aku sebelum belanja berlebihan.</p>
                    </div>
                    <label class="switch"><input type="checkbox" id="impulseToggle"><span class="slider"></span></label>
                </div>

                <div class="clean-panel" style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <p style="font-weight: 800; color: var(--text-muted); font-size: 0.85rem;">TOTAL SALDO</p>
                        <h1 style="font-size: 3rem; font-weight: 800; margin: 0.5rem 0 1.5rem 0;">Rp {{ number_format($totalBalance ?? 0, 0, ',', '.') }}</h1>
                        <div style="display: flex; gap: 1rem;">
                            <a href="{{ url('/topup') }}" class="btn-action btn-blue">+ Top Up</a>
                            <a href="{{ url('/transaction/create') }}" class="btn-action btn-green">Catat Keluar</a>
                        </div>
                    </div>
                    <div style="width: 80px; height: 80px; border-radius: 50%; border: 6px solid var(--primary); display: flex; justify-content: center; align-items: center; font-size: 1.5rem; font-weight: 800; color: var(--primary); background: var(--card-bg);">85</div>
                </div>

                <div class="clean-panel">
                    <h3 style="font-size: 1.1rem; margin-bottom: 1rem;">⚡ Jalan Pintas</h3>
                    <div class="quick-pay-grid">
                        <a href="{{ url('/transfer') }}" class="quick-pay-item" style="border-color: var(--primary);"><div class="quick-pay-icon">💸</div><div class="quick-pay-label" style="color: var(--primary);">Transfer</div></a>
                        <a href="{{ url('/pay') }}" class="quick-pay-item"><div class="quick-pay-icon">📱</div><div class="quick-pay-label">Pulsa</div></a>
                        <a href="{{ url('/pay') }}" class="quick-pay-item"><div class="quick-pay-icon">⚡</div><div class="quick-pay-label">Token PLN</div></a>
                        <a href="{{ url('/pay') }}" class="quick-pay-item" style="border-style: dashed;"><div class="quick-pay-icon">🎛️</div><div class="quick-pay-label">Lainnya</div></a>
                    </div>
                </div>
            </div>

            <div>
                <div class="clean-panel" style="background: rgba(59, 130, 246, 0.05); border-color: var(--info);">
                    <h3 style="color: var(--info); margin-bottom: 1.5rem;">📊 Live Market</h3>
                    <div style="background: var(--card-bg); padding: 1rem; border-radius: 16px; margin-bottom: 1rem;"><p style="font-size: 0.8rem; font-weight: 800;">💵 USD ke IDR</p><h3>Rp {{ number_format($usdToIdr ?? 0, 0, ',', '.') }}</h3></div>
                    <div style="background: var(--card-bg); padding: 1rem; border-radius: 16px;"><p style="font-size: 0.8rem; font-weight: 800;">🪙 1 Bitcoin</p><h3 style="color: var(--info);">Rp {{ number_format($btcToIdr ?? 0, 0, ',', '.') }}</h3></div>
                </div>
                <div class="clean-panel"><h3>🎭 Analisis Mood</h3><canvas id="moodChart" height="250"></canvas></div>
            </div>
        </div>
    </div>
    <script>
        const savedTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-theme', savedTheme);
        const themeBtn = document.getElementById('themeToggle');
        themeBtn.innerHTML = savedTheme === 'dark' ? '☀️' : '🌙';
        themeBtn.addEventListener('click', () => {
            const next = document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', next);
            localStorage.setItem('theme', next);
            themeBtn.innerHTML = next === 'dark' ? '☀️' : '🌙';
        });

        const impulseToggle = document.getElementById('impulseToggle');
        impulseToggle.checked = localStorage.getItem('antiImpulse') === 'true';
        impulseToggle.addEventListener('change', (e) => localStorage.setItem('antiImpulse', e.target.checked));

        const ctx = document.getElementById('moodChart').getContext('2d');
        const chartData = @json($chartData ?? []);
        new Chart(ctx, { type: 'bar', data: { labels: ['Happy', 'Stress', 'Bored', 'FOMO'], datasets: [{ label: 'Pengeluaran', data: [ chartData['Happy'] || 0, chartData['Stress'] || 0, chartData['Bored'] || 0, chartData['FOMO'] || 0 ], backgroundColor: ['#00a550', '#e11d48', '#6b7280', '#f59e0b'], borderRadius: 8 }] }, options: { responsive: true, plugins: { legend: { display: false } }, scales: { x: { grid: { display: false } } } } });
    </script>
</body>
</html>