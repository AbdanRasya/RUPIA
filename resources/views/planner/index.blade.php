<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rupia | Planner</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap');
        :root { --bg-main: #f3f4f6; --card-bg: #ffffff; --text-main: #111827; --text-muted: #6b7280; --primary: #00a550; --primary-light: #dcfce7; --danger: #e11d48; --border-color: #e5e7eb; --radius-lg: 28px; --shadow-soft: 0 10px 40px -10px rgba(0,0,0,0.08); }
        [data-theme="dark"] { --bg-main: #0f172a; --card-bg: #1e293b; --text-main: #f8fafc; --text-muted: #94a3b8; --primary-light: rgba(0, 165, 80, 0.15); --border-color: #334155; --shadow-soft: 0 10px 40px -10px rgba(0,0,0,0.5); }
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
        .clean-panel { background: var(--card-bg); border-radius: var(--radius-lg); padding: 2rem; margin-bottom: 1.5rem; box-shadow: var(--shadow-soft); border: 1px solid var(--border-color); transition: 0.3s; }
        .plan-item { border-left: 6px solid var(--primary); padding-left: 1rem; margin-bottom: 1.5rem; }
        .btn-primary { background: var(--primary); color: white; padding: 0.8rem 1.5rem; border-radius: 999px; border: none; font-weight: 800; cursor: pointer; width: 100%; transition: 0.3s; }
        .modal { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); backdrop-filter: blur(5px); z-index: 1000; align-items: center; justify-content: center; }
        .modal-content { background: var(--card-bg); padding: 2rem; border-radius: var(--radius-lg); width: 90%; max-width: 400px; border: 1px solid var(--border-color); }
        .modal-input { width: 100%; padding: 1rem; border-radius: 12px; border: 2px solid var(--border-color); background: var(--bg-main); color: var(--text-main); margin-bottom: 1rem; font-weight: 600; outline: none; }
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
                    <a href="{{ url('/education') }}" class="nav-link">Edukasi</a>
                    <a href="{{ url('/planner') }}" class="nav-link active">Planner</a>
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

        <h1 style="font-size: 2.2rem; font-weight: 800; margin-bottom: 2rem;">🗓️ Life Event Planner</h1>

        <div class="main-layout">
            <div>
                <div class="clean-panel">
                    <h2 style="margin-bottom: 2rem;">Timeline Momen Hidup</h2>
                    <div>
                        @forelse($plans ?? [] as $plan)
                            <div class="plan-item">
                                <h3 style="font-size: 1.2rem;">{{ $plan->year }}: {{ $plan->event_name }} 🎓</h3>
                                <p style="font-size: 0.95rem; color: var(--text-muted); margin-top: 0.5rem;">{{ $plan->description }}</p>
                            </div>
                        @empty
                            <p class="text-muted">Belum ada rencana masa depan. Yuk mulai buat!</p>
                        @endforelse
                    </div>
                </div>
            </div>
            <div>
                <div class="clean-panel">
                    <h3>Aksi Cepat</h3>
                    <p style="font-size: 0.95rem; margin: 1rem 0; color: var(--text-muted);">Punya rencana baru? Tambahkan sekarang.</p>
                    <button class="btn-primary" onclick="document.getElementById('planModal').style.display='flex'">+ Buat Plan Baru</button>
                </div>
            </div>
        </div>
        <footer><p>&copy; 2026 Rupia App</p></footer>
    </div>

    <div id="planModal" class="modal">
        <form class="modal-content" action="{{ url('/planner/store') }}" method="POST">
            @csrf
            <h2 style="margin-bottom: 1.5rem;">Apa Rencanamu? 🚀</h2>
            <input type="text" name="year" class="modal-input" placeholder="Tahun (ex: 2027)" required>
            <input type="text" name="event_name" class="modal-input" placeholder="Nama Event (ex: Lulus/Beli Motor)" required>
            <input type="text" name="description" class="modal-input" placeholder="Deskripsi/Budget" required>
            <button type="submit" class="btn-primary">Simpan Rencana</button>
            <button type="button" style="width:100%; margin-top: 0.8rem; background:transparent; color:var(--text-muted); border:none; font-weight:bold; cursor:pointer;" onclick="document.getElementById('planModal').style.display='none'">Batal</button>
        </form>
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
    </script>
</body>
</html>