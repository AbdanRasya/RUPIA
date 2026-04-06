<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rupia | Catat Pengeluaran</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap');
        :root { --bg-main: #f3f4f6; --card-bg: #ffffff; --text-main: #111827; --text-muted: #6b7280; --primary: #00a550; --primary-light: #dcfce7; --danger: #e11d48; --warning: #f59e0b; --border-color: #e5e7eb; --radius-lg: 28px; --shadow-soft: 0 10px 40px -10px rgba(0,0,0,0.08); }
        [data-theme="dark"] { --bg-main: #0f172a; --card-bg: #1e293b; --text-main: #f8fafc; --text-muted: #94a3b8; --border-color: #334155; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background-color: var(--bg-main); color: var(--text-main); padding: 1.5rem; min-height: 100vh; }
        .container { max-width: 1000px; margin: 0 auto; }
        .navbar { display: flex; justify-content: space-between; align-items: center; background: var(--card-bg); border-radius: 999px; padding: 0.75rem 1.5rem; margin-bottom: 2rem; border: 1px solid var(--border-color); }
        .nav-brand { font-size: 1.5rem; font-weight: 800; text-decoration: none; color: var(--primary); }
        .main-layout { display: grid; grid-template-columns: 1fr; gap: 1.5rem; }
        @media (min-width: 768px) { .main-layout { grid-template-columns: 1fr 1fr; } }
        .clean-panel { background: var(--card-bg); border-radius: var(--radius-lg); padding: 2rem; border: 1px solid var(--border-color); }
        .custom-input { width: 100%; padding: 1rem; font-size: 1.1rem; border-radius: 12px; border: 2px solid var(--border-color); background: var(--bg-main); color: var(--text-main); outline: none; margin-top: 0.5rem; }
        .custom-input.amount { font-size: 2rem; font-weight: 800; color: var(--danger); }
        .btn-submit { width: 100%; background: var(--danger); color: white; padding: 1.2rem; border-radius: 999px; border: none; font-weight: 800; font-size: 1.1rem; cursor: pointer; margin-top: 1.5rem; }
        
        /* Modal Peringatan Impulsif */
        .modal { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.7); backdrop-filter: blur(5px); z-index: 1000; align-items: center; justify-content: center; }
        .modal-content { background: var(--card-bg); padding: 2.5rem; border-radius: var(--radius-lg); width: 90%; max-width: 450px; text-align: center; border: 2px solid var(--warning); }
        .btn-cancel { background: var(--primary); color: white; padding: 1rem; border-radius: 999px; border: none; font-weight: 800; width: 100%; cursor: pointer; margin-top: 1rem; }
        .btn-force { background: transparent; color: var(--text-muted); padding: 1rem; border: none; font-weight: 800; width: 100%; cursor: pointer; margin-top: 0.5rem; text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <nav class="navbar"><a href="{{ url('/') }}" class="nav-brand">Rupia.</a></nav>
        <h1 style="font-size: 2.2rem; font-weight: 800; margin-bottom: 2rem; color: var(--text-main);">💸 Catat Pengeluaran</h1>
        
        <form id="expenseForm" action="{{ url('/transaction/store') }}" method="POST" class="main-layout">
            @csrf
            <div class="clean-panel">
                <label style="font-weight:800; color:var(--text-muted);">UANG KELUAR (RP)</label>
                <input type="number" name="amount" id="amountInput" class="custom-input amount" placeholder="0" required>
                <label style="font-weight:800; color:var(--text-muted); display:block; margin-top:1.5rem;">BUAT BELI APA?</label>
                <input type="text" name="description" id="descInput" class="custom-input" placeholder="Contoh: Kopi Mahal" required>
            </div>
            <div class="clean-panel">
                <input type="hidden" name="category" value="Lainnya">
                <input type="hidden" name="mood" value="Normal">
                <button type="submit" class="btn-submit">Catat Sekarang 🔥</button>
            </div>
        </form>
    </div>

    <div id="impulseModal" class="modal">
        <div class="modal-content">
            <div style="font-size: 4rem; margin-bottom: 1rem;">🚨</div>
            <h2 style="color: var(--warning); margin-bottom: 1rem;">Tunggu Dulu!</h2>
            <p style="color: var(--text-main); margin-bottom: 0.5rem;">Kamu mau ngeluarin uang sebesar:</p>
            <h1 id="modalAmount" style="color: var(--danger); margin-bottom: 0.5rem;">Rp 0</h1>
            <p style="color: var(--text-main); margin-bottom: 1.5rem;">hanya untuk <b><span id="modalDesc">...</span></b>?</p>
            
            <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 2rem;">Mode Anti-Impuls mendeteksi pengeluaran ini. Apakah ini benar-benar kebutuhan, atau cuma keinginan sesaat?</p>
            
            <button type="button" class="btn-cancel" onclick="cancelExpense()">Batalin Aja Deh (Nabung) 🛡️</button>
            <button type="button" class="btn-force" onclick="forceSubmit()">Iya gapapa, tetep beli 😔</button>
        </div>
    </div>

    <script>
        const savedTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-theme', savedTheme);

        const form = document.getElementById('expenseForm');
        const modal = document.getElementById('impulseModal');

        form.addEventListener('submit', function(e) {
            // Cek apakah mode anti impuls nyala di Beranda
            if (localStorage.getItem('antiImpulse') === 'true') {
                e.preventDefault(); // Tahan form jangan dikirim dulu
                
                // Isi text di dalam modal biar personal
                let amount = document.getElementById('amountInput').value;
                let desc = document.getElementById('descInput').value;
                document.getElementById('modalAmount').innerText = 'Rp ' + parseInt(amount).toLocaleString('id-ID');
                document.getElementById('modalDesc').innerText = desc;
                
                // Munculkan modal peringatan
                modal.style.display = 'flex';
            }
        });

        function cancelExpense() {
            modal.style.display = 'none';
            window.location.href = '/saving'; // Arahin ke halaman tabungan biar tobat wkwk
        }

        function forceSubmit() {
            // Matikan sementara perlindungan, lalu submit form beneran
            localStorage.setItem('antiImpulseTempPass', 'true'); 
            form.submit();
        }
    </script>
</body>
</html>