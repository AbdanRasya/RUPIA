<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rupia | Mall Pembayaran</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap');
        
        :root { 
            --bg-main: #f3f4f6; --card-bg: #ffffff; --text-main: #111827; --text-muted: #6b7280; 
            --primary: #00a550; --primary-light: #dcfce7; --danger: #e11d48; --info: #3b82f6; --warning: #f59e0b;
            --border-color: #e5e7eb; --radius-lg: 28px; --shadow-soft: 0 10px 40px -10px rgba(0,0,0,0.08);
        }

        [data-theme="dark"] {
            --bg-main: #0f172a; --card-bg: #1e293b; --text-main: #f8fafc; --text-muted: #94a3b8;
            --primary-light: rgba(0, 165, 80, 0.15); --border-color: #334155; --shadow-soft: 0 10px 40px -10px rgba(0,0,0,0.5);
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background-color: var(--bg-main); color: var(--text-main); padding: 1.5rem; min-height: 100vh; transition: 0.3s; }
        .container { max-width: 1000px; margin: 0 auto; }
        
        /* NAVBAR SAKTI */
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
        
        /* KATEGORI PEMBAYARAN (DESAIN BARU TANPA HARGA) */
        .category-section { margin-bottom: 2.5rem; }
        .category-title { font-size: 1.3rem; margin-bottom: 1rem; color: var(--text-main); display: flex; align-items: center; gap: 0.5rem; }
        
        .product-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem; }
        .product-card { background: var(--card-bg); border: 2px solid var(--border-color); padding: 1.5rem; border-radius: 20px; cursor: pointer; transition: 0.3s; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 0.5rem; box-shadow: var(--shadow-soft); text-align: center; }
        .product-card:hover { border-color: var(--info); transform: translateY(-3px); background: rgba(59, 130, 246, 0.05); }
        
        .product-icon { font-size: 2.5rem; margin-bottom: 0.5rem; }
        .product-name { font-weight: 800; font-size: 1.1rem; color: var(--text-main); }

        /* MODAL LIST PRODUK & KONFIRMASI */
        .modal { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); backdrop-filter: blur(5px); z-index: 1000; align-items: center; justify-content: center; }
        .modal-content { background: var(--card-bg); padding: 2rem; border-radius: var(--radius-lg); width: 90%; max-width: 450px; border: 1px solid var(--border-color); max-height: 90vh; overflow-y: auto; }
        
        /* ITEM DI DALAM MODAL LIST */
        .list-item { display: flex; justify-content: space-between; align-items: center; padding: 1rem; border: 2px solid var(--border-color); border-radius: 16px; margin-bottom: 0.8rem; cursor: pointer; transition: 0.3s; }
        .list-item:hover { border-color: var(--info); background: var(--bg-main); }
        .list-item-name { font-weight: 800; color: var(--text-main); font-size: 1.05rem; }
        .list-item-price { font-weight: 800; color: var(--info); font-size: 1.1rem; }
        
        .custom-input { width: 100%; padding: 1rem; font-size: 1rem; border-radius: 12px; border: 2px solid var(--border-color); background: var(--bg-main); color: var(--text-main); outline: none; margin-bottom: 1.5rem; font-weight: 600; text-align: center; }
        .custom-input:focus { border-color: var(--info); }

        .btn-submit { width: 100%; background: var(--info); color: white; padding: 1.2rem; border-radius: 999px; border: none; font-weight: 800; font-size: 1.1rem; cursor: pointer; margin-top: 1rem; transition: 0.3s; box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3); }
        .btn-submit:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4); }
        .btn-outline { background: transparent; border: 2px solid var(--border-color); color: var(--text-muted); padding: 1rem; border-radius: 999px; font-weight: 800; cursor: pointer; width: 100%; margin-top: 0.5rem; transition: 0.3s; }
        .btn-outline:hover { background: var(--bg-main); color: var(--text-main); }
    </style>
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
                    <a href="{{ url('/planner') }}" class="nav-link">Planner</a>
                </div>
            </div>
            <div class="nav-right">
                <button id="themeToggle" class="btn-theme">🌙</button>
                <div class="avatar">{{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}</div>
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="btn-logout">Keluar</button>
                </form>
            </div>
        </nav>

        <h1 style="font-size: 2.2rem; font-weight: 800; margin-bottom: 2rem; color: var(--text-main);">🎛️ Mall Pembayaran</h1>

        @if(session('error'))
            <div style="background: var(--danger); color: white; padding: 1rem 1.5rem; border-radius: 12px; margin-bottom: 2rem; font-weight: 800; display: flex; align-items: center; gap: 1rem;">
                <span style="font-size: 1.5rem;">🛑</span> <span>{{ session('error') }}</span>
            </div>
        @endif
        @if(session('success'))
            <div style="background: var(--primary); color: white; padding: 1rem 1.5rem; border-radius: 12px; margin-bottom: 2rem; font-weight: 800; display: flex; align-items: center; gap: 1rem;">
                <span style="font-size: 1.5rem;">✅</span> <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="category-section">
            <h3 class="category-title">📱 Pulsa & Paket Data</h3>
            <div class="product-grid">
                <div class="product-card" onclick="openMenuModal('pulsa')">
                    <div class="product-icon">📱</div>
                    <div class="product-name">Isi Pulsa</div>
                </div>
                <div class="product-card" onclick="openMenuModal('data')">
                    <div class="product-icon">🌐</div>
                    <div class="product-name">Paket Data</div>
                </div>
            </div>
        </div>

        <div class="category-section">
            <h3 class="category-title">🏠 Tagihan Rumah</h3>
            <div class="product-grid">
                <div class="product-card" onclick="openMenuModal('pln')">
                    <div class="product-icon">⚡</div>
                    <div class="product-name">Token PLN</div>
                </div>
                <div class="product-card" onclick="openMenuModal('pdam')">
                    <div class="product-icon">💧</div>
                    <div class="product-name">Air PDAM</div>
                </div>
                <div class="product-card" onclick="openMenuModal('internet')">
                    <div class="product-icon">📡</div>
                    <div class="product-name">Internet & TV</div>
                </div>
            </div>
        </div>

        <div class="category-section">
            <h3 class="category-title">🎮 Hiburan & E-Wallet</h3>
            <div class="product-grid">
                <div class="product-card" onclick="openMenuModal('ewallet')">
                    <div class="product-icon">🏍️</div>
                    <div class="product-name">Top Up E-Wallet</div>
                </div>
                <div class="product-card" onclick="openMenuModal('hiburan')">
                    <div class="product-icon">🎬</div>
                    <div class="product-name">Voucher Hiburan</div>
                </div>
            </div>
        </div>
    </div>

    <div id="menuModal" class="modal">
        <div class="modal-content">
            <h2 id="menuTitle" style="color: var(--text-main); margin-bottom: 1.5rem; text-align: center;">Pilih Nominal</h2>
            <div id="menuContainer">
                </div>
            <button class="btn-outline" onclick="closeMenuModal()">Batal</button>
        </div>
    </div>

    <div id="paymentModal" class="modal">
        <form id="paymentForm" class="modal-content" action="{{ url('/pay/process') }}" method="POST" style="text-align: center;">
            @csrf
            <div id="modalIcon" style="font-size: 3.5rem; margin-bottom: 1rem;">🛒</div>
            <h2 style="margin-bottom: 0.5rem; color: var(--text-main);">Konfirmasi Bayar</h2>
            <p style="color: var(--text-muted); margin-bottom: 1.5rem;">Pembelian: <b id="displayProduct" style="color: var(--text-main);">...</b></p>
            
            <h1 id="displayPrice" style="color: var(--info); margin-bottom: 1.5rem;">Rp 0</h1>

            <input type="text" class="custom-input" placeholder="Masukkan Nomor HP / ID Pelanggan" required>

            <input type="hidden" name="product_name" id="inputProduct">
            <input type="hidden" name="amount" id="inputAmount">

            <button type="submit" class="btn-submit">Bayar Sekarang</button>
            <button type="button" class="btn-outline" onclick="closePaymentModal()">Kembali</button>
        </form>
    </div>

    <script>
        // Tema Logika
        const savedTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-theme', savedTheme);
        const themeBtn = document.getElementById('themeToggle');
        themeBtn.innerHTML = savedTheme === 'dark' ? '☀️' : '🌙';
        themeBtn.addEventListener('click', () => {
            const next = document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', next);
            localStorage.setItem('theme', next);
            themeBtn.innerHTML = next === 'dark' ? '☀️' : '🌙';
        });

        // ---------------------------------------------------
        // DATABASE DUMMY PRODUK & HARGA
        // ---------------------------------------------------
        const productData = {
            'pulsa': {
                title: '📱 Pilih Nominal Pulsa',
                icon: '📱',
                items: [
                    { name: 'Pulsa 20.000', price: 21500 },
                    { name: 'Pulsa 50.000', price: 51000 },
                    { name: 'Pulsa 100.000', price: 99500 }
                ]
            },
            'data': {
                title: '🌐 Pilih Paket Data',
                icon: '🌐',
                items: [
                    { name: 'Paket Harian 2GB', price: 15000 },
                    { name: 'Paket Mingguan 10GB', price: 55000 },
                    { name: 'Paket Bulanan 30GB', price: 115000 }
                ]
            },
            'pln': {
                title: '⚡ Pilih Token Listrik',
                icon: '⚡',
                items: [
                    { name: 'Token PLN 50.000', price: 52500 },
                    { name: 'Token PLN 100.000', price: 102500 },
                    { name: 'Token PLN 200.000', price: 202500 }
                ]
            },
            'pdam': {
                title: '💧 Bayar PDAM',
                icon: '💧',
                items: [
                    { name: 'PDAM Golongan 1', price: 55000 },
                    { name: 'PDAM Golongan 2', price: 85000 }
                ]
            },
            'internet': {
                title: '📡 Bayar Internet WiFi',
                icon: '📡',
                items: [
                    { name: 'Indihome 30Mbps', price: 350000 },
                    { name: 'Biznet Home 100Mbps', price: 400000 }
                ]
            },
            'ewallet': {
                title: '🏍️ Pilih E-Wallet',
                icon: '🏍️',
                items: [
                    { name: 'Top Up GoPay 50rb', price: 51000 },
                    { name: 'Top Up DANA 100rb', price: 101000 },
                    { name: 'Top Up OVO 100rb', price: 101500 }
                ]
            },
            'hiburan': {
                title: '🎬 Pilih Voucher',
                icon: '🎬',
                items: [
                    { name: 'Spotify Premium 1 Bulan', price: 54900 },
                    { name: 'Netflix Mobile', price: 54000 },
                    { name: 'Netflix Basic', price: 65000 }
                ]
            }
        };

        // ---------------------------------------------------
        // LOGIKA MEMBUKA MODAL LIST HARGA
        // ---------------------------------------------------
        function openMenuModal(categoryKey) {
            const data = productData[categoryKey];
            document.getElementById('menuTitle').innerText = data.title;
            
            const container = document.getElementById('menuContainer');
            container.innerHTML = ''; // Kosongkan isi sebelumnya

            // Render daftar harganya
            data.items.forEach(item => {
                const div = document.createElement('div');
                div.className = 'list-item';
                div.onclick = () => openPaymentModal(item.name, item.price, data.icon);
                
                div.innerHTML = `
                    <div class="list-item-name">${item.name}</div>
                    <div class="list-item-price">Rp ${item.price.toLocaleString('id-ID')}</div>
                `;
                container.appendChild(div);
            });

            document.getElementById('menuModal').style.display = 'flex';
        }

        function closeMenuModal() {
            document.getElementById('menuModal').style.display = 'none';
        }

        // ---------------------------------------------------
        // LOGIKA MEMBUKA MODAL KONFIRMASI (LANGKAH TERAKHIR)
        // ---------------------------------------------------
        function openPaymentModal(productName, price, icon) {
            // Tutup modal pertama dulu
            closeMenuModal();

            // Setup dan buka modal kedua
            document.getElementById('modalIcon').innerText = icon;
            document.getElementById('displayProduct').innerText = productName;
            document.getElementById('displayPrice').innerText = 'Rp ' + price.toLocaleString('id-ID');
            document.getElementById('inputProduct').value = productName;
            document.getElementById('inputAmount').value = price;
            
            document.getElementById('paymentModal').style.display = 'flex';
        }

        function closePaymentModal() {
            document.getElementById('paymentModal').style.display = 'none';
        }
    </script>
</body>
</html>