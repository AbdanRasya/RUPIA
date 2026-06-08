@extends('layouts.app')
@section('title', 'Kategori Keuangan')
@section('header_title', 'Kategori Keuangan')
@section('header_subtitle', 'Kelola kategori pemasukan dan pengeluaran')

@section('content')
<div class="panel" style="display:flex; justify-content:space-between; align-items:center;">
    <div>
        <h2 class="panel-title" style="margin:0;">Kategori Kustom</h2>
        <p style="font-size:0.8rem; color:var(--text-muted); margin-top:0.2rem;">Atur kategori sesuai kebutuhan pengeluaranmu</p>
    </div>
    <button onclick="document.getElementById('addCategoryModal').style.display='flex'" class="btn btn-primary">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path></svg>
        Tambah Kategori
    </button>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
    <!-- Expenses -->
    <div class="panel">
        <h3 style="margin-bottom:1rem; color:var(--danger); border-bottom:1px solid var(--border-color); padding-bottom:0.5rem;">Pengeluaran</h3>
        <div style="display:flex; flex-direction:column; gap:0.5rem;">
            @foreach($categories->where('type', 'expense') as $cat)
            <div style="display:flex; justify-content:space-between; align-items:center; padding:0.5rem; background:var(--bg-page); border-radius:var(--radius-sm); border:1px solid var(--border-color);">
                <div style="display:flex; align-items:center; gap:0.5rem;">
                    <span style="font-size:1.2rem;">{{ $cat->icon }}</span>
                    <span style="font-weight:500;">{{ $cat->name }}</span>
                </div>
                <div style="display:flex; gap:0.2rem;">
                    <button onclick="editCategory({{ $cat->toJson() }})" style="background:none; border:none; cursor:pointer; color:var(--text-muted); padding:0.2rem;"><svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg></button>
                    <form action="{{ route('categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?');" style="margin:0;">
                        @csrf @method('DELETE')
                        <button type="submit" style="background:none; border:none; cursor:pointer; color:var(--danger); padding:0.2rem;"><svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    
    <!-- Incomes -->
    <div class="panel">
        <h3 style="margin-bottom:1rem; color:var(--primary); border-bottom:1px solid var(--border-color); padding-bottom:0.5rem;">Pemasukan</h3>
        <div style="display:flex; flex-direction:column; gap:0.5rem;">
            @foreach($categories->where('type', 'income') as $cat)
            <div style="display:flex; justify-content:space-between; align-items:center; padding:0.5rem; background:var(--bg-page); border-radius:var(--radius-sm); border:1px solid var(--border-color);">
                <div style="display:flex; align-items:center; gap:0.5rem;">
                    <span style="font-size:1.2rem;">{{ $cat->icon }}</span>
                    <span style="font-weight:500;">{{ $cat->name }}</span>
                </div>
                <div style="display:flex; gap:0.2rem;">
                    <button onclick="editCategory({{ $cat->toJson() }})" style="background:none; border:none; cursor:pointer; color:var(--text-muted); padding:0.2rem;"><svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg></button>
                    <form action="{{ route('categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?');" style="margin:0;">
                        @csrf @method('DELETE')
                        <button type="submit" style="background:none; border:none; cursor:pointer; color:var(--danger); padding:0.2rem;"><svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Modal Add -->
<div id="addCategoryModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:100; align-items:center; justify-content:center;">
    <form action="{{ route('categories.store') }}" method="POST" class="panel" style="width:100%; max-width:400px; position:relative; margin:0;">
        @csrf
        <h3 style="margin-bottom:1rem;">Tambah Kategori</h3>
        <div class="form-group">
            <label class="form-label">Nama Kategori</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label class="form-label">Tipe</label>
            <select name="type" class="form-control" required>
                <option value="expense">Pengeluaran</option>
                <option value="income">Pemasukan</option>
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Icon (Emoji)</label>
            <input type="text" name="icon" class="form-control" placeholder="🍕" required>
        </div>
        <div class="form-group">
            <label class="form-label">Warna Hex</label>
            <input type="color" name="color" class="form-control" value="#3B82F6" style="padding:0; height:40px;" required>
        </div>
        <div style="display:flex; gap:0.5rem; margin-top:1.5rem;">
            <button type="submit" class="btn btn-primary" style="flex:1; justify-content:center;">Simpan</button>
            <button type="button" class="btn btn-outline" style="flex:1; justify-content:center;" onclick="document.getElementById('addCategoryModal').style.display='none'">Batal</button>
        </div>
    </form>
</div>

<!-- Modal Edit -->
<div id="editCategoryModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:100; align-items:center; justify-content:center;">
    <form id="editCategoryForm" method="POST" class="panel" style="width:100%; max-width:400px; position:relative; margin:0;">
        @csrf @method('PUT')
        <h3 style="margin-bottom:1rem;">Edit Kategori</h3>
        <div class="form-group">
            <label class="form-label">Nama Kategori</label>
            <input type="text" name="name" id="editCatName" class="form-control" required>
        </div>
        <div class="form-group">
            <label class="form-label">Tipe</label>
            <select name="type" id="editCatType" class="form-control" required>
                <option value="expense">Pengeluaran</option>
                <option value="income">Pemasukan</option>
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Icon (Emoji)</label>
            <input type="text" name="icon" id="editCatIcon" class="form-control" required>
        </div>
        <div class="form-group">
            <label class="form-label">Warna Hex</label>
            <input type="color" name="color" id="editCatColor" class="form-control" style="padding:0; height:40px;" required>
        </div>
        <div style="display:flex; gap:0.5rem; margin-top:1.5rem;">
            <button type="submit" class="btn btn-primary" style="flex:1; justify-content:center;">Simpan</button>
            <button type="button" class="btn btn-outline" style="flex:1; justify-content:center;" onclick="document.getElementById('editCategoryModal').style.display='none'">Batal</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    function editCategory(cat) {
        document.getElementById('editCategoryForm').action = '/categories/' + cat.id;
        document.getElementById('editCatName').value = cat.name;
        document.getElementById('editCatType').value = cat.type;
        document.getElementById('editCatIcon').value = cat.icon;
        document.getElementById('editCatColor').value = cat.color;
        document.getElementById('editCategoryModal').style.display = 'flex';
    }
</script>
@endsection
