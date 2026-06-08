@extends('layouts.app')
@section('title', 'Dompet Saya')
@section('header_title', 'Dompet Saya')
@section('header_subtitle', 'Kelola semua dompet dan rekening kamu')

@section('content')
<div class="panel" style="display:flex; justify-content:space-between; align-items:center;">
    <div>
        <h2 class="panel-title" style="margin:0;">Daftar Dompet</h2>
        <p style="font-size:0.8rem; color:var(--text-muted); margin-top:0.2rem;">Total saldo di semua dompet: Rp {{ number_format($wallets->sum('balance'), 0, ',', '.') }}</p>
    </div>
    <button onclick="document.getElementById('addWalletModal').style.display='flex'" class="btn btn-primary">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path></svg>
        Tambah Dompet
    </button>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1rem;">
    @forelse($wallets as $wallet)
    <div class="panel" style="margin-bottom:0; position:relative; overflow:hidden;">
        <div style="position:absolute; top:0; left:0; width:4px; height:100%; background:{{ $wallet->color }};"></div>
        <div style="display:flex; justify-content:space-between; align-items:flex-start;">
            <div style="display:flex; align-items:center; gap:0.75rem;">
                <div style="width:40px; height:40px; border-radius:10px; background:{{ $wallet->color }}20; display:flex; align-items:center; justify-content:center; font-size:1.2rem;">
                    {{ $wallet->icon }}
                </div>
                <div>
                    <h3 style="font-size:1rem; font-weight:600; color:var(--text-main);">{{ $wallet->name }}</h3>
                    <span style="font-size:0.7rem; color:var(--text-muted); text-transform:uppercase;">{{ $wallet->type }}</span>
                </div>
            </div>
            <div style="display:flex; gap:0.5rem;">
                <button onclick="editWallet({{ $wallet->toJson() }})" style="background:none; border:none; color:var(--text-muted); cursor:pointer; padding:0.2rem;" title="Edit">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </button>
                <form action="{{ route('wallets.destroy', $wallet->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus dompet ini?');" style="margin:0;">
                    @csrf @method('DELETE')
                    <button type="submit" style="background:none; border:none; color:var(--danger); cursor:pointer; padding:0.2rem;" title="Hapus">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </form>
            </div>
        </div>
        <div style="margin-top:1.25rem;">
            <p style="font-size:0.8rem; color:var(--text-muted); margin-bottom:0.2rem;">Saldo</p>
            <p style="font-size:1.4rem; font-weight:700; color:var(--text-main);">Rp {{ number_format($wallet->balance, 0, ',', '.') }}</p>
        </div>
    </div>
    @empty
    <div style="grid-column: 1/-1; text-align:center; padding:3rem; background:var(--card-bg); border-radius:var(--radius-md); border:1px dashed var(--border-color);">
        <p style="color:var(--text-muted);">Belum ada dompet. Silahkan tambahkan dompet pertama kamu.</p>
    </div>
    @endforelse
</div>

<!-- Add Modal -->
<div id="addWalletModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:100; align-items:center; justify-content:center;">
    <form action="{{ route('wallets.store') }}" method="POST" class="panel" style="width:100%; max-width:400px; position:relative; margin:0;">
        @csrf
        <h3 style="margin-bottom:1rem;">Tambah Dompet</h3>
        <div class="form-group">
            <label class="form-label">Nama Dompet (Mis: BCA Pribadi, Gopay)</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label class="form-label">Tipe Dompet</label>
            <select name="type" class="form-control" required>
                <option value="tunai">Uang Tunai</option>
                <option value="bank">Rekening Bank</option>
                <option value="ewallet">E-Wallet</option>
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Saldo Saat Ini (Rp)</label>
            <input type="number" name="balance" class="form-control" value="0" required>
        </div>
        <div style="display:flex; gap:0.5rem; margin-top:1.5rem;">
            <button type="submit" class="btn btn-primary" style="flex:1; justify-content:center;">Simpan</button>
            <button type="button" class="btn btn-outline" style="flex:1; justify-content:center;" onclick="document.getElementById('addWalletModal').style.display='none'">Batal</button>
        </div>
    </form>
</div>

<!-- Edit Modal -->
<div id="editWalletModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:100; align-items:center; justify-content:center;">
    <form id="editWalletForm" method="POST" class="panel" style="width:100%; max-width:400px; position:relative; margin:0;">
        @csrf @method('PUT')
        <h3 style="margin-bottom:1rem;">Edit Dompet</h3>
        <div class="form-group">
            <label class="form-label">Nama Dompet</label>
            <input type="text" name="name" id="editWalletName" class="form-control" required>
        </div>
        <div class="form-group">
            <label class="form-label">Tipe Dompet</label>
            <select name="type" id="editWalletType" class="form-control" required>
                <option value="tunai">Uang Tunai</option>
                <option value="bank">Rekening Bank</option>
                <option value="ewallet">E-Wallet</option>
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Saldo (Rp)</label>
            <input type="number" name="balance" id="editWalletBalance" class="form-control" required>
        </div>
        <div style="display:flex; gap:0.5rem; margin-top:1.5rem;">
            <button type="submit" class="btn btn-primary" style="flex:1; justify-content:center;">Simpan Perubahan</button>
            <button type="button" class="btn btn-outline" style="flex:1; justify-content:center;" onclick="document.getElementById('editWalletModal').style.display='none'">Batal</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    function editWallet(wallet) {
        document.getElementById('editWalletForm').action = '/wallets/' + wallet.id;
        document.getElementById('editWalletName').value = wallet.name;
        document.getElementById('editWalletType').value = wallet.type;
        document.getElementById('editWalletBalance').value = wallet.balance;
        document.getElementById('editWalletModal').style.display = 'flex';
    }
</script>
@endsection
