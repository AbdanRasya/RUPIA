<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rupia | Top Up Saldo</title>
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
        body { background-color: var(--bg-main); color: var(--text-main); padding: 1.5rem; min-height: 100vh; transition: background-color 0.3s, color 0.3s; }
        .container { max-width: 1000px; margin: 0 auto; }
        
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
        @media (min-width: 768px) { .main-layout { grid-template-columns: 1.5fr 1fr; } }
        
        .clean-panel { background: var(--card-bg); border-radius: var(--radius-lg); padding: 2rem; box-shadow: var(--shadow-soft); border: 1px solid var(--border-color); }
        .nominal-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; margin-top: 1.5rem; }
        .nominal-btn { background: var(--bg-main); border: 2px solid var(--border-color); color: var(--text-main); padding: 1rem; border-radius: 16px; font-weight: 800; font-size: 1.1rem; cursor: pointer; transition: 0.3s; text-align: center; }
        .nominal-btn:hover, .nominal-btn.selected { border-color: var(--info); background: rgba(59, 130, 246, 0.1); color: var(--info); }
        
        .custom-input { width: 100%; padding: 1.2rem; font-size: 1.5rem; font-weight: 800; border-radius: 16px; border: 2px solid var(--border-color); background: var(--bg-main); color: var(--text-main); margin-top: 1rem; outline: none; transition: 0.3s; }
        .custom-input:focus { border-color: var(--info); }

        .method-item { display: flex; align-items: center; gap: 1rem; padding: 1rem; border: 2px solid var(--border-color); border-radius: 16px; margin-bottom: 1rem; cursor: pointer; transition: 0.3s; }
        .method-item:hover, .method-item.selected { border-color: var(--primary); background: var(--primary-light); }
        .method-icon { font-size: 1.8rem; }
        
        .btn-pay { width: 100%; background: var(--info); color: white; padding: 1.2rem; border-radius: 999px; border: none; font-weight: 800; font-size: 1.1rem; cursor: pointer; margin-top: 1.5rem; transition: 0.3s; box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3); }
        .btn-pay:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4); }
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

        <h1 style="font-size: 2.2rem; font-weight: 800; margin-bottom: 2rem; color: var(--text-main);">💳 Top Up Saldo</h1>

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

        <form action="{{ url('/topup/process') }}" method="POST" class="main-layout">
            @csrf
            
            <div class="clean-panel">
                <h2 style="font-size: 1.3rem; margin-bottom: 0.5rem;">Mau isi berapa?</h2>
                <p style="color: var(--text-muted); font-size: 0.95rem;">Pilih nominal cepat atau ketik sendiri.</p>

                <div class="nominal-grid">
                    <div class="nominal-btn" onclick="setNominal(50000, this)">Rp 50.000</div>
                    <div class="nominal-btn" onclick="setNominal(100000, this)">Rp 100.000</div>
                    <div class="nominal-btn" onclick="setNominal(250000, this)">Rp 250.000</div>
                    <div class="nominal-btn" onclick="setNominal(500000, this)">Rp 500.000</div>
                </div>

                <div style="margin-top: 2rem;">
                    <label style="font-weight: 800; color: var(--text-muted); font-size: 0.9rem;">ATAU KETIK NOMINAL LAIN</label>
                    <input type="number" name="amount" id="customAmount" class="custom-input" placeholder="Rp 0" required oninput="clearSelection()">
                </div>
            </div>

            <div class="clean-panel">
                <h2 style="font-size: 1.3rem; margin-bottom: 1.5rem;">Metode Pembayaran</h2>

                <input type="hidden" name="payment_method" id="selectedMethod" value="qris" required>

                <div class="method-item selected" onclick="selectMethod('qris', this)">
                    <div class="method-icon">📱</div>
                    <div>
                        <h4 style="font-size: 1.1rem; margin-bottom: 0.2rem;">QRIS (Rekomendasi)</h4>
                        <p style="font-size: 0.85rem; color: var(--text-muted);">Bebas admin, langsung masuk.</p>
                    </div>
                </div>

                <div class="method-item" onclick="selectMethod('va_bca', this)">
                    <div class="method-icon">🏦</div>
                    <div>
                        <h4 style="font-size: 1.1rem; margin-bottom: 0.2rem;">BCA Virtual Account</h4>
                        <p style="font-size: 0.85rem; color: var(--text-muted);">Biaya admin Rp 1.000</p>
                    </div>
                </div>

                <div class="method-item" onclick="selectMethod('minimarket', this)">
                    <div class="method-icon">🏪</div>
                    <div>
                        <h4 style="font-size: 1.1rem; margin-bottom: 0.2rem;">Indomaret / Alfamart</h4>
                        <p style="font-size: 0.85rem; color: var(--text-muted);">Biaya admin Rp 2.500</p>
                    </div>
                </div>

                <button type="submit" class="btn-pay">Lanjut Bayar 🚀</button>
            </div>
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

        function setNominal(amount, element) {
            document.getElementById('customAmount').value = amount;
            document.querySelectorAll('.nominal-btn').forEach(btn => btn.classList.remove('selected'));
            element.classList.add('selected');
        }

        function clearSelection() {
            document.querySelectorAll('.nominal-btn').forEach(btn => btn.classList.remove('selected'));
        }

        function selectMethod(method, element) {
            document.getElementById('selectedMethod').value = method;
            document.querySelectorAll('.method-item').forEach(item => item.classList.remove('selected'));
            element.classList.add('selected');
        }
    </script>
</body>
</html>