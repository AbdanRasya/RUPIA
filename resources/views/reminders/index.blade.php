@extends('layouts.app')
@section('title', 'Pengingat Tagihan')
@section('header_title', 'Pengingat (Reminders)')
@section('header_subtitle', 'Jangan sampai telat bayar tagihan!')

@section('content')
<div class="panel" style="display:flex; justify-content:space-between; align-items:center;">
    <div>
        <h2 class="panel-title" style="margin:0;">Jadwal Pembayaran & Cicilan</h2>
    </div>
    <button onclick="document.getElementById('addReminderModal').style.display='flex'" class="btn btn-primary">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path></svg>
        Tambah Pengingat
    </button>
</div>

<div style="display:flex; flex-direction:column; gap:1rem;">
    @forelse($reminders as $rem)
        @php
            $isPast = !$rem->is_done && \Carbon\Carbon::parse($rem->remind_date)->isPast();
            $isToday = !$rem->is_done && \Carbon\Carbon::parse($rem->remind_date)->isToday();
            $borderColor = $rem->is_done ? 'var(--border-color)' : ($isPast ? 'var(--danger)' : ($isToday ? 'var(--warning)' : 'var(--primary)'));
            $bgCol = $rem->is_done ? 'var(--bg-page)' : 'var(--card-bg)';
        @endphp
        <div class="panel" style="margin:0; border-left:4px solid {{ $borderColor }}; background:{{ $bgCol }}; display:flex; align-items:center; gap:1rem;">
            <form action="{{ url('/reminders/'.$rem->id.'/toggle') }}" method="POST" style="margin:0;">
                @csrf
                <button type="submit" style="width:24px; height:24px; border-radius:50%; border:2px solid {{ $rem->is_done ? 'var(--primary)' : 'var(--text-muted)' }}; background:{{ $rem->is_done ? 'var(--primary)' : 'transparent' }}; color:white; display:flex; align-items:center; justify-content:center; cursor:pointer;">
                    @if($rem->is_done)
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                    @endif
                </button>
            </form>
            
            <div style="flex:1; {{ $rem->is_done ? 'text-decoration:line-through; color:var(--text-muted);' : '' }}">
                <h3 style="font-size:1rem; font-weight:600; color:var(--text-main); margin-bottom:0.2rem;">{{ $rem->title }}</h3>
                <div style="font-size:0.75rem; color:var(--text-muted); display:flex; gap:1rem;">
                    <span>📅 {{ \Carbon\Carbon::parse($rem->remind_date)->translatedFormat('d M Y') }}</span>
                    @if($rem->repeat != 'none')
                        <span>🔄 Repeat: {{ ucfirst($rem->repeat) }}</span>
                    @endif
                </div>
            </div>
            
            <div style="display:flex; gap:0.5rem;">
                <button onclick="editReminder({{ $rem->toJson() }})" style="background:none; border:none; color:var(--text-muted); cursor:pointer;"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg></button>
                <form action="{{ url('/reminders/'.$rem->id) }}" method="POST" onsubmit="return confirm('Hapus pengingat ini?');" style="margin:0;">
                    @csrf @method('DELETE')
                    <button type="submit" style="background:none; border:none; color:var(--danger); cursor:pointer;"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                </form>
            </div>
        </div>
    @empty
        <div style="text-align:center; padding:3rem; background:var(--card-bg); border-radius:var(--radius-md); border:1px dashed var(--border-color);">
            <div style="font-size:3rem; margin-bottom:1rem;">⏰</div>
            <h3 style="color:var(--text-main); margin-bottom:0.5rem;">Belum ada pengingat tagihan.</h3>
        </div>
    @endforelse
</div>

<!-- Modal Add -->
<div id="addReminderModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:100; align-items:center; justify-content:center;">
    <form action="{{ url('/reminders') }}" method="POST" class="panel" style="width:100%; max-width:400px; position:relative; margin:0;">
        @csrf
        <h3 style="margin-bottom:1rem;">Tambah Pengingat</h3>
        <div class="form-group">
            <label class="form-label">Judul (Mis: Bayar SPP, Cicilan Motor)</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label class="form-label">Tanggal Pengingat</label>
            <input type="date" name="remind_date" class="form-control" required>
        </div>
        <div class="form-group">
            <label class="form-label">Ulangi</label>
            <select name="repeat" class="form-control">
                <option value="none">Tidak Diulang</option>
                <option value="daily">Setiap Hari</option>
                <option value="weekly">Setiap Minggu</option>
                <option value="monthly">Setiap Bulan</option>
            </select>
        </div>
        <div style="display:flex; gap:0.5rem; margin-top:1.5rem;">
            <button type="submit" class="btn btn-primary" style="flex:1; justify-content:center;">Simpan</button>
            <button type="button" class="btn btn-outline" style="flex:1; justify-content:center;" onclick="document.getElementById('addReminderModal').style.display='none'">Batal</button>
        </div>
    </form>
</div>

<!-- Modal Edit -->
<div id="editReminderModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:100; align-items:center; justify-content:center;">
    <form id="editReminderForm" method="POST" class="panel" style="width:100%; max-width:400px; position:relative; margin:0;">
        @csrf @method('PUT')
        <h3 style="margin-bottom:1rem;">Edit Pengingat</h3>
        <div class="form-group">
            <label class="form-label">Judul</label>
            <input type="text" name="title" id="editRemTitle" class="form-control" required>
        </div>
        <div class="form-group">
            <label class="form-label">Tanggal Pengingat</label>
            <input type="date" name="remind_date" id="editRemDate" class="form-control" required>
        </div>
        <div class="form-group">
            <label class="form-label">Ulangi</label>
            <select name="repeat" id="editRemRepeat" class="form-control">
                <option value="none">Tidak Diulang</option>
                <option value="daily">Setiap Hari</option>
                <option value="weekly">Setiap Minggu</option>
                <option value="monthly">Setiap Bulan</option>
            </select>
        </div>
        <div style="display:flex; gap:0.5rem; margin-top:1.5rem;">
            <button type="submit" class="btn btn-primary" style="flex:1; justify-content:center;">Simpan</button>
            <button type="button" class="btn btn-outline" style="flex:1; justify-content:center;" onclick="document.getElementById('editReminderModal').style.display='none'">Batal</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    function editReminder(rem) {
        document.getElementById('editReminderForm').action = '/reminders/' + rem.id;
        document.getElementById('editRemTitle').value = rem.title;
        document.getElementById('editRemDate').value = rem.remind_date.split(' ')[0];
        document.getElementById('editRemRepeat').value = rem.repeat;
        document.getElementById('editReminderModal').style.display = 'flex';
    }
</script>
@endsection
