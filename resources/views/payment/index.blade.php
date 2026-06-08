@extends('layouts.app')
@section('title', 'Pembayaran')
@section('header_title', 'Mall Pembayaran')
@section('header_subtitle', 'Bayar tagihan dan beli pulsa dengan mudah')

@section('styles')
<style>
    /* ── CATEGORY ── */
    .category-label { 
        font-size: 0.85rem; 
        font-weight: 700; 
        text-transform: uppercase; 
        letter-spacing: 1px; 
        color: var(--text-main); 
        margin: 2rem 0 1rem; 
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .category-label:first-child { margin-top: 0; }
    .category-label span {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        background: var(--bg-page);
        border-radius: 8px;
        font-size: 0.9rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }

    /* ── PRODUCT GRID ── */
    .payment-section {
        background: var(--card-bg);
        border-radius: var(--radius-lg);
        padding: 1.5rem;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-sm);
        margin-bottom: 2rem;
    }

    .product-grid { 
        display: grid; 
        grid-template-columns: repeat(auto-fill, minmax(100px, 1fr)); 
        gap: 1rem; 
    }
    
    @media (min-width: 640px) {
        .product-grid { grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); }
    }

    .product-card {
        background: transparent;
        border: 1px solid transparent;
        border-radius: var(--radius-md);
        padding: 1rem 0.5rem;
        cursor: pointer;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.75rem;
    }
    
    .product-card:hover { 
        background: var(--bg-page);
        border-color: var(--border-color);
        transform: translateY(-4px); 
        box-shadow: 0 4px 12px rgba(0,0,0,0.03);
    }

    .product-icon-wrap { 
        width: 56px; 
        height: 56px; 
        border-radius: 16px; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        font-size: 1.75rem;
        transition: all 0.2s ease;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }
    
    /* Beautiful Gradient Backgrounds for Icons */
    .icon-blue { background: linear-gradient(135deg, #e0f2fe, #bae6fd); color: #0284c7; }
    .icon-green { background: linear-gradient(135deg, #dcfce7, #bbf7d0); color: #16a34a; }
    .icon-yellow { background: linear-gradient(135deg, #fef9c3, #fef08a); color: #ca8a04; }
    .icon-purple { background: linear-gradient(135deg, #f3e8ff, #e9d5ff); color: #9333ea; }
    .icon-orange { background: linear-gradient(135deg, #ffedd5, #fed7aa); color: #ea580c; }
    .icon-red { background: linear-gradient(135deg, #fee2e2, #fecaca); color: #dc2626; }
    .icon-teal { background: linear-gradient(135deg, #ccfbf1, #99f6e4); color: #0d9488; }
    .icon-indigo { background: linear-gradient(135deg, #e0e7ff, #c7d2fe); color: #4f46e5; }

    .product-card:hover .product-icon-wrap {
        transform: scale(1.08) rotate(-3deg);
        box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    }

    .product-name { 
        font-size: 0.85rem; 
        font-weight: 600; 
        color: var(--text-main); 
        line-height: 1.3;
    }

    /* ── MODALS ── */
    .pay-modal { 
        display: none; 
        position: fixed; 
        inset: 0; 
        background: rgba(0,0,0,0.5); 
        backdrop-filter: blur(4px); 
        z-index: 1000; 
        align-items: center; 
        justify-content: center; 
        opacity: 0; 
        transition: opacity 0.2s ease; 
    }
    .pay-modal.show { opacity: 1; }
    .pay-modal-content { 
        background: var(--card-bg); 
        border-radius: 20px; 
        width: 90%; 
        max-width: 400px; 
        box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); 
        color: var(--text-main); 
        overflow: hidden;
        transform: translateY(20px) scale(0.95);
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .pay-modal.show .pay-modal-content { 
        transform: translateY(0) scale(1); 
    }
    
    .modal-header {
        padding: 1.5rem;
        text-align: center;
        border-bottom: 1px solid var(--border-color);
        background: var(--bg-page);
        position: relative;
    }
    
    .modal-close {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: none;
        border: none;
        font-size: 1.5rem;
        color: var(--text-muted);
        cursor: pointer;
        transition: color 0.2s;
    }
    .modal-close:hover { color: var(--danger); }

    .modal-body { padding: 1.5rem; }

    .list-item-pay { 
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
        padding: 1rem; 
        border: 1px solid var(--border-color); 
        border-radius: 12px; 
        margin-bottom: 0.75rem; 
        cursor: pointer; 
        transition: all 0.2s ease; 
        background: var(--card-bg);
    }
    .list-item-pay:hover { 
        border-color: var(--primary); 
        background: var(--primary-light); 
        transform: translateX(4px);
    }
    .list-item-name { font-weight: 600; font-size: 0.9rem; color: var(--text-main); }
    .list-item-price { font-weight: 700; color: var(--primary); font-size: 0.9rem; }
    
    .custom-input { 
        width: 100%; 
        padding: 1rem; 
        border-radius: 12px; 
        border: 1px solid var(--border-color); 
        background: var(--bg-page); 
        color: var(--text-main); 
        margin: 1rem 0; 
        outline: none; 
        text-align: center; 
        font-weight: 600; 
        font-size: 1.05rem; 
        transition: all 0.2s ease;
    }
    .custom-input:focus { 
        border-color: var(--primary); 
        box-shadow: 0 0 0 3px rgba(0,165,80,0.1); 
    }
</style>
@endsection

@section('content')

<h3 class="category-label"><span>📱</span> Pulsa &amp; Paket Data</h3>
<div class="payment-section">
    <div class="product-grid">
        <div class="product-card" onclick="openMenuModal('pulsa')">
            <div class="product-icon-wrap icon-blue">📱</div>
            <div class="product-name">Isi Pulsa</div>
        </div>
        <div class="product-card" onclick="openMenuModal('data')">
            <div class="product-icon-wrap icon-purple">🌐</div>
            <div class="product-name">Paket Data</div>
        </div>
        <div class="product-card" onclick="openMenuModal('roaming')">
            <div class="product-icon-wrap icon-teal">✈️</div>
            <div class="product-name">Roaming</div>
        </div>
        <div class="product-card" onclick="openMenuModal('postpaid')">
            <div class="product-icon-wrap icon-indigo">📝</div>
            <div class="product-name">Pascabayar</div>
        </div>
    </div>
</div>

<h3 class="category-label"><span>🏠</span> Tagihan Rumah</h3>
<div class="payment-section">
    <div class="product-grid">
        <div class="product-card" onclick="openMenuModal('pln')">
            <div class="product-icon-wrap icon-yellow">⚡</div>
            <div class="product-name">Token PLN</div>
        </div>
        <div class="product-card" onclick="openMenuModal('pln_bill')">
            <div class="product-icon-wrap icon-orange">💡</div>
            <div class="product-name">Tagihan Listrik</div>
        </div>
        <div class="product-card" onclick="openMenuModal('internet')">
            <div class="product-icon-wrap icon-blue">📡</div>
            <div class="product-name">Internet &amp; TV</div>
        </div>
        <div class="product-card" onclick="openMenuModal('pdam')">
            <div class="product-icon-wrap icon-blue" style="background: linear-gradient(135deg, #bfdbfe, #93c5fd); color: #1d4ed8;">💧</div>
            <div class="product-name">PDAM</div>
        </div>
    </div>
</div>

<h3 class="category-label"><span>🎮</span> Hiburan & Lainnya</h3>
<div class="payment-section">
    <div class="product-grid">
        <div class="product-card" onclick="openMenuModal('games')">
            <div class="product-icon-wrap icon-purple">🕹️</div>
            <div class="product-name">Voucher Game</div>
        </div>
        <div class="product-card" onclick="openMenuModal('streaming')">
            <div class="product-icon-wrap icon-red">🎬</div>
            <div class="product-name">Streaming</div>
        </div>
        <div class="product-card" onclick="openMenuModal('bpjs')">
            <div class="product-icon-wrap icon-green">🏥</div>
            <div class="product-name">BPJS</div>
        </div>
        <div class="product-card" onclick="openMenuModal('emas')">
            <div class="product-icon-wrap icon-yellow">🪙</div>
            <div class="product-name">E-Mas</div>
        </div>
    </div>
</div>

<!-- Pilih Nominal Modal -->
<div id="menuModal" class="pay-modal">
    <div class="pay-modal-content">
        <div class="modal-header">
            <button class="modal-close" onclick="closeMenuModal()">&times;</button>
            <h2 id="menuTitle" style="font-size:1.1rem;font-weight:700;margin:0;">Pilih Nominal</h2>
        </div>
        <div class="modal-body">
            <div id="menuContainer"></div>
        </div>
    </div>
</div>

<!-- Konfirmasi Pembayaran Modal -->
<div id="paymentModal" class="pay-modal">
    <form id="paymentForm" class="pay-modal-content" action="{{ url('/pay/process') }}" method="POST" style="margin:0;">
        @csrf
        <div class="modal-header" style="padding-bottom: 2rem;">
            <button type="button" class="modal-close" onclick="closePaymentModal()">&times;</button>
            <div id="modalIconWrap" class="product-icon-wrap" style="margin: 0 auto 1rem; width: 64px; height: 64px; font-size: 2rem;">🛒</div>
            <h2 style="font-size:1.2rem;font-weight:800;margin-bottom:0.25rem;">Konfirmasi Bayar</h2>
            <p style="color:var(--text-muted);font-size:0.85rem;margin:0;">Pembelian <span id="displayProduct" style="font-weight:600;color:var(--text-main);">...</span></p>
        </div>
        
        <div class="modal-body" style="text-align:center; padding-top: 0;">
            <div style="background:var(--bg-page); padding:1rem; border-radius:12px; margin-top:-1.5rem; margin-bottom:1.5rem; border:1px solid var(--border-color); box-shadow:0 4px 6px -1px rgba(0,0,0,0.05);">
                <p style="font-size:0.8rem; color:var(--text-muted); margin-bottom:0.25rem; font-weight:600;">Total Pembayaran</p>
                <h1 id="displayPrice" style="color:var(--primary);font-size:2rem;font-weight:800;margin:0; letter-spacing:-0.5px;">Rp 0</h1>
            </div>
            
            <input type="text" class="custom-input" placeholder="Masukkan Nomor / ID Pelanggan" required autocomplete="off">
            
            <input type="hidden" name="product_name" id="inputProduct">
            <input type="hidden" name="amount" id="inputAmount">
            
            <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center; padding:0.875rem; font-size:1rem; margin-top:0.5rem; border-radius:12px; box-shadow:0 4px 12px rgba(0,165,80,0.2);">
                Bayar Sekarang
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    const productData = {
        'pulsa': { title: '📱 Pilih Nominal Pulsa', iconClass: 'icon-blue', icon: '📱', items: [{ name: 'Pulsa 20.000', price: 21500 }, { name: 'Pulsa 50.000', price: 51000 }, { name: 'Pulsa 100.000', price: 99500 }] },
        'data':  { title: '🌐 Pilih Paket Data', iconClass: 'icon-purple', icon: '🌐', items: [{ name: 'Paket Harian 2GB', price: 15000 }, { name: 'Paket Mingguan 10GB', price: 55000 }, { name: 'Paket Bulanan 30GB', price: 110000 }] },
        'roaming': { title: '✈️ Paket Roaming', iconClass: 'icon-teal', icon: '✈️', items: [{ name: 'Asia 3 Hari', price: 150000 }, { name: 'Eropa 7 Hari', price: 350000 }] },
        'postpaid': { title: '📝 Tagihan Pascabayar', iconClass: 'icon-indigo', icon: '📝', items: [{ name: 'Cek Tagihan (Simulasi 150rb)', price: 150000 }] },
        
        'pln':   { title: '⚡ Pilih Token Listrik', iconClass: 'icon-yellow', icon: '⚡', items: [{ name: 'Token PLN 50.000', price: 52500 }, { name: 'Token PLN 100.000', price: 102500 }, { name: 'Token PLN 500.000', price: 502500 }] },
        'pln_bill': { title: '💡 Tagihan Listrik', iconClass: 'icon-orange', icon: '💡', items: [{ name: 'Cek Tagihan (Simulasi 200rb)', price: 200000 }] },
        'internet': { title: '📡 Bayar Internet & TV', iconClass: 'icon-blue', icon: '📡', items: [{ name: 'Indihome 30Mbps', price: 350000 }, { name: 'Biznet 100Mbps', price: 400000 }] },
        'pdam': { title: '💧 Tagihan Air PDAM', iconClass: 'icon-blue', icon: '💧', items: [{ name: 'Cek Tagihan (Simulasi 85rb)', price: 85000 }] },
        
        'games': { title: '🕹️ Voucher Game', iconClass: 'icon-purple', icon: '🕹️', items: [{ name: 'Steam Wallet 45.000', price: 49500 }, { name: 'MLBB 86 Diamonds', price: 25000 }] },
        'streaming': { title: '🎬 Streaming', iconClass: 'icon-red', icon: '🎬', items: [{ name: 'Netflix Premium 1 Bulan', price: 186000 }, { name: 'Spotify Premium 1 Bulan', price: 55000 }] },
        'bpjs': { title: '🏥 Tagihan BPJS', iconClass: 'icon-green', icon: '🏥', items: [{ name: 'BPJS Kelas 1 (Simulasi)', price: 150000 }, { name: 'BPJS Kelas 3 (Simulasi)', price: 35000 }] },
        'emas': { title: '🪙 Investasi E-Mas', iconClass: 'icon-yellow', icon: '🪙', items: [{ name: 'Beli Emas 0.1 Gram', price: 120000 }, { name: 'Beli Emas 1 Gram', price: 1200000 }] }
    };

    function openMenuModal(key) {
        const data = productData[key];
        document.getElementById('menuTitle').innerText = data.title;
        const container = document.getElementById('menuContainer');
        container.innerHTML = '';
        data.items.forEach(item => {
            const div = document.createElement('div');
            div.className = 'list-item-pay';
            div.onclick = () => openPaymentModal(item.name, item.price, data.icon, data.iconClass);
            div.innerHTML = `<span class="list-item-name">${item.name}</span><span class="list-item-price">Rp ${item.price.toLocaleString('id-ID')}</span>`;
            container.appendChild(div);
        });
        
        const modal = document.getElementById('menuModal');
        modal.style.display = 'flex';
        // Add a small delay to allow display block to apply before adding class for transition
        setTimeout(() => modal.classList.add('show'), 10);
    }

    function openPaymentModal(name, price, icon, iconClass) {
        closeMenuModal();
        
        const iconWrap = document.getElementById('modalIconWrap');
        iconWrap.innerText = icon;
        iconWrap.className = 'product-icon-wrap ' + iconClass;
        
        document.getElementById('displayProduct').innerText = name;
        document.getElementById('displayPrice').innerText = 'Rp ' + price.toLocaleString('id-ID');
        document.getElementById('inputProduct').value = name;
        document.getElementById('inputAmount').value = price;
        
        const modal = document.getElementById('paymentModal');
        modal.style.display = 'flex';
        setTimeout(() => modal.classList.add('show'), 10);
    }

    function closeMenuModal() { 
        const modal = document.getElementById('menuModal');
        modal.classList.remove('show');
        setTimeout(() => modal.style.display = 'none', 200); // match transition duration
    }
    
    function closePaymentModal() { 
        const modal = document.getElementById('paymentModal');
        modal.classList.remove('show');
        setTimeout(() => modal.style.display = 'none', 200);
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        const menuModal = document.getElementById('menuModal');
        const paymentModal = document.getElementById('paymentModal');
        if (event.target == menuModal) closeMenuModal();
        if (event.target == paymentModal) closePaymentModal();
    }
</script>
@endsection
