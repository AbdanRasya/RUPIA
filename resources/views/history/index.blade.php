@extends('layouts.app')
@section('title', 'Riwayat Pencatatan')
@section('header_title', 'Riwayat Transaksi')
@section('header_subtitle', 'Pantau kemana perginya uangmu')

@section('content')
<div class="panel">
    <form action="{{ url('/history') }}" method="GET" style="display:flex; gap:1rem; flex-wrap:wrap; align-items:flex-end;">
        <div class="form-group" style="margin-bottom:0; flex:1; min-width:200px;">
            <label class="form-label">Cari Catatan</label>
            <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Ketik nominal atau catatan...">
        </div>
        <div class="form-group" style="margin-bottom:0; flex:1; min-width:150px;">
            <label class="form-label">Tipe Transaksi</label>
            <select name="type" class="form-control">
                <option value="all">Semua Tipe</option>
                <option value="income" {{ request('type') == 'income' ? 'selected' : '' }}>Pemasukan</option>
                <option value="expense" {{ request('type') == 'expense' ? 'selected' : '' }}>Pengeluaran</option>
            </select>
        </div>
        <div class="form-group" style="margin-bottom:0; flex:1; min-width:150px;">
            <label class="form-label">Kategori</label>
            <select name="category_id" class="form-control">
                <option value="all">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->icon }} {{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group" style="margin-bottom:0;">
            <button type="submit" class="btn btn-primary" style="padding:0.6rem 1.5rem; height:40px;">Filter</button>
            <a href="{{ url('/history') }}" class="btn btn-outline" style="padding:0.6rem 1.5rem; height:40px; margin-left:0.5rem;">Reset</a>
        </div>
    </form>
</div>

<div class="panel">
    <h3 style="margin-bottom:1rem;">Timeline Transaksi</h3>
    
    @if($transactions->count() > 0)
        @php $currentDate = ''; @endphp
        
        <div style="display:flex; flex-direction:column; gap:1rem;">
            @foreach($transactions as $trx)
                @php
                    $trxDate = $trx->transaction_date ? \Carbon\Carbon::parse($trx->transaction_date)->format('d M Y') : \Carbon\Carbon::parse($trx->created_at)->format('d M Y');
                @endphp
                
                @if($currentDate !== $trxDate)
                    <div style="padding-top:0.5rem; padding-bottom:0.25rem; border-bottom:1px solid var(--border-color); font-size:0.85rem; font-weight:600; color:var(--text-muted);">
                        {{ $trxDate }}
                    </div>
                    @php $currentDate = $trxDate; @endphp
                @endif
                
                <div style="display:flex; justify-content:space-between; align-items:center; padding:0.75rem; background:var(--bg-page); border-radius:var(--radius-sm);">
                    <div style="display:flex; gap:1rem; align-items:center;">
                        <div style="width:40px; height:40px; border-radius:50%; display:flex; align-items:center; justify-content:center; background:{{ $trx->type == 'income' ? 'var(--primary-light)' : 'var(--danger-light)' }}; color:{{ $trx->type == 'income' ? 'var(--primary-dark)' : 'var(--danger)' }};">
                            @if($trx->type == 'income')
                                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path></svg>
                            @else
                                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4"></path></svg>
                            @endif
                        </div>
                        <div>
                            <h4 style="font-size:0.95rem; font-weight:600; margin-bottom:0.2rem; color:var(--text-main);">{{ $trx->description ?: 'Tanpa Keterangan' }}</h4>
                            <div style="display:flex; gap:0.5rem; font-size:0.75rem; color:var(--text-muted);">
                                <span style="background:var(--card-bg); padding:0.1rem 0.4rem; border-radius:4px; border:1px solid var(--border-color);">{{ $trx->category }}</span>
                                @if($trx->wallet)
                                    <span style="background:var(--card-bg); padding:0.1rem 0.4rem; border-radius:4px; border:1px solid var(--border-color);">{{ $trx->wallet->name }}</span>
                                @endif
                                @if($trx->attachment)
                                    <span style="color:var(--primary);"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:inline;vertical-align:middle;"><path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg> Bukti</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div style="text-align:right;">
                        <h4 style="font-size:1rem; font-weight:700; color:{{ $trx->type == 'income' ? 'var(--primary)' : 'var(--danger)' }};">
                            {{ $trx->type == 'income' ? '+' : '-' }} Rp {{ number_format($trx->amount, 0, ',', '.') }}
                        </h4>
                        <span style="font-size:0.7rem; color:var(--text-muted);">{{ $trx->created_at->format('H:i') }}</span>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div style="margin-top:1.5rem;">
            {{ $transactions->links() }}
        </div>
    @else
        <div style="text-align:center; padding:3rem 0;">
            <svg style="width:48px;height:48px;color:var(--border-color);margin:0 auto 1rem;display:block;" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            <p style="color:var(--text-muted);font-size:0.9rem;">Tidak ada transaksi yang cocok dengan filter.</p>
        </div>
    @endif
</div>
@endsection
