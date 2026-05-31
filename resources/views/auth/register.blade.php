<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar | Rupia - Financial Assistant</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,400;0,14..32,500;0,14..32,600;0,14..32,700;1,14..32,400&display=swap');
        
        :root {
            --primary: #00A550;
            --primary-dark: #007A3B;
            --bg-page: #F4F6FA;
            --text-main: #1A2744;
            --text-muted: #6B7280;
            --border-color: #E5E7EB;
            --radius-md: 12px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: var(--bg-page); color: var(--text-main); display: flex; min-height: 100vh; -webkit-font-smoothing: antialiased; }

        .auth-container { display: flex; width: 100%; min-height: 100vh; }
        
        /* ── LEFT BRANDING AREA ── */
        .auth-left {
            flex: 1;
            background: linear-gradient(135deg, var(--primary), #0077B6);
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 4rem;
            position: relative;
            overflow: hidden;
        }
        @media (max-width: 900px) { .auth-left { display: none; } }
        
        .auth-left::before {
            content: '';
            position: absolute;
            top: -100px; right: -100px;
            width: 400px; height: 400px;
            border-radius: 50%;
            background: rgba(255,255,255,0.05);
        }
        .auth-left::after {
            content: '';
            position: absolute;
            bottom: -50px; left: -50px;
            width: 300px; height: 300px;
            border-radius: 50%;
            background: rgba(255,255,255,0.05);
        }

        .auth-brand { font-size: 2.5rem; font-weight: 800; margin-bottom: 1.5rem; position: relative; z-index: 1; letter-spacing: -1px; }
        .auth-tagline { font-size: 1.25rem; font-weight: 500; line-height: 1.6; max-width: 450px; opacity: 0.9; position: relative; z-index: 1; }

        /* ── RIGHT FORM AREA ── */
        .auth-right {
            flex: 1;
            background: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            overflow-y: auto;
        }
        .form-wrapper { width: 100%; max-width: 420px; }
        
        .form-header { margin-bottom: 2.5rem; }
        .form-header h2 { font-size: 1.75rem; font-weight: 700; color: var(--text-main); margin-bottom: 0.5rem; letter-spacing: -0.5px; }
        .form-header p { font-size: 0.95rem; color: var(--text-muted); }

        .form-group { margin-bottom: 1.25rem; }
        .form-label { display: block; font-size: 0.85rem; font-weight: 600; color: var(--text-main); margin-bottom: 0.5rem; }
        .form-input {
            width: 100%;
            padding: 1rem;
            border-radius: var(--radius-md);
            border: 1px solid var(--border-color);
            background: var(--bg-page);
            color: var(--text-main);
            font-size: 0.95rem;
            font-family: 'Inter', sans-serif;
            transition: 0.2s;
            outline: none;
        }
        .form-input:focus { border-color: var(--primary); background: #fff; box-shadow: 0 0 0 4px rgba(0, 165, 80, 0.1); }

        .btn-primary {
            width: 100%;
            padding: 1rem;
            border-radius: var(--radius-md);
            background: var(--primary);
            color: white;
            border: none;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: 0.2s;
            margin-top: 0.5rem;
            font-family: 'Inter', sans-serif;
        }
        .btn-primary:hover { background: var(--primary-dark); transform: translateY(-1px); }

        .error-message {
            background: #FEF2F2;
            color: #991B1B;
            padding: 1rem;
            border-radius: var(--radius-md);
            font-size: 0.875rem;
            margin-bottom: 1.5rem;
            border: 1px solid #FECACA;
            font-weight: 500;
        }

        .input-error { color: #991B1B; font-size: 0.8rem; margin-top: 0.3rem; font-weight: 500; }

        .auth-links { margin-top: 1.75rem; text-align: center; font-size: 0.9rem; color: var(--text-muted); }
        .auth-links a { color: var(--primary); text-decoration: none; font-weight: 600; }
        .auth-links a:hover { text-decoration: underline; }
    </style>
<link rel="stylesheet" href="{{ asset('css/theme.css') }}">
</head>
<body>
    <div class="auth-container">
        <div class="auth-left">
            <h1 class="auth-brand">Rupia.</h1>
            <p class="auth-tagline">Mulai langkah pertamamu menuju kebebasan finansial. Daftar sekarang dan kelola keuanganmu lebih baik.</p>
        </div>
        <div class="auth-right">
            <div class="form-wrapper">
                <div class="form-header">
                    <h2>Buat Akun Baru</h2>
                    <p>Bergabunglah dengan Rupia hari ini.</p>
                </div>

                <form action="{{ url('/register') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-input" placeholder="Isi Nama Lengkap" required value="{{ old('name') }}">
                        @error('name') <div class="input-error">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Alamat Email</label>
                        <input type="email" name="email" class="form-input" placeholder="contoh@email.com" required value="{{ old('email') }}">
                        @error('email') <div class="input-error">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Kata Sandi</label>
                        <input type="password" name="password" class="form-input" placeholder="Minimal 8 karakter" required>
                        @error('password') <div class="input-error">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Konfirmasi Kata Sandi</label>
                        <input type="password" name="password_confirmation" class="form-input" placeholder="Ulangi kata sandi" required>
                    </div>

                    <button type="submit" class="btn-primary">Daftar Sekarang</button>
                </form>

                <div class="auth-links">
                    Sudah punya akun? <a href="{{ url('/login') }}">Masuk di sini</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

