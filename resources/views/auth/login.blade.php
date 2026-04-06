<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Rupia - Gen Z Financial BFF</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap');
        
        :root {
            --bg-dark: #0f172a;
            --text-light: #f8fafc;
            --text-muted: #94a3b8;
            --primary: #10b981;
            --primary-hover: #059669;
            --glass-bg: rgba(30, 41, 59, 0.7);
            --glass-border: rgba(255, 255, 255, 0.1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }

        body {
            background-color: var(--bg-dark);
            color: var(--text-light);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-image: radial-gradient(circle at top right, rgba(16, 185, 129, 0.1), transparent 40%),
                              radial-gradient(circle at bottom left, rgba(34, 211, 238, 0.1), transparent 40%);
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 2rem;
        }

        .glass-panel {
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            border: 1px solid var(--glass-border);
            border-radius: 1.5rem;
            padding: 2.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .header { text-align: center; margin-bottom: 2rem; }
        .title { 
            font-size: 2.5rem; 
            font-weight: 800; 
            background: linear-gradient(to right, #34d399, #22d3ee); 
            -webkit-background-clip: text; 
            color: transparent; 
            margin-bottom: 0.5rem;
        }

        .form-group { margin-bottom: 1.5rem; }
        .form-label { display: block; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.5rem; color: #cbd5e1; }
        
        .form-input {
            width: 100%;
            padding: 1rem;
            border-radius: 0.75rem;
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid var(--glass-border);
            color: white;
            font-size: 1rem;
            transition: all 0.3s;
        }
        .form-input:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2); }

        .btn-primary {
            width: 100%;
            padding: 1rem;
            border-radius: 0.75rem;
            background: var(--primary);
            color: var(--bg-dark);
            border: none;
            font-weight: 800;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 1rem;
        }
        .btn-primary:hover { background: var(--primary-hover); transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.3); }

        .error-message {
            background: rgba(244, 63, 94, 0.1);
            color: #fb7185;
            padding: 0.75rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(244, 63, 94, 0.2);
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <div class="glass-panel">
            <div class="header">
                <h1 class="title">Rupia.</h1>
                <p style="color: var(--text-muted); font-size: 0.875rem;">Masuk dulu buat atur amunisimu.</p>
            </div>

            @if ($errors->any())
                <div class="error-message">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ url('/login') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-input" placeholder="abdan@smktelkom.edu" required value="{{ old('email') }}">
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-input" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn-primary">Masuk Sekarang 🚀</button>

                <p class="link" style="text-align: center; margin-top: 1.5rem; font-size: 0.875rem; color: #94a3b8;">
    Belum punya akun? <a href="{{ url('/register') }}" style="color: var(--primary); text-decoration: none; font-weight: bold;">Daftar di sini</a>
</p>
            </form>
        </div>
    </div>

</body>
</html>