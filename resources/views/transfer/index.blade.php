<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rupia | Transfer</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap');
        :root { --bg-main: #f3f4f6; --card-bg: #ffffff; --text-main: #111827; --text-muted: #6b7280; --primary: #00a550; --danger: #e11d48; --info: #3b82f6; --border-color: #e5e7eb; --radius-lg: 28px; }
        [data-theme="dark"] { --bg-main: #0f172a; --card-bg: #1e293b; --text-main: #f8fafc; --text-muted: #94a3b8; --border-color: #334155; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background-color: var(--bg-main); color: var(--text-main); padding: 1.5rem; min-height: 100vh; }
        .container { max-width: 600px; margin: 0 auto; }
        .clean-panel { background: var(--card-bg); border-radius: var(--radius-lg); padding: 2rem; border: 1px solid var(--border-color); margin-top: 2rem; }
        .custom-input { width: 100%; padding: 1.2rem; font-size: 1.1rem; border-radius: 16px; border: 2px solid var(--border-color); background: var(--bg-main); color: var(--text-main); outline: none; margin-bottom: 1.5rem; }
        .custom-input.amount { font-size: 2.5rem; font-weight: 800; color: var(--primary); text-align: center; }
        .btn-submit { width: 100%; background: var(--primary); color: white; padding: 1.2rem; border-radius: 999px; border: none; font-weight: 800; font-size: 1.1rem; cursor: pointer; }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ url('/') }}" style="text-decoration:none; color:var(--text-muted); font-weight:800;">← Kembali ke Beranda</a>
        
        @if(session('error'))
            <div style="background: var(--danger); color: white; padding: 1rem; border-radius: 12px; margin-top: 1rem; font-weight: 800;">🛑 {{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div style="background: var(--primary); color: white; padding: 1rem; border-radius: 12px; margin-top: 1rem; font-weight: 800;">✅ {{ session('success') }}</div>
        @endif

        <form action="{{ url('/transfer/process') }}" method="POST" class="clean-panel">
            @csrf
            <h1 style="font-size: 1.8rem; font-weight: 800; margin-bottom: 1.5rem; text-align: center;">Kirim Uang 💸</h1>
            
            <label style="font-weight:800; color:var(--text-muted); display:block; margin-bottom:0.5rem;">NOMINAL TRANSFER</label>
            <input type="number" name="amount" class="custom-input amount" placeholder="0" required autofocus>
            
            <label style="font-weight:800; color:var(--text-muted); display:block; margin-bottom:0.5rem;">TUJUAN (BANK/E-WALLET/NO HP)</label>
            <input type="text" name="destination" class="custom-input" placeholder="Contoh: BCA 12345678" required>

            <label style="font-weight:800; color:var(--text-muted); display:block; margin-bottom:0.5rem;">CATATAN (OPSIONAL)</label>
            <input type="text" name="notes" class="custom-input" placeholder="Contoh: Patungan Warkop">

            <button type="submit" class="btn-submit">Transfer Sekarang 🚀</button>
        </form>
    </div>
    <script> document.documentElement.setAttribute('data-theme', localStorage.getItem('theme') || 'light'); </script>
</body>
</html>