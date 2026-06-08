@extends('layouts.app')
@section('title', 'Pencapaian')
@section('header_title', 'Pencapaian')
@section('header_subtitle', 'Reward untuk kebiasaan finansialmu')

@section('content')
<div class="panel">
    <h2 class="panel-title" style="margin-bottom:1.5rem;">Badge Penghargaan</h2>
    
    <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap:1.5rem;">
        @php
            $badges = [
                'first_blood' => ['icon' => '🥉', 'color' => '#F59E0B'],
                'trx_50' => ['icon' => '🥈', 'color' => '#3B82F6'],
                'saver_1' => ['icon' => '🏆', 'color' => '#10B981']
            ];
        @endphp

        @forelse($achievements as $ach)
            <div style="text-align:center; padding:2rem; background:var(--card-bg); border:1px solid var(--border-color); border-radius:var(--radius-lg); box-shadow:var(--shadow-sm); position:relative; overflow:hidden;">
                <div style="position:absolute; top:-20px; right:-20px; width:100px; height:100px; background:{{ $badges[$ach->type]['color'] ?? 'var(--primary)' }}20; border-radius:50%;"></div>
                
                <div style="font-size:3.5rem; margin-bottom:1rem; position:relative; z-index:1;">
                    {{ $badges[$ach->type]['icon'] ?? '🏅' }}
                </div>
                
                <h3 style="font-size:1.1rem; font-weight:700; color:var(--text-main); margin-bottom:0.5rem; position:relative; z-index:1;">{{ $ach->title }}</h3>
                <p style="font-size:0.8rem; color:var(--text-muted); line-height:1.5; margin-bottom:1rem; position:relative; z-index:1;">{{ $ach->description }}</p>
                
                <span style="display:inline-block; font-size:0.7rem; font-weight:600; padding:0.2rem 0.6rem; border-radius:4px; background:var(--bg-page); color:var(--text-muted); position:relative; z-index:1;">
                    Diraih: {{ \Carbon\Carbon::parse($ach->earned_at)->translatedFormat('d M Y') }}
                </span>
            </div>
        @empty
            <div style="grid-column: 1/-1; text-align:center; padding:3rem;">
                <div style="font-size:3rem; margin-bottom:1rem;">🔒</div>
                <h3 style="color:var(--text-main); margin-bottom:0.5rem;">Belum ada pencapaian</h3>
                <p style="color:var(--text-muted); font-size:0.9rem;">Catat transaksi dan capai target tabunganmu untuk membuka badge!</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
