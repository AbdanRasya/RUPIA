@extends('layouts.app')
@section('title', 'Pembayaran')
@section('header_title', 'Mall Pembayaran')
@section('header_subtitle', 'Bayar tagihan dan beli pulsa dengan mudah')

@section('styles')
<style>
    /* ── CATEGORY ── */
    .category-label { font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: var(--text-muted); margin: 1.75rem 0 0.875rem; }
    .category-label:first-child { margin-top: 0; }

    /* ── PRODUCT GRID ── */
    .product-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 1rem; }
    .product-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        padding: 1.5rem 1rem;
        cursor: pointer;
        transition: all 0.18s ease;
        text-align: center;
        box-shadow: var(--shadow-sm);
    }
    .product-card:hover { border-color: var(--primary); box-shadow: 0 4px 16px rgba(0,165,80,0.12); transform: translateY(-2px); }
    .product-icon-wrap { width: 52px; height: 52px; border-radius: 14px; background: var(--primary-light); display: flex; align-items: center; justify-content: center; margin: 0 auto 0.75rem; font-size: 1.6rem; }
    .product-name { font-size: 0.875rem; font-weight: 600; color: var(--text-main); }

    /* ── MODALS ── */
    .pay-modal { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); backdrop-filter: blur(4px); z-index: 1000; align-items: center; justify-content: center; }
    .pay-modal-content { background: var(--card-bg); padding: 2rem; border-radius: var(--radius-lg); width: 90%; max-width: 420px; border: 1px solid var(--border-color); box-shadow: var(--shadow-md); color: var(--text-main); }
    .list-item-pay { display: flex; justify-content: space-between; align-items: center; padding: 0.875rem 1rem; border: 1px solid var(--border-color); border-radius: var(--radius-sm); margin-bottom: 0.625rem; cursor: pointer; transition: 0.18s; }
    .list-item-pay:hover { border-color: var(--primary); background: var(--primary-light); }
    .list-item-name { font-weight: 600; font-size: 0.875rem; color: var(--text-main); }
    .list-item-price { font-weight: 700; color: var(--primary); font-size: 0.875rem; }
    .custom-input { width: 100%; padding: 0.875rem; border-radius: var(--radius-sm); border: 1px solid var(--border-color); background: var(--bg-page); color: var(--text-main); margin: 0.875rem 0; outline: none; text-align: center; font-weight: 700; font-size: 1rem; font-family: 'Inter', sans-serif; }
    .custom-input:focus { border-color: var(--primary); }
</style>
@endsection

@section('content')
<p class="category-label">📱 Pulsa &amp; Paket Data</p>
<div class="product-grid">
    <div class="product-card" onclick="openMenuModal('pulsa')">
        <div class="product-icon-wrap">📱</div>
        <div class="product-name">Isi Pulsa</div>
    </div>
    <div class="product-card" onclick="openMenuModal('data')">
        <div class="product-icon-wrap">🌐</div>
        <div class="product-name">Paket Data</div>
    </div>
</div>

<p class="category-label">🏠 Tagihan Rumah</p>
<div class="product-grid">
    <div class="product-card" onclick="openMenuModal('pln')">
        <div class="product-icon-wrap">⚡</div>
        <div class="product-name">Token PLN</div>
    </div>
    <div class="product-card" onclick="openMenuModal('internet')">
        <div class="product-icon-wrap">📡</div>
        <div class="product-name">Internet &amp; TV</div>
    </div>
</div>

<div id="menuModal" class="pay-modal">
    <div class="pay-modal-content">
        <h2 id="menuTitle" style="font-size:1.05rem;font-weight:700;margin-bottom:1.25rem;text-align:center;">Pilih Nominal</h2>
        <div id="menuContainer"></div>
        <button class="btn btn-outline" style="width:100%; justify-content:center; margin-top:1rem;" onclick="closeMenuModal()">Batal</button>
    </div>
</div>

<div id="paymentModal" class="pay-modal">
    <form id="paymentForm" class="pay-modal-content" action="{{ url('/pay/process') }}" method="POST" style="text-align:center; margin:0;">
        @csrf
        <div id="modalIcon" style="font-size:2.5rem;margin-bottom:0.875rem;">🛒</div>
        <h2 style="font-size:1.1rem;font-weight:700;margin-bottom:0.4rem;">Konfirmasi Bayar</h2>
        <p style="color:var(--text-muted);font-size:0.825rem;margin-bottom:0.875rem;">Pembelian: <b id="displayProduct" style="color:var(--text-main);">...</b></p>
        <h1 id="displayPrice" style="color:var(--primary);font-size:1.75rem;font-weight:800;margin-bottom:0.875rem;">Rp 0</h1>
        <input type="text" class="custom-input" placeholder="Nomor HP / ID Pelanggan" required>
        <input type="hidden" name="product_name" id="inputProduct">
        <input type="hidden" name="amount" id="inputAmount">
        <div style="display:flex; gap:0.5rem; margin-top:1rem;">
            <button type="submit" class="btn btn-primary" style="flex:1; justify-content:center;">Bayar</button>
            <button type="button" class="btn btn-outline" style="flex:1; justify-content:center;" onclick="closePaymentModal()">Kembali</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    const productData = {
        'pulsa': { title: '📱 Pilih Nominal Pulsa', icon: '📱', items: [{ name: 'Pulsa 20.000', price: 21500 }, { name: 'Pulsa 50.000', price: 51000 }, { name: 'Pulsa 100.000', price: 99500 }] },
        'data':  { title: '🌐 Pilih Paket Data', icon: '🌐', items: [{ name: 'Paket Harian 2GB', price: 15000 }, { name: 'Paket Mingguan 10GB', price: 55000 }] },
        'pln':   { title: '⚡ Pilih Token Listrik', icon: '⚡', items: [{ name: 'Token PLN 50.000', price: 52500 }, { name: 'Token PLN 100.000', price: 102500 }] },
        'internet': { title: '📡 Bayar Internet', icon: '📡', items: [{ name: 'Indihome 30Mbps', price: 350000 }] }
    };
    function openMenuModal(key) {
        const data = productData[key];
        document.getElementById('menuTitle').innerText = data.title;
        const container = document.getElementById('menuContainer');
        container.innerHTML = '';
        data.items.forEach(item => {
            const div = document.createElement('div');
            div.className = 'list-item-pay';
            div.onclick = () => openPaymentModal(item.name, item.price, data.icon);
            div.innerHTML = `<span class="list-item-name">${item.name}</span><span class="list-item-price">Rp ${item.price.toLocaleString('id-ID')}</span>`;
            container.appendChild(div);
        });
        document.getElementById('menuModal').style.display = 'flex';
    }
    function openPaymentModal(name, price, icon) {
        closeMenuModal();
        document.getElementById('modalIcon').innerText = icon;
        document.getElementById('displayProduct').innerText = name;
        document.getElementById('displayPrice').innerText = 'Rp ' + price.toLocaleString('id-ID');
        document.getElementById('inputProduct').value = name;
        document.getElementById('inputAmount').value = price;
        document.getElementById('paymentModal').style.display = 'flex';
    }
    function closeMenuModal() { document.getElementById('menuModal').style.display = 'none'; }
    function closePaymentModal() { document.getElementById('paymentModal').style.display = 'none'; }
</script>
@endsection
