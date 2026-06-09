@extends('layouts.app')
@section('title', 'Pembayaran')
@section('header_title', 'Mall Pembayaran')
@section('header_subtitle', 'Bayar tagihan dan beli pulsa dengan mudah')

@section('styles')
<style>

.payment-banner{
    background: var(--card-bg);
    border:1px solid var(--border-color);
    border-radius:20px;
    padding:1.5rem;
    margin-bottom:1.5rem;
    box-shadow:var(--shadow-sm);
}

.payment-banner h2{
    margin:0;
    font-size:1.4rem;
    font-weight:700;
    color:var(--text-main);
}

.payment-banner p{
    margin:.5rem 0 0;
    color:var(--text-muted);
}

.category-label{
    display:flex;
    align-items:center;
    gap:.5rem;
    margin:1.5rem 0 .8rem;
    font-size:.95rem;
    font-weight:700;
    color:var(--text-main);
}

.payment-section{
    background:var(--card-bg);
    border:1px solid var(--border-color);
    border-radius:20px;
    padding:1rem;
    margin-bottom:1.5rem;
    box-shadow:var(--shadow-sm);
}

.product-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(130px,1fr));
    gap:1rem;
}

.product-card{
    background:#fff;
    border:1px solid var(--border-color);
    border-radius:16px;
    padding:1rem;
    text-align:center;
    cursor:pointer;
    transition:.2s;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    gap:.75rem;
    min-height:120px;
}

.product-card:hover{
    transform:translateY(-3px);
    border-color:var(--primary);
}

.product-icon-wrap{
    width:56px;
    height:56px;
    border-radius:14px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:1.6rem;
    background:#f5f5f5;
}

.product-name{
    font-size:.85rem;
    font-weight:600;
    color:var(--text-main);
}

.icon-blue,
.icon-green,
.icon-yellow,
.icon-purple,
.icon-orange,
.icon-red,
.icon-teal,
.icon-indigo{
    background:#f5f7fa;
    color:#333;
}

.pay-modal{
    display:none;
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.45);
    z-index:1000;
    justify-content:center;
    align-items:center;
}

.pay-modal-content{
    width:90%;
    max-width:420px;
    background:var(--card-bg);
    border-radius:20px;
    overflow:hidden;
}

.modal-header{
    padding:1.2rem;
    border-bottom:1px solid var(--border-color);
    position:relative;
}

.modal-body{
    padding:1.2rem;
}

.modal-close{
    position:absolute;
    top:10px;
    right:15px;
    border:none;
    background:none;
    cursor:pointer;
    font-size:1.3rem;
}

.list-item-pay{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:.9rem;
    border:1px solid var(--border-color);
    border-radius:12px;
    margin-bottom:.7rem;
    cursor:pointer;
}

.list-item-pay:hover{
    border-color:var(--primary);
}

.list-item-name{
    font-weight:600;
}

.list-item-price{
    color:var(--primary);
    font-weight:700;
}

.custom-input{
    width:100%;
    padding:.9rem;
    border-radius:12px;
    border:1px solid var(--border-color);
    margin:1rem 0;
}
</style>
@endsection

@section('content')

<div class="payment-banner">
    <h2>Pembayaran & Tagihan</h2>
    <p>Semua kebutuhan pembayaran dalam satu halaman.</p>
</div>

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
