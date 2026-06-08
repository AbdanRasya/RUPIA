@extends('layouts.app')
@section('title', 'Catat Pemasukan')
@section('header_title', 'Catat Pemasukan')
@section('header_subtitle', 'Tambah saldo ke dompet kamu')

@section('content')
<form action="{{ url('/topup/process') }}" method="POST" class="panel" style="max-width:600px;">
    @csrf
    <h3 style="margin-bottom:1.5rem;">Informasi Pemasukan</h3>
    
    <div class="form-group">
        <label class="form-label">Nominal (Rp)</label>
        <input type="number" name="amount" class="form-control" placeholder="100000" style="font-size:1.5rem; font-weight:700; color:var(--primary);" required>
    </div>
    
    <div class="form-group">
        <label class="form-label">Pilih Dompet / Rekening Tujuan</label>
        <select name="wallet_id" class="form-control" required>
            <option value="">-- Pilih Dompet --</option>
            @foreach($wallets as $wallet)
                <option value="{{ $wallet->id }}">{{ $wallet->icon }} {{ $wallet->name }} (Saldo: Rp {{ number_format($wallet->balance, 0, ',', '.') }})</option>
            @endforeach
        </select>
    </div>
    
    <div class="form-group">
        <label class="form-label">Kategori Pemasukan</label>
        <select name="category_id" class="form-control" required>
            <option value="">-- Pilih Kategori --</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->icon }} {{ $cat->name }}</option>
            @endforeach
        </select>
    </div>
    
    <div class="form-group">
        <label class="form-label">Tanggal Transaksi</label>
        <input type="date" name="transaction_date" class="form-control" value="{{ date('Y-m-d') }}" required>
    </div>
    
    <div class="form-group">
        <label class="form-label">Catatan (Opsional)</label>
        <input type="text" name="description" class="form-control" placeholder="Contoh: Gaji bulan April">
    </div>
    
    <button type="submit" class="btn btn-primary" style="width:100%; padding:1rem; font-size:1rem; margin-top:1rem; justify-content:center;">Simpan Pemasukan</button>
</form>
@endsection
