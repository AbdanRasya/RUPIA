@extends('layouts.app')
@section('title', 'Budget Planning')
@section('header_title', 'Budget Bulanan')
@section('header_subtitle', 'Bulan ' . \Carbon\Carbon::now()->translatedFormat('F Y'))

@section('content')
<div class="panel" style="display:flex; justify-content:space-between; align-items:center;">
    <div>
        <h2 class="panel-title" style="margin:0;">Atur Batas Pengeluaran</h2>
        <p style="font-size:0.8rem; color:var(--text-muted); margin-top:0.2rem;">Jangan sampai pengeluaran melebihi batas (Overbudget)</p>
    </div>
    <button onclick="document.getElementById('addBudgetModal').style.display='flex'" class="btn btn-primary">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path></svg>
        Buat Budget Baru
    </button>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 1.5rem;">
    @forelse($budgets as $budget)
        @php
            $percentage = $budget->amount > 0 ? ($budget->spent / $budget->amount) * 100 : 0;
            $percentageClamped = min(100, $percentage);
            $isOver = $percentage > 100;
            $isWarning = $percentage > 80 && !$isOver;
            
            $barColor = 'var(--primary)';
            if ($isWarning) $barColor = 'var(--warning)';
            if ($isOver) $barColor = 'var(--danger)';
        @endphp
        <div class="panel" style="margin:0; position:relative; {{ $isOver ? 'border-color:var(--danger); background:var(--danger-light);' : '' }}">
            <div style="position:absolute; top:1rem; right:1rem; display:flex; gap:0.4rem;">
                <button onclick="editBudget({{ $budget->toJson() }})" style="background:none; border:none; color:var(--text-muted); cursor:pointer;"><svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg></button>
                <form action="{{ url('/budgets/'.$budget->id) }}" method="POST" onsubmit="return confirm('Hapus budget ini?');" style="margin:0;">
                    @csrf @method('DELETE')
                    <button type="submit" style="background:none; border:none; color:var(--danger); cursor:pointer;"><svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                </form>
            </div>

            <div style="display:flex; align-items:center; gap:0.75rem; margin-bottom:1rem;">
                <div style="width:40px; height:40px; border-radius:50%; background:var(--bg-page); display:flex; align-items:center; justify-content:center; font-size:1.2rem;">
                    {{ optional($budget->category)->icon ?? '💰' }}
                </div>
                <div>
                    <h3 style="font-size:1rem; font-weight:700; color:var(--text-main);">{{ optional($budget->category)->name ?? 'Kategori Dihapus' }}</h3>
                    <p style="font-size:0.75rem; color:var(--text-muted);">Batas: Rp {{ number_format($budget->amount, 0, ',', '.') }}</p>
                </div>
            </div>

            <div style="margin-bottom:0.5rem; display:flex; justify-content:space-between; font-size:0.85rem;">
                <span style="color:var(--text-main); font-weight:600;">Terpakai: Rp {{ number_format($budget->spent, 0, ',', '.') }}</span>
                <span style="color:{{ $barColor }}; font-weight:700;">{{ number_format($percentage, 1) }}%</span>
            </div>

            <div style="height:8px; background:{{ $isOver ? '#fecaca' : 'var(--bg-page)' }}; border-radius:4px; overflow:hidden;">
                <div style="height:100%; width:{{ $percentageClamped }}%; background:{{ $barColor }}; border-radius:4px;"></div>
            </div>

            @if($isOver)
                <p style="font-size:0.75rem; color:var(--danger); margin-top:0.5rem; font-weight:600;">⚠️ Overbudget Rp {{ number_format($budget->spent - $budget->amount, 0, ',', '.') }}</p>
            @elseif($isWarning)
                <p style="font-size:0.75rem; color:var(--warning); margin-top:0.5rem;">⚠️ Hampir mendekati batas.</p>
            @else
                <p style="font-size:0.75rem; color:var(--text-muted); margin-top:0.5rem;">Tersisa Rp {{ number_format($budget->amount - $budget->spent, 0, ',', '.') }}</p>
            @endif
        </div>
    @empty
        <div style="grid-column: 1/-1; text-align:center; padding:3rem; background:var(--card-bg); border-radius:var(--radius-md); border:1px dashed var(--border-color);">
            <div style="font-size:3rem; margin-bottom:1rem;">📊</div>
            <h3 style="color:var(--text-main); margin-bottom:0.5rem;">Belum ada Budget Bulanan</h3>
            <p style="color:var(--text-muted); font-size:0.9rem;">Bantu kontrol pengeluaran dengan mengatur batas per kategori.</p>
        </div>
    @endforelse
</div>

<!-- Add Modal -->
<div id="addBudgetModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:100; align-items:center; justify-content:center;">
    <form action="{{ url('/budgets') }}" method="POST" class="panel" style="width:100%; max-width:400px; position:relative; margin:0;">
        @csrf
        <h3 style="margin-bottom:1rem;">Buat Budget Baru</h3>
        <div class="form-group">
            <label class="form-label">Kategori</label>
            <select name="category_id" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->icon }} {{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Batas Pengeluaran Bulanan (Rp)</label>
            <input type="number" name="amount" class="form-control" required>
        </div>
        <div style="display:flex; gap:0.5rem; margin-top:1.5rem;">
            <button type="submit" class="btn btn-primary" style="flex:1; justify-content:center;">Simpan</button>
            <button type="button" class="btn btn-outline" style="flex:1; justify-content:center;" onclick="document.getElementById('addBudgetModal').style.display='none'">Batal</button>
        </div>
    </form>
</div>

<!-- Edit Modal -->
<div id="editBudgetModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:100; align-items:center; justify-content:center;">
    <form id="editBudgetForm" method="POST" class="panel" style="width:100%; max-width:400px; position:relative; margin:0;">
        @csrf @method('PUT')
        <h3 style="margin-bottom:1rem;">Edit Batas Budget</h3>
        <div class="form-group">
            <label class="form-label">Batas Pengeluaran Baru (Rp)</label>
            <input type="number" name="amount" id="editBudgetAmount" class="form-control" required>
        </div>
        <div style="display:flex; gap:0.5rem; margin-top:1.5rem;">
            <button type="submit" class="btn btn-primary" style="flex:1; justify-content:center;">Simpan</button>
            <button type="button" class="btn btn-outline" style="flex:1; justify-content:center;" onclick="document.getElementById('editBudgetModal').style.display='none'">Batal</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    function editBudget(budget) {
        document.getElementById('editBudgetForm').action = '/budgets/' + budget.id;
        document.getElementById('editBudgetAmount').value = budget.amount;
        document.getElementById('editBudgetModal').style.display = 'flex';
    }
</script>
@endsection
