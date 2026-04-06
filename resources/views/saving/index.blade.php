<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rupia | Tabungan</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap');
        
        :root { 
            --bg-main: #f3f4f6; --card-bg: #ffffff; --text-main: #111827; --text-muted: #6b7280; 
            --primary: #00a550; --primary-light: #dcfce7; --danger: #e11d48; --info: #3b82f6; 
            --border-color: #e5e7eb; --radius-lg: 28px; --shadow-soft: 0 10px 40px -10px rgba(0,0,0,0.08); 
        }
        
        [data-theme="dark"] { 
            --bg-main: #0f172a; --card-bg: #1e293b; --text-main: #f8fafc; --text-muted: #94a3b8; 
            --primary-light: rgba(0, 165, 80, 0.15); --border-color: #334155; --shadow-soft: 0 10px 40px -10px rgba(0,0,0,0.5); 
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background-color: var(--bg-main); color: var(--text-main); padding: 1.5rem; min-height: 100vh; transition: 0.3s; }
        .container { max-width: 1200px; margin: 0 auto; }
        
        /* NAVBAR */
        .navbar { display: flex; justify-content: space-between; align-items: center; background: var(--card-bg); border-radius: 999px; padding: 0.75rem 1.5rem; margin-bottom: 2rem; position: sticky; top: 1rem; z-index: 100; box-shadow: var(--shadow-soft); border: 1px solid var(--border-color); transition: 0.3s; }
        .nav-left, .nav-links { display: flex; align-items: center; gap: 1.5rem; }
        .nav-brand { font-size: 1.5rem; font-weight: 800; text-decoration: none; color: var(--primary); }
        .nav-link { color: var(--text-muted); text-decoration: none; font-weight: 600; font-size: 0.9rem; transition: 0.3s; padding: 0.5rem 1rem; border-radius: 999px; }
        .nav-link.active { background: var(--text-main); color: var(--card-bg); }
        .nav-link:hover:not(.active) { background: var(--bg-main); color: var(--text-main); }
        .nav-right { display: flex; align-items: center; gap: 1rem; }
        .btn-theme { background: none; border: none; font-size: 1.2rem; cursor: pointer; padding: 0.5rem; border-radius: 50%; transition: 0.3s; }
        .btn-theme:hover { background: var(--bg-main); }
        .avatar { width: 2.5rem; height: 2.5rem; border-radius: 50%; background: var(--primary-light); color: var(--primary); display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.1rem; }
        .btn-logout { background: var(--card-bg); color: var(--text-main); border: 2px solid var(--border-color); padding: 0.5rem 1rem; border-radius: 999px; font-weight: 800; cursor: pointer; font-size: 0.85rem; transition: 0.3s; }
        .btn-logout:hover { border-color: var(--danger); color: var(--danger); }

        /* KONTEN */
        .main-layout { display: grid; grid-template-columns: 1fr; gap: 1.5rem; }
        @media (min-width: 1024px) { .main-layout { grid-template-columns: 2fr 1fr; } }
        
        .clean-panel { background: var(--card-bg); border-radius: var(--radius-lg); padding: 2rem; margin-bottom: 1.5rem; box-shadow: var(--shadow-soft); border: 1px solid var(--border-color); transition: 0.3s; }
        .progress-track { background: var(--bg-main); height: 12px; border-radius: 999px; overflow: hidden; margin: 1rem 0; }
        .progress-fill { height: 100%; background: var(--primary); border-radius: 999px; transition: 0.5s; }
        
        .btn-primary { background: var(--primary); color: white; padding: 0.8rem 1.5rem; border-radius: 999px; border: none; font-weight: 800; cursor: pointer; width: 100%; transition: 0.3s; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 4px 15px rgba(0, 165, 80, 0.3); }
        .btn-outline { background: transparent; border: 2px solid var(--primary); color: var(--primary); padding: 0.5rem 1rem; border-radius: 999px; font-weight: 800; cursor: pointer; font-size: 0.8rem; transition: 0.3s; }
        .btn-outline:hover { background: var(--primary); color: white; }
        
        .modal { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); backdrop-filter: blur(5px); z-index: 1000; align-items: center; justify-content: center; }
        .modal-content { background: var(--card-bg); padding: 2rem; border-radius: var(--radius-lg); width: 90%; max-width: 400px; border: 1px solid var(--border-color); transition: 0.3s; }
        .modal-input { width: 100%; padding: 1rem; border-radius: 12px; border: 2px solid var(--border-color); background: var(--bg-main); color: var(--text-main); margin-bottom: 1rem; font-weight: 600; outline: none; transition: 0.3s; }
        .modal-input:focus { border-color: var(--primary); }
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
                    <a href="{{ url('/') }}" class="nav-link {{ Request::is('/') ? 'active' : '' }}">Beranda</a>
                    <a href="{{ url('/saving') }}" class="nav-link {{ Request::is('saving') ? 'active' : '' }}">Tabungan</a>
                    <a href="{{ url('/education') }}" class="nav-link {{ Request::is('education') ? 'active' : '' }}">Edukasi</a>
                    <a href="{{ url('/planner') }}" class="nav-link {{ Request::is('planner') ? 'active' : '' }}">Planner</a>
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

        <h1 style="font-size: 2.2rem; font-weight: 800; margin-bottom: 2rem; color: var(--text-main);">🎯 Target Tabungan</h1>

        @if(session('error'))
            <div style="background: var(--danger); color: white; padding: 1rem 1.5rem; border-radius: 12px; margin-bottom: 2rem; font-weight: 800; display: flex; align-items: center; gap: 1rem; box-shadow: 0 4px 15px rgba(225, 29, 72, 0.3);">
                <span style="font-size: 1.5rem;">🛑</span> 
                <span>{{ session('error') }}</span>
            </div>
        @endif
        @if(session('success'))
            <div style="background: var(--primary); color: white; padding: 1rem 1.5rem; border-radius: 12px; margin-bottom: 2rem; font-weight: 800; display: flex; align-items: center; gap: 1rem; box-shadow: 0 4px 15px rgba(0, 165, 80, 0.3);">
                <span style="font-size: 1.5rem;">✅</span> 
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="main-layout">
            <div>
                <div class="clean-panel">
                    @forelse($savings ?? [] as $saving)
                        @php 
                            $progress = $saving->target_amount > 0 ? round(($saving->current_amount / $saving->target_amount) * 100) : 0; 
                        @endphp
                        <div style="margin-bottom: 2rem; border-bottom: 1px solid var(--border-color); padding-bottom: 1.5rem;">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <h3 style="font-size: 1.2rem; color: var(--text-main);">{{ $saving->title }}</h3>
                                    <p style="font-size: 0.8rem; color: var(--text-muted);">Target: Rp {{ number_format($saving->target_amount, 0, ',', '.') }}</p>
                                </div>
                                <span style="color: var(--primary); font-weight: 800; font-size: 1.5rem;">{{ $progress }}%</span>
                            </div>
                            
                            <div class="progress-track">
                                <div class="progress-fill" style="width: {{ $progress > 100 ? 100 : $progress }}%;"></div>
                            </div>
                            
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <p style="font-size: 0.9rem; color: var(--text-main);">Terkumpul: <b>Rp {{ number_format($saving->current_amount, 0, ',', '.') }}</b></p>
                                <button class="btn-outline" onclick="openDepositModal('{{ $saving->id }}', '{{ $saving->title }}')">💰 Isi Celengan</button>
                            </div>
                        </div>
                    @empty
                        <p style="color: var(--text-muted);">Belum ada target. Klik tombol di samping!</p>
                    @endforelse
                </div>
            </div>
            
            <div>
                <div class="clean-panel" style="background: var(--primary-light); border-color: var(--primary);">
                    <h3 style="color: var(--primary);">Tambah Target</h3>
                    <p style="font-size: 0.9rem; margin: 1rem 0; color: var(--text-main);">Tentukan impianmu dan mulai menabung secara bertahap.</p>
                    <button class="btn-primary" onclick="document.getElementById('goalModal').style.display='flex'">+ Buat Goal Baru</button>
                </div>
            </div>
        </div>
    </div>

    <div id="goalModal" class="modal">
        <form class="modal-content" action="{{ url('/saving/store') }}" method="POST">
            @csrf
            <h2 style="margin-bottom: 1.5rem; color: var(--text-main);">Goal Baru ✨</h2>
            <input type="text" name="title" class="modal-input" placeholder="Nama Barang (ex: Knalpot Racing)" required>
            <input type="number" name="target_amount" class="modal-input" placeholder="Harga Target (Rp)" required>
            <button type="submit" class="btn-primary">Pasang Target!</button>
            <button type="button" class="btn-outline" style="width:100%; border:none; margin-top:0.5rem;" onclick="document.getElementById('goalModal').style.display='none'">Batal</button>
        </form>
    </div>

    <div id="depositModal" class="modal">
        <form id="depositForm" class="modal-content" method="POST">
            @csrf
            <h2 style="margin-bottom: 0.5rem; color: var(--text-main);">Isi Celengan 💰</h2>
            <p id="depositTitle" style="color: var(--text-muted); margin-bottom: 1.5rem;"></p>
            <input type="number" name="amount" class="modal-input" placeholder="Nominal (Rp)" required autofocus>
            <button type="submit" class="btn-primary">Pindahkan Saldo Utama</button>
            <button type="button" class="btn-outline" style="width:100%; border:none; margin-top:0.5rem;" onclick="document.getElementById('depositModal').style.display='none'">Batal</button>
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

        function openDepositModal(id, title) {
            document.getElementById('depositForm').action = '/saving/deposit/' + id;
            document.getElementById('depositTitle').innerText = 'Untuk: ' + title;
            document.getElementById('depositModal').style.display = 'flex';
        }
    </script>
</body>
</html>