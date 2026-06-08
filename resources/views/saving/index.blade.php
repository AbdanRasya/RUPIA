@extends('layouts.app')
@section('title', 'Target Tabungan')
@section('header_title', 'Target Tabungan')
@section('header_subtitle', 'Wujudkan mimpimu satu per satu')

@section('content')
<div class="panel" style="display:flex; justify-content:space-between; align-items:center;">
    <div>
        <h2 class="panel-title" style="margin:0;">Target Keuangan</h2>
        <p style="font-size:0.8rem; color:var(--text-muted); margin-top:0.2rem;">Kumpulkan dana untuk masa depan</p>
    </div>
    <button onclick="document.getElementById('addSavingModal').style.display='flex'" class="btn btn-primary">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path></svg>
        Buat Target Baru
    </button>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem;">
    @forelse($savings as $saving)
        @php
            $progress = $saving->target_amount > 0 ? min(100, ($saving->current_amount / $saving->target_amount) * 100) : 0;
            $isCompleted = $saving->current_amount >= $saving->target_amount;
        @endphp
        <div class="panel" style="margin:0; position:relative; {{ $isCompleted ? 'border-color:var(--primary);' : '' }}">
            @if($isCompleted)
                <div style="position:absolute; top:1rem; right:1rem; background:var(--primary-light); color:var(--primary-dark); padding:0.2rem 0.5rem; border-radius:4px; font-size:0.7rem; font-weight:700;">TERCAPAI 🎉</div>
            @else
                <div style="position:absolute; top:1rem; right:1rem; display:flex; gap:0.4rem;">
                    <button onclick="editSaving({{ $saving->toJson() }})" style="background:none; border:none; color:var(--text-muted); cursor:pointer;"><svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg></button>
                    <form action="{{ url('/saving/'.$saving->id) }}" method="POST" onsubmit="return confirm('Hapus target tabungan ini?');" style="margin:0;">
                        @csrf @method('DELETE')
                        <button type="submit" style="background:none; border:none; color:var(--danger); cursor:pointer;"><svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                    </form>
                </div>
            @endif

            <div style="font-size:2rem; margin-bottom:0.5rem;">{{ $saving->icon ?? '🎯' }}</div>
            <h3 style="font-size:1.1rem; font-weight:700; color:var(--text-main); margin-bottom:0.2rem;">{{ $saving->title }}</h3>
            @if($saving->deadline)
                <p style="font-size:0.75rem; color:var(--warning); margin-bottom:1rem; font-weight:500;">
                    ⏳ Target: {{ \Carbon\Carbon::parse($saving->deadline)->format('d M Y') }}
                </p>
            @endif

            <div style="margin:1.5rem 0 1rem;">
                <div style="display:flex; justify-content:space-between; margin-bottom:0.4rem;">
                    <span style="font-size:0.8rem; font-weight:600; color:var(--text-main);">Rp {{ number_format($saving->current_amount, 0, ',', '.') }}</span>
                    <span style="font-size:0.8rem; color:var(--text-muted);">Rp {{ number_format($saving->target_amount, 0, ',', '.') }}</span>
                </div>
                <div style="height:8px; background:var(--bg-page); border-radius:4px; overflow:hidden;">
                    <div style="height:100%; width:{{ $progress }}%; background:{{ $isCompleted ? 'var(--primary)' : 'var(--accent)' }}; border-radius:4px; transition:width 0.5s ease;"></div>
                </div>
                <div style="text-align:right; margin-top:0.4rem; font-size:0.75rem; font-weight:600; color:var(--primary);">
                    {{ number_format($progress, 1) }}% Terkumpul
                </div>
            </div>

            @if(!$isCompleted)
                <form action="{{ url('/saving/'.$saving->id.'/topup') }}" method="POST" style="display:flex; gap:0.5rem;">
                    @csrf
                    <input type="number" name="amount" class="form-control" placeholder="Isi nominal..." style="flex:1; padding:0.5rem;" required>
                    <button type="submit" class="btn btn-primary" style="padding:0.5rem 1rem;">Nabung</button>
                </form>
            @endif
        </div>
    @empty
        <div style="grid-column: 1/-1; text-align:center; padding:3rem; background:var(--card-bg); border-radius:var(--radius-md); border:1px dashed var(--border-color);">
            <div style="font-size:3rem; margin-bottom:1rem;">🎯</div>
            <h3 style="color:var(--text-main); margin-bottom:0.5rem;">Belum ada target tabungan</h3>
            <p style="color:var(--text-muted); font-size:0.9rem;">Mulai kumpulkan uang untuk membeli barang impianmu.</p>
        </div>
    @endforelse
</div>

<!-- Add Modal -->
<div id="addSavingModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:100; align-items:center; justify-content:center;">
    <form action="{{ url('/saving') }}" method="POST" class="panel" style="width:100%; max-width:400px; position:relative; margin:0;">
        @csrf
        <h3 style="margin-bottom:1rem;">Buat Target Baru</h3>
        <div class="form-group">
            <label class="form-label">Nama Impian (Mis: Beli Laptop)</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label class="form-label">Target Dana (Rp)</label>
            <input type="number" name="target_amount" class="form-control" required>
        </div>
        <div class="form-group">
            <label class="form-label">Deadline (Opsional)</label>
            <input type="date" name="deadline" class="form-control">
        </div>
        <div class="form-group">
            <label class="form-label">Icon (Emoji)</label>
            <input type="text" name="icon" class="form-control" placeholder="💻">
        </div>
        <div style="display:flex; gap:0.5rem; margin-top:1.5rem;">
            <button type="submit" class="btn btn-primary" style="flex:1; justify-content:center;">Simpan</button>
            <button type="button" class="btn btn-outline" style="flex:1; justify-content:center;" onclick="document.getElementById('addSavingModal').style.display='none'">Batal</button>
        </div>
    </form>
</div>

<!-- Edit Modal -->
<div id="editSavingModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:100; align-items:center; justify-content:center;">
    <form id="editSavingForm" method="POST" class="panel" style="width:100%; max-width:400px; position:relative; margin:0;">
        @csrf @method('PUT')
        <h3 style="margin-bottom:1rem;">Edit Target</h3>
        <div class="form-group">
            <label class="form-label">Nama Impian</label>
            <input type="text" name="title" id="editSavTitle" class="form-control" required>
        </div>
        <div class="form-group">
            <label class="form-label">Target Dana (Rp)</label>
            <input type="number" name="target_amount" id="editSavTarget" class="form-control" required>
        </div>
        <div class="form-group">
            <label class="form-label">Deadline (Opsional)</label>
            <input type="date" name="deadline" id="editSavDeadline" class="form-control">
        </div>
        <div class="form-group">
            <label class="form-label">Icon (Emoji)</label>
            <input type="text" name="icon" id="editSavIcon" class="form-control">
        </div>
        <div style="display:flex; gap:0.5rem; margin-top:1.5rem;">
            <button type="submit" class="btn btn-primary" style="flex:1; justify-content:center;">Simpan</button>
            <button type="button" class="btn btn-outline" style="flex:1; justify-content:center;" onclick="document.getElementById('editSavingModal').style.display='none'">Batal</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    function editSaving(saving) {
        document.getElementById('editSavingForm').action = '/saving/' + saving.id;
        document.getElementById('editSavTitle').value = saving.title;
        document.getElementById('editSavTarget').value = saving.target_amount;
        document.getElementById('editSavDeadline').value = saving.deadline ? saving.deadline.split('T')[0] : '';
        document.getElementById('editSavIcon').value = saving.icon;
        document.getElementById('editSavingModal').style.display = 'flex';
    }
</script>
@endsection
