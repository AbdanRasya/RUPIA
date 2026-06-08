@extends('layouts.app')
@section('title', 'Planner')
@section('header_title', 'Life Event Planner')
@section('header_subtitle', 'Visualisasikan target jangka panjangmu')

@section('styles')
<style>
    /* ── TIMELINE ── */
    .timeline { position: relative; padding-left: 2.25rem; border-left: 2px solid var(--border-color); margin-top: 1rem; }
    .timeline-item { position: relative; margin-bottom: 2.25rem; }
    .timeline-dot { position: absolute; left: calc(-2.25rem - 5px); top: 5px; width: 10px; height: 10px; background: var(--primary); border-radius: 50%; border: 2px solid var(--card-bg); outline: 2px solid var(--primary); }
    .timeline-year { font-size: 0.75rem; font-weight: 700; color: var(--primary); text-transform: uppercase; display: block; margin-bottom: 4px; letter-spacing: 0.5px; }
    .timeline-title { font-size: 0.95rem; font-weight: 600; margin-bottom: 6px; color: var(--text-main); }
    .timeline-desc { font-size: 0.825rem; color: var(--text-muted); line-height: 1.6; }

    /* ── MODAL ── */
    .planner-modal { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); backdrop-filter: blur(4px); z-index: 1000; align-items: center; justify-content: center; }
    .planner-modal-content { background: var(--card-bg); padding: 2rem; border-radius: var(--radius-lg); width: 90%; max-width: 400px; border: 1px solid var(--border-color); box-shadow: var(--shadow-md); }
    .planner-modal-input { width: 100%; padding: 0.75rem 1rem; border-radius: var(--radius-sm); border: 1px solid var(--border-color); background: var(--bg-page); color: var(--text-main); margin-bottom: 0.875rem; outline: none; font-size: 0.875rem; font-family: 'Inter', sans-serif; transition: 0.2s; }
    .planner-modal-input:focus { border-color: var(--primary); }
</style>
@endsection

@section('content')
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;">
    <div class="panel">
        <p style="font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:var(--text-muted);margin-bottom:1.5rem;">Timeline Rencana</p>
        <div class="timeline">
            @forelse($plans ?? [] as $plan)
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <span class="timeline-year">{{ $plan->year }}</span>
                    <h3 class="timeline-title">{{ $plan->event_name }}</h3>
                    <p class="timeline-desc">{{ $plan->description }}</p>
                </div>
            @empty
                <p style="color:var(--text-muted);font-size:0.875rem;">Belum ada rencana yang disusun.</p>
            @endforelse
        </div>
    </div>

    <aside>
        <div class="panel">
            <h3 style="font-size:0.95rem;font-weight:700;margin-bottom:0.4rem;color:var(--text-main);">Aksi</h3>
            <p style="font-size:0.8rem;color:var(--text-muted);margin-bottom:1.25rem;">Tambah milestone baru untuk hidupmu.</p>
            <button class="btn btn-primary" onclick="document.getElementById('planModal').style.display='flex'" style="width:100%; justify-content:center;">+ Buat Plan Baru</button>
        </div>
    </aside>
</div>

<div id="planModal" class="planner-modal">
    <form class="planner-modal-content" action="{{ url('/planner/store') }}" method="POST">
        @csrf
        <h2 style="font-size:1.1rem;font-weight:700;margin-bottom:1.25rem;color:var(--text-main);">Rencana Baru</h2>
        <input type="text" name="year" class="planner-modal-input" placeholder="Tahun (contoh: 2027)" required>
        <input type="text" name="event_name" class="planner-modal-input" placeholder="Nama Event" required>
        <textarea name="description" class="planner-modal-input" placeholder="Deskripsi/Budget" style="height:80px;resize:none;"></textarea>
        <div style="display:flex; gap:0.5rem; margin-top:0.5rem;">
            <button type="submit" class="btn btn-primary" style="flex:1; justify-content:center;">Simpan Rencana</button>
            <button type="button" class="btn btn-outline" style="flex:1; justify-content:center;" onclick="document.getElementById('planModal').style.display='none'">Batal</button>
        </div>
    </form>
</div>
@endsection
