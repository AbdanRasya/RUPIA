<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rupia | Edukasi</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap');
        :root { --bg-main: #f3f4f6; --card-bg: #ffffff; --text-main: #111827; --text-muted: #6b7280; --primary: #00a550; --primary-light: #dcfce7; --danger: #e11d48; --info: #3b82f6; --info-light: #dbeafe; --border-color: #e5e7eb; --radius-lg: 28px; --shadow-soft: 0 10px 40px -10px rgba(0,0,0,0.08); }
        [data-theme="dark"] { --bg-main: #0f172a; --card-bg: #1e293b; --text-main: #f8fafc; --text-muted: #94a3b8; --primary-light: rgba(0, 165, 80, 0.15); --info-light: rgba(59, 130, 246, 0.15); --border-color: #334155; --shadow-soft: 0 10px 40px -10px rgba(0,0,0,0.5); }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background-color: var(--bg-main); color: var(--text-main); padding: 1.5rem; min-height: 100vh; transition: 0.3s; }
        .container { max-width: 1200px; margin: 0 auto; }
        .navbar { display: flex; justify-content: space-between; align-items: center; background: var(--card-bg); border-radius: 999px; padding: 0.75rem 1.5rem; margin-bottom: 2rem; position: sticky; top: 1rem; z-index: 100; box-shadow: var(--shadow-soft); border: 1px solid var(--border-color); transition: 0.3s; }
        .nav-left, .nav-links { display: flex; align-items: center; gap: 1.5rem; }
        .nav-brand { font-size: 1.5rem; font-weight: 800; text-decoration: none; color: var(--primary); }
        .nav-link { color: var(--text-muted); text-decoration: none; font-weight: 600; font-size: 0.9rem; transition: 0.3s; padding: 0.5rem 1rem; border-radius: 999px; }
        .nav-link.active { background: var(--text-main); color: var(--card-bg); }
        .nav-link:hover:not(.active) { background: var(--bg-main); color: var(--text-main); }
        .nav-right { display: flex; align-items: center; gap: 1rem; }
        .btn-theme { background: none; border: none; font-size: 1.2rem; cursor: pointer; padding: 0.5rem; border-radius: 50%; }
        .avatar { width: 2.5rem; height: 2.5rem; border-radius: 50%; background: var(--primary-light); color: var(--primary); display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.1rem; }
        .btn-logout { background: var(--card-bg); color: var(--text-main); border: 2px solid var(--border-color); padding: 0.5rem 1rem; border-radius: 999px; font-weight: 800; cursor: pointer; font-size: 0.85rem; }
        .main-layout { display: grid; grid-template-columns: 1fr; gap: 1.5rem; }
        @media (min-width: 1024px) { .main-layout { grid-template-columns: 2fr 1fr; } }
        
        .clean-panel { background: var(--card-bg); border-radius: var(--radius-lg); padding: 2rem; margin-bottom: 1.5rem; box-shadow: var(--shadow-soft); border: 1px solid var(--border-color); transition: 0.3s; cursor: pointer; }
        .clean-panel:hover { border-color: var(--primary); }
        .edu-detail { display: none; margin-top: 1rem; padding-top: 1rem; border-top: 1px solid var(--border-color); color: var(--text-muted); line-height: 1.6; font-size: 0.95rem; }
        footer { text-align: center; padding: 3rem 0; color: var(--text-muted); font-size: 0.85rem; }
    </style>
    <script>
        const savedTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-theme', savedTheme);
    </script>
</head>
<body>
    <div class="container">
        <nav class="navbar">
            <div class="nav-left">
                <a href="{{ url('/') }}" class="nav-brand">Rupia.</a>
                <div class="nav-links">
                    <a href="{{ url('/') }}" class="nav-link">Beranda</a>
                    <a href="{{ url('/saving') }}" class="nav-link">Tabungan</a>
                    <a href="{{ url('/education') }}" class="nav-link active">Edukasi</a>
                    <a href="{{ url('/planner') }}" class="nav-link">Planner</a>
                </div>
            </div>
            <div class="nav-right">
                <button id="themeToggle" class="btn-theme"></button>
                <div class="avatar">{{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}</div>
                <form action="{{ route('logout') }}" method="POST" style="margin: 0; display: flex;">
                    @csrf
                    <button type="submit" class="btn-logout">Keluar</button>
                </form>
            </div>
        </nav>

        <h1 style="font-size: 2.2rem; font-weight: 800; margin-bottom: 2rem;">📚 Knowledge Base</h1>

        <div class="main-layout">
            <div>
                <div class="clean-panel" onclick="toggleDetail(this)">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h3 style="font-size: 1.2rem; color: var(--text-main);">Kenapa Harus Dana Darurat? 🛡️</h3>
                        <span style="font-weight: 800; color: var(--primary);">▼</span>
                    </div>
                    <div class="edu-detail">Dana darurat adalah uang yang disimpan khusus untuk kejadian tak terduga (HP rusak, motor mogok, dll). Idealnya buat pelajar/magang, simpan minimal 3-6 bulan biaya hidupmu.</div>
                </div>
                <div class="clean-panel" onclick="toggleDetail(this)">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h3 style="font-size: 1.2rem; color: var(--text-main);">Jurus 50/30/20 📊</h3>
                        <span style="font-weight: 800; color: var(--primary);">▼</span>
                    </div>
                    <div class="edu-detail">Bagi gajimu: 50% untuk kebutuhan, 30% keinginan, dan 20% tabung. Cara paling simpel biar nggak bokek!</div>
                </div>
            </div>
            <div>
                <div class="clean-panel" style="background: var(--info-light); border: 1px solid var(--info); cursor: default;">
                    <h3 style="color: var(--info); margin-bottom: 0.5rem;">Did You Know?</h3>
                    <p style="font-size: 0.95rem; color: var(--text-main);">Inflasi bikin harga barang naik terus. Makanya nyimpen uang di bawah bantal itu rugi!</p>
                </div>
            </div>
        </div>
        <footer><p>&copy; 2026 Rupia App</p></footer>
    </div>

    <script>
        const themeBtn = document.getElementById('themeToggle');
        themeBtn.innerHTML = savedTheme === 'dark' ? '☀️' : '🌙';
        themeBtn.addEventListener('click', () => {
            const current = document.documentElement.getAttribute('data-theme');
            const next = current === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', next);
            localStorage.setItem('theme', next);
            themeBtn.innerHTML = next === 'dark' ? '☀️' : '🌙';
        });

        function toggleDetail(panel) {
            const detail = panel.querySelector('.edu-detail');
            detail.style.display = detail.style.display === 'block' ? 'none' : 'block';
        }
    </script>
</body>
</html>