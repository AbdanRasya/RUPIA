@extends('layouts.app')
@section('title', 'Transfer Saldo')
@section('header_title', 'Transfer Saldo')
@section('header_subtitle', 'Pindah dana antar dompetmu')

@section('content')
<form action="{{ url('/transfer/process') }}" method="POST" class="panel" style="max-width:600px;">
    @csrf
    <h3 style="margin-bottom:1.5rem;">Detail Transfer</h3>
    
    <div class="form-group">
        <label class="form-label">Nominal (Rp)</label>
        <input type="number" name="amount" class="form-control" placeholder="50000" style="font-size:1.5rem; font-weight:700; color:var(--text-main);" required>
    </div>
    
    <div style="display:flex; gap:1rem; align-items:flex-end;">
        <div class="form-group" style="flex:1;">
            <label class="form-label">Dompet Asal</label>
            <select name="source_wallet_id" class="form-control" required>
                <option value="">-- Pilih Asal Dana --</option>
                @foreach($wallets as $wallet)
                    <option value="{{ $wallet->id }}">{{ $wallet->icon }} {{ $wallet->name }} (Rp {{ number_format($wallet->balance, 0, ',', '.') }})</option>
                @endforeach
            </select>
        </div>
        
        <div style="padding-bottom:1rem;">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="color:var(--text-muted);"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
        </div>

        <div class="form-group" style="flex:1;">
            <label class="form-label">Dompet Tujuan</label>
            <select name="destination_wallet_id" class="form-control" required>
                <option value="">-- Pilih Tujuan Dana --</option>
                @foreach($wallets as $wallet)
                    <option value="{{ $wallet->id }}">{{ $wallet->icon }} {{ $wallet->name }} (Rp {{ number_format($wallet->balance, 0, ',', '.') }})</option>
                @endforeach
            </select>
        </div>
    </div>
    
    <div class="form-group">
        <label class="form-label">Catatan Tambahan (Opsional)</label>
        <input type="text" name="notes" class="form-control" placeholder="Contoh: Pindahin buat bayar kos">
    </div>
    
    <button type="submit" class="btn btn-primary" style="width:100%; padding:1rem; font-size:1rem; margin-top:1rem; justify-content:center;">Proses Transfer</button>
</form>
@endsection
