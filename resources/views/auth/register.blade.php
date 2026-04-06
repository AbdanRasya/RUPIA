<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar | Rupia</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap');
        :root {
            --bg-dark: #0f172a;
            --text-light: #f8fafc;
            --primary: #10b981;
            --glass-bg: rgba(30, 41, 59, 0.7);
            --glass-border: rgba(255, 255, 255, 0.1);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body {
            background-color: var(--bg-dark);
            color: var(--text-light);
            display: flex; align-items: center; justify-content: center; min-height: 100vh;
        }
        .glass-panel {
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            border: 1px solid var(--glass-border);
            border-radius: 1.5rem;
            padding: 2.5rem;
            width: 100%; max-width: 450px;
        }
        .title { 
            font-size: 2.5rem; font-weight: 800; text-align: center;
            background: linear-gradient(to right, #34d399, #22d3ee); 
            -webkit-background-clip: text; color: transparent; margin-bottom: 1.5rem;
        }
        .form-group { margin-bottom: 1.2rem; }
        label { display: block; font-size: 0.875rem; margin-bottom: 0.5rem; color: #cbd5e1; }
        input {
            width: 100%; padding: 0.8rem; border-radius: 0.75rem;
            background: rgba(15, 23, 42, 0.6); border: 1px solid var(--glass-border);
            color: white; outline: none;
        }
        input:focus { border-color: var(--primary); }
        .btn {
            width: 100%; padding: 1rem; border-radius: 0.75rem;
            background: var(--primary); color: var(--bg-dark);
            border: none; font-weight: 800; cursor: pointer; margin-top: 1rem;
        }
        .link { text-align: center; margin-top: 1.5rem; font-size: 0.875rem; color: #94a3b8; }
        .link a { color: var(--primary); text-decoration: none; font-weight: bold; }
        .error { color: #fb7185; font-size: 0.8rem; margin-top: 0.3rem; }
    </style>
</head>
<body>
    <div class="glass-panel">
        <h1 class="title">Join Rupia.</h1>
        <form action="{{ url('/register') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" placeholder="Isi Nama Lengkap" required value="{{ old('name') }}">
                @error('name') <p class="error">{{ $message }}</p> @enderror
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="email@contoh.com" required value="{{ old('email') }}">
                @error('email') <p class="error">{{ $message }}</p> @enderror
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Minimal 8 karakter" required>
                @error('password') <p class="error">{{ $message }}</p> @enderror
            </div>
            <div class="form-group">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation" placeholder="Ulangi password" required>
            </div>
            <button type="submit" class="btn">Daftar Sekarang 🚀</button>
            <p class="link">Sudah punya akun? <a href="{{ url('/login') }}">Masuk di sini</a></p>
        </form>
    </div>
</body>
</html>