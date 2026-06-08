@extends('layouts.app')
@section('title', 'Catat Pengeluaran')
@section('header_title', 'Catat Pengeluaran')
@section('header_subtitle', 'Rekam setiap transaksi keluar dengan detail')

@section('content')
<div style="display:grid; grid-template-columns: 1.5fr 1fr; gap:1.5rem;">
    <form id="expenseForm" action="{{ url('/transaction/store') }}" method="POST" enctype="multipart/form-data" class="panel">
        @csrf
        <h3 style="margin-bottom:1.5rem;">Detail Pengeluaran</h3>
        
        <div class="form-group">
            <label class="form-label">Nominal (Rp)</label>
            <input type="number" name="amount" id="amountInput" class="form-control" placeholder="50000" style="font-size:1.5rem; font-weight:700; color:var(--danger);" required>
        </div>
        
        <div class="form-group">
            <label class="form-label">Dari Dompet / Rekening</label>
            <select name="wallet_id" class="form-control" required>
                <option value="">-- Pilih Sumber Dana --</option>
                @foreach($wallets as $wallet)
                    <option value="{{ $wallet->id }}">{{ $wallet->icon }} {{ $wallet->name }} (Sisa: Rp {{ number_format($wallet->balance, 0, ',', '.') }})</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <label class="form-label">Kategori</label>
            <select name="category_id" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->icon }} {{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        
        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:1rem;">
            <div class="form-group">
                <label class="form-label">Tanggal Transaksi</label>
                <input type="date" name="transaction_date" class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Mood Belanja</label>
                <select name="mood" class="form-control" required>
                    <option value="Normal">😐 Normal (Kebutuhan)</option>
                    <option value="Happy">😃 Happy (Self Reward)</option>
                    <option value="Stress">😫 Stress (Pelarian)</option>
                    <option value="FOMO">🥴 FOMO (Ikut-ikutan)</option>
                </select>
            </div>
        </div>
        
        <div class="form-group">
            <label class="form-label">Catatan / Deskripsi Belanja</label>
            <input type="text" name="description" id="descInput" class="form-control" placeholder="Contoh: Kopi janji jiwa" required>
        </div>

        <div class="form-group">
            <label class="form-label">Bukti Foto (Opsional)</label>
            <input type="file" name="attachment" class="form-control" accept="image/*" style="padding:0.4rem 0.5rem;">
        </div>
        
        <button type="submit" class="btn btn-danger" style="width:100%; padding:1rem; font-size:1rem; margin-top:1rem; justify-content:center;">Catat Pengeluaran 🔥</button>
    </form>

    <div>
        <div class="panel" style="background:var(--danger-light); border:1px solid rgba(239,68,68,0.2);">
            <div style="font-size:2rem; margin-bottom:0.75rem;">💸</div>
            <h3 style="font-size:0.95rem; font-weight:700; color:var(--danger); margin-bottom:0.5rem;">Catat dengan Bijak</h3>
            <p style="font-size:0.8rem; color:var(--text-muted); line-height:1.6;">Setiap pengeluaran yang tercatat membantu kamu memahami pola belanjamu dan membuat keputusan finansial yang lebih cerdas.</p>
        </div>
        
        <div class="panel">
            <h3 style="font-size:0.9rem; font-weight:600; margin-bottom:0.75rem;">Mode Anti-Impuls</h3>
            <label style="display:flex; align-items:center; gap:0.5rem; cursor:pointer;">
                <input type="checkbox" id="impulseToggle" style="width:18px; height:18px;" {{ Auth::user()->is_anti_impulse_active ? 'checked' : '' }}>
                <span style="font-size:0.85rem; color:var(--text-main);">Aktifkan untuk minta mikir 2x sebelum beli barang nggak penting.</span>
            </label>
        </div>
    </div>
</div>

<!-- Modal Anti Impuls -->
<div id="impulseModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); backdrop-filter:blur(5px); z-index:1000; align-items:center; justify-content:center;">
    <div class="panel" style="max-width:440px; text-align:center; border:2px solid var(--warning); margin:0;">
        <div style="font-size:3.5rem; margin-bottom:0.875rem;">🚨</div>
        <h2 style="color:var(--warning); margin-bottom:0.875rem; font-size:1.2rem;">Tunggu Dulu!</h2>
        <p style="color:var(--text-main); margin-bottom:0.4rem; font-size:0.9rem;">Kamu mau ngeluarin uang sebesar:</p>
        <h1 id="modalAmount" style="color:var(--danger); margin-bottom:0.4rem; font-size:1.75rem; font-weight:800;">Rp 0</h1>
        <p style="color:var(--text-main); margin-bottom:1.25rem; font-size:0.9rem;">hanya untuk <b><span id="modalDesc">...</span></b>?</p>
        <p style="color:var(--text-muted); font-size:0.825rem; margin-bottom:1.75rem; line-height:1.6;">Mode Anti-Impuls mendeteksi pengeluaran ini. Apakah ini benar-benar kebutuhan, atau cuma keinginan sesaat?</p>
        
        <button type="button" class="btn btn-primary" style="width:100%; padding:0.875rem; justify-content:center;" onclick="cancelExpense()">Batalin Aja Deh (Nabung) 🛡️</button>
        <button type="button" style="background:transparent; color:var(--text-muted); padding:0.875rem; border:none; font-weight:600; width:100%; cursor:pointer; margin-top:0.25rem; text-decoration:underline;" onclick="forceSubmit()">Iya gapapa, tetep beli 😔</button>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const form = document.getElementById('expenseForm');
    const modal = document.getElementById('impulseModal');
    const impulseToggle = document.getElementById('impulseToggle');
    let antiImpulseTempPass = false;
    
    impulseToggle.addEventListener('change', function() {
        const isChecked = this.checked;
        fetch('{{ route("toggle.impuls") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ is_active: isChecked })
        })
        .then(response => response.json())
        .catch(error => {
            console.error('Error:', error);
            this.checked = !isChecked;
        });
    });

    form.addEventListener('submit', function(e) {
        if (impulseToggle.checked && !antiImpulseTempPass) {
            e.preventDefault();
            let amount = document.getElementById('amountInput').value || 0;
            let desc = document.getElementById('descInput').value || '...';
            document.getElementById('modalAmount').innerText = 'Rp ' + parseInt(amount).toLocaleString('id-ID');
            document.getElementById('modalDesc').innerText = desc;
            modal.style.display = 'flex';
        }
    });

    function cancelExpense() { 
        modal.style.display = 'none'; 
        antiImpulseTempPass = false;
    }
    
    function forceSubmit() { 
        antiImpulseTempPass = true; 
        form.submit(); 
    }
</script>
@endsection
