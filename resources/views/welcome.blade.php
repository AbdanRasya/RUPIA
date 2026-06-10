<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RUPIA - Manajemen Keuangan Harian</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --sidebar-bg: #1A2744;
            --bg-page: #F4F6FA;
            --card-bg: #FFFFFF;
            --primary: #00A550;
            --primary-light: #E6F7EE;
            --primary-dark: #007A3B;
            --accent: #3B82F6;
            --text-main: #1A2744;
            --text-muted: #6B7280;
            --border-color: #E5E7EB;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.08);
            --shadow-md: 0 4px 16px rgba(0,0,0,0.08);
            --shadow-lg: 0 10px 25px rgba(0,0,0,0.05);
            --radius-lg: 16px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--bg-page);
            color: var(--text-main);
            line-height: 1.6;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.25rem 5%;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 100;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
        }

        .logo {
            font-size: 1.6rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: var(--sidebar-bg);
            text-decoration: none;
        }

        .logo span {
            color: var(--primary);
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .nav-links a {
            color: var(--text-main);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: var(--primary);
        }

        .btn-primary {
            background: var(--primary);
            color: white !important;
            padding: 0.6rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            display: inline-block;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(0, 165, 80, 0.25);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        .btn-outline {
            background: transparent;
            color: var(--text-main) !important;
            padding: 0.6rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            border: 1px solid var(--border-color);
            transition: all 0.3s;
            display: inline-block;
            text-decoration: none;
            background-color: var(--card-bg);
        }

        .btn-outline:hover {
            border-color: var(--primary);
            color: var(--primary) !important;
            background-color: var(--primary-light);
        }

        header.hero {
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-height: 100vh;
            padding: 7rem 5% 3rem;
            gap: 3rem;
            background: linear-gradient(135deg, #FFFFFF 0%, #E6F7EE 100%);
            position: relative;
        }

        .hero-content {
            flex: 1;
            max-width: 600px;
        }

        .badge {
            background: var(--primary-light);
            color: var(--primary-dark);
            padding: 0.4rem 1rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(0, 165, 80, 0.2);
        }

        .hero h1 {
            font-size: 3.5rem;
            line-height: 1.15;
            margin-bottom: 1.25rem;
            font-weight: 800;
            color: var(--sidebar-bg);
            letter-spacing: -1px;
        }

        .hero h1 span {
            color: var(--primary);
        }

        .hero p {
            font-size: 1.15rem;
            color: var(--text-muted);
            margin-bottom: 2rem;
            font-weight: 400;
        }

        .hero-btns {
            display: flex;
            gap: 1rem;
        }

        .hero-image {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .hero-image img {
            width: 100%;
            max-width: 550px;
            animation: float 6s ease-in-out infinite;
            filter: drop-shadow(0 20px 40px rgba(0, 165, 80, 0.15));
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
            100% { transform: translateY(0px); }
        }

        section {
            padding: 6rem 5%;
        }

        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .section-header h2 {
            font-size: 2.5rem;
            color: var(--sidebar-bg);
            margin-bottom: 1rem;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .section-header p {
            color: var(--text-muted);
            max-width: 600px;
            margin: 0 auto;
            font-size: 1.1rem;
        }

        .features {
            background-color: var(--card-bg);
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            background: var(--bg-page);
            border: 1px solid var(--border-color);
            padding: 2.5rem 2rem;
            border-radius: var(--radius-lg);
            transition: transform 0.3s, box-shadow 0.3s;
            text-align: left;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
            border-color: var(--primary-light);
        }

        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 70px;
            height: 70px;
            background: var(--primary-light);
            color: var(--primary);
            border-radius: 16px;
        }

        .feature-card h3 {
            font-size: 1.25rem;
            margin-bottom: 0.75rem;
            color: var(--sidebar-bg);
            font-weight: 700;
        }

        .feature-card p {
            color: var(--text-muted);
            font-size: 0.95rem;
            line-height: 1.5;
        }

        .about {
            background-color: var(--sidebar-bg);
            color: white;
        }

        .about .section-header h2 {
            color: white;
        }

        .about .section-header p {
            color: #8FA3C0;
        }

        .about-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }

        .about-text p {
            color: #8FA3C0;
            margin-bottom: 1.5rem;
            font-size: 1.05rem;
        }

        .about-stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .stat-item {
            background: rgba(255, 255, 255, 0.05);
            padding: 1.5rem;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .stat-item h4 {
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 0.25rem;
            font-weight: 800;
        }

        .stat-item span {
            color: #8FA3C0;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .cta {
            text-align: center;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 5rem 2rem;
            border-radius: 24px;
            margin: 4rem 5%;
            box-shadow: 0 20px 40px rgba(0, 165, 80, 0.2);
        }

        .cta h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            font-weight: 800;
        }

        .cta p {
            color: var(--primary-light);
            margin-bottom: 2rem;
            font-size: 1.1rem;
            max-width: 600px;
            margin-inline: auto;
        }

        .cta .btn-outline {
            background-color: white;
            color: var(--primary-dark) !important;
            border-color: white;
        }
        
        .cta .btn-outline:hover {
            background-color: #f8f9fa;
        }

        footer {
            text-align: center;
            padding: 2rem;
            border-top: 1px solid var(--border-color);
            color: var(--text-muted);
            font-size: 0.9rem;
            background: var(--card-bg);
        }

        @media (max-width: 768px) {
            header.hero, .about-content {
                flex-direction: column;
                text-align: center;
            }
            .hero-btns {
                justify-content: center;
            }
            .hero h1 { font-size: 2.8rem; }
            .nav-links { display: none; }
            .about-content { gap: 2rem; }
        }
    </style>
</head>
<body>

    <nav>
        <a href="#" class="logo">RUPIA<span>.</span></a>
        <div class="nav-links">
            <a href="#features">Fitur Utama</a>
            <a href="#about">Tentang Kami</a>
            @auth
                <a href="{{ url('/dashboard') }}" class="btn-primary">Dashboard</a>
            @else
                <a href="{{ route('login') }}">Masuk</a>
                <a href="{{ route('register') }}" class="btn-primary">Daftar Gratis</a>
            @endauth
        </div>
    </nav>

    <header class="hero">
        <div class="hero-content">
            <div class="badge">🚀 Masa Depan Finansialmu Dimulai di Sini</div>
            <h1>Kendalikan Uangmu,<br>Raih <span>Kebebasan</span></h1>
            <p>Satu aplikasi terintegrasi untuk mencatat transaksi harian, merencanakan target masa depan, dan mencegah pengeluaran impulsif. Saatnya hidup lebih sejahtera!</p>
            <div class="hero-btns">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-primary">Lanjut ke Dashboard</a>
                @else
                    <a href="{{ route('register') }}" class="btn-primary">Mulai Sekarang</a>
                    <a href="#about" class="btn-outline">Pelajari Lebih Lanjut</a>
                @endauth
            </div>
        </div>
        <div class="hero-image">
            <img src="{{ asset('images/hero-asset-green.png') }}" alt="RUPIA App Illustration">
        </div>
    </header>

    <section id="features" class="features">
        <div class="section-header">
            <h2>Solusi Lengkap Keuanganmu</h2>
            <p>Beragam fitur yang didesain khusus untuk memudahkan kamu dalam memonitor, mengalokasikan, dan mengelola dana sehari-hari secara otomatis.</p>
        </div>
        
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">📊</div>
                <h3>Pencatatan Cerdas</h3>
                <p>Catat semua arus kas harianmu, kelompokkan dengan kategori fleksibel, dan pantau pengeluaran via grafik statistik yang super intuitif.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🛑</div>
                <h3>Anti-Impuls Mode</h3>
                <p>Fitur andalan kami yang akan meminta konfirmasi ganda sebelum transaksi non-esensial. Cocok bagi kamu yang ingin menghentikan kebiasaan boros!</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🎯</div>
                <h3>Life Event Planner</h3>
                <p>Buat tujuan spesifik (seperti beli rumah, liburan, modal nikah) dan lacak progres menabungmu secara real-time setiap bulan.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🤖</div>
                <h3>AI Financial Assistant</h3>
                <p>Dapatkan insight harian, tips penghematan, dan saran alokasi budget otomatis dari sistem kecerdasan buatan (AI) RUPIA.</p>
            </div>
        </div>
    </section>

    <section id="about" class="about">
        <div class="section-header">
            <h2>Tentang RUPIA</h2>
            <p>Menjadi mitra terbaik untuk kesehatan dompetmu</p>
        </div>
        <div class="about-content">
            <div class="about-image">
                <div style="background: rgba(255,255,255,0.05); padding: 2rem; border-radius: 20px; text-align: center; border: 1px solid rgba(255,255,255,0.1);">
                    <div style="font-size: 5rem; margin-bottom: 1rem;">💼</div>
                    <h3 style="font-size: 1.5rem; color: white; margin-bottom: 0.5rem;">Visi Kami</h3>
                    <p style="color: #8FA3C0; font-size: 0.95rem;">Membebaskan setiap individu dari tekanan finansial akibat manajemen uang yang buruk.</p>
                </div>
            </div>
            <div class="about-text">
                <p>Di era serba digital yang mendorong kita untuk berbelanja secara konsumtif, <strong>RUPIA</strong> hadir sebagai rem cerdas dan pendamping keuangan pribadimu. Kami menyadari bahwa masalah finansial bukanlah pada seberapa banyak uang yang dihasilkan, melainkan pada bagaimana uang tersebut dikelola.</p>
                <p>Aplikasi RUPIA dikembangkan dengan pendekatan psikologi keuangan, membantu pengguna tidak sekadar mencatat, namun juga <i>mengubah kebiasaan</i>. Melalui fitur Anti-Impuls, kami memastikan setiap rupiah yang keluar selalu tepat sasaran.</p>
                
                <div class="about-stats">
                    <div class="stat-item">
                        <h4>100%</h4>
                        <span>Aman & Terenkripsi</span>
                    </div>
                    <div class="stat-item">
                        <h4>24/7</h4>
                        <span>Dukungan AI Cerdas</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="cta">
        <h2>Siap Merapikan Keuanganmu Hari Ini?</h2>
        <p>Bergabunglah bersama kami dan ubah caramu melihat dan menggunakan uang selamanya. Mulai dari langkah kecil, raih pencapaian besar.</p>
        @auth
            <a href="{{ url('/dashboard') }}" class="btn-outline">Kembali ke Dashboard</a>
        @else
            <a href="{{ route('register') }}" class="btn-outline">Daftar Sekarang Secara Gratis</a>
        @endauth
    </div>

    <footer>
        <p>&copy; {{ date('Y') }} RUPIA Financial Management. Hak Cipta Dilindungi.</p>
    </footer>

</body>
</html>
